<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('featureables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('feature_id')->constrained('features')->cascadeOnDelete();
            $table->morphs('featureable');
            $table->timestamps();

            $table->unique(['feature_id', 'featureable_id', 'featureable_type'], 'featureable_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('featureables');
    }
};
