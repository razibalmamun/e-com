<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $user = new \App\Models\User();
        $user->fill([
            'name'=>'Admin',
            'email'=>'admin@admin.com',
            'password'=> 123123,
        ])->save();
    }
}
