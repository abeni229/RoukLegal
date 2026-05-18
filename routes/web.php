<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ActeurController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CreneauController;
use App\Http\Controllers\RendezVousController;
use App\Http\Controllers\HomeController;

// Pages légales
Route::view('/mentions-legales', 'legal.mentions')->name('legal.mentions');
Route::view('/confidentialite', 'legal.privacy')->name('legal.privacy');
Route::view('/conditions-utilisation', 'legal.terms')->name('legal.terms');

// Homepage - Show landing page or redirect to dashboard
Route::get('/', [HomeController::class, 'index'])->name('home');


// Auth
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'reset'])->name('password.update');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Role selection after registration
Route::middleware(['auth', 'prevent.role.change'])->group(function () {
    Route::get('/select-role', [AuthController::class, 'showSelectRole'])->name('auth.selectRole');
    Route::post('/select-role', [AuthController::class, 'selectRole']);
});

// Dashboards avec middleware
Route::middleware(['auth', 'role:client'])->group(function () {
    Route::get('/client/dashboard', [ClientController::class, 'dashboard'])->name('client.dashboard');
    Route::get('/client/articles', [ClientController::class, 'articles'])->name('client.articles');
    Route::get('/client/acteurs', [ClientController::class, 'actors'])->name('client.acteurs');
    Route::get('/client/acteur/{user}', [ClientController::class, 'showActor'])->name('client.acteur.show');
    Route::get('/client/questions', [ClientController::class, 'questions'])->name('client.questions');
    Route::post('/client/start-trial', [ClientController::class, 'startFreeTrial'])->name('client.startTrial');
});

Route::middleware(['auth', 'role:acteur_juridique'])->group(function () {
    Route::get('/acteur/dashboard', [ActeurController::class, 'dashboard'])->name('acteur.dashboard');
    Route::get('/acteur/profile', [ActeurController::class, 'editProfile'])->name('acteur.profile');
    Route::post('/acteur/profile', [ActeurController::class, 'updateProfile'])->name('acteur.profile.update');
    Route::get('/acteur/questions', [ActeurController::class, 'questions'])->name('acteur.questions');
    Route::post('/acteur/questions/{question}/respond', [ActeurController::class, 'respondToQuestion'])->name('acteur.respondToQuestion');
   
});
Route::middleware(['auth', 'role:acteur_juridique'])->group(function () {
    Route::get('/articles/dashboard', [ArticleController::class, 'dashboard'])->name('articles.dashboard');
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/{id}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::post('/articles/{id}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{id}', [ArticleController::class, 'destroy'])->name('articles.destroy');
});

Route::middleware('auth')->group(function () {
    Route::delete('/settings', [\App\Http\Controllers\SettingsController::class, 'destroy'])->name('settings.destroy');
});

// Articles publiques (tous les users authentifiés peuvent lire)
Route::middleware('auth')->group(function () {
    Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
    Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('articles.show');
    Route::post('/articles/{id}/questions', [ArticleController::class, 'storeQuestion'])
        ->middleware('role:client')
        ->name('articles.storeQuestion');
    Route::post('/articles/{article}/noter', [ArticleController::class, 'noter'])
        ->middleware('role:client')
        ->name('articles.noter');
    // messaging between clients and actors after profile visit
    Route::get('/messages', [\App\Http\Controllers\MessageController::class, 'index'])
         ->name('messages.index');

    // user settings
    Route::get('/settings', [\App\Http\Controllers\SettingsController::class, 'edit'])->name('settings.edit');
    Route::post('/settings', [\App\Http\Controllers\SettingsController::class, 'update'])->name('settings.update');
    Route::get('/messages/{user}', [\App\Http\Controllers\MessageController::class, 'conversation'])
         ->name('messages.conversation');
    Route::post('/messages/{user}', [\App\Http\Controllers\MessageController::class, 'send'])
         ->name('messages.send');
});

//  CRÉNEAUX (acteur) 
Route::prefix('acteur')->middleware(['auth','role:acteur_juridique'])->group(function () {
    Route::get('/creneaux',                        [CreneauController::class, 'index'])->name('acteur.creneaux');
    Route::post('/creneaux',                       [CreneauController::class, 'store'])->name('acteur.creneaux.store');
    Route::patch('/creneaux/{creneau}/toggle',     [CreneauController::class, 'toggle'])->name('acteur.creneaux.toggle');
    Route::delete('/creneaux/{creneau}',           [CreneauController::class, 'destroy'])->name('acteur.creneaux.destroy');
    Route::get('/rendez-vous',                     [RendezVousController::class, 'acteurIndex'])->name('acteur.rendezVous');
    Route::post('/rendez-vous/{rdv}/confirmer',    [RendezVousController::class, 'confirmer'])->name('acteur.rdv.confirmer');
    Route::post('/rendez-vous/{rdv}/refuser',      [RendezVousController::class, 'refuser'])->name('acteur.rdv.refuser');
});

// CRÉNEAUX PUBLICS (pour le client, pas besoin d'être acteur)
Route::get('/acteur/{acteur}/creneaux-disponibles', [CreneauController::class, 'disponibles'])
    ->middleware('auth')
    ->name('acteur.creneaux.disponibles');

//RENDEZ-VOUS (client) 
Route::prefix('client')->middleware(['auth','role:client'])->group(function () {
    Route::get('/rendez-vous',                     [RendezVousController::class, 'clientIndex'])->name('client.rendezVous');
    Route::get('/reserver/{acteur}',               [RendezVousController::class, 'reserver'])->name('client.reserver');
    Route::post('/reserver/{acteur}',              [RendezVousController::class, 'initierPaiement'])->name('client.reserver.payer');
    Route::get('/abonnement',                      [ClientController::class, 'abonnement'])->name('client.abonnement');
    Route::post('/abonnement',                     [ClientController::class, 'payerAbonnement'])->name('client.abonnement.payer');
});

Route::prefix('admin')->middleware(['auth','role:admin'])->group(function () {
    Route::get('/dashboard',     [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/utilisateurs',  [AdminController::class, 'utilisateurs'])->name('admin.users');
    Route::get('/paiements',     [AdminController::class, 'paiements'])->name('admin.paiements');
    Route::get('/commissions',   [AdminController::class, 'commissions'])->name('admin.commissions');
    Route::get('/rendez-vous',   [RendezVousController::class, 'adminIndex'])->name('admin.rendezVous');
    Route::post('/rendez-vous/{rdv}/valider',    [RendezVousController::class, 'validerAdmin'])->name('admin.rdv.valider');
    Route::post('/rendez-vous/{rdv}/rembourser', [RendezVousController::class, 'rembourserAdmin'])->name('admin.rdv.rembourser');
    Route::get('/retraits',              [AdminController::class, 'retraits'])->name('admin.retraits');
    Route::post('/retraits/{retrait}/traiter',  [AdminController::class, 'traiterRetrait'])->name('admin.retraits.traiter');
    Route::post('/retraits/{retrait}/refuser',  [AdminController::class, 'refuserRetrait'])->name('admin.retraits.refuser');
});

// Acteur — retraits
Route::middleware(['auth','role:acteur_juridique'])->group(function () {
    Route::get('/acteur/retraits',       [ActeurController::class, 'retraits'])->name('acteur.retraits');
    Route::post('/acteur/retraits',      [ActeurController::class, 'storeRetrait'])->name('acteur.retraits.store');
});

// Admin — retraits (consolidated in admin group)

Route::get('/rdv/paiement/retour',  [RendezVousController::class, 'paiementRetour'])->name('rdv.paiement.retour')->middleware('auth');
Route::get('/rdv/paiement/annule',  [RendezVousController::class, 'paiementAnnule'])->name('rdv.paiement.annule')->middleware('auth');

Route::get('/acteur/abonnement',  [ActeurController::class, 'abonnement'])->name('acteur.abonnement')->middleware(['auth','role:acteur_juridique']);
Route::post('/acteur/abonnement', [ActeurController::class, 'payerAbonnement'])->name('acteur.abonnement.payer')->middleware(['auth','role:acteur_juridique']);