<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('property_categories')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('description');
            $table->decimal('price', 15, 2);
            $table->decimal('area_sqft', 10, 2)->default(0);
            $table->unsignedTinyInteger('bedrooms')->default(0);
            $table->unsignedTinyInteger('bathrooms')->default(0);
            $table->unsignedTinyInteger('balconies')->default(0);
            $table->string('address');
            $table->string('locality'); // e.g., SG Highway, Prahlad Nagar, Bodakdev
            $table->string('city')->default('Ahmedabad');
            $table->string('state')->default('Gujarat');
            $table->string('pincode', 10)->default('380015');
            $table->enum('property_type', ['sale', 'rent'])->default('sale');
            $table->enum('status', ['active', 'pending', 'sold', 'rented'])->default('active');
            $table->boolean('is_featured')->default(false);
            $table->unsignedBigInteger('view_count')->default(0);
            $table->timestamps();

            // High-Performance Composite Indexes
            $table->index(['category_id', 'property_type', 'status']);
            $table->index(['price', 'property_type', 'status']);
            $table->index(['city', 'locality', 'status']);
            $table->index(['is_featured', 'status']);

            // Fulltext Index for Natural Search (MySQL / PostgreSQL / MariaDB)
            if (DB::getDriverName() !== 'sqlite') {
                $table->fullText(['title', 'description', 'address', 'locality']);
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
