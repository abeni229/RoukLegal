<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>RoukLegal — Plateforme Juridique en Ligne</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,500;0,700;0,900;1,400;1,700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
    html { scroll-behavior: smooth; }

    :root {
      --gold:     #c9a84c;
      --gold-lt:  #e2c47a;
      --gold-dim: rgba(201,168,76,.08);
      --ink:      #f5f0e8;
      --ink-dim:  rgba(245,240,232,.6);
      --bg:       #0c1117;
      --bg2:      #111820;
      --bg3:      #161f2a;
      --border:   rgba(201,168,76,.18);
      --red:      #e74c3c;
      --green:    #27ae60;
      --radius:   12px;
    }

    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--bg);
      color: var(--ink);
      overflow-x: hidden;
    }

    /* ─── GRAIN OVERLAY ─── */
    body::before {
      content: '';
      position: fixed;
      inset: 0;
      background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
      pointer-events: none;
      z-index: 9999;
      opacity: .6;
    }

    /* ─── NAVBAR ─── */
    nav {
      position: fixed;
      top: 0; left: 0; right: 0;
      z-index: 500;
      padding: 0 48px;
      height: 72px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      background: rgba(12,17,23,.85);
      backdrop-filter: blur(20px);
      border-bottom: 1px solid var(--border);
      animation: slideDown .6s ease both;
    }
    @keyframes slideDown { from { opacity:0; transform:translateY(-16px); } to { opacity:1; transform:none; } }

    .nav-brand {
      display: flex;
      align-items: center;
      gap: 10px;
      text-decoration: none;
      font-family: 'Playfair Display', serif;
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--ink);
      letter-spacing: .02em;
    }
    .nav-brand .gavel {
      width: 36px; height: 36px;
      background: var(--gold);
      border-radius: 8px;
      display: flex; align-items: center; justify-content: center;
      font-size: .9rem;
      color: var(--bg);
      flex-shrink: 0;
    }
    .nav-brand span { color: var(--gold); }

    .nav-links {
      display: flex;
      align-items: center;
      gap: 32px;
      list-style: none;
    }
    .nav-links a {
      text-decoration: none;
      font-size: .85rem;
      font-weight: 500;
      color: var(--ink-dim);
      letter-spacing: .04em;
      text-transform: uppercase;
      transition: color .2s;
    }
    .nav-links a:hover { color: var(--gold); }

    .nav-cta {
      display: flex;
      align-items: center;
      gap: 12px;
    }
    .btn-ghost {
      padding: 8px 20px;
      border: 1px solid var(--border);
      border-radius: 8px;
      font-size: .82rem;
      font-weight: 500;
      color: var(--ink-dim);
      text-decoration: none;
      transition: border-color .2s, color .2s;
    }
    .btn-ghost:hover { border-color: var(--gold); color: var(--gold); }
    .btn-gold {
      padding: 9px 22px;
      background: var(--gold);
      border-radius: 8px;
      font-size: .82rem;
      font-weight: 600;
      color: var(--bg);
      text-decoration: none;
      transition: background .2s, transform .15s;
    }
    .btn-gold:hover { background: var(--gold-lt); transform: translateY(-1px); }

    /* ─── HERO ─── */
    .hero {
      min-height: 100vh;
      display: grid;
      grid-template-columns: 1fr 1fr;
      align-items: center;
      gap: 0;
      padding: 120px 80px 80px;
      position: relative;
      overflow: hidden;
    }

    /* Ambient glow */
    .hero::before {
      content: '';
      position: absolute;
      width: 700px; height: 700px;
      background: radial-gradient(circle, rgba(201,168,76,.12) 0%, transparent 70%);
      top: -100px; right: -200px;
      pointer-events: none;
    }
    .hero::after {
      content: '';
      position: absolute;
      width: 400px; height: 400px;
      background: radial-gradient(circle, rgba(201,168,76,.06) 0%, transparent 70%);
      bottom: 0; left: 200px;
      pointer-events: none;
    }

    .hero-left { position: relative; z-index: 2; }

    .hero-eyebrow {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 6px 14px;
      background: var(--gold-dim);
      border: 1px solid var(--border);
      border-radius: 100px;
      font-size: .72rem;
      font-weight: 600;
      color: var(--gold);
      letter-spacing: .1em;
      text-transform: uppercase;
      margin-bottom: 28px;
      animation: fadeUp .8s .2s both;
    }
    .hero-eyebrow::before {
      content: '';
      width: 6px; height: 6px;
      border-radius: 50%;
      background: var(--gold);
      animation: blink 2s infinite;
    }
    @keyframes blink { 0%,100%{opacity:1} 50%{opacity:.3} }

    .hero-title {
      font-family: 'Playfair Display', serif;
      font-size: clamp(2.8rem, 5vw, 4.2rem);
      font-weight: 900;
      line-height: 1.1;
      color: var(--ink);
      margin-bottom: 24px;
      animation: fadeUp .8s .3s both;
    }
    .hero-title em {
      font-style: italic;
      color: var(--gold);
    }

    .hero-sub {
      font-size: 1.05rem;
      color: var(--ink-dim);
      line-height: 1.8;
      max-width: 480px;
      margin-bottom: 40px;
      animation: fadeUp .8s .4s both;
    }

    .hero-btns {
      display: flex;
      gap: 16px;
      flex-wrap: wrap;
      animation: fadeUp .8s .5s both;
    }
    .btn-hero-primary {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 14px 32px;
      background: var(--gold);
      border-radius: 10px;
      font-weight: 600;
      font-size: .95rem;
      color: var(--bg);
      text-decoration: none;
      transition: background .2s, transform .15s, box-shadow .2s;
    }
    .btn-hero-primary:hover {
      background: var(--gold-lt);
      transform: translateY(-2px);
      box-shadow: 0 12px 40px rgba(201,168,76,.3);
    }
    .btn-hero-outline {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 14px 32px;
      border: 1px solid var(--border);
      border-radius: 10px;
      font-weight: 500;
      font-size: .95rem;
      color: var(--ink-dim);
      text-decoration: none;
      transition: border-color .2s, color .2s;
    }
    .btn-hero-outline:hover { border-color: var(--gold); color: var(--gold); }

    .hero-stats {
      display: flex;
      gap: 40px;
      margin-top: 56px;
      animation: fadeUp .8s .65s both;
    }
    .hero-stat {}
    .hero-stat-num {
      font-family: 'Playfair Display', serif;
      font-size: 2rem;
      font-weight: 700;
      color: var(--gold);
      line-height: 1;
    }
    .hero-stat-label {
      font-size: .75rem;
      color: var(--ink-dim);
      margin-top: 4px;
      text-transform: uppercase;
      letter-spacing: .06em;
    }
    .stat-divider {
      width: 1px;
      background: var(--border);
      align-self: stretch;
    }

    /* Balance Scale illustration */
    .hero-right {
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      z-index: 2;
      animation: fadeUp .8s .4s both;
    }
    .scale-card {
      width: 440px;
      aspect-ratio: 1;
      background: var(--bg2);
      border: 1px solid var(--border);
      border-radius: 24px;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      overflow: hidden;
    }
    .scale-card::before {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(201,168,76,.06) 0%, transparent 60%);
    }
    .scale-icon {
      font-size: 9rem;
      color: var(--gold);
      opacity: .85;
      animation: float 5s ease-in-out infinite;
      position: relative;
      z-index: 2;
    }
    @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-14px)} }

    /* Gold corner decoration */
    .scale-card::after {
      content: '';
      position: absolute;
      top: 0; right: 0;
      width: 120px; height: 120px;
      background: conic-gradient(from 180deg at 100% 0%, var(--gold) 0deg, transparent 90deg);
      opacity: .15;
    }

    /* Floating badge */
    .float-badge {
      position: absolute;
      background: var(--bg3);
      border: 1px solid var(--border);
      border-radius: 12px;
      padding: 12px 16px;
      font-size: .8rem;
      display: flex;
      align-items: center;
      gap: 10px;
      animation: float 4s ease-in-out infinite;
      box-shadow: 0 8px 32px rgba(0,0,0,.4);
    }
    .float-badge.b1 { bottom: 40px; left: -20px; animation-delay: 0s; }
    .float-badge.b2 { top: 50px; right: -20px; animation-delay: 1.5s; }
    .float-badge-icon { width: 32px; height: 32px; border-radius: 8px; background: var(--gold-dim); border: 1px solid var(--border); display:flex;align-items:center;justify-content:center;color:var(--gold);font-size:.85rem; }
    .float-badge-text { font-size: .72rem; color: var(--ink-dim); }
    .float-badge-val { font-size: .82rem; font-weight: 600; color: var(--ink); }

    @keyframes fadeUp { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:none} }

    /* ─── SECTION GÉNÉRIQUE ─── */
    section { padding: 100px 80px; }
    .section-label {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      font-size: .7rem;
      font-weight: 600;
      color: var(--gold);
      letter-spacing: .15em;
      text-transform: uppercase;
      margin-bottom: 16px;
    }
    .section-label::before, .section-label::after {
      content: '';
      height: 1px;
      width: 24px;
      background: var(--gold);
      opacity: .5;
    }
    .section-title {
      font-family: 'Playfair Display', serif;
      font-size: clamp(2rem, 3.5vw, 2.8rem);
      font-weight: 700;
      color: var(--ink);
      line-height: 1.2;
      margin-bottom: 16px;
    }
    .section-sub {
      font-size: .95rem;
      color: var(--ink-dim);
      line-height: 1.8;
      max-width: 560px;
    }
    .section-head { margin-bottom: 60px; }

    /* ─── SERVICES ─── */
    #services { background: var(--bg2); }
    .services-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 24px;
    }
    .service-card {
      padding: 36px 32px;
      background: var(--bg3);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      transition: transform .25s, border-color .25s, box-shadow .25s;
      position: relative;
      overflow: hidden;
    }
    .service-card::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0;
      height: 2px;
      background: linear-gradient(90deg, transparent, var(--gold), transparent);
      opacity: 0;
      transition: opacity .3s;
    }
    .service-card:hover { transform: translateY(-6px); border-color: rgba(201,168,76,.35); box-shadow: 0 20px 60px rgba(0,0,0,.3); }
    .service-card:hover::before { opacity: 1; }
    .service-ico {
      width: 56px; height: 56px;
      background: var(--gold-dim);
      border: 1px solid var(--border);
      border-radius: 12px;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.4rem;
      color: var(--gold);
      margin-bottom: 24px;
      transition: background .25s;
    }
    .service-card:hover .service-ico { background: rgba(201,168,76,.18); }
    .service-card h4 {
      font-family: 'Playfair Display', serif;
      font-size: 1.15rem;
      font-weight: 600;
      color: var(--ink);
      margin-bottom: 12px;
    }
    .service-card p { font-size: .88rem; color: var(--ink-dim); line-height: 1.7; }
    .service-arrow {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      margin-top: 20px;
      font-size: .78rem;
      color: var(--gold);
      font-weight: 600;
      text-decoration: none;
      opacity: 0;
      transform: translateX(-8px);
      transition: opacity .25s, transform .25s;
    }
    .service-card:hover .service-arrow { opacity: 1; transform: none; }

    /* ─── ACTEURS ─── */
    #actors { background: var(--bg); }
    .actors-search {
      display: flex;
      gap: 12px;
      margin-bottom: 40px;
      max-width: 520px;
    }
    .search-wrap {
      flex: 1;
      position: relative;
    }
    .search-wrap i {
      position: absolute;
      left: 14px; top: 50%;
      transform: translateY(-50%);
      color: var(--ink-dim);
      font-size: .85rem;
      pointer-events: none;
    }
    .search-input {
      width: 100%;
      padding: 11px 14px 11px 38px;
      background: var(--bg2);
      border: 1px solid var(--border);
      border-radius: 10px;
      color: var(--ink);
      font-family: 'DM Sans', sans-serif;
      font-size: .88rem;
      outline: none;
      transition: border-color .2s;
    }
    .search-input:focus { border-color: var(--gold); }
    .search-input::placeholder { color: var(--ink-dim); }

    #actorsList { display: flex; flex-direction: column; gap: 16px; }
    .actor-card {
      display: flex;
      align-items: center;
      gap: 20px;
      padding: 20px 24px;
      background: var(--bg2);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      transition: border-color .2s, transform .2s;
    }
    .actor-card:hover { border-color: rgba(201,168,76,.4); transform: translateX(4px); }
    .actor-avatar {
      width: 56px; height: 56px;
      border-radius: 50%;
      background: var(--gold-dim);
      border: 2px solid var(--gold);
      display: flex; align-items: center; justify-content: center;
      overflow: hidden;
      flex-shrink: 0;
      font-family: 'Playfair Display', serif;
      font-size: 1.1rem;
      font-weight: 700;
      color: var(--gold);
    }
    .actor-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .actor-info { flex: 1; min-width: 0; }
    .actor-name {
      font-family: 'Playfair Display', serif;
      font-size: .98rem;
      font-weight: 600;
      color: var(--ink);
      margin-bottom: 4px;
    }
    .actor-profession {
      display: inline-block;
      padding: 3px 10px;
      background: var(--gold-dim);
      border: 1px solid var(--border);
      border-radius: 100px;
      font-size: .7rem;
      color: var(--gold);
      font-weight: 600;
      letter-spacing: .04em;
      margin-bottom: 6px;
    }
    .actor-desc { font-size: .8rem; color: var(--ink-dim); }
    .btn-actor {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 9px 20px;
      border: 1px solid var(--border);
      border-radius: 8px;
      font-size: .78rem;
      font-weight: 600;
      color: var(--gold);
      text-decoration: none;
      transition: background .2s, border-color .2s;
      flex-shrink: 0;
    }
    .btn-actor:hover { background: var(--gold-dim); border-color: var(--gold); }

    .actors-more { margin-top: 32px; text-align: center; }

    /* ─── À PROPOS ─── */
    #about { background: var(--bg2); }
    .about-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 80px;
      align-items: center;
    }
    .about-visual {
      position: relative;
    }
    .about-visual-main {
      background: var(--bg3);
      border: 1px solid var(--border);
      border-radius: 20px;
      padding: 60px;
      text-align: center;
      position: relative;
      overflow: hidden;
    }
    .about-visual-main::before {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(201,168,76,.05) 0%, transparent 60%);
    }
    .about-visual-main i { font-size: 7rem; color: var(--gold); opacity: .9; position: relative; z-index: 2; }
    .about-badge {
      position: absolute;
      bottom: -16px; right: 32px;
      background: var(--gold);
      color: var(--bg);
      padding: 10px 18px;
      border-radius: 10px;
      font-size: .8rem;
      font-weight: 700;
    }
    .features { display: flex; flex-direction: column; gap: 28px; margin-top: 40px; }
    .feature-item {
      display: flex;
      gap: 16px;
      align-items: flex-start;
    }
    .feature-ico {
      width: 44px; height: 44px;
      background: var(--gold-dim);
      border: 1px solid var(--border);
      border-radius: 10px;
      display: flex; align-items: center; justify-content: center;
      color: var(--gold);
      font-size: .9rem;
      flex-shrink: 0;
    }
    .feature-item h5 { font-size: .9rem; font-weight: 600; color: var(--ink); margin-bottom: 4px; }
    .feature-item p { font-size: .82rem; color: var(--ink-dim); line-height: 1.7; }

    /* ─── TÉMOIGNAGES ─── */
    #testimonials { background: var(--bg); }
    .testi-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 24px;
    }
    .testi-card {
      padding: 32px 28px;
      background: var(--bg2);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      transition: transform .25s, border-color .25s;
    }
    .testi-card:hover { transform: translateY(-4px); border-color: rgba(201,168,76,.3); }
    .testi-stars { color: var(--gold); font-size: .85rem; letter-spacing: 2px; margin-bottom: 18px; }
    .testi-text {
      font-size: .88rem;
      color: var(--ink-dim);
      line-height: 1.8;
      font-style: italic;
      margin-bottom: 24px;
    }
    .testi-author { display: flex; align-items: center; gap: 12px; }
    .testi-av {
      width: 44px; height: 44px;
      border-radius: 50%;
      background: var(--gold-dim);
      border: 1px solid var(--border);
      display: flex; align-items: center; justify-content: center;
      color: var(--gold);
      font-size: 1rem;
    }
    .testi-name { font-size: .88rem; font-weight: 600; color: var(--ink); }
    .testi-role { font-size: .72rem; color: var(--gold); margin-top: 2px; }

    /* ─── CTA ─── */
    .cta-section {
      margin: 0 80px 100px;
      background: var(--bg2);
      border: 1px solid var(--border);
      border-radius: 24px;
      padding: 80px;
      text-align: center;
      position: relative;
      overflow: hidden;
    }
    .cta-section::before {
      content: '';
      position: absolute;
      width: 600px; height: 600px;
      background: radial-gradient(circle, rgba(201,168,76,.1) 0%, transparent 65%);
      top: 50%; left: 50%;
      transform: translate(-50%,-50%);
      pointer-events: none;
    }
    .cta-section h2 {
      font-family: 'Playfair Display', serif;
      font-size: clamp(2rem, 3vw, 2.8rem);
      font-weight: 700;
      color: var(--ink);
      margin-bottom: 16px;
      position: relative;
      z-index: 2;
    }
    .cta-section p {
      font-size: .95rem;
      color: var(--ink-dim);
      max-width: 480px;
      margin: 0 auto 36px;
      line-height: 1.8;
      position: relative;
      z-index: 2;
    }
    .cta-btns { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; position: relative; z-index: 2; }

    /* ─── FOOTER ─── */
    footer {
      background: var(--bg2);
      border-top: 1px solid var(--border);
      padding: 60px 80px 32px;
    }
    .footer-grid {
      display: grid;
      grid-template-columns: 1.5fr 1fr 1fr 1fr;
      gap: 48px;
      margin-bottom: 48px;
    }
    .footer-brand-wrap { display: flex; flex-direction: column; gap: 0; }
    .footer-logo {
      display: flex;
      align-items: center;
      gap: 10px;
      font-family: 'Playfair Display', serif;
      font-size: 1.3rem;
      font-weight: 700;
      color: var(--ink);
      margin-bottom: 16px;
    }
    .footer-logo .gavel {
      width: 32px; height: 32px;
      background: var(--gold);
      border-radius: 7px;
      display: flex; align-items: center; justify-content: center;
      font-size: .8rem;
      color: var(--bg);
    }
    .footer-logo span { color: var(--gold); }
    .footer-desc { font-size: .82rem; color: var(--ink-dim); line-height: 1.8; margin-bottom: 24px; }
    .footer-social { display: flex; gap: 10px; }
    .footer-social a {
      width: 36px; height: 36px;
      border-radius: 50%;
      background: var(--gold-dim);
      border: 1px solid var(--border);
      display: flex; align-items: center; justify-content: center;
      font-size: .8rem;
      color: var(--ink-dim);
      text-decoration: none;
      transition: background .2s, color .2s;
    }
    .footer-social a:hover { background: var(--gold); color: var(--bg); border-color: var(--gold); }
    .footer-col h6 {
      font-size: .72rem;
      font-weight: 700;
      color: var(--gold);
      letter-spacing: .12em;
      text-transform: uppercase;
      margin-bottom: 20px;
    }
    .footer-col ul { list-style: none; display: flex; flex-direction: column; gap: 10px; }
    .footer-col ul li a, .footer-col ul li {
      font-size: .82rem;
      color: var(--ink-dim);
      text-decoration: none;
      transition: color .2s;
    }
    .footer-col ul li a:hover { color: var(--gold); }
    .footer-bottom {
      border-top: 1px solid var(--border);
      padding-top: 24px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 16px;
      flex-wrap: wrap;
    }
    .footer-bottom p { font-size: .75rem; color: var(--ink-dim); }
    .footer-bottom-links { display: flex; gap: 24px; }
    .footer-bottom-links a { font-size: .75rem; color: var(--ink-dim); text-decoration: none; transition: color .2s; }
    .footer-bottom-links a:hover { color: var(--gold); }

    /* ─── RESPONSIVE ─── */
    .hamburger { display: none; background: none; border: 1px solid var(--border); border-radius: 8px; padding: 8px 12px; color: var(--ink); cursor: pointer; font-size: .9rem; }
    @media (max-width: 1024px) {
      nav { padding: 0 24px; }
      .nav-links { display: none; }
      .hamburger { display: block; }
      .hero { grid-template-columns: 1fr; padding: 120px 24px 60px; gap: 48px; }
      .hero-right { display: none; }
      section { padding: 60px 24px; }
      .services-grid, .about-grid, .testi-grid { grid-template-columns: 1fr; }
      .cta-section { margin: 0 24px 60px; padding: 48px 24px; }
      footer { padding: 40px 24px 24px; }
      .footer-grid { grid-template-columns: 1fr 1fr; gap: 32px; }
      .hero-stats { flex-wrap: wrap; gap: 24px; }
    }

    /* Scroll reveal */
    .reveal { opacity: 0; transform: translateY(28px); transition: opacity .7s ease, transform .7s ease; }
    .reveal.visible { opacity: 1; transform: none; }
  </style>
</head>
<body>

<!-- NAVBAR -->
<nav>
  <a class="nav-brand" href="/">
    <div class="gavel"><i class="fas fa-gavel"></i></div>
    Rouk<span>Legal</span>
  </a>
  <ul class="nav-links">
    <li><a href="#services">Services</a></li>
    <li><a href="#actors">Acteurs</a></li>
    <li><a href="#about">À propos</a></li>
    <li><a href="#testimonials">Témoignages</a></li>
  </ul>
  <div class="nav-cta">
    <a href="{{ route('login') }}" class="btn-ghost">Connexion</a>
    <a href="{{ route('register') }}" class="btn-gold">S'inscrire</a>
  </div>
  <button class="hamburger" onclick="this.nextElementSibling?.classList.toggle('open')"><i class="fas fa-bars"></i></button>
</nav>

<!-- HERO -->
<section class="hero">
  <div class="hero-left">
    <div class="hero-eyebrow">Plateforme juridique en ligne</div>
    <h1 class="hero-title">
      L'expertise<br>juridique à<br><em>portée de main</em>
    </h1>
    <p class="hero-sub">
      Connectez-vous avec des professionnels du droit qualifiés pour résoudre vos questions juridiques — simplement, rapidement, en toute confiance.
    </p>
    <div class="hero-btns">
      <a href="{{ route('register') }}" class="btn-hero-primary">
        <i class="fas fa-user-plus"></i> Commencer gratuitement
      </a>
      <a href="#services" class="btn-hero-outline">
        Découvrir les services <i class="fas fa-arrow-down"></i>
      </a>
    </div>
    <div class="hero-stats">
      <div class="hero-stat">
        <div class="hero-stat-num">500+</div>
        <div class="hero-stat-label">Clients actifs</div>
      </div>
      <div class="stat-divider"></div>
      <div class="hero-stat">
        <div class="hero-stat-num">120+</div>
        <div class="hero-stat-label">Experts juridiques</div>
      </div>
      <div class="stat-divider"></div>
      <div class="hero-stat">
        <div class="hero-stat-num">98%</div>
        <div class="hero-stat-label">Satisfaction</div>
      </div>
    </div>
  </div>
  <div class="hero-right">
    <div style="position:relative;">
      <div class="scale-card">
        <i class="fas fa-balance-scale scale-icon"></i>
      </div>
      <div class="float-badge b1">
        <div class="float-badge-icon"><i class="fas fa-check"></i></div>
        <div>
          <div class="float-badge-val">Question répondue</div>
          <div class="float-badge-text">il y a 2 minutes</div>
        </div>
      </div>
      <div class="float-badge b2">
        <div class="float-badge-icon"><i class="fas fa-star"></i></div>
        <div>
          <div class="float-badge-val">4.9 / 5</div>
          <div class="float-badge-text">Note moyenne</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SERVICES -->
<section id="services">
  <div class="section-head reveal">
    <div class="section-label">Ce que nous offrons</div>
    <h2 class="section-title">Des services juridiques<br>adaptés à vos besoins</h2>
    <p class="section-sub">Accédez à une gamme complète de services professionnels, de la simple question aux consultations approfondies.</p>
  </div>
  <div class="services-grid">
    @foreach([
      ['fas fa-question-circle','Consultation Juridique','Posez vos questions à des avocats expérimentés et obtenez des réponses détaillées, fiables et argumentées.','En savoir plus'],
      ['fas fa-file-contract','Assistance Légale','Bénéficiez d\'une aide complète pour vos documents juridiques, contrats et procédures administratives.','En savoir plus'],
      ['fas fa-calendar-check','Rendez-vous Personnalisés','Planifiez des consultations en tête-à-tête avec nos professionnels pour vos besoins spécifiques.','En savoir plus'],
      ['fas fa-newspaper','Articles Juridiques','Accédez à une bibliothèque d\'articles rédigés par nos experts sur tous les domaines du droit.','Lire les articles'],
      ['fas fa-comments','Messagerie Privée','Échangez directement avec un professionnel via notre messagerie sécurisée et confidentielle.','En savoir plus'],
      ['fas fa-star','Système de Notation','Évaluez vos interactions et consultez les avis d\'autres clients pour choisir votre expert.','En savoir plus'],
    ] as $s)
    <div class="service-card reveal">
      <div class="service-ico"><i class="{{ $s[0] }}"></i></div>
      <h4>{{ $s[1] }}</h4>
      <p>{{ $s[2] }}</p>
      <a href="{{ route('register') }}" class="service-arrow">{{ $s[3] }} <i class="fas fa-arrow-right" style="font-size:.7rem;"></i></a>
    </div>
    @endforeach
  </div>
</section>

<!-- ACTEURS JURIDIQUES -->
<section id="actors">
  <div class="section-head reveal">
    <div class="section-label">Nos professionnels</div>
    <h2 class="section-title">Rencontrez nos<br>acteurs juridiques</h2>
    <p class="section-sub">Des professionnels vérifiés et qualifiés prêts à répondre à vos questions.</p>
  </div>

  <div class="actors-search reveal">
    <div class="search-wrap">
      <i class="fas fa-search"></i>
      <input type="text" id="actorSearch" class="search-input" placeholder="Rechercher un acteur ou une profession…">
    </div>
  </div>

  <div id="actorsList">
    @forelse($actors as $actor)
    <div class="actor-card reveal"
         data-name="{{ strtolower($actor->nom) }}"
         data-profession="{{ strtolower(optional($actor->profession)->nom ?? $actor->profession_libre ?? '') }}">
      <div class="actor-avatar">
        @if($actor->photo_professionnelle)
          <img src="{{ asset('storage/'.$actor->photo_professionnelle) }}" alt="{{ $actor->nom }}">
        @elseif($actor->profile_photo)
          <img src="{{ asset('storage/'.$actor->profile_photo) }}" alt="{{ $actor->nom }}">
        @else
          {{ strtoupper(substr($actor->nom,0,2)) }}
        @endif
      </div>
      <div class="actor-info">
        <div class="actor-name">{{ $actor->nom }}</div>
        <div class="actor-profession">{{ $actor->profession?->nom ?? $actor->profession_libre ?? 'Expert juridique' }}</div>
        @if($actor->description)
        <div class="actor-desc">{{ Str::limit($actor->description, 100) }}</div>
        @endif
      </div>
      @if(Auth::check())
        <a href="{{ route('messages.conversation', $actor->id) }}" class="btn-actor">
          <i class="fas fa-comments"></i> Contacter
        </a>
      @else
        <a href="{{ route('register') }}" class="btn-actor">
          <i class="fas fa-user-plus"></i> Rejoindre
        </a>
      @endif
    </div>
    @empty
    <div style="text-align:center;padding:48px;color:var(--ink-dim);font-size:.9rem;">
      <i class="fas fa-user-slash" style="font-size:2rem;color:var(--border);display:block;margin-bottom:12px;"></i>
      Aucun acteur disponible pour le moment.
    </div>
    @endforelse
  </div>
  <p id="noActors" style="display:none;text-align:center;padding:32px;color:var(--ink-dim);font-size:.88rem;">Aucun résultat pour cette recherche.</p>

  @if(isset($hasMore) && $hasMore)
  <div class="actors-more reveal">
    <a href="{{ route('client.acteurs') }}" class="btn-hero-outline" style="display:inline-flex;">
      Voir tous les acteurs <i class="fas fa-arrow-right"></i>
    </a>
  </div>
  @endif
</section>

<!-- À PROPOS -->
<section id="about">
  <div class="about-grid">
    <div class="about-visual reveal">
      <div class="about-visual-main">
        <i class="fas fa-briefcase"></i>
        <div class="about-badge">⚖️ Depuis 2024</div>
      </div>
      <div class="features">
        @foreach([
          ['fas fa-check','Professionnels vérifiés','Tous nos experts sont certifiés et validés par les ordres professionnels.'],
          ['fas fa-shield-alt','Confidentialité garantie','Vos consultations sont protégées par le secret professionnel.'],
          ['fas fa-bolt','Réponses en 24h','Obtenez des réponses juridiques rapides et fiables.'],
        ] as $f)
        <div class="feature-item">
          <div class="feature-ico"><i class="{{ $f[0] }}"></i></div>
          <div>
            <h5>{{ $f[1] }}</h5>
            <p>{{ $f[2] }}</p>
          </div>
        </div>
        @endforeach
      </div>
    </div>
    <div class="reveal">
      <div class="section-label">Notre mission</div>
      <h2 class="section-title">Démocratiser<br>l'accès au droit</h2>
      <p style="font-size:.92rem;color:var(--ink-dim);line-height:1.9;margin-bottom:20px;">
        RoukLegal est une plateforme qui révolutionne l'accès aux services juridiques au Bénin et en Afrique de l'Ouest. Nous connectons les clients avec des professionnels du droit qualifiés et expérimentés.
      </p>
      <p style="font-size:.92rem;color:var(--ink-dim);line-height:1.9;margin-bottom: 36px;">
        Notre mission est de rendre la consultation juridique accessible, abordable et pratique pour tous — particuliers, entrepreneurs et entreprises.
      </p>
      <a href="{{ route('register') }}" class="btn-hero-primary" style="display:inline-flex;">
        <i class="fas fa-user-plus"></i> Rejoindre RoukLegal
      </a>
    </div>
  </div>
</section>

<!-- TÉMOIGNAGES -->
<section id="testimonials" style="background:var(--bg2);">
  <div class="section-head reveal" style="text-align:center;">
    <div class="section-label" style="justify-content:center;">Témoignages</div>
    <h2 class="section-title" style="text-align:center;">Ce que disent<br>nos utilisateurs</h2>
  </div>
  <div class="testi-grid">
    @foreach([
      ['"Service exceptionnel ! J\'ai eu une réponse détaillée à ma question juridique en quelques heures. Les experts sont vraiment professionnels et à l\'écoute."','Marie Dupont','Entrepreneur'],
      ['"RoukLegal a transformé ma façon d\'accéder à des conseils juridiques. C\'est rapide, transparent et abordable. Je recommande vivement !"','Jean Martin','Développeur Web'],
      ['"Plateforme innovante avec une interface intuitive. Des consultations de qualité à des prix justes. Indispensable pour tout entrepreneur."','Amina Sall','Directrice Commerciale'],
    ] as $t)
    <div class="testi-card reveal">
      <div class="testi-stars">★★★★★</div>
      <p class="testi-text">{{ $t[0] }}</p>
      <div class="testi-author">
        <div class="testi-av"><i class="fas fa-user"></i></div>
        <div>
          <div class="testi-name">{{ $t[1] }}</div>
          <div class="testi-role">{{ $t[2] }}</div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</section>

<!-- CTA -->
<div class="cta-section reveal">
  <h2>Prêt à accéder à l'expertise<br><em style="font-style:italic;color:var(--gold);">juridique dont vous avez besoin ?</em></h2>
  <p>Rejoignez des centaines d'utilisateurs qui font confiance à RoukLegal pour leurs questions juridiques.</p>
  <div class="cta-btns">
    <a href="{{ route('register') }}" class="btn-hero-primary"><i class="fas fa-user-plus"></i> Créer un compte gratuit</a>
    <a href="{{ route('login') }}" class="btn-hero-outline"><i class="fas fa-sign-in-alt"></i> Se connecter</a>
  </div>
</div>

<!-- FOOTER -->
<footer>
  <div class="footer-grid">
    <div class="footer-brand-wrap">
      <div class="footer-logo">
        <div class="gavel"><i class="fas fa-gavel"></i></div>
        Rouk<span>Legal</span>
      </div>
      <p class="footer-desc">Votre plateforme de consultation juridique en ligne. Accédez facilement à des professionnels du droit qualifiés au Bénin et en Afrique.</p>
      <div class="footer-social">
        <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
        <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
        <a href="#" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
        <a href="#" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
      </div>
    </div>
    <div class="footer-col">
      <h6>Services</h6>
      <ul>
        <li><a href="#services">Consultation Juridique</a></li>
        <li><a href="#services">Assistance Légale</a></li>
        <li><a href="#services">Rendez-vous</a></li>
        <li><a href="#services">Articles Juridiques</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h6>Entreprise</h6>
      <ul>
        <li><a href="#about">À Propos</a></li>
        <li><a href="#">Conditions d'Utilisation</a></li>
        <li><a href="#">Confidentialité</a></li>
        <li><a href="#">Mentions Légales</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h6>Contact</h6>
      <ul>
        <li><a href="tel:+2290150434710"><i class="fas fa-phone" style="margin-right:6px;color:var(--gold);"></i>+229 01 50 43 47 10</a></li>
        <li><a href="mailto:contact@rouklegal.com"><i class="fas fa-envelope" style="margin-right:6px;color:var(--gold);"></i>contact@rouklegal.com</a></li>
        <li><i class="fas fa-map-marker-alt" style="margin-right:6px;color:var(--gold);"></i>Calavi, Bénin</li>
        <li><i class="fas fa-clock" style="margin-right:6px;color:var(--gold);"></i>Lun–Ven : 9h–18h</li>
      </ul>
    </div>
  </div>
  <div class="footer-bottom">
    <p>&copy; 2026 RoukLegal. Tous droits réservés.</p>
    <div class="footer-bottom-links">
      <a href="#">Conditions</a>
      <a href="#">Confidentialité</a>
      <a href="#">Plan du site</a>
    </div>
  </div>
</footer>

<script>
// Recherche acteurs
document.getElementById('actorSearch')?.addEventListener('keyup', function() {
  const q = this.value.toLowerCase();
  const cards = document.querySelectorAll('#actorsList .actor-card');
  let n = 0;
  cards.forEach(c => {
    const match = c.dataset.name.includes(q) || c.dataset.profession.includes(q);
    c.style.display = match ? '' : 'none';
    if(match) n++;
  });
  document.getElementById('noActors').style.display = n === 0 && q ? 'block' : 'none';
});

// Scroll reveal
const observer = new IntersectionObserver(entries => {
  entries.forEach((e, i) => {
    if(e.isIntersecting) {
      setTimeout(() => e.target.classList.add('visible'), i * 80);
    }
  });
}, { threshold: 0.1 });
document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

// Smooth scroll
document.querySelectorAll('a[href^="#"]').forEach(a => {
  a.addEventListener('click', e => {
    const t = document.querySelector(a.getAttribute('href'));
    if(t){ e.preventDefault(); t.scrollIntoView({behavior:'smooth'}); }
  });
});
</script>
</body>
</html>