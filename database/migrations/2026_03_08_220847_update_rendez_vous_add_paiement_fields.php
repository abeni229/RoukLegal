<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Modifier la table rendez_vous existante
        Schema::table('rendez_vous', function (Blueprint $table) {
            $table->integer('montant')->default(10000)->after('sujet');
            $table->enum('statut_paiement', [
                'en_attente',
                'payé',
                'validé_admin',
                'confirmé_acteur',
                'refusé',
                'remboursé'
            ])->default('en_attente')->after('montant');
            $table->string('paiement_id')->nullable()->after('statut_paiement');
            $table->integer('commission_admin')->default(2000)->after('paiement_id');
            $table->integer('commission_acteur')->default(8000)->after('commission_admin');
            $table->foreignId('creneau_id')->nullable()->constrained('creneaux')->nullOnDelete()->after('commission_acteur');
        });

        // Nouvelle table paiements_rdv
        Schema::create('paiements_rdv', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rdv_id')->constrained('rendez_vous')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('montant')->default(10000);
            $table->string('methode')->default('mobile_money'); // mobile_money | carte
            $table->enum('statut', ['initié','confirmé','remboursé'])->default('initié');
            $table->string('paygate_reference')->nullable();
            $table->timestamp('remboursement_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paiements_rdv');

        Schema::table('rendez_vous', function (Blueprint $table) {
            $table->dropForeign(['creneau_id']);
            $table->dropColumn([
                'montant','statut_paiement','paiement_id',
                'commission_admin','commission_acteur','creneau_id'
            ]);
        });
    }
};