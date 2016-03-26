<?php

use CodeProject\Entities\ProjectTask;
use Illuminate\Database\Seeder;

class ProjectTaskTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProjectTask::truncate();

		factory(ProjectTask::class, 30)->create();
    }
}
