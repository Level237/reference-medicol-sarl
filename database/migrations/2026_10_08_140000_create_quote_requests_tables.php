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
        Schema::create('quote_requests', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->string('status')->default('pending'); // pending, processing, processed, rejected

            // Coordonnées de l'établissement et du contact
            $table->string('organization_name');
            $table->string('organization_type')->nullable(); // CHU, Clinique, Cabinet, etc.
            $table->string('contact_name');
            $table->string('email');
            $table->string('phone');
            $table->string('address')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('city')->nullable();

            // Détails et gestion interne
            $table->text('message')->nullable();
            $table->decimal('estimated_total', 12, 2)->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('quote_request_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quote_request_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->string('product_name');
            $table->string('product_reference')->nullable();
            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('unit_price', 12, 2)->nullable();
            $table->decimal('total_price', 12, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_request_items');
        Schema::dropIfExists('quote_requests');
    }
};
