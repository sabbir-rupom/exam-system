<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateUserTables();

        $user = \App\Models\User::firstOrCreate([
            'name' => 'admin_user',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin1123'),
            'email_verified_at' => Carbon::now(),
            'dob' => Carbon::now()
        ]);

        $user->attachRole('admin');
        $user->attachPermissions(['all-create', 'all-read', 'all-update', 'all-delete']);

        // create owner
        $userOwner = \App\Models\User::firstOrCreate([
            'name' => 'Sabbir',
            'email' => 'sabbir@gmail.com',
            'password' => Hash::make('test1123'),
            'email_verified_at' => Carbon::now(),
            'dob' => Carbon::now()
        ]);

        $userOwner->attachRole('owner');

        $owner = \App\Models\Owner::firstOrCreate([
            'user_id' => $userOwner->id,
            'status' => true,
            'domain' => 'sabbir',
            'activated_at' => Carbon::now(),
        ]);

        // create student
        $student = \App\Models\User::firstOrCreate([
            'name' => 'Student',
            'email' => 'student@gmail.com',
            'password' => Hash::make('test1123'),
            'email_verified_at' => Carbon::now(),
            'dob' => Carbon::now()
        ]);

        $student->attachRole('student');

        \App\Models\OwnerUser::firstOrCreate([
            'user_id' => $student->id,
            'owner_id' => $owner->id,
            'status' => true,
            'type' => \App\Models\OwnerUser::USER_STUDENT
        ]);

        // create student
        $teacher = \App\Models\User::firstOrCreate([
            'name' => 'Teacher',
            'email' => 'teacher@gmail.com',
            'password' => Hash::make('test1123'),
            'email_verified_at' => Carbon::now(),
            'dob' => Carbon::now()
        ]);

        $teacher->attachRole('teacher');

        \App\Models\OwnerUser::firstOrCreate([
            'user_id' => $teacher->id,
            'owner_id' => $owner->id,
            'status' => true,
            'type' => \App\Models\OwnerUser::USER_TEACHER
        ]);

    }

    /**
     * Truncates users table
     *
     * @return  void
     */
    public function truncateUserTables()
    {
        $this->command->info('Truncating User table');
        Schema::disableForeignKeyConstraints();

        $usersTable = (new \App\Models\User)->getTable();
        DB::table($usersTable)->truncate();

        Schema::enableForeignKeyConstraints();
    }
}
