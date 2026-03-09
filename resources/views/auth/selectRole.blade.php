<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Choisir votre rôle — RoukLegal</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
:root{
  --gold:     #c2601a;
  --gold-lt:  #d97c38;
  --gold-dim: rgba(194,96,26,.09);
  --ink:      #1c2434;
  --ink-dim:  rgba(28,36,52,.58);
  --bg:       #f5f0e8;
  --bg2:      #ede8df;
  --bg3:      #e6dfd4;
  --border:   rgba(28,36,52,.12);
  --navy:     #1a2e4a;
  --orange:   #d97c38;
  --radius:   12px;
}
body{
  font-family:'DM Sans',sans-serif;
  background:var(--bg);color:var(--ink);
  min-height:100vh;display:flex;flex-direction:column;
  align-items:center;justify-content:center;padding:40px 24px;
}
body::before{
  content:'';position:fixed;inset:0;
  background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
  pointer-events:none;z-index:9999;opacity:.2;
}

/* TOPBAR */
.topbar{
  position:fixed;top:0;left:0;right:0;height:64px;
  background:rgba(245,240,232,.94);backdrop-filter:blur(20px);
  border-bottom:1px solid var(--border);
  display:flex;align-items:center;justify-content:space-between;
  padding:0 40px;z-index:100;
}
.logo{display:flex;align-items:center;gap:10px;font-family:'Playfair Display',serif;font-size:1.3rem;font-weight:700;color:var(--ink);text-decoration:none;}
.logo .gavel{width:32px;height:32px;background:var(--gold);border-radius:7px;display:flex;align-items:center;justify-content:center;font-size:.82rem;color:#fff;}
.logo span{color:var(--gold);}
.logout-btn{
  display:flex;align-items:center;gap:6px;padding:7px 16px;
  border-radius:8px;background:transparent;border:1.5px solid var(--border);
  color:var(--ink-dim);font-family:'DM Sans',sans-serif;font-size:.8rem;font-weight:500;
  cursor:pointer;text-decoration:none;transition:border-color .15s,color .15s;
}
.logout-btn:hover{border-color:var(--gold);color:var(--gold);}

/* WRAPPER */
.wrapper{width:100%;max-width:680px;margin-top:64px;padding-top:40px;}

/* BIENVENUE */
.welcome-card{
  text-align:center;padding:40px 36px 32px;
  background:var(--bg2);border:1px solid var(--border);
  border-radius:20px;box-shadow:0 8px 32px rgba(28,36,52,.07);
  margin-bottom:28px;position:relative;overflow:hidden;
}
.welcome-card::before{
  content:'';position:absolute;top:0;left:0;right:0;height:4px;
  background:linear-gradient(90deg,var(--navy),var(--gold),var(--gold-lt));
}
.welcome-avatar{
  width:64px;height:64px;border-radius:50%;
  background:linear-gradient(135deg,var(--navy),var(--gold));
  display:flex;align-items:center;justify-content:center;
  font-family:'Playfair Display',serif;font-size:1.4rem;font-weight:700;color:#fff;
  margin:0 auto 16px;
}
.welcome-title{font-family:'Playfair Display',serif;font-size:1.5rem;font-weight:700;color:var(--ink);margin-bottom:8px;}
.welcome-sub{font-size:.88rem;color:var(--ink-dim);line-height:1.7;max-width:440px;margin:0 auto;}

/* CARTES RÔLES */
.roles-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:24px;}
.role-form{height:100%;}
.role-card{
  width:100%;height:100%;background:var(--bg2);
  border:2px solid var(--border);border-radius:16px;
  padding:32px 24px;cursor:pointer;
  display:flex;flex-direction:column;align-items:flex-start;
  text-align:left;font-family:'DM Sans',sans-serif;
  transition:border-color .2s,transform .2s,box-shadow .2s;
  position:relative;overflow:hidden;
}
.role-card::before{
  content:'';position:absolute;top:0;left:0;right:0;height:3px;
  transform:scaleX(0);transform-origin:left;transition:transform .25s;
}
.role-card.client::before{background:var(--gold);}
.role-card.acteur::before{background:var(--navy);}
.role-card:hover{transform:translateY(-4px);box-shadow:0 16px 40px rgba(28,36,52,.1);}
.role-card.client:hover{border-color:rgba(194,96,26,.4);}
.role-card.acteur:hover{border-color:rgba(26,46,74,.35);}
.role-card:hover::before{transform:scaleX(1);}

.role-icon{
  width:56px;height:56px;border-radius:14px;
  display:flex;align-items:center;justify-content:center;
  font-size:1.4rem;margin-bottom:18px;
}
.role-card.client .role-icon{background:var(--gold-dim);color:var(--gold);border:1px solid rgba(194,96,26,.2);}
.role-card.acteur .role-icon{background:rgba(26,46,74,.08);color:var(--navy);border:1px solid rgba(26,46,74,.15);}

.role-title{font-family:'Playfair Display',serif;font-size:1.05rem;font-weight:700;color:var(--ink);margin-bottom:8px;}
.role-desc{font-size:.82rem;color:var(--ink-dim);line-height:1.7;margin-bottom:20px;}

.role-features{display:flex;flex-direction:column;gap:6px;width:100%;margin-bottom:20px;}
.role-feature{display:flex;align-items:center;gap:8px;font-size:.78rem;color:var(--ink-dim);}
.role-feature i{width:14px;text-align:center;flex-shrink:0;}
.role-card.client .role-feature i{color:var(--gold);}
.role-card.acteur .role-feature i{color:var(--navy);}

.role-btn{
  margin-top:auto;width:100%;
  padding:10px 20px;border-radius:10px;
  font-family:'DM Sans',sans-serif;font-size:.84rem;font-weight:600;
  border:none;cursor:pointer;
  display:flex;align-items:center;justify-content:center;gap:7px;
  transition:background .18s,transform .15s;
}
.role-card.client .role-btn{background:var(--gold);color:#fff;}
.role-card.client .role-btn:hover{background:var(--gold-lt);}
.role-card.acteur .role-btn{background:var(--navy);color:#f5f0e8;}
.role-card.acteur .role-btn:hover{background:#0f1f33;}

/* AVERTISSEMENT */
.warning{
  display:flex;align-items:center;gap:12px;
  padding:14px 18px;
  background:rgba(194,96,26,.07);
  border:1px solid rgba(194,96,26,.2);
  border-radius:12px;font-size:.82rem;color:#8b4513;
}
.warning i{color:var(--gold);flex-shrink:0;font-size:1rem;}

@media(max-width:580px){.roles-grid{grid-template-columns:1fr;}}
</style>
</head>
<body>

<div class="topbar">
  <a class="logo" href="{{ route('home') }}">
    <div class="gavel"><i class="fas fa-gavel"></i></div>
    Rouk<span>Legal</span>
  </a>
  <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Se déconnecter</button>
  </form>
</div>

<div class="wrapper">

  <div class="welcome-card">
    <div class="welcome-avatar">{{ strtoupper(substr(Auth::user()->nom, 0, 2)) }}</div>
    <h1 class="welcome-title">Bienvenue, {{ Auth::user()->nom }} !</h1>
    <p class="welcome-sub">Votre compte a été créé avec succès. Choisissez maintenant votre rôle sur la plateforme pour accéder à votre espace personnalisé.</p>
  </div>

  <div class="roles-grid">

    <form method="POST" action="{{ route('auth.selectRole') }}" class="role-form">
      @csrf
      <input type="hidden" name="role" value="client">
      <button type="submit" class="role-card client">
        <div class="role-icon"><i class="fas fa-user"></i></div>
        <div class="role-title">Client</div>
        <p class="role-desc">Accédez à des conseils juridiques professionnels pour vos besoins personnels ou professionnels.</p>
        <div class="role-features">
          @foreach(['Poser des questions aux experts','Accès aux articles juridiques','Prise de rendez-vous','Messagerie sécurisée','Essai gratuit 2 semaines'] as $f)
          <div class="role-feature"><i class="fas fa-check"></i> {{ $f }}</div>
          @endforeach
        </div>
        <div class="role-btn"><i class="fas fa-arrow-right"></i> Choisir ce rôle</div>
      </button>
    </form>

    <form method="POST" action="{{ route('auth.selectRole') }}" class="role-form">
      @csrf
      <input type="hidden" name="role" value="acteur_juridique">
      <button type="submit" class="role-card acteur">
        <div class="role-icon"><i class="fas fa-balance-scale"></i></div>
        <div class="role-title">Acteur Juridique</div>
        <p class="role-desc">Partagez votre expertise, répondez aux questions et développez votre clientèle en ligne.</p>
        <div class="role-features">
          @foreach(['Publier des articles juridiques','Répondre aux questions clients','Gérer vos créneaux & RDV','Messagerie professionnelle','Percevez 80% du tarif RDV'] as $f)
          <div class="role-feature"><i class="fas fa-check"></i> {{ $f }}</div>
          @endforeach
        </div>
        <div class="role-btn"><i class="fas fa-arrow-right"></i> Choisir ce rôle</div>
      </button>
    </form>

  </div>

  <div class="warning">
    <i class="fas fa-exclamation-triangle"></i>
    <span><strong>Attention :</strong> Ce choix est définitif. Vous ne pourrez pas changer de rôle ultérieurement. Choisissez avec soin.</span>
  </div>

</div>
</body>
</html>