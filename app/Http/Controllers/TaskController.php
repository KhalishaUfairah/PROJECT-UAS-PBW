<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Task;
use App\Models\TaskComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $user  = Auth::user();
        $query = Task::forUser($user->id)->with(['category']);

        // Filter status
        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        // Filter priority
        if ($request->filled('priority')) {
            $query->byPriority($request->priority);
        }

        // Filter kategori
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('mata_kuliah', 'like', "%{$search}%")
                  ->orWhere('dosen', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Sort
        $sort = $request->get('sort', 'due_date');
        match ($sort) {
            'priority'   => $query->orderByRaw("FIELD(priority, 'urgent', 'high', 'medium', 'low')"),
            'title'      => $query->orderBy('title'),
            'created_at' => $query->orderBy('created_at', 'desc'),
            default      => $query->orderByRaw("is_pinned DESC")->orderBy('due_date'),
        };

        $tasks      = $query->paginate(9)->withQueryString();
        $categories = Category::all();
        $stats      = $user->task_stats;

        return view('tasks.index', compact('tasks', 'categories', 'stats'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('tasks.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => ['required', 'string', 'max:200'],
            'description' => ['nullable', 'string', 'max:2000'],
            'priority'    => ['required', 'in:low,medium,high,urgent'],
            'status'      => ['required', 'in:todo,in_progress,done,cancelled'],
            'due_date'    => ['nullable', 'date'],
            'due_time'    => ['nullable', 'date_format:H:i'],
            'mata_kuliah' => ['nullable', 'string', 'max:100'],
            'dosen'       => ['nullable', 'string', 'max:100'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'progress'    => ['integer', 'min:0', 'max:100'],
        ], [
            'title.required'   => 'Judul tugas wajib diisi.',
            'title.max'        => 'Judul maksimal 200 karakter.',
            'priority.required' => 'Prioritas wajib dipilih.',
            'priority.in'      => 'Prioritas tidak valid.',
            'status.required'  => 'Status wajib dipilih.',
            'status.in'        => 'Status tidak valid.',
            'due_date.date'    => 'Format tanggal tidak valid.',
        ]);

        Task::create([
            ...$request->only([
                'title', 'description', 'priority', 'status',
                'due_date', 'due_time', 'mata_kuliah', 'dosen',
                'category_id', 'progress',
            ]),
            'user_id'   => Auth::id(),
            'is_pinned' => $request->boolean('is_pinned'),
        ]);

        return redirect()->route('tasks.index')
            ->with('success', 'Tugas berhasil ditambahkan!');
    }

    public function show(Task $task)
    {
        $this->authorizeTask($task);
        $task->load(['category', 'comments.user']);
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $this->authorizeTask($task);
        $categories = Category::all();
        return view('tasks.edit', compact('task', 'categories'));
    }

    public function update(Request $request, Task $task)
    {
        $this->authorizeTask($task);

        $request->validate([
            'title'       => ['required', 'string', 'max:200'],
            'description' => ['nullable', 'string', 'max:2000'],
            'priority'    => ['required', 'in:low,medium,high,urgent'],
            'status'      => ['required', 'in:todo,in_progress,done,cancelled'],
            'due_date'    => ['nullable', 'date'],
            'due_time'    => ['nullable', 'date_format:H:i'],
            'mata_kuliah' => ['nullable', 'string', 'max:100'],
            'dosen'       => ['nullable', 'string', 'max:100'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'progress'    => ['integer', 'min:0', 'max:100'],
        ], [
            'title.required' => 'Judul tugas wajib diisi.',
            'title.max'      => 'Judul maksimal 200 karakter.',
        ]);

        $task->update([
            ...$request->only([
                'title', 'description', 'priority', 'status',
                'due_date', 'due_time', 'mata_kuliah', 'dosen',
                'category_id', 'progress',
            ]),
            'is_pinned' => $request->boolean('is_pinned'),
        ]);

        return redirect()->route('tasks.show', $task)
            ->with('success', 'Tugas berhasil diperbarui!');
    }

    public function destroy(Task $task)
    {
        $this->authorizeTask($task);
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Tugas berhasil dihapus.');
    }

    public function updateStatus(Request $request, Task $task)
    {
        $this->authorizeTask($task);
        $request->validate(['status' => ['required', 'in:todo,in_progress,done,cancelled']]);
        $task->update(['status' => $request->status]);

        return back()->with('success', 'Status tugas diperbarui!');
    }

    public function addComment(Request $request, Task $task)
    {
        $this->authorizeTask($task);
        $request->validate([
            'comment' => ['required', 'string', 'max:500'],
        ], [
            'comment.required' => 'Komentar tidak boleh kosong.',
            'comment.max'      => 'Komentar maksimal 500 karakter.',
        ]);

        TaskComment::create([
            'task_id' => $task->id,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Komentar ditambahkan!');
    }

    private function authorizeTask(Task $task): void
    {
        if ($task->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses ke tugas ini.');
        }
    }
}
