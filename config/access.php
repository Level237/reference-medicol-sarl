<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Chemin de connexion
    |--------------------------------------------------------------------------
    |
    | Adresse volontairement sans mot reconnaissable. Elle n'est pas liée
    | depuis le site public. Ne pas la remplacer par /admin/login ou /login.
    |
    */

    'path' => 'k8f3c1a9e2',

    /*
    |--------------------------------------------------------------------------
    | Tableau de bord
    |--------------------------------------------------------------------------
    |
    | Segment ajouté au chemin de connexion. L'adresse complète reste
    | introuvable : elle n'est pas /admin ni /dashboard.
    |
    */

    'board' => 'board',

    /*
    |--------------------------------------------------------------------------
    | Compte administrateur
    |--------------------------------------------------------------------------
    |
    | Lu par AdminSeeder. Ne pas écrire le mot de passe dans le code.
    |
    */

    'admin' => [
        'name' => env('ADMIN_NAME', 'Administrateur'),
        'email' => env('ADMIN_EMAIL'),
        'password' => env('ADMIN_PASSWORD'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Limite des tentatives de connexion
    |--------------------------------------------------------------------------
    |
    | Nombre de tentatives autorisées par minute, pour un même e-mail et
    | une même adresse IP.
    |
    */

    'rate_limit' => [
        'max_attempts' => 5,
    ],

];
