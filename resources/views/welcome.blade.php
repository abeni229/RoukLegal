<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RoukLegal - Plateforme Juridique en Ligne</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@700;800&display=swap" rel="stylesheet">
    <style>
        * { scroll-behavior: smooth; }
        :root {
            --primary: #1e40af;
            --primary-dark: #1e3a8a;
            --secondary: #0f766e;
            --success: #10b981;
            --dark: #1f2937;
        }
        body {
            font-family: 'Inter', sans-serif;
            background: #ffffff;
            color: var(--dark);
        }
        
        .navbar {
            background: white;
            box-shadow: 0 2px 15px rgba(0,0,0,0.08);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            animation: slideDown 0.5s ease-out;
        }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        
        .navbar-brand {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--primary) !important;
            font-family: 'Plus Jakarta Sans', sans-serif;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: transform 0.3s ease;
        }
        .navbar-brand:hover { transform: scale(1.05); }
        .navbar-brand i { font-size: 2rem; }
        
        .nav-link {
            color: var(--dark) !important;
            font-weight: 500;
            position: relative;
            transition: all 0.3s ease;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 0;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            transition: width 0.3s ease;
        }
        .nav-link:hover::after { width: 100%; }
        
        .btn-nav-login {
            background: var(--primary);
            color: white !important;
            border: none;
            padding: 0.6rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-nav-login:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(30,64,175,0.3);
        }
        
        .hero-section {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 100px 0;
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .hero-section::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            top: -100px;
            right: -100px;
            animation: float 6s ease-in-out infinite;
        }
        .hero-section::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(15,118,110,0.1);
            border-radius: 50%;
            bottom: -50px;
            left: -50px;
            animation: float 8s ease-in-out infinite reverse;
        }
        @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(20px); } }
        
        .hero-content {
            position: relative;
            z-index: 2;
            animation: fadeInUp 0.8s ease-out;
        }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }
        .hero-subtitle {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            opacity: 0.95;
            font-weight: 500;
        }
        
        .hero-buttons {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
        }
        .btn-hero {
            padding: 0.9rem 2.5rem;
            font-size: 1.1rem;
            border-radius: 0.6rem;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-hero-primary {
            background: white;
            color: var(--primary);
        }
        .btn-hero-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
            color: var(--primary);
        }
        .btn-hero-secondary {
            background: transparent;
            color: white;
            border: 2px solid white;
        }
        .btn-hero-secondary:hover {
            background: white;
            color: var(--primary);
            transform: translateY(-3px);
        }
        
        .hero-illustration {
            width: 100%;
            max-width: 500px;
            background: linear-gradient(135deg, rgba(255,255,255,0.15), rgba(255,255,255,0.05));
            border-radius: 1rem;
            padding: 3rem;
            text-align: center;
            border: 2px solid rgba(255,255,255,0.2);
            animation: pulse 4s ease-in-out infinite;
        }
        @keyframes pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.02); } }
        .hero-illustration i { font-size: 120px; opacity: 0.9; }
        
        .section-padding { padding: 100px 0; }
        .section-title {
            text-align: center;
            margin-bottom: 4rem;
            animation: fadeInUp 0.8s ease-out;
        }
        .section-title h2 {
            font-size: 2.8rem;
            font-weight: 800;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--dark);
            margin-bottom: 1rem;
        }
        .section-title p {
            font-size: 1.2rem;
            color: #6b7280;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .service-card {
            background: white;
            border-radius: 1rem;
            padding: 2.5rem 2rem;
            text-align: center;
            border: 1px solid #e5e7eb;
            transition: all 0.4s ease;
            animation: fadeInUp 0.8s ease-out;
        }
        .service-card:nth-child(2) { animation-delay: 0.2s; }
        .service-card:nth-child(3) { animation-delay: 0.4s; }
        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(30,64,175,0.1);
            border-color: var(--primary);
        }
        
        .service-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2.5rem;
            color: white;
            transition: all 0.3s ease;
        }
        .service-card:hover .service-icon {
            transform: rotate(10deg) scale(1.1);
        }
        
        .service-card h5 {
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1rem;
            font-size: 1.3rem;
        }
        .service-card p { color: #6b7280; margin: 0; }
        /* actors section */
        #actors .card {
            border: none;
            border-radius: 0.75rem;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        #actors .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.12);
        }
        #actors .card .btn {
            font-size: 0.85rem;
        }
        #actorsList .actor-card {
            width: 100%;
            max-width: none; /* allow full width */
            margin: 0 auto;
        }
        #actorsList .actor-card .card {
            width: 100%;
        }
        
        .about-section {
            background: linear-gradient(135deg, #f3f4f6 0%, #ffffff 100%);
        }
        .about-content {
            display: flex;
            align-items: center;
            gap: 4rem;
        }
        .about-illustration {
            width: 100%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 1.5rem;
            padding: 3rem;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        .about-illustration::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            top: -100px;
            right: -100px;
        }
        .about-illustration i {
            font-size: 100px;
            position: relative;
            z-index: 2;
        }
        
        .about-text h2 {
            font-size: 2.5rem;
            font-weight: 800;
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin-bottom: 1.5rem;
            color: var(--dark);
        }
        .about-text p {
            font-size: 1.1rem;
            color: #6b7280;
            margin-bottom: 1.5rem;
            line-height: 1.8;
        }
        
        .feature-item {
            display: flex;
            gap: 1rem;
            align-items: flex-start;
            margin-bottom: 1.5rem;
        }
        .feature-icon {
            width: 50px;
            height: 50px;
            background: var(--primary);
            color: white;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 1.5rem;
        }
        .feature-text h4 {
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }
        .feature-text p { color: #6b7280; margin: 0; font-size: 0.95rem; }
        
        .testimonial-card {
            background: white;
            border-radius: 1rem;
            padding: 2.5rem;
            border: 1px solid #e5e7eb;
            text-align: center;
            transition: all 0.3s ease;
            animation: fadeInUp 0.8s ease-out;
        }
        .testimonial-card:nth-child(2) { animation-delay: 0.2s; }
        .testimonial-card:nth-child(3) { animation-delay: 0.4s; }
        .testimonial-card:hover {
            box-shadow: 0 15px 35px rgba(30,64,175,0.15);
            transform: translateY(-5px);
        }
        
        .testimonial-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            margin: 0 auto 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2.5rem;
        }
        .testimonial-text {
            font-size: 1.05rem;
            color: #6b7280;
            margin-bottom: 1.5rem;
            font-style: italic;
        }
        .testimonial-author h5 {
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.3rem;
        }
        .testimonial-author p { font-size: 0.9rem; color: var(--primary); margin: 0; }
        .stars { color: #fbbf24; margin-bottom: 1rem; font-size: 1.2rem; }
        
        .cta-section {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 80px 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .cta-section::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            top: -100px;
            right: -100px;
        }
        .cta-content {
            position: relative;
            z-index: 2;
            animation: fadeInUp 0.8s ease-out;
        }
        .cta-section h2 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .cta-section p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.95;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        .btn-cta {
            background: white;
            color: var(--primary);
            padding: 1rem 3rem;
            font-size: 1.1rem;
            font-weight: 700;
            border: none;
            border-radius: 0.6rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        .btn-cta:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
            color: var(--primary);
        }
        
        footer {
            background: var(--dark);
            color: #d1d5db;
            padding-top: 60px;
            padding-bottom: 20px;
        }
        .footer-section { margin-bottom: 2rem; }
        .footer-section h5 {
            color: white;
            font-weight: 700;
            margin-bottom: 1.5rem;
            font-size: 1.1rem;
        }
        .footer-section ul { list-style: none; padding: 0; margin: 0; }
        .footer-section ul li { margin-bottom: 0.8rem; }
        .footer-section a {
            color: #d1d5db;
            text-decoration: none;
            transition: color 0.3s ease;
            font-size: 0.95rem;
        }
        .footer-section a:hover { color: var(--primary); }
        
        .footer-brand {
            font-size: 1.5rem;
            font-weight: 800;
            color: white;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .footer-brand i { color: var(--primary); font-size: 1.8rem; }
        .footer-description { color: #9ca3af; margin-bottom: 1.5rem; font-size: 0.95rem; line-height: 1.6; }
        
        .footer-social {
            display: flex;
            gap: 1rem;
        }
        .footer-social a {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            color: #d1d5db;
            text-decoration: none;
        }
        .footer-social a:hover {
            background: var(--primary);
            color: white;
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 2rem;
            margin-top: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .footer-bottom p { margin: 0; color: #9ca3af; font-size: 0.9rem; }
        .footer-links { display: flex; gap: 2rem; flex-wrap: wrap; }
        .footer-links a { color: #9ca3af; text-decoration: none; font-size: 0.9rem; transition: color 0.3s ease; }
        .footer-links a:hover { color: var(--primary); }
        
        @media (max-width: 768px) {
            .hero-title { font-size: 2.5rem; }
            .hero-subtitle { font-size: 1.1rem; }
            .hero-buttons { flex-direction: column; }
            .about-content { flex-direction: column; gap: 2rem; }
            .section-title h2 { font-size: 2rem; }
            .footer-bottom { flex-direction: column; align-items: flex-start; }
            .cta-section h2 { font-size: 1.8rem; }
        }
    </style>
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-gavel"></i> RoukLegal
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="#actors">Nos Acteurs Juridiques</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">À Propos</a></li>
                    <li class="nav-item"><a class="nav-link" href="#testimonials">Témoignages</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                    <li class="nav-item ms-2"><a class="btn btn-nav-login" href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> Connexion</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- HERO -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content">
                    <h1 class="hero-title">Solutions Juridiques en Ligne</h1>
                    <p class="hero-subtitle">Connectez-vous avec des professionnels du droit qualifiés pour résoudre vos questions juridiques en toute confiance</p>
                    <div class="hero-buttons">
                        <a href="{{ route('register') }}" class="btn-hero btn-hero-primary"><i class="fas fa-user-plus"></i> S'inscrire Gratuitement</a>
                        <a href="#services" class="btn-hero btn-hero-secondary"><i class="fas fa-arrow-down"></i> En Savoir Plus</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-illustration"><i class="fas fa-balance-scale"></i></div>
                </div>
            </div>
        </div>
    </section>

    <!-- SERVICES -->
    <section class="section-padding" id="services">
        <div class="container">
            <div class="section-title">
                <h2>Nos Services</h2>
                <p>Accédez à une large gamme de services juridiques professionnels adaptés à vos besoins</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="service-card">
                        <div class="service-icon"><i class="fas fa-question-circle"></i></div>
                        <h5>Consultation Juridique</h5>
                        <p>Posez vos questions à des avocats expérimentés et obtenez des réponses détaillées et fiables</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="service-card">
                        <div class="service-icon"><i class="fas fa-file-contract"></i></div>
                        <h5>Assistance Légale</h5>
                        <p>Bénéficiez d'une aide complète pour vos documents juridiques et contrats professionnels</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="service-card">
                        <div class="service-icon"><i class="fas fa-calendar-check"></i></div>
                        <h5>Rendez-vous Personnalisés</h5>
                        <p>Planifiez des consultations en tête-à-tête avec nos professionnels pour des besoins spécifiques</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ACTEURS -->
    <section class="section-padding" id="actors">
        <div class="container-fluid">
            <div class="section-title">
                <h2>Nos Acteurs Juridiques</h2>
                <p>Nous sommes là pour vous servir. Découvrez tous les professionnels inscrits sur la plateforme et contactez‑les facilement.</p>
            </div>
            <div class="row mb-4">
                <div class="col-md-6 offset-md-3">
                    <input type="text" id="actorSearch" class="form-control" placeholder="Rechercher un acteur ou une profession...">
                </div>
            </div>
            <div id="actorsList" class="d-flex flex-column gap-4">
                @forelse($actors as $actor)
                    <div class="actor-card" data-name="{{ strtolower($actor->nom) }}" data-profession="{{ strtolower(optional($actor->profession)->nom ?? $actor->profession_libre ?? '') }}">
                        <div class="card h-100 shadow-sm">
                            <div class="d-flex align-items-center p-3">
                                <div class="flex-shrink-0 me-3" style="width:50%; max-width:300px;">
                                    @if($actor->profile_photo)
                                        <img src="{{ asset('storage/' . $actor->profile_photo) }}" style="width:100%;height:100%;object-fit:cover;">
                                    @else
                                        <div style="width:100%;padding-top:100%;background:linear-gradient(135deg,var(--primary),var(--primary-dark));position:relative;">
                                            <i class="fas fa-user-tie" style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);color:white;font-size:2rem;"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-grow-1 text-start" style="width:50%;">
                                    <h5 class="card-title" style="color: var(--dark);">{{ $actor->nom }}</h5>
                                    <p class="text-muted" style="font-size:0.9rem;">
                                        {{ $actor->profession?->nom ?? $actor->profession_libre ?? 'Professionnel' }}
                                    </p>
                                    @if($actor->description)
                                        <p class="mt-2" style="color:#6b7280;font-size:0.9rem;">{{ Str::limit($actor->description, 100) }}</p>
                                    @endif
                                    <div class="mt-3">
                                        @if(Auth::check())
                                            <a href="{{ route('messages.conversation', $actor->id) }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-envelope"></i> Contacter
                                            </a>
                                        @else
                                            <a href="{{ route('register') }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-envelope"></i> Contacter
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center">Aucun acteur disponible</p>
                @endforelse
            </div>
            <p id="noActorsMessage" class="text-center" style="display:none;">Aucun résultat</p>
            @if(isset($hasMore) && $hasMore)
                <div class="text-center mt-4">
                    <a href="{{ route('client.acteurs') }}" class="btn btn-outline-primary">Voir plus d'acteurs</a>
                </div>
            @endif
        </div>
    </section>

    <!-- ABOUT -->
    <section class="section-padding about-section" id="about">
        <div class="container">
            <div class="about-content">
                <div>
                    <div class="about-illustration"><i class="fas fa-briefcase"></i></div>
                </div>
                <div class="about-text">
                    <h2>À Propos de RoukLegal</h2>
                    <p>RoukLegal est une plateforme révolutionnaire qui démocratise l'accès aux services juridiques. Nous connectons des clients avec des professionnels du droit qualifiés et expérimentés.</p>
                    <p>Notre mission est de rendre la consultation juridique accessible, abordable et pratique pour tous, où que vous soyez.</p>
                    <div>
                        <div class="feature-item">
                            <div class="feature-icon"><i class="fas fa-check"></i></div>
                            <div class="feature-text">
                                <h4>Avocats Vérifiés</h4>
                                <p>Tous nos professionnels sont vérifiés et certifiés par les ordres professionnels</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
                            <div class="feature-text">
                                <h4>Confidentialité Garantie</h4>
                                <p>Vos données et consultations sont protégées par le secret professionnel</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon"><i class="fas fa-fast-forward"></i></div>
                            <div class="feature-text">
                                <h4>Réponses Rapides</h4>
                                <p>Obtenez des réponses juridiques en moins de 24 heures en moyenne</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- TESTIMONIALS -->
    <script>
        document.getElementById('actorSearch')?.addEventListener('keyup', function(e) {
            const query = e.target.value.toLowerCase();
            const cards = document.querySelectorAll('.actor-card');
            let visible = 0;
            cards.forEach(card => {
                const name = card.getAttribute('data-name');
                const prof = card.getAttribute('data-profession');
                if (name.includes(query) || prof.includes(query)) {
                    card.style.display = 'block';
                    visible++;
                } else {
                    card.style.display = 'none';
                }
            });
            document.getElementById('noActorsMessage').style.display = visible === 0 ? 'block' : 'none';
        });
    </script>
    <section class="section-padding" id="testimonials">
        <div class="container">
            <div class="section-title">
                <h2>Ce Que Disent Nos Utilisateurs</h2>
                <p>Découvrez les expériences positives de nos clients satisfaits</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="testimonial-card">
                        <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                        <p class="testimonial-text">"Service exceptionnel! J'ai eu une réponse détaillée à ma question juridique en quelques heures. Les avocats sont vraiment professionnels."</p>
                        <div class="testimonial-avatar"><i class="fas fa-user"></i></div>
                        <div class="testimonial-author"><h5>Marie Dupont</h5><p>Entrepreneur</p></div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="testimonial-card">
                        <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                        <p class="testimonial-text">"RoukLegal a transformé ma façon d'accéder à des conseils juridiques. C'est rapide, transparent et abordable. Hautement recommandé!"</p>
                        <div class="testimonial-avatar"><i class="fas fa-user"></i></div>
                        <div class="testimonial-author"><h5>Jean Martin</h5><p>Développeur</p></div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="testimonial-card">
                        <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                        <p class="testimonial-text">"Plateforme innovante avec une interface intuitive. Les consultations de qualité à des prix justes. Je recommande vivement!"</p>
                        <div class="testimonial-avatar"><i class="fas fa-user"></i></div>
                        <div class="testimonial-author"><h5>Amina Sall</h5><p>Directrice Commerciale</p></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta-section" id="contact">
        <div class="cta-content">
            <h2>Prêt à Commencer?</h2>
            <p>Rejoignez des milliers d'utilisateurs qui font confiance à RoukLegal pour leurs besoins juridiques</p>
            <a href="{{ route('register') }}" class="btn-cta"><i class="fas fa-user-plus"></i> Créer Un Compte</a>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="footer-section">
                        <div class="footer-brand"><i class="fas fa-gavel"></i> RoukLegal</div>
                        <p class="footer-description">Votre plateforme de consultation juridique en ligne. Accédez facilement à des professionnels du droit qualifiés.</p>
                        <div class="footer-social">
                            <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                            <a href="#" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-section">
                        <h5><i class="fas fa-cogs"></i> Services</h5>
                        <ul>
                            <li><a href="#services">Consultation Juridique</a></li>
                            <li><a href="#services">Assistance Légale</a></li>
                            <li><a href="#services">Rendez-vous Personnalisés</a></li>
                            <li><a href="#services">Documents Juridiques</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-section">
                        <h5><i class="fas fa-building"></i> Entreprise</h5>
                        <ul>
                            <li><a href="#about">À Propos</a></li>
                            <li><a href="#">Conditions d'Utilisation</a></li>
                            <li><a href="#">Politique de Confidentialité</a></li>
                            <li><a href="#">Mentions Légales</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-section">
                        <h5><i class="fas fa-headset"></i> Contact</h5>
                        <ul>
                            <li><a href="tel:+2290150434710"><i class="fas fa-phone"></i> +229 0150434710</a></li>
                            <li><a href="mailto:contact@rouklegal.com"><i class="fas fa-envelope"></i> contact@rouklegal.com</a></li>
                            <li><i class="fas fa-map-marker-alt"></i> Calavi, Bénin</li>
                            <li><i class="fas fa-clock"></i> Lun-Ven: 9h-18h</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2026 RoukLegal. Tous droits réservés. Plateforme de consultation juridique professionnelle.</p>
                <div class="footer-links">
                    <a href="#">Conditions d'Utilisation</a>
                    <a href="#">Politique de Confidentialité</a>
                    <a href="#">Plan du Site</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) target.scrollIntoView({ behavior: 'smooth' });
            });
        });
    </script>
</body>
</html>
