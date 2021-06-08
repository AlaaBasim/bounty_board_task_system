<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([
            'name' => 'acc',
        ]);

        DB::table('departments')->insert([
            'name' => 'it',
        ]);

        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'a@a.com',
            'password' => Hash::make('12345678'),
            'phone' => '0780000000',
            'department_id' => 1,
            'is_admin' => 1,
        ]);

        DB::table('users')->insert([
            'name' => 'user',
            'email' => 'b@a.com',
            'password' => Hash::make('12345678'),
            'phone' => '0780000001',
            'department_id' => 1,
            'is_admin' => 0,
        ]);

        DB::table('tasks')->insert([
            'id' => 1,
            'title' => 'task1',
            'description' => 'd for t1',
            'department_id' => 1,
            'assets' => 'google.com',
            'resources' => 'google.com',
            'start_date' => '2021-06-03',
            'deadline' => '2021-06-13',
            'budget' => 55,
        ]);

        DB::table('tasks')->insert([
            'id' => 2,
            'title' => 'task2',
            'description' => 'd for t2',
            'department_id' => 1,
            'assets' => 'google.com',
            'resources' => 'google.com',
            'start_date' => '2021-06-03',
            'deadline' => '2021-06-13',
            'budget' => 95,
        ]);

        DB::table('tasks')->insert([
            'id' => 3,
            'title' => 'task3',
            'description' => 'd for t3',
            'department_id' => 2,
            'assets' => 'google.com',
            'resources' => 'google.com',
            'start_date' => '2021-06-03',
            'deadline' => '2021-06-13',
            'budget' => 155,
        ]);

        DB::table('requirements')->insert([
            'body' => 'req 1 for task 1',
            'task_id' => 1,
        ]);

        DB::table('requirements')->insert([
            'body' => 'req 2 for task 1',
            'task_id' => 1,
        ]);

        DB::table('requirements')->insert([
            'body' => 'req 3 for task 1',
            'task_id' => 1,
        ]);

        DB::table('requirements')->insert([
            'body' => 'req 1 for task 2',
            'task_id' => 2,
        ]);

        DB::table('requirements')->insert([
            'body' => 'req 2 for task 2',
            'task_id' => 2,
        ]);

        DB::table('requirements')->insert([
            'body' => 'req 1 for task 3',
            'task_id' => 3,
        ]);
    }
}
