<?php

use Illuminate\Database\Seeder;

class SampleTasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            [
                'title' => 'Task 1',
                'description' => 'Description for Task 1'
            ],
            [
                'title' => 'Task 2',
                'description' => 'Description for Task 2'
            ],
            [
                'title' => 'Task 3',
                'description' => 'Description for Task 3'
            ],
            [
                'title' => 'Task 4',
                'description' => 'Description for Task 4'
            ],
            [
                'title' => 'Task 5',
                'description' => 'Description for Task 5'
            ],
        ];

        \App\Task::insert($items);


    }
}
