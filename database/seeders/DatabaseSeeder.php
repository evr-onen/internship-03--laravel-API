<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        

        User::create([
            'name' => 'Evren',
            'email' => 'evr.onen@gmail.com',
            'password' => Hash::make('amiga500'),
            'user_spec' => 0,
            'store_id' => 0,

            


        ]);


    }
}
