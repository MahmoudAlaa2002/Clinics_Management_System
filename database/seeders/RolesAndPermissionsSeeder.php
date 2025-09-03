<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder{
    public function run(){
        // Reset cache
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'manage clinics',
            'view appointments',
            'create appointments',
            'edit patients',
            'view reports',
            'prescribe medication',
            'access dashboard',
            'access admin panel',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $clinicManager = Role::firstOrCreate(['name' => 'clinic_manager']);
        $departmentManager = Role::firstOrCreate(['name' => 'department_manager']);
        $doctor = Role::firstOrCreate(['name' => 'doctor']);
        $employee = Role::firstOrCreate(['name' => 'employee']);
        $patient = Role::firstOrCreate(['name' => 'patient']);

        // Assign permissions to roles
        $admin->syncPermissions($permissions);

        $clinicManager->syncPermissions([
            'manage clinics',
            'view appointments',
            'create appointments',
            'edit patients',
            'view reports',
            'access dashboard',
        ]);

        $departmentManager->syncPermissions([
            'view appointments',
            'create appointments',
            'edit patients',
            'view reports',
            'access dashboard',
        ]);

        $doctor->syncPermissions([
            'view appointments',
            'view reports',
            'prescribe medication',
            'access dashboard',
        ]);

        $employee->syncPermissions([
            'view appointments',
            'create appointments',
            'edit patients',
            'access dashboard',
        ]);

        $patient->syncPermissions([
            'view appointments',
        ]);
    }
}
