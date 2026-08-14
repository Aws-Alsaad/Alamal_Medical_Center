<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role', 32)->index();
            $table->timestamps();
        });

        $this->addRoleConstraint();
    }

    public function down(): void {
        Schema::dropIfExists('users');
    }

    private function addRoleConstraint(): void {
        $allowedRoles = "'patient', 'doctor', 'secretary', 'super_administrator'";

        if (DB::getDriverName() === 'mysql') {
            DB::statement(
                "ALTER TABLE users ADD CONSTRAINT users_role_allowed CHECK (role IN ({$allowedRoles}))",
            );

            return;
        }

        if (DB::getDriverName() === 'sqlite') {
            DB::unprepared(<<<SQL
                CREATE TRIGGER users_role_allowed_insert
                BEFORE INSERT ON users
                FOR EACH ROW WHEN NEW.role NOT IN ({$allowedRoles})
                BEGIN
                    SELECT RAISE(ABORT, 'unsupported user role');
                END
                SQL);
            DB::unprepared(<<<SQL
                CREATE TRIGGER users_role_allowed_update
                BEFORE UPDATE OF role ON users
                FOR EACH ROW WHEN NEW.role NOT IN ({$allowedRoles})
                BEGIN
                    SELECT RAISE(ABORT, 'unsupported user role');
                END
                SQL);
        }
    }
};
