<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => env('HASNUR_ADMIN_EMAIL', 'admin@hasnurgroup.local')],
            [
                'name' => 'Hasnur Group Admin',
                'password' => env('HASNUR_ADMIN_PASSWORD', 'ChangeMe123!'),
            ]
        );
    }
}
