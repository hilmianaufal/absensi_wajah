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
            Schema::table('employees', function (Blueprint $table) {
                $table->foreignId('work_shift_id')
                    ->nullable()
                    ->after('department')
                    ->constrained('work_shifts')
                    ->nullOnDelete();
            });
        }

        public function down(): void
        {
            Schema::table('employees', function (Blueprint $table) {
                $table->dropConstrainedForeignId('work_shift_id');
            });
        }
};
