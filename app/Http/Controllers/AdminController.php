<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users'    => User::where('role', 'student')->count(),
            'total_tasks'    => Task::count(),
            'done_tasks'     => Task::where('status', 'done')->count(),
            'overdue_tasks'  => Task::overdue()->count(),
            'total_categories' => Category::count(),
        ];

        $recentUsers = User::where('role', 'student')->latest()->take(5)->get();
        $recentTasks = Task::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentTasks'));
    }

    // ── Users ────────────────────────────────────────────────
    public function users(Request $request)
    {
        $query = User::where('role', 'student');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('name', 'like', "%$s%")
                ->orWhere('email', 'like', "%$s%")
                ->orWhere('nim', 'like', "%$s%"));
        }

        $users = $query->withCount('tasks')->latest()->paginate(10)->withQueryString();
        return view('admin.users.index', compact('users'));
    }

    public function showUser(User $user)
    {
        $user->load('tasks.category');
        return view('admin.users.show', compact('user'));
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'email'    => ['required', 'email', 'unique:users,email,' . $user->id],
            'nim'      => ['nullable', 'string', 'max:20'],
            'jurusan'  => ['nullable', 'string', 'max:100'],
            'semester' => ['nullable', 'string', 'max:5'],
        ]);

        $user->update($request->only('name', 'email', 'nim', 'jurusan', 'semester'));

        if ($request->filled('password')) {
            $request->validate(['password' => ['min:8', 'confirmed']]);
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.users')->with('success', 'Data pengguna diperbarui!');
    }

    public function destroyUser(User $user)
    {
        if ($user->isAdmin()) {
            return back()->with('error', 'Tidak dapat menghapus akun admin.');
        }
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'Pengguna berhasil dihapus.');
    }

    // ── Categories ───────────────────────────────────────────
    public function categories()
    {
        $categories = Category::withCount('tasks')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function createCategory()
    {
        return view('admin.categories.create');
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name'        => ['required', 'string', 'max:50', 'unique:categories,name'],
            'color'       => ['required', 'string'],
            'icon'        => ['required', 'string'],
            'description' => ['nullable', 'string', 'max:200'],
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique'   => 'Nama kategori sudah ada.',
        ]);

        Category::create($request->only('name', 'color', 'icon', 'description'));
        return redirect()->route('admin.categories')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function editCategory(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function updateCategory(Request $request, Category $category)
    {
        $request->validate([
            'name'        => ['required', 'string', 'max:50', 'unique:categories,name,' . $category->id],
            'color'       => ['required', 'string'],
            'icon'        => ['required', 'string'],
            'description' => ['nullable', 'string', 'max:200'],
        ]);

        $category->update($request->only('name', 'color', 'icon', 'description'));
        return redirect()->route('admin.categories')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroyCategory(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories')->with('success', 'Kategori berhasil dihapus.');
    }

    // ── All Tasks (monitor) ──────────────────────────────────
    public function tasks(Request $request)
    {
        $query = Task::with(['user', 'category']);

        if ($request->filled('status'))   $query->byStatus($request->status);
        if ($request->filled('priority')) $query->byPriority($request->priority);
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('title', 'like', "%$s%")
                ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%$s%")));
        }

        $tasks = $query->latest()->paginate(10)->withQueryString();
        return view('admin.tasks.index', compact('tasks'));
    }
}
