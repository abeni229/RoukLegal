<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>RoukLegal — Votre partenaire juridique</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
<style>
    :root {
      --gold:     #c2601a;
      --gold-lt:  #d97c38;
      --gold-dim: rgba(194,96,26,.09);
      --ink:      #1c2434;
      --ink-dim:  rgba(28,36,52,.58);
      --bg:       #f5f0e8;
      --bg2:      #ede8df;
      --bg3:      #e6dfd4;
      --border:   rgba(28,36,52,.12);
      --red:      #c0392b;
      --green:    #1e7e50;
      --navy:     #1a2e4a;
      --navy-dim: rgba(26,46,74,.08);
      --radius:   12px;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

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
      opacity: .2;
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
      background: rgba(245,240,232,.94);
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
      color: #fff;
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
      color: #fff;
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
      background-image: url("https://images.unsplash.com/photo-1589829545856-d10d557cf95f?w=1600&auto=format&fit=crop&q=80");
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
    }
    .hero-overlay {
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(245,240,232,.92) 0%, rgba(237,232,223,.88) 50%, rgba(245,240,232,.75) 100%);
      z-index: 1;
    }
    .hero::before {
      content: '';
      position: absolute;
      width: 700px; height: 700px;
      background: radial-gradient(circle, rgba(194,96,26,.10) 0%, transparent 70%);
      top: -100px; right: -200px;
      pointer-events: none;
    }
    .hero::after {
      content: '';
      position: absolute;
      width: 400px; height: 400px;
      background: radial-gradient(circle, rgba(26,46,74,.06) 0%, transparent 70%);
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
      border: 1px solid rgba(194,96,26,.2);
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
    .hero-title em { font-style: italic; color: var(--gold); }

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
      color: #fff;
      text-decoration: none;
      transition: background .2s, transform .15s, box-shadow .2s;
    }
    .btn-hero-primary:hover {
      background: var(--gold-lt);
      transform: translateY(-2px);
      box-shadow: 0 12px 40px rgba(194,96,26,.28);
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

    .hero-left, .hero-right, .hero-stats, .hero-eyebrow, .hero-title, .hero-sub, .hero-btns { position: relative; z-index: 2; }
    .hero-stats {
      display: flex;
      gap: 40px;
      margin-top: 56px;
      animation: fadeUp .8s .65s both;
    }
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
    .stat-divider { width: 1px; background: var(--border); align-self: stretch; }

    /* Carte droite */
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
      box-shadow: 0 24px 64px rgba(28,36,52,.10);
    }
    .scale-card::before {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(194,96,26,.07) 0%, transparent 60%);
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

    .scale-card::after {
      content: '';
      position: absolute;
      top: 0; right: 0;
      width: 120px; height: 120px;
      background: conic-gradient(from 180deg at 100% 0%, var(--gold) 0deg, transparent 90deg);
      opacity: .12;
    }

    .float-badge {
      position: absolute;
      background: var(--bg);
      border: 1px solid var(--border);
      border-radius: 12px;
      padding: 12px 16px;
      font-size: .8rem;
      display: flex;
      align-items: center;
      gap: 10px;
      animation: float 4s ease-in-out infinite;
      box-shadow: 0 8px 32px rgba(28,36,52,.10);
    }
    .float-badge.b1 { bottom: 40px; left: -20px; animation-delay: 0s; }
    .float-badge.b2 { top: 50px; right: -20px; animation-delay: 1.5s; }
    .float-badge-icon {
      width: 32px; height: 32px;
      border-radius: 8px;
      background: var(--gold-dim);
      border: 1px solid var(--border);
      display: flex; align-items: center; justify-content: center;
      color: var(--gold); font-size: .85rem;
    }
    .float-badge-text { font-size: .72rem; color: var(--ink-dim); }
    .float-badge-val { font-size: .82rem; font-weight: 600; color: var(--ink); }

    @keyframes fadeUp { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:none} }

    /* ─── SECTIONS ─── */
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
      content: ''; height: 1px; width: 24px;
      background: var(--gold); opacity: .5;
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
    #services {
      background: var(--bg2);
      position: relative;
      background-image: url("https://images.unsplash.com/photo-1521587760476-6c12a4b040da?w=1600&auto=format&fit=crop&q=80");
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
    }
    #services::before {
      content: "";
      position: absolute;
      inset: 0;
      background: rgba(237,232,223,.93);
      z-index: 0;
    }
    #services > * { position: relative; z-index: 1; }
    .services-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
    .service-card {
      padding: 36px 32px;
      background: var(--bg);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      transition: transform .25s, border-color .25s, box-shadow .25s;
      position: relative;
      overflow: hidden;
    }
    .service-card::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0; height: 2px;
      background: linear-gradient(90deg, transparent, var(--gold), transparent);
      opacity: 0; transition: opacity .3s;
    }
    .service-card:hover { transform: translateY(-6px); border-color: rgba(194,96,26,.3); box-shadow: 0 20px 60px rgba(28,36,52,.08); }
    .service-card:hover::before { opacity: 1; }
    .service-ico {
      width: 56px; height: 56px;
      background: var(--gold-dim);
      border: 1px solid var(--border);
      border-radius: 12px;
      display: flex; align-items: center; justify-content: center;
      font-size: 1.4rem; color: var(--gold);
      margin-bottom: 24px;
      transition: background .25s;
    }
    .service-card:hover .service-ico { background: rgba(194,96,26,.14); }
    .service-card h4 { font-family: 'Playfair Display', serif; font-size: 1.15rem; font-weight: 600; color: var(--ink); margin-bottom: 12px; }
    .service-card p { font-size: .88rem; color: var(--ink-dim); line-height: 1.7; }
    .service-arrow {
      display: inline-flex; align-items: center; gap: 6px;
      margin-top: 20px; font-size: .78rem; color: var(--gold); font-weight: 600;
      text-decoration: none; opacity: 0; transform: translateX(-8px);
      transition: opacity .25s, transform .25s;
    }
    .service-card:hover .service-arrow { opacity: 1; transform: none; }

    /* ─── ACTEURS ─── */
    #actors {
      background: var(--bg);
      position: relative;
      background-image: url("https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=1600&auto=format&fit=crop&q=80");
      background-size: cover;
      background-position: center top;
      background-attachment: fixed;
    }
    #actors::before {
      content: "";
      position: absolute;
      inset: 0;
      background: rgba(245,240,232,.94);
      z-index: 0;
    }
    #actors > * { position: relative; z-index: 1; }
    .actors-search { display: flex; gap: 12px; margin-bottom: 40px; max-width: 520px; }
    .search-wrap { flex: 1; position: relative; }
    .search-wrap i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--ink-dim); font-size: .85rem; pointer-events: none; }
    .search-input {
      width: 100%; padding: 11px 14px 11px 38px;
      background: var(--bg2); border: 1px solid var(--border);
      border-radius: 10px; color: var(--ink);
      font-family: 'DM Sans', sans-serif; font-size: .88rem;
      outline: none; transition: border-color .2s;
    }
    .search-input:focus { border-color: var(--gold); }
    .search-input::placeholder { color: var(--ink-dim); }
    #actorsList { display: flex; flex-direction: column; gap: 16px; }
    .actor-card {
      display: flex; align-items: center; gap: 20px;
      padding: 20px 24px;
      background: var(--bg2); border: 1px solid var(--border);
      border-radius: var(--radius);
      transition: border-color .2s, transform .2s;
    }
    .actor-card:hover { border-color: rgba(194,96,26,.35); transform: translateX(4px); }
    .actor-avatar {
      width: 56px; height: 56px; border-radius: 50%;
      background: var(--gold-dim); border: 2px solid var(--gold);
      display: flex; align-items: center; justify-content: center;
      overflow: hidden; flex-shrink: 0;
      font-family: 'Playfair Display', serif;
      font-size: 1.1rem; font-weight: 700; color: var(--gold);
    }
    .actor-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .actor-info { flex: 1; min-width: 0; }
    .actor-name { font-family: 'Playfair Display', serif; font-size: .98rem; font-weight: 600; color: var(--ink); margin-bottom: 4px; }
    .actor-profession {
      display: inline-block; padding: 3px 10px;
      background: var(--gold-dim); border: 1px solid var(--border);
      border-radius: 100px; font-size: .7rem; color: var(--gold);
      font-weight: 600; letter-spacing: .04em; margin-bottom: 6px;
    }
    .actor-desc { font-size: .8rem; color: var(--ink-dim); }
    .btn-actor {
      display: inline-flex; align-items: center; gap: 8px;
      padding: 9px 20px; border: 1px solid var(--border);
      border-radius: 8px; font-size: .78rem; font-weight: 600;
      color: var(--gold); text-decoration: none;
      transition: background .2s, border-color .2s; flex-shrink: 0;
    }
    .btn-actor:hover { background: var(--gold-dim); border-color: var(--gold); }
    .actors-more { margin-top: 32px; text-align: center; }

    /* ─── À PROPOS ─── */
    #about {
      background: var(--bg2);
      position: relative;
      background-image: url("https://images.unsplash.com/photo-1555374018-13a8994ab246?w=1600&auto=format&fit=crop&q=80");
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
    }
    #about::before {
      content: "";
      position: absolute;
      inset: 0;
      background: rgba(237,232,223,.93);
      z-index: 0;
    }
    #about > * { position: relative; z-index: 1; }
    .about-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 80px; align-items: center; }
    .about-visual-main {
      background: var(--bg); border: 1px solid var(--border);
      border-radius: 20px; padding: 60px; text-align: center;
      position: relative; overflow: hidden;
    }
    .about-visual-main::before {
      content: ''; position: absolute; inset: 0;
      background: linear-gradient(135deg, rgba(194,96,26,.05) 0%, transparent 60%);
    }
    .about-visual-main i { font-size: 7rem; color: var(--gold); opacity: .9; position: relative; z-index: 2; }
    .about-badge {
      position: absolute; bottom: 16px; right: 32px;
      background: var(--gold); color: #fff;
      padding: 10px 18px; border-radius: 10px;
      font-size: .8rem; font-weight: 700;
    }
    .features { display: flex; flex-direction: column; gap: 28px; margin-top: 40px; }
    .feature-item { display: flex; gap: 16px; align-items: flex-start; }
    .feature-ico {
      width: 44px; height: 44px;
      background: var(--gold-dim); border: 1px solid var(--border);
      border-radius: 10px; display: flex; align-items: center; justify-content: center;
      color: var(--gold); font-size: .9rem; flex-shrink: 0;
    }
    .feature-item h5 { font-size: .9rem; font-weight: 600; color: var(--ink); margin-bottom: 4px; }
    .feature-item p { font-size: .82rem; color: var(--ink-dim); line-height: 1.7; }

    /* ─── TÉMOIGNAGES ─── */
    #testimonials {
      background: var(--bg);
      position: relative;
      background-image: url("https://images.unsplash.com/photo-1600880292203-757bb62b4baf?w=1600&auto=format&fit=crop&q=80");
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
    }
    #testimonials::before {
      content: "";
      position: absolute;
      inset: 0;
      background: rgba(245,240,232,.94);
      z-index: 0;
    }
    #testimonials > * { position: relative; z-index: 1; }
    .testi-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
    .testi-card {
      padding: 32px 28px;
      background: var(--bg2); border: 1px solid var(--border);
      border-radius: var(--radius);
      transition: transform .25s, border-color .25s;
    }
    .testi-card:hover { transform: translateY(-4px); border-color: rgba(194,96,26,.25); }
    .testi-stars { color: var(--gold); font-size: .85rem; letter-spacing: 2px; margin-bottom: 18px; }
    .testi-text { font-size: .88rem; color: var(--ink-dim); line-height: 1.8; font-style: italic; margin-bottom: 24px; }
    .testi-author { display: flex; align-items: center; gap: 12px; }
    .testi-av {
      width: 44px; height: 44px; border-radius: 50%;
      background: var(--gold-dim); border: 1px solid var(--border);
      display: flex; align-items: center; justify-content: center;
      color: var(--gold); font-size: 1rem;
    }
    .testi-name { font-size: .88rem; font-weight: 600; color: var(--ink); }
    .testi-role { font-size: .72rem; color: var(--gold); margin-top: 2px; }

    /* ─── CTA ─── */
    .cta-section {
      margin: 0 80px 100px;
      background: var(--navy);
      border: 1px solid rgba(255,255,255,.07);
      border-radius: 24px;
      padding: 80px;
      text-align: center;
      position: relative;
      overflow: hidden;
      background-image: url("https://images.unsplash.com/photo-1450101499163-c8848c66ca85?w=1600&auto=format&fit=crop&q=80");
      background-size: cover;
      background-position: center;
    }
    .cta-overlay {
      position: absolute;
      inset: 0;
      background: rgba(26,46,74,.88);
      border-radius: 24px;
    }
    .cta-section::before {
      content: ''; position: absolute;
      width: 600px; height: 600px;
      background: radial-gradient(circle, rgba(194,96,26,.14) 0%, transparent 65%);
      top: 50%; left: 50%; transform: translate(-50%,-50%);
      pointer-events: none;
    }
    .cta-section h2 {
      font-family: 'Playfair Display', serif;
      font-size: clamp(2rem, 3vw, 2.8rem);
      font-weight: 700; color: #f5f0e8;
      margin-bottom: 16px; position: relative; z-index: 2;
    }
    .cta-section p {
      font-size: .95rem; color: rgba(245,240,232,.62);
      max-width: 480px; margin: 0 auto 36px;
      line-height: 1.8; position: relative; z-index: 2;
    }
    .cta-btns { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; position: relative; z-index: 2; }

    /* ─── FOOTER ─── */
    footer {
      background: var(--navy);
      border-top: 1px solid rgba(255,255,255,.07);
      padding: 60px 80px 32px;
    }
    .footer-grid {
      display: grid;
      grid-template-columns: 1.5fr 1fr 1fr 1fr;
      gap: 48px; margin-bottom: 48px;
    }
    .footer-logo {
      display: flex; align-items: center; gap: 10px;
      font-family: 'Playfair Display', serif;
      font-size: 1.3rem; font-weight: 700; color: #f5f0e8;
      margin-bottom: 16px;
    }
    .footer-logo .gavel {
      width: 32px; height: 32px; background: var(--gold);
      border-radius: 7px; display: flex; align-items: center; justify-content: center;
      font-size: .8rem; color: var(--navy);
    }
    .footer-logo span { color: var(--gold); }
    .footer-desc { font-size: .82rem; color: rgba(245,240,232,.45); line-height: 1.8; margin-bottom: 24px; }
    .footer-social { display: flex; gap: 10px; }
    .footer-social a {
      width: 36px; height: 36px; border-radius: 50%;
      background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.1);
      display: flex; align-items: center; justify-content: center;
      font-size: .8rem; color: rgba(245,240,232,.45);
      text-decoration: none; transition: background .2s, color .2s;
    }
    .footer-social a:hover { background: var(--gold); color: var(--navy); border-color: var(--gold); }
    .footer-col h6 {
      font-size: .72rem; font-weight: 700; color: var(--gold);
      letter-spacing: .12em; text-transform: uppercase; margin-bottom: 20px;
    }
    .footer-col ul { list-style: none; display: flex; flex-direction: column; gap: 10px; }
    .footer-col ul li a {
      font-size: .82rem; color: rgba(245,240,232,.45);
      text-decoration: none; transition: color .2s;
    }
    .footer-col ul li a:hover { color: var(--gold); }
    .footer-bottom {
      border-top: 1px solid rgba(255,255,255,.07);
      padding-top: 24px;
      display: flex; justify-content: space-between; align-items: center;
      gap: 16px; flex-wrap: wrap;
    }
    .footer-bottom p { font-size: .75rem; color: rgba(245,240,232,.28); }
    .footer-bottom-links { display: flex; gap: 24px; }
    .footer-bottom-links a { font-size: .75rem; color: rgba(245,240,232,.28); text-decoration: none; transition: color .2s; }
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

    .reveal { opacity: 0; transform: translateY(28px); transition: opacity .7s ease, transform .7s ease; }
    .reveal.visible { opacity: 1; transform: none; }
</style>
</head>
<body>

<!-- NAVBAR -->
<nav>
  <a class="nav-brand" href="#">
    <div class="gavel"><i class="fas fa-gavel"></i></div>
    Rouk<span>Legal</span>
  </a>
  <ul class="nav-links">
    <li><a href="#services">Services</a></li>
    <li><a href="#actors">Experts</a></li>
    <li><a href="#about">À propos</a></li>
    <li><a href="#testimonials">Témoignages</a></li>
  </ul>
  <div class="nav-cta">
    <a class="btn-ghost" href="{{ route('login') }}">Connexion</a>
    <a class="btn-gold" href="{{ route('register') }}">Commencer</a>
  </div>
  <button class="hamburger"><i class="fas fa-bars"></i></button>
</nav>

<!-- HERO -->
<div class="hero">
  <div class="hero-overlay"></div>
  <div class="hero-left" style="position:relative;z-index:2;">
    <div class="hero-eyebrow">Plateforme juridique certifiée</div>
    <h1 class="hero-title">
      Le droit à portée de <em>tous</em>,<br>
      conseillé par des <em>experts</em>
    </h1>
    <p class="hero-sub">
      Accédez à des consultations juridiques professionnelles, posez vos questions à des avocats et juristes qualifiés, et prenez rendez-vous en quelques clics.
    </p>
    <div class="hero-btns">
      <a class="btn-hero-primary" href="{{ route('register') }}">
        <i class="fas fa-user-plus"></i> Créer un compte gratuit
      </a>
      <a class="btn-hero-outline" href="#services">
        <i class="fas fa-arrow-down"></i> Découvrir
      </a>
    </div>
    <div class="hero-stats">
      <div class="hero-stat">
        <div class="hero-stat-num">3 200+</div>
        <div class="hero-stat-label">Clients satisfaits</div>
      </div>
      <div class="stat-divider"></div>
      <div class="hero-stat">
        <div class="hero-stat-num">48</div>
        <div class="hero-stat-label">Experts vérifiés</div>
      </div>
      <div class="stat-divider"></div>
      <div class="hero-stat">
        <div class="hero-stat-num">98%</div>
        <div class="hero-stat-label">Satisfaction</div>
      </div>
    </div>
  </div>
  <div class="hero-right" style="position:relative;z-index:2;">
    <div style="position:relative;">
      <div class="scale-card">
        <i class="fas fa-balance-scale scale-icon"></i>
      </div>
      <div class="float-badge b1">
        <div class="float-badge-icon"><i class="fas fa-check"></i></div>
        <div>
          <div class="float-badge-val">Réponse confirmée</div>
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
</div>

<!-- SERVICES -->
<section id="services">
  <div class="section-head reveal">
    <div class="section-label">Nos services</div>
    <h2 class="section-title">Tout ce dont vous avez besoin,<br>en un seul endroit</h2>
    <p class="section-sub">De la simple question juridique à la consultation privée, RoukLegal couvre tous vos besoins légaux.</p>
  </div>
  <div class="services-grid">
    @foreach([
      ['fas fa-question-circle','Questions juridiques','Posez vos questions à des experts qualifiés. Obtenez des réponses claires et fiables rapidement.'],
      ['fas fa-newspaper','Articles & ressources','Bibliothèque d\'articles rédigés par nos experts pour vous informer sur vos droits.'],
      ['fas fa-calendar-check','Prise de rendez-vous','Réservez une consultation privée selon les créneaux disponibles de l\'expert choisi.'],
      ['fas fa-comments','Messagerie sécurisée','Communiquez directement et confidentiellement avec les acteurs juridiques.'],
      ['fas fa-shield-alt','Paiement sécurisé','Transactions via PayGate. Remboursement automatique en cas d\'annulation ou de refus.'],
      ['fas fa-user-tie','Experts vérifiés','Avocats, notaires, juristes, huissiers — tous vérifiés et certifiés sur la plateforme.'],
    ] as $s)
    <div class="service-card reveal">
      <div class="service-ico"><i class="{{ $s[0] }}"></i></div>
      <h4>{{ $s[1] }}</h4>
      <p>{{ $s[2] }}</p>
      <a class="service-arrow" href="{{ route('register') }}">En savoir plus <i class="fas fa-arrow-right"></i></a>
    </div>
    @endforeach
  </div>
</section>

<!-- ACTEURS -->
<section id="actors">
  <div class="section-head reveal">
    <div class="section-label">Nos experts</div>
    <h2 class="section-title">Des professionnels à votre service</h2>
    <p class="section-sub">Trouvez l'expert juridique qu'il vous faut parmi nos avocats, notaires et juristes certifiés.</p>
  </div>
  <div class="actors-search">
    <div class="search-wrap">
      <i class="fas fa-search"></i>
      <input class="search-input" type="text" id="searchInput" placeholder="Rechercher un expert, une profession…" oninput="filterActors()">
    </div>
  </div>
  <div id="actorsList">
    @php $experts = \App\Models\User::where('role','acteur_juridique')->with('profession')->take(6)->get(); @endphp
    @forelse($experts as $expert)
    <div class="actor-card reveal" data-name="{{ strtolower($expert->nom) }}" data-prof="{{ strtolower($expert->profession?->nom ?? $expert->profession_libre ?? '') }}">
      <div class="actor-avatar">
        @if($expert->photo_professionnelle)
          <img src="{{ asset('storage/'.$expert->photo_professionnelle) }}" alt=""/>
        @else
          {{ strtoupper(substr($expert->nom,0,2)) }}
        @endif
      </div>
      <div class="actor-info">
        <div class="actor-name">{{ $expert->nom }}</div>
        <div class="actor-profession">{{ $expert->profession?->nom ?? $expert->profession_libre ?? 'Expert juridique' }}</div>
        <div class="actor-desc">{{ Str::limit($expert->description ?? 'Expert juridique qualifié disponible pour répondre à vos questions.',100) }}</div>
      </div>
      <a class="btn-actor" href="{{ route('login') }}"><i class="fas fa-arrow-right"></i> Consulter</a>
    </div>
    @empty
    @foreach([
      ['ME','Maître Ekpé','Avocat au barreau','Droit des affaires, contrats commerciaux et contentieux civil.'],
      ['AK','Adjoa Koffi','Notaire','Droit immobilier, successions, donations et actes notariés.'],
      ['BH','Basile Hounsou','Juriste d\'entreprise','Droit du travail, relations sociales et droit des sociétés.'],
    ] as $e)
    <div class="actor-card reveal" data-name="{{ strtolower($e[1]) }}" data-prof="{{ strtolower($e[2]) }}">
      <div class="actor-avatar">{{ $e[0] }}</div>
      <div class="actor-info">
        <div class="actor-name">{{ $e[1] }}</div>
        <div class="actor-profession">{{ $e[2] }}</div>
        <div class="actor-desc">{{ $e[3] }}</div>
      </div>
      <a class="btn-actor" href="{{ route('login') }}"><i class="fas fa-arrow-right"></i> Consulter</a>
    </div>
    @endforeach
    @endforelse
  </div>
  <div class="actors-more">
    <a class="btn-hero-outline" href="{{ route('register') }}">Voir tous les experts <i class="fas fa-arrow-right"></i></a>
  </div>
</section>

<!-- À PROPOS -->
<section id="about">
  <div class="about-grid">
    <div class="about-visual reveal">
      <div class="about-visual-main">
        <i class="fas fa-landmark"></i>
        <div class="about-badge">Fondé en 2026</div>
      </div>
    </div>
    <div class="reveal">
      <div class="section-label">À propos</div>
      <h2 class="section-title">Une plateforme pensée pour l'accès au droit</h2>
      <p class="section-sub" style="margin-bottom:0;">RoukLegal connecte les citoyens béninois avec des professionnels du droit qualifiés pour démocratiser l'accès à la justice.</p>
      <div class="features">
        @foreach([
          ['fas fa-shield-alt','Experts vérifiés','Chaque acteur juridique est vérifié et certifié avant d\'être admis sur la plateforme.'],
          ['fas fa-lock','Confidentialité totale','Vos échanges et consultations sont 100% sécurisés et strictement confidentiels.'],
          ['fas fa-clock','Disponibilité 24h/24','Posez vos questions à tout moment et recevez une réponse dans les meilleurs délais.'],
        ] as $f)
        <div class="feature-item">
          <div class="feature-ico"><i class="{{ $f[0] }}"></i></div>
          <div><h5>{{ $f[1] }}</h5><p>{{ $f[2] }}</p></div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>

<!-- TÉMOIGNAGES -->
<section id="testimonials">
  <div class="section-head reveal" style="text-align:center;">
    <div class="section-label" style="justify-content:center;">Témoignages</div>
    <h2 class="section-title">Ce que disent nos clients</h2>
  </div>
  <div class="testi-grid">
    @foreach([
      ['J\'ai obtenu une réponse claire à ma question sur mon contrat de travail en moins de 3 heures. Service exceptionnel.','Kouassi A.','Client','KA'],
      ['La prise de rendez-vous est simple et le notaire était très professionnel. Je recommande vivement RoukLegal.','Fatima B.','Cliente','FB'],
      ['En tant qu\'avocat, cette plateforme m\'a permis d\'élargir ma clientèle tout en gérant mes disponibilités facilement.','Me. Sodji','Acteur juridique','MS'],
    ] as $t)
    <div class="testi-card reveal">
      <div class="testi-stars">★★★★★</div>
      <p class="testi-text">"{{ $t[0] }}"</p>
      <div class="testi-author">
        <div class="testi-av">{{ $t[3] }}</div>
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
  <div class="cta-overlay"></div>
  <h2>Prêt à résoudre vos questions juridiques ?</h2>
  <p>Rejoignez plus de 3 200 clients qui font confiance à RoukLegal. Commencez avec 2 semaines d'essai gratuit, sans engagement.</p>
  <div class="cta-btns">
    <a class="btn-hero-primary" href="{{ route('register') }}"><i class="fas fa-user-plus"></i> Créer un compte gratuit</a>
    <a class="btn-ghost" href="{{ route('login') }}" style="color:rgba(245,240,232,.7);border-color:rgba(255,255,255,.2);">Se connecter</a>
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
      <p class="footer-desc">Votre partenaire juridique de confiance au Bénin et en Afrique de l'Ouest.</p>
      <div class="footer-social">
        <a href="#"><i class="fab fa-facebook-f"></i></a>
        <a href="#"><i class="fab fa-twitter"></i></a>
        <a href="#"><i class="fab fa-linkedin-in"></i></a>
        <a href="#"><i class="fab fa-whatsapp"></i></a>
      </div>
    </div>
    <div class="footer-col">
      <h6>Plateforme</h6>
      <ul>
        <li><a href="{{ route('register') }}">S'inscrire</a></li>
        <li><a href="{{ route('login') }}">Se connecter</a></li>
        <li><a href="#services">Nos services</a></li>
        <li><a href="#actors">Nos experts</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h6>Services</h6>
      <ul>
        <li><a href="#">Questions juridiques</a></li>
        <li><a href="#">Rendez-vous</a></li>
        <li><a href="#">Articles</a></li>
        <li><a href="#">Messagerie</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h6>Légal</h6>
      <ul>
        <li><a href="#">Conditions d'utilisation</a></li>
        <li><a href="#">Confidentialité</a></li>
        <li><a href="#">Mentions légales</a></li>
      </ul>
    </div>
  </div>
  <div class="footer-bottom">
    <p>© {{ date('Y') }} RoukLegal. Tous droits réservés. Cotonou, Bénin.</p>
    <div class="footer-bottom-links">
      <a href="#">Politique de confidentialité</a>
      <a href="#">Conditions générales</a>
    </div>
  </div>
</footer>

<script>
const obs=new IntersectionObserver(e=>e.forEach(x=>{if(x.isIntersecting)x.target.classList.add('visible');}),{threshold:.1});
document.querySelectorAll('.reveal').forEach(el=>obs.observe(el));

function filterActors(){
  const q=document.getElementById('searchInput').value.toLowerCase();
  document.querySelectorAll('.actor-card').forEach(c=>{
    const match=c.dataset.name.includes(q)||c.dataset.prof.includes(q);
    c.style.display=match?'flex':'none';
  });
}
</script>
</body>
</html>