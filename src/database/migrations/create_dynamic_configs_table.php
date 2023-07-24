<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use zukyDev\DynamicConfig\Models\DynamicConfig;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dynamic_configs', function (Blueprint $table) {
            $table->string('name')->primary();
            $table->enum('type', DynamicConfig::TYPES);
            $table->text('enums')->nullable();
            $table->text('value')->nullable();
            $table->text('default_value')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dynamic_configs');
    }
};
