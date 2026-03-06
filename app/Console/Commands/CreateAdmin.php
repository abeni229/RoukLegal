<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create {name} {email} {password?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new admin user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = $this->argument('password') ?: 'admin123';

        // Vérifier si un admin existe déjà
        $existingAdmin = User::where('role', 'admin')->first();
        if ($existingAdmin) {
            $this->warn('Un administrateur existe déjà: ' . $existingAdmin->email);
            if (!$this->confirm('Voulez-vous créer un autre administrateur?')) {
                return;
            }
        }

        // Créer le nouvel admin
        $admin = User::create([
            'nom' => $name,
            'email' => $email,
            'mot_de_passe' => Hash::make($password),
            'role' => 'admin',
        ]);

        $this->info('Administrateur créé avec succès!');
        $this->info('Nom: ' . $admin->nom);
        $this->info('Email: ' . $admin->email);
        $this->info('Mot de passe: ' . $password);

        return 0;
    }
}
