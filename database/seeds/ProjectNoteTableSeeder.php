<?php

use CodeProject\Entities\ProjectNote;
use Illuminate\Database\Seeder;

class ProjectNoteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		ProjectNote::truncate();

        factory(ProjectNote::class, 50)->create();
    }
}
