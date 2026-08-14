<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
        Schema::create('doctor_working_hours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_user_id')->constrained('users');
            $table->unsignedTinyInteger('day_of_week');
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();

            $table->index(['doctor_user_id', 'day_of_week']);
        });

        $this->addWorkingHourConstraints();
    }

    public function down(): void {
        Schema::dropIfExists('doctor_working_hours');
    }

    private function addWorkingHourConstraints(): void {
        if (DB::getDriverName() === 'mysql') {
            DB::statement(<<<'SQL'
                ALTER TABLE doctor_working_hours
                ADD CONSTRAINT doctor_working_hours_valid_weekday CHECK (day_of_week BETWEEN 1 AND 7),
                ADD CONSTRAINT doctor_working_hours_valid_time_range CHECK (end_time > start_time)
                SQL);

            return;
        }

        if (DB::getDriverName() === 'sqlite') {
            DB::unprepared(<<<'SQL'
                CREATE TRIGGER doctor_working_hours_valid_insert
                BEFORE INSERT ON doctor_working_hours
                FOR EACH ROW WHEN NEW.day_of_week NOT BETWEEN 1 AND 7 OR NEW.end_time <= NEW.start_time
                BEGIN
                    SELECT RAISE(ABORT, 'doctor working hours must use a valid weekday and time range');
                END
                SQL);
            DB::unprepared(<<<'SQL'
                CREATE TRIGGER doctor_working_hours_valid_update
                BEFORE UPDATE OF day_of_week, start_time, end_time ON doctor_working_hours
                FOR EACH ROW WHEN NEW.day_of_week NOT BETWEEN 1 AND 7 OR NEW.end_time <= NEW.start_time
                BEGIN
                    SELECT RAISE(ABORT, 'doctor working hours must use a valid weekday and time range');
                END
                SQL);
        }
    }
};
