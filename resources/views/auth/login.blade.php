<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion — RoukLegal</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }
    :root {
      --gold:    #c9a84c;
      --gold-lt: #e2c47a;
      --gold-dim:rgba(201,168,76,.09);
      --ink:     #f5f0e8;
      --ink-dim: rgba(245,240,232,.55);
      --bg:      #0c1117;
      --bg2:     #111820;
      --bg3:     #161f2a;
      --border:  rgba(201,168,76,.18);
      --red:     #e74c3c;
      --radius:  12px;
    }
    html, body { height:100%; font-family:'DM Sans',sans-serif; background:var(--bg); color:var(--ink); overflow:hidden; }

    /* grain */
    body::before {
      content:'';
      position:fixed; inset:0;
      background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
      pointer-events:none; z-index:9999; opacity:.5;
    }

    .auth-wrapper {
      display:flex;
      height:100vh;
    }

    /* ─── PANNEAU GAUCHE : FORMULAIRE ─── */
    .form-panel {
      flex:1;
      display:flex;
      align-items:center;
      justify-content:center;
      padding:40px 48px;
      background:var(--bg);
      overflow-y:auto;
      animation:slideLeft .6s ease both;
    }
    @keyframes slideLeft { from{opacity:0;transform:translateX(-24px)} to{opacity:1;transform:none} }

    .form-box {
      width:100%;
      max-width:400px;
    }

    /* Logo */
    .form-logo {
      display:flex;
      align-items:center;
      gap:10px;
      margin-bottom:40px;
      text-decoration:none;
    }
    .form-logo .gavel {
      width:36px; height:36px;
      background:var(--gold);
      border-radius:8px;
      display:flex; align-items:center; justify-content:center;
      font-size:.85rem; color:var(--bg);
    }
    .form-logo span {
      font-family:'Playfair Display',serif;
      font-size:1.3rem; font-weight:700; color:var(--ink);
    }
    .form-logo span em { font-style:normal; color:var(--gold); }

    .form-heading {
      margin-bottom:32px;
    }
    .form-heading h1 {
      font-family:'Playfair Display',serif;
      font-size:2rem; font-weight:700;
      color:var(--ink); line-height:1.2;
      margin-bottom:8px;
    }
    .form-heading p { font-size:.88rem; color:var(--ink-dim); }

    /* Erreur */
    .alert-err {
      display:flex;
      align-items:center;
      gap:10px;
      padding:12px 16px;
      background:rgba(231,76,60,.1);
      border:1px solid rgba(231,76,60,.3);
      border-radius:10px;
      font-size:.82rem;
      color:#e74c3c;
      margin-bottom:24px;
    }

    /* Champs */
    .field { margin-bottom:20px; }
    .field label {
      display:block;
      font-size:.78rem;
      font-weight:600;
      color:var(--ink-dim);
      letter-spacing:.06em;
      text-transform:uppercase;
      margin-bottom:8px;
    }
    .input-wrap { position:relative; }
    .input-wrap i {
      position:absolute;
      left:14px; top:50%;
      transform:translateY(-50%);
      font-size:.8rem;
      color:var(--ink-dim);
      pointer-events:none;
      transition:color .2s;
    }
    .input-wrap input {
      width:100%;
      padding:12px 14px 12px 38px;
      background:var(--bg2);
      border:1px solid var(--border);
      border-radius:10px;
      font-family:'DM Sans',sans-serif;
      font-size:.9rem;
      color:var(--ink);
      outline:none;
      transition:border-color .2s, background .2s;
    }
    .input-wrap input::placeholder { color:var(--ink-dim); }
    .input-wrap input:focus { border-color:var(--gold); background:var(--bg3); }
    .input-wrap input:focus + i,
    .input-wrap:focus-within i { color:var(--gold); }

    /* toggle password */
    .pw-toggle {
      position:absolute;
      right:14px; top:50%;
      transform:translateY(-50%);
      background:none; border:none;
      color:var(--ink-dim);
      cursor:pointer; font-size:.85rem;
      transition:color .2s;
    }
    .pw-toggle:hover { color:var(--gold); }

    /* Submit */
    .btn-submit {
      width:100%;
      padding:13px;
      background:var(--gold);
      border:none;
      border-radius:10px;
      font-family:'DM Sans',sans-serif;
      font-size:.92rem;
      font-weight:600;
      color:var(--bg);
      cursor:pointer;
      transition:background .2s, transform .15s, box-shadow .2s;
      margin-top:8px;
      display:flex; align-items:center; justify-content:center; gap:8px;
    }
    .btn-submit:hover {
      background:var(--gold-lt);
      transform:translateY(-1px);
      box-shadow:0 8px 32px rgba(201,168,76,.25);
    }
    .btn-submit:active { transform:none; }

    .form-footer {
      text-align:center;
      margin-top:24px;
      font-size:.82rem;
      color:var(--ink-dim);
    }
    .form-footer a {
      color:var(--gold);
      text-decoration:none;
      font-weight:600;
      transition:color .2s;
    }
    .form-footer a:hover { color:var(--gold-lt); }

    .divider {
      display:flex; align-items:center; gap:12px;
      margin:24px 0;
      font-size:.72rem; color:var(--ink-dim);
      text-transform:uppercase; letter-spacing:.08em;
    }
    .divider::before, .divider::after {
      content:''; flex:1; height:1px; background:var(--border);
    }

    /* ─── PANNEAU DROIT : BRANDING ─── */
    .brand-panel {
      flex:1;
      background:var(--bg2);
      border-left:1px solid var(--border);
      display:flex;
      align-items:center;
      justify-content:center;
      padding:60px;
      position:relative;
      overflow:hidden;
      animation:slideRight .6s ease both;
    }
    @keyframes slideRight { from{opacity:0;transform:translateX(24px)} to{opacity:1;transform:none} }

    /* Glow */
    .brand-panel::before {
      content:'';
      position:absolute;
      width:500px; height:500px;
      background:radial-gradient(circle, rgba(201,168,76,.1) 0%, transparent 70%);
      top:50%; left:50%;
      transform:translate(-50%,-50%);
      pointer-events:none;
    }

    /* Décorations géométriques */
    .brand-panel::after {
      content:'';
      position:absolute;
      top:0; right:0;
      width:200px; height:200px;
      background:conic-gradient(from 180deg at 100% 0%, rgba(201,168,76,.15) 0deg, transparent 90deg);
    }

    .brand-content { position:relative; z-index:2; text-align:center; max-width:380px; }

    .brand-icon {
      font-size:5.5rem;
      color:var(--gold);
      opacity:.9;
      margin-bottom:32px;
      display:block;
      animation:float 5s ease-in-out infinite;
    }
    @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-14px)} }

    .brand-title {
      font-family:'Playfair Display',serif;
      font-size:2.4rem; font-weight:900;
      color:var(--ink); line-height:1.15;
      margin-bottom:16px;
    }
    .brand-title em { font-style:italic; color:var(--gold); }

    .brand-sub {
      font-size:.9rem;
      color:var(--ink-dim);
      line-height:1.8;
      margin-bottom:40px;
    }

    .brand-features {
      display:flex;
      flex-direction:column;
      gap:14px;
      text-align:left;
    }
    .bf-item {
      display:flex;
      align-items:center;
      gap:14px;
      padding:14px 18px;
      background:var(--gold-dim);
      border:1px solid var(--border);
      border-radius:10px;
      transition:border-color .2s;
    }
    .bf-item:hover { border-color:rgba(201,168,76,.4); }
    .bf-ico {
      width:36px; height:36px;
      border-radius:8px;
      background:rgba(201,168,76,.15);
      display:flex; align-items:center; justify-content:center;
      color:var(--gold); font-size:.85rem;
      flex-shrink:0;
    }
    .bf-item span { font-size:.83rem; color:var(--ink-dim); }

    /* Corner déco bas-gauche */
    .brand-deco {
      position:absolute;
      bottom:0; left:0;
      width:160px; height:160px;
      border-right:1px solid var(--border);
      border-top:1px solid var(--border);
      border-radius:0 120px 0 0;
      opacity:.4;
    }

    /* Responsive */
    @media (max-width:900px) {
      .brand-panel { display:none; }
      .form-panel { padding:40px 24px; }
    }
  </style>
</head>
<body>
<div class="auth-wrapper">

  <!-- FORMULAIRE -->
  <div class="form-panel">
    <div class="form-box">

      <a href="{{ url('/') }}" class="form-logo">
        <div class="gavel"><i class="fas fa-gavel"></i></div>
        <span>Rouk<em>Legal</em></span>
      </a>

      <div class="form-heading">
        <h1>Bon retour<br>parmi nous</h1>
        <p>Connectez-vous à votre espace RoukLegal</p>
      </div>

      @if($errors->any())
      <div class="alert-err">
        <i class="fas fa-exclamation-circle"></i>
        {{ $errors->first() }}
      </div>
      @endif

      <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="field">
          <label for="email">Adresse e-mail</label>
          <div class="input-wrap">
            <i class="fas fa-envelope"></i>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="vous@exemple.com" autofocus>
          </div>
        </div>

        <div class="field">
          <label for="mot_de_passe">Mot de passe</label>
          <div class="input-wrap" style="position:relative;">
            <i class="fas fa-lock"></i>
            <input type="password" id="mot_de_passe" name="mot_de_passe" required placeholder="••••••••">
            <button type="button" class="pw-toggle" onclick="togglePw()" id="pwToggle">
              <i class="fas fa-eye" id="pwIcon"></i>
            </button>
          </div>
        </div>

        <button type="submit" class="btn-submit">
          <i class="fas fa-sign-in-alt"></i> Se connecter
        </button>
      </form>

      <div class="divider">ou</div>

      <div class="form-footer">
        Pas encore de compte ?
        <a href="{{ route('register') }}">Créer un compte</a>
      </div>

    </div>
  </div>

  <!-- BRANDING -->
  <div class="brand-panel">
    <div class="brand-deco"></div>
    <div class="brand-content">
      <i class="fas fa-balance-scale brand-icon"></i>
      <div class="brand-title">L'expertise<br>juridique<br><em>à portée.</em></div>
      <p class="brand-sub">Connectez-vous avec des professionnels du droit vérifiés pour toutes vos questions juridiques.</p>
      <div class="brand-features">
        @foreach([
          ['fas fa-shield-alt','Consultations sécurisées et confidentielles'],
          ['fas fa-user-check','Professionnels vérifiés et certifiés'],
          ['fas fa-bolt','Réponses rapides en moins de 24h'],
        ] as $f)
        <div class="bf-item">
          <div class="bf-ico"><i class="{{ $f[0] }}"></i></div>
          <span>{{ $f[1] }}</span>
        </div>
        @endforeach
      </div>
    </div>
  </div>

</div>

<script>
function togglePw() {
  const input = document.getElementById('mot_de_passe');
  const icon  = document.getElementById('pwIcon');
  if(input.type === 'password') {
    input.type = 'text';
    icon.className = 'fas fa-eye-slash';
  } else {
    input.type = 'password';
    icon.className = 'fas fa-eye';
  }
}
</script>
</body>
</html>