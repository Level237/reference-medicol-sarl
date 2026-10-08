<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use RuntimeException;

class AdminSeeder extends Seeder
{
    /**
     * Crée ou met à jour le compte administrateur à partir de la configuration.
     * Les identifiants viennent de l'environnement, jamais du code source.
     */
    public function run(): void
    {
        $name = config('access.admin.name');
        $email = config('access.admin.email');
        $password = config('access.admin.password');

        if (! is_string($email) || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new RuntimeException('ADMIN_EMAIL doit être une adresse e-mail valide.');
        }

        if (! is_string($password) || strlen($password) < 12) {
            throw new RuntimeException('ADMIN_PASSWORD doit contenir au moins 12 caractères.');
        }

        User::query()->updateOrCreate(
            ['email' => $email],
            [
                'name' => is_string($name) && $name !== '' ? $name : 'Administrateur',
                'password' => $password,
                'email_verified_at' => now(),
                'is_admin' => true,
            ],
        );
    }
}
