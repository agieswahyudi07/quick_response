<?php

namespace database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Kabag Sarpras',
                'email' => 'kabag.sarpras@alhasra.sch.id',
                'role' => 'admin',
                'password' => Hash::make('zaHh8LWK)ru4neTMd7>E;x')
            ],
            [
                'name' => 'Admin Sarpras',
                'email' => 'admin.sarpras@alhasra.sch.id',
                'role' => 'admin',
                'password' => Hash::make('Fh/^%;A@Ec3{_Zj$2!m=+p')
            ],
            [
                'name' => 'IT Support Sarpras',
                'email' => 'it.sarpras@alhasra.sch.id',
                'role' => 'admin',
                'password' => Hash::make('Jk?T6)(>UACyK*x2j.3s^!')
            ],
            [
                'name' => 'Yayasan Al-hasra',
                'email' => 'yayasan.sarpras@alhasra.sch.id',
                'role' => 'user',
                'password' => Hash::make('RQ!cE-ua#~gV^A_SNLq7Cn')
            ],
            [
                'name' => 'SMA Al-hasra',
                'email' => 'sma.sarpras@alhasra.sch.id',
                'role' => 'user',
                'password' => Hash::make('R[Mh+35vU$,fGdwZXKyA-4')
            ],
            [
                'name' => 'SMP Al-hasra',
                'email' => 'smp.sarpras@alhasra.sch.id',
                'role' => 'user',
                'password' => Hash::make('VhR;(HTSaBF4eGyg.sp^]n')
            ],
            [
                'name' => 'SMK Al-hasra',
                'email' => 'smk.sarpras@alhasra.sch.id',
                'role' => 'user',
                'password' => Hash::make('aLUT@D;*u/7)H~wSFN"M8-')
            ],
        ];

        // Menyimpan data ke dalam tabel users
        foreach ($users as $key => $val) {
            User::create($val);
        }
    }
}
