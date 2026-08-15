<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\DoctorWorkingHour;
use App\Models\MedicalService;
use App\Models\User;
use App\Shared\Identity\Enums\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use LogicException;

class DevelopmentSeeder extends Seeder
{
    public function run(): void {
        if (! app()->environment(['local', 'testing'])) {
            throw new LogicException('DevelopmentSeeder may run only in local or testing environments.');
        }

        $passwordHash = Hash::make('Password123!');

        $accounts = [
            [
                'name' => 'Development Patient',
                'email' => 'patient@example.test',
                'role' => UserRole::Patient,
            ],
            [
                'name' => 'Development Doctor',
                'email' => 'doctor@example.test',
                'role' => UserRole::Doctor,
            ],
            [
                'name' => 'Development Secretary',
                'email' => 'secretary@example.test',
                'role' => UserRole::Secretary,
            ],
            [
                'name' => 'Development Super Administrator',
                'email' => 'superadmin@example.test',
                'role' => UserRole::SuperAdministrator,
            ],
        ];

        foreach ($accounts as $account) {
            User::updateOrCreate(
                ['email' => $account['email']],
                [
                    'name' => $account['name'],
                    'password' => $passwordHash,
                    'role' => $account['role'],
                ],
            );
        }

        foreach ([
            'Development General Medicine',
            'Development Dentistry',
            'Development Pediatrics',
        ] as $departmentName) {
            Department::firstOrCreate(['name' => $departmentName]);
        }

        foreach ([
            'Development Consultation' => '50.00',
            'Development Dental Examination' => '75.00',
            'Development Pediatric Consultation' => '60.00',
        ] as $serviceName => $cost) {
            MedicalService::updateOrCreate(
                ['name' => $serviceName],
                ['cost' => $cost],
            );
        }

        $doctor = User::where('email', 'doctor@example.test')->firstOrFail();

        foreach ([
            ['day_of_week' => 1, 'start_time' => '09:00:00', 'end_time' => '12:00:00'],
            ['day_of_week' => 3, 'start_time' => '14:00:00', 'end_time' => '18:00:00'],
            ['day_of_week' => 5, 'start_time' => '09:00:00', 'end_time' => '13:00:00'],
        ] as $workingPeriod) {
            DoctorWorkingHour::firstOrCreate([
                'doctor_user_id' => $doctor->id,
                ...$workingPeriod,
            ]);
        }
    }
}
