<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniqueNameToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->after('name')->nullable()->unique();
            $table->string('mobile')->after('username')->nullable()->unique();
            $table->string('photo')->after('email')->nullable();
            $table->string('domain_now')->after('photo')->nullable();
            $table->string('verification_code', 12)->after('email_verified_at')->nullable();
            $table->boolean('blocked')->after('verification_code')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('username');
            $table->dropColumn('mobile');
            $table->dropColumn('photo');
            $table->dropColumn('domain_now');
            $table->dropColumn('verification_code');
            $table->dropColumn('blocked');
        });
    }
}
