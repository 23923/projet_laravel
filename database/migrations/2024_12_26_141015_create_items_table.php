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
        Schema::create('items', function (Blueprint $table) {
            $table->id(); // ID principal
            $table->string('nomart', 100); // Nom avec une limite de 100 caractères
            $table->decimal('prixUnitaire', 8, 2); // Prix en type decimal avec précision
            $table->text('description')->nullable(); // Notes facultatives
            $table->string('imageart', 255)->nullable(); // Stocke uniquement le chemin du fichier
            $table->unsignedBigInteger('categorie_id'); // Référence à la catégorie
            $table->boolean('is_active')->default(true); // Statut actif par défaut à vrai
            $table->timestamps(); // Colonnes created_at et updated_at

            // Clé étrangère avec contrainte onDelete restrict
            $table->foreign('categorie_id')
                ->references('id')
                ->on('categories')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
