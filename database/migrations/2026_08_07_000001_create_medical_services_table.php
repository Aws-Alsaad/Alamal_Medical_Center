<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void {
        Schema::create('medical_services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('cost', 10, 2);
            $table->timestamps();
        });

        $this->addCostConstraint();
    }

    public function down(): void {
        Schema::dropIfExists('medical_services');
    }

    private function addCostConstraint(): void {
        if (DB::getDriverName() === 'mysql') {
            DB::statement(
                'ALTER TABLE medical_services ADD CONSTRAINT medical_services_cost_non_negative CHECK (cost >= 0)',
            );

            return;
        }

        if (DB::getDriverName() === 'sqlite') {
            DB::unprepared(<<<'SQL'
                CREATE TRIGGER medical_services_cost_non_negative_insert
                BEFORE INSERT ON medical_services
                FOR EACH ROW WHEN NEW.cost < 0
                BEGIN
                    SELECT RAISE(ABORT, 'medical service cost must not be negative');
                END
                SQL);
            DB::unprepared(<<<'SQL'
                CREATE TRIGGER medical_services_cost_non_negative_update
                BEFORE UPDATE OF cost ON medical_services
                FOR EACH ROW WHEN NEW.cost < 0
                BEGIN
                    SELECT RAISE(ABORT, 'medical service cost must not be negative');
                END
                SQL);
        }
    }
};
