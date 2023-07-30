<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Rafi Musthafa',
            'email' => 'rafimusthafa74@gmail.com',
            'password' => Hash::make('password'),
        ]);
    }
}
?>
