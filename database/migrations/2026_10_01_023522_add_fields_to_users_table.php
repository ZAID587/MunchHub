<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('cliente')->after('email');
            }
            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username')->nullable()->after('name');
            }
            if (!Schema::hasColumn('users', 'apellido')) {
                $table->string('apellido')->nullable()->after('username');
            }
            if (!Schema::hasColumn('users', 'edad')) {
                $table->integer('edad')->nullable()->after('role');
            }
            if (!Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar')->nullable()->after('edad');
            }
            if (!Schema::hasColumn('users', 'telefono')) {
                $table->string('telefono')->nullable()->after('avatar');
            }
            if (!Schema::hasColumn('users', 'localidad')) {
                $table->string('localidad')->nullable()->after('telefono');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'username', 'apellido', 'edad', 'avatar', 'telefono', 'localidad']);
        });
    }
};
