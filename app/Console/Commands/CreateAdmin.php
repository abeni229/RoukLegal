<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdmin extends Command
{
    protected $signature = 'admin:create {name} {email} {password?}';
    protected $description = 'Créer un nouvel administrateur';

    public function handle()
    {
        $name     = $this->argument('name');
        $email    = $this->argument('email');
        $password = $this->argument('password') ?: 'admin123';

        // Vérifier si l'email est déjà utilisé
        if (User::where('email', $email)->exists()) {
            $this->error('Cet email est déjà utilisé : ' . $email);
            return 1;
        }

        // Avertir si un admin existe déjà
        $existingAdmin = User::where('role', 'admin')->first();
        if ($existingAdmin) {
            $this->warn('Un administrateur existe déjà : ' . $existingAdmin->email);
            if (!$this->confirm('Voulez-vous créer un autre administrateur ?')) {
                return 0;
            }
        }

        // Créer l'admin — utilise les mêmes colonnes que le reste de l'app
        $admin = User::create([
            'nom'          => $name,
            'email'        => $email,
            'mot_de_passe' => Hash::make($password),
            'role'         => 'admin',
        ]);

        if (!$admin) {
            $this->error('Échec de la création. Vérifie les colonnes $fillable dans User.php.');
            return 1;
        }

        $this->info('');
        $this->info('✅ Administrateur créé avec succès !');
        $this->table(
            ['Champ', 'Valeur'],
            [
                ['Nom',        $admin->nom],
                ['Email',      $admin->email],
                ['Mot de passe', $password],
                ['Rôle',       $admin->role],
            ]
        );
        $this->warn('⚠️  Pensez à changer le mot de passe après la première connexion.');

        return 0;
    }
}