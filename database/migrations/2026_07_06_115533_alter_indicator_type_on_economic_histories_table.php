<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE economic_histories
            MODIFY indicator_type VARCHAR(50)
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE economic_histories
            MODIFY indicator_type ENUM(
                'GDP',
                'INFLATION',
                'EXPORT',
                'IMPORT'
            )
        ");
    }
};