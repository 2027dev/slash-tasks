<?php

use Livewire\Component;
use App\Models\Task;

new class extends Component
{
    public string $title = '';

    public function addTask(): void
    {
        $title = trim($this->title);

        if ($title === '') {
            return;
        }

        Task::create([
            'title' => $title,
            'position' => (int) Task::max('position') + 1,
        ]);

        $this->title = '';
    }

    public function toggle(int $taskId): void
    {
        $task = Task::findOrFail($taskId);

        $task->update(['completed' => ! $task->completed]);
    }

    public function delete(int $taskId): void
    {
        Task::whereKey($taskId)->delete();
    }

    public function with(): array
    {
        return [
            'tasks' => Task::orderBy('position')->orderBy('id')->get(),
        ];
    }
};
?>

<div class="mx-auto flex min-h-screen w-full max-w-lg flex-col justify-center px-6 py-16">
    <p class="mb-8 text-lg text-neutral-500">Today</p>

    <div class="mb-8 space-y-5">
        @forelse ($tasks as $task)
            <div wire:key="task-{{ $task->id }}" class="group flex items-center justify-between gap-3">
                <button
                    type="button"
                    wire:click="toggle({{ $task->id }})"
                    class="text-left text-lg font-bold transition {{ $task->completed ? 'text-neutral-600 line-through' : 'text-white' }}"
                >
                    {{ $task->title }}
                </button>

                <button
                    type="button"
                    wire:click="delete({{ $task->id }})"
                    wire:confirm="Delete this task?"
                    class="shrink-0 text-2xl leading-none text-neutral-700 opacity-0 transition hover:text-red-500 group-hover:opacity-100"
                    aria-label="Delete task"
                >
                    &times;
                </button>
            </div>
        @empty
            <p class="text-lg text-neutral-600">Nothing on your list yet.</p>
        @endforelse
    </div>

    <form wire:submit="addTask">
        <input
            type="text"
            wire:model="title"
            placeholder="Add task..."
            autofocus
            class="w-full border-0 border-b border-neutral-700 bg-transparent pb-3 text-lg font-semibold text-neutral-400 placeholder-neutral-500 focus:border-violet-500 focus:outline-none focus:ring-0"
        >

        <button
            type="submit"
            class="mt-6 w-full rounded-lg bg-violet-600 py-4 text-lg font-bold text-white transition hover:bg-violet-500 active:bg-violet-700"
        >
            Start Slashing
        </button>
    </form>
</div>
