<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Paket MCU: A, B, C, D, E
        Schema::create('mcu_packages', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique(); // A, B, C, D, E
            $table->string('name')->nullable();   // Optional longer name
            $table->timestamps();
        });

        // Item / jenis pemeriksaan (Physical Conditions, Blood Test, dst.)
        Schema::create('mcu_items', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Pivot: item mana yang termasuk dalam paket mana
        Schema::create('mcu_item_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mcu_item_id')->constrained()->cascadeOnDelete();
            $table->foreignId('mcu_package_id')->constrained()->cascadeOnDelete();
            $table->unique(['mcu_item_id', 'mcu_package_id']);
        });

        // Matrix: mapping posisi/departemen ke paket MCU
        Schema::create('mcu_matrices', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();         // e.g. GIS-PROD051
            $table->string('company')->nullable();
            $table->string('department')->nullable();
            $table->string('sub_section')->nullable();
            $table->string('employee_position');
            $table->unsignedBigInteger('mcu_package_id')->nullable();
            $table->foreign('mcu_package_id')->references('id')->on('mcu_packages')->nullOnDelete();
            $table->timestamps();
        });

        // Seed default packages A-E
        DB::table('mcu_packages')->insert([
            ['code' => 'A', 'name' => 'Paket A', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'B', 'name' => 'Paket B', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'C', 'name' => 'Paket C', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'D', 'name' => 'Paket D', 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'E', 'name' => 'Paket E', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('mcu_matrices');
        Schema::dropIfExists('mcu_item_packages');
        Schema::dropIfExists('mcu_items');
        Schema::dropIfExists('mcu_packages');
    }
};
