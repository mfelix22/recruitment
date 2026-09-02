<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // On MySQL the status column is already VARCHAR(50) - no change needed.
        // This migration existed only to expand SQLite CHECK constraints.
    }

    public function down(): void
    {
        // Nothing to reverse.
    }
};
