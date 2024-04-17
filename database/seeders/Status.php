<?php

namespace Database\Seeders;

use App\Models\Status as StatusModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Status extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        StatusModel::create([
            "name" =>'To Do'
        ]);

        StatusModel::create([
            "name" =>'In Progress'
        ]);

        StatusModel::create([
            "name" =>'Done'
        ]);
    }
}
