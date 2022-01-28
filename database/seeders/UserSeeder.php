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

        /**
         * Create admin user
         */
        $user = \App\Models\User::firstOrCreate([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin1123'),
            'username' => 'admin',
            'email_verified_at' => Carbon::now(),
            'dob' => Carbon::now()
        ]);

        $user->attachRole('admin');
        $user->attachPermissions(['all-create', 'all-read', 'all-update', 'all-delete']);

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
