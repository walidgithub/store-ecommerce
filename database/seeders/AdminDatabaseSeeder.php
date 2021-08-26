<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class   extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Admin::create([
            'name'=>'walid barakat',
            'email'=>'leadermatrix@yahoo.com',
            'password'=>bcrypt('12345678'),
        ]);
    }
}
