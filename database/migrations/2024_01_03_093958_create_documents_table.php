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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('description');
            $table->string('status');
            $table->string('isCatalog')->nullable();
            $table->foreignId('catalog_id')->nullable()->constrained(
                table: 'catalogs', indexName: 'document_catalog_id'
            );
            $table->foreignId('user_id')->nullable()->constrained(
                table: 'users', indexName: 'document_user_id'
            );
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
