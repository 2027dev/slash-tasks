<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (Task::count() > 0) {
            return;
        }

        collect([
            'Learn about Slash',
            'Answer emails for 30 minutes',
            'Buy flight to Portugal',
        ])->each(fn (string $title, int $position) => Task::create([
            'title' => $title,
            'position' => $position,
        ]));
    }
}
