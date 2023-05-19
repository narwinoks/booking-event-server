<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $model = new User();
        $model->username = "winarno12";
        $model->email = "win@gmail.com";
        $model->password = Hash::make("password");
        $model->role = UserRole::USER;
        $model->avatar = "profile.png";
        $model->save();

        $model = new User();
        $model->username = "admin";
        $model->email = "admin@gmail.com";
        $model->password = Hash::make("admin");
        $model->role = UserRole::ADMIN;
        $model->avatar = "profile.png";
        $model->save();
    }
}
