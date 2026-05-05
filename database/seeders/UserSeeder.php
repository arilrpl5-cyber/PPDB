<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\TestQuestion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        $userRole = Role::where('name', 'user')->first();

        User::firstOrCreate(
            ['email' => 'admin@pmb.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
            ]
        );

        $student = User::firstOrCreate(
            ['email' => 'student@pmb.com'],
            [
                'name' => 'Calon Mahasiswa',
                'password' => Hash::make('password'),
                'role_id' => $userRole->id,
            ]
        );

        if (!$student->profile) {
            $student->profile()->create([
                'phone' => '08123456789',
                'address' => 'Jl. Pendidikan No. 1',
                'test_number' => 'TEST-' . date('Y') . '-1',
            ]);
        }

        if (TestQuestion::count() === 0) {
            for ($i = 1; $i <= 10; $i++) {
                TestQuestion::create([
                    'question' => "Contoh Soal Ujian Nomor $i. Apa jawaban yang benar?",
                    'option_a' => "Jawaban A untuk soal $i",
                    'option_b' => "Jawaban B untuk soal $i",
                    'option_c' => "Jawaban C untuk soal $i",
                    'option_d' => "Jawaban D untuk soal $i",
                    'correct_answer' => ['A', 'B', 'C', 'D'][array_rand(['A', 'B', 'C', 'D'])],
                    'weight' => 10,
                ]);
            }
        }
    }
}