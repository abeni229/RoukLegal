<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - RoukLegal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1e40af;
            --primary-dark: #1e3a8a;
            --secondary: #0f766e;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        body {
            overflow: hidden;
        }

        .auth-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Form Section (Left Side - 50%) */
        .auth-form-section {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            padding: 2rem;
            overflow-y: auto;
        }

        .auth-form-container {
            width: 100%;
            max-width: 420px;
            animation: slideInLeft 0.5s ease-out;
        }

        .auth-header {
            margin-bottom: 2rem;
        }

        .auth-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .auth-subtitle {
            color: #6b7280;
            font-size: 0.95rem;
        }

        .form-control {
            padding: 0.75rem 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            font-size: 0.95rem;
            transition: all 0.3s;
            background: #f9fafb;
        }

        .form-control:focus {
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
        }

        .form-label {
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .btn-login {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border: none;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            border-radius: 0.5rem;
            width: 100%;
            color: white;
            font-size: 0.95rem;
            transition: all 0.3s;
            margin-top: 1rem;
            cursor: pointer;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(30, 64, 175, 0.3);
            color: white;
            text-decoration: none;
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .auth-link {
            text-align: center;
            margin-top: 1.5rem;
            font-size: 0.9rem;
        }

        .auth-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s;
        }

        .auth-link a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .alert {
            border-radius: 0.5rem;
            border: none;
            margin-bottom: 1.5rem;
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
        }

        .alert-danger {
            background-color: #fee2e2;
            color: #991b1b;
        }

        /* Branding Section (Right Side - 50%) */
        .auth-branding-section {
            flex: 1;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
            overflow: hidden;
            animation: slideInRight 0.5s ease-out;
        }

        .branding-content {
            text-align: center;
            color: white;
            z-index: 2;
            position: relative;
        }

        .branding-icon {
            font-size: 5rem;
            margin-bottom: 1.5rem;
            opacity: 0.9;
            animation: float 3s ease-in-out infinite;
        }

        .branding-title {
            font-size: 2.5rem;
            font-weight: 700;
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin-bottom: 0.75rem;
            letter-spacing: -0.5px;
        }

        .branding-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 2rem;
            font-weight: 300;
        }

        .branding-features {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-top: 2rem;
            text-align: left;
            max-width: 300px;
            margin-left: auto;
            margin-right: auto;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.95rem;
            opacity: 0.85;
        }

        .feature-icon {
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        /* Background shapes */
        .shape-1 {
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -50px;
            right: -50px;
        }

        .shape-2 {
            position: absolute;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            bottom: 50px;
            left: -30px;
        }

        /* Animations */
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        /* Mobile responsive */
        @media (max-width: 768px) {
            .auth-wrapper {
                flex-direction: column;
                min-height: auto;
            }

            .auth-form-section {
                min-height: auto;
                padding: 2rem 1rem;
            }

            .auth-branding-section {
                min-height: 300px;
                padding: 2rem 1rem;
            }

            .branding-title {
                font-size: 2rem;
            }

            .branding-icon {
                font-size: 3.5rem;
            }

            .branding-features {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="auth-wrapper">
        <!-- Form Section (Left) -->
        <div class="auth-form-section">
            <div class="auth-form-container">
                <div class="auth-header">
                    <h1 class="auth-title">Bienvenue</h1>
                    <p class="auth-subtitle">Connectez-vous à votre compte RoukLegal</p>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email" class="form-label"><i class="fas fa-envelope"></i> Email</label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="vous@example.com">
                    </div>
                    <div class="form-group">
                        <label for="mot_de_passe" class="form-label"><i class="fas fa-lock"></i> Mot de passe</label>
                        <input type="password" id="mot_de_passe" name="mot_de_passe" class="form-control" required placeholder="••••••••">
                    </div>
                    <button type="submit" class="btn btn-login"><i class="fas fa-sign-in-alt"></i> Se connecter</button>
                </form>

                <div class="auth-link">
                    Pas encore de compte? <a href="{{ route('register') }}">Créer un compte</a>
                </div>
            </div>
        </div>

        <!-- Branding Section (Right) -->
        <div class="auth-branding-section">
            <div class="shape-1"></div>
            <div class="shape-2"></div>
            <div class="branding-content">
                <div class="branding-icon">
                    <i class="fas fa-gavel"></i>
                </div>
                <div class="branding-title">RoukLegal</div>
                <div class="branding-subtitle">Plateforme juridique digne de confiance</div>
                <div class="branding-features">
                    <div class="feature-item">
                        <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
                        <div>Consultation sécurisée</div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon"><i class="fas fa-users"></i></div>
                        <div>Professionnels qualifiés</div>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon"><i class="fas fa-clock"></i></div>
                        <div>Rendez-vous flexibles</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>