<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inscription — RoukLegal</title>
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
      --green:   #27ae60;
      --radius:  12px;
    }
    html, body { height:100%; font-family:'DM Sans',sans-serif; background:var(--bg); color:var(--ink); }

    body::before {
      content:'';
      position:fixed; inset:0;
      background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
      pointer-events:none; z-index:9999; opacity:.5;
    }

    .auth-wrapper { display:flex; height:100vh; }

    /* ─── PANNEAU GAUCHE ─── */
    .form-panel {
      flex:1;
      display:flex;
      align-items:center;
      justify-content:center;
      padding:32px 48px;
      background:var(--bg);
      overflow-y:auto;
      animation:slideLeft .6s ease both;
    }
    @keyframes slideLeft { from{opacity:0;transform:translateX(-24px)} to{opacity:1;transform:none} }

    .form-box { width:100%; max-width:420px; }

    .form-logo {
      display:flex; align-items:center; gap:10px;
      margin-bottom:32px; text-decoration:none;
    }
    .form-logo .gavel {
      width:36px; height:36px; background:var(--gold);
      border-radius:8px; display:flex; align-items:center; justify-content:center;
      font-size:.85rem; color:var(--bg);
    }
    .form-logo span { font-family:'Playfair Display',serif; font-size:1.3rem; font-weight:700; color:var(--ink); }
    .form-logo span em { font-style:normal; color:var(--gold); }

    .form-heading { margin-bottom:28px; }
    .form-heading h1 {
      font-family:'Playfair Display',serif;
      font-size:1.85rem; font-weight:700;
      color:var(--ink); line-height:1.2; margin-bottom:8px;
    }
    .form-heading p { font-size:.85rem; color:var(--ink-dim); }

    /* Erreurs */
    .alert-err {
      padding:12px 16px;
      background:rgba(231,76,60,.1);
      border:1px solid rgba(231,76,60,.3);
      border-radius:10px;
      font-size:.8rem; color:var(--red);
      margin-bottom:20px;
    }
    .alert-err ul { padding-left:16px; margin:0; display:flex; flex-direction:column; gap:4px; }

    /* Grille 2 colonnes pour nom+email */
    .fields-row { display:grid; grid-template-columns:1fr 1fr; gap:14px; }

    .field { margin-bottom:16px; }
    .field label {
      display:block;
      font-size:.72rem; font-weight:600;
      color:var(--ink-dim);
      letter-spacing:.06em; text-transform:uppercase;
      margin-bottom:7px;
    }
    .input-wrap { position:relative; }
    .input-wrap i.ico {
      position:absolute; left:13px; top:50%;
      transform:translateY(-50%);
      font-size:.78rem; color:var(--ink-dim);
      pointer-events:none; transition:color .2s;
    }
    .input-wrap input {
      width:100%;
      padding:11px 13px 11px 36px;
      background:var(--bg2);
      border:1px solid var(--border);
      border-radius:10px;
      font-family:'DM Sans',sans-serif;
      font-size:.88rem; color:var(--ink);
      outline:none;
      transition:border-color .2s, background .2s;
    }
    .input-wrap input::placeholder { color:var(--ink-dim); }
    .input-wrap input:focus { border-color:var(--gold); background:var(--bg3); }
    .input-wrap:focus-within i.ico { color:var(--gold); }

    /* Indicateur force mot de passe */
    .pw-strength { margin-top:6px; display:flex; gap:4px; align-items:center; }
    .pw-bar { flex:1; height:3px; border-radius:2px; background:var(--border); transition:background .3s; }
    .pw-label { font-size:.68rem; color:var(--ink-dim); white-space:nowrap; margin-left:4px; transition:color .3s; }

    .pw-toggle {
      position:absolute; right:12px; top:50%;
      transform:translateY(-50%);
      background:none; border:none;
      color:var(--ink-dim); cursor:pointer;
      font-size:.82rem; transition:color .2s;
    }
    .pw-toggle:hover { color:var(--gold); }

    /* Submit */
    .btn-submit {
      width:100%; padding:13px;
      background:var(--gold); border:none;
      border-radius:10px;
      font-family:'DM Sans',sans-serif;
      font-size:.9rem; font-weight:600;
      color:var(--bg); cursor:pointer;
      transition:background .2s, transform .15s, box-shadow .2s;
      margin-top:4px;
      display:flex; align-items:center; justify-content:center; gap:8px;
    }
    .btn-submit:hover { background:var(--gold-lt); transform:translateY(-1px); box-shadow:0 8px 32px rgba(201,168,76,.25); }
    .btn-submit:active { transform:none; }

    .divider {
      display:flex; align-items:center; gap:12px;
      margin:20px 0;
      font-size:.7rem; color:var(--ink-dim);
      text-transform:uppercase; letter-spacing:.08em;
    }
    .divider::before, .divider::after { content:''; flex:1; height:1px; background:var(--border); }

    .form-footer { text-align:center; font-size:.82rem; color:var(--ink-dim); }
    .form-footer a { color:var(--gold); text-decoration:none; font-weight:600; transition:color .2s; }
    .form-footer a:hover { color:var(--gold-lt); }

    /* ─── PANNEAU DROIT ─── */
    .brand-panel {
      flex:1;
      background:var(--bg2);
      border-left:1px solid var(--border);
      display:flex; align-items:center; justify-content:center;
      padding:60px;
      position:relative; overflow:hidden;
      animation:slideRight .6s ease both;
    }
    @keyframes slideRight { from{opacity:0;transform:translateX(24px)} to{opacity:1;transform:none} }

    .brand-panel::before {
      content:'';
      position:absolute;
      width:500px; height:500px;
      background:radial-gradient(circle, rgba(201,168,76,.1) 0%, transparent 70%);
      top:50%; left:50%; transform:translate(-50%,-50%);
      pointer-events:none;
    }
    .brand-panel::after {
      content:'';
      position:absolute; top:0; right:0;
      width:200px; height:200px;
      background:conic-gradient(from 180deg at 100% 0%, rgba(201,168,76,.15) 0deg, transparent 90deg);
    }

    .brand-content { position:relative; z-index:2; text-align:center; max-width:360px; }

    .brand-icon {
      font-size:5rem; color:var(--gold); opacity:.9;
      margin-bottom:28px; display:block;
      animation:float 5s ease-in-out infinite;
    }
    @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-14px)} }

    .brand-title {
      font-family:'Playfair Display',serif;
      font-size:2.2rem; font-weight:900;
      color:var(--ink); line-height:1.2; margin-bottom:14px;
    }
    .brand-title em { font-style:italic; color:var(--gold); }

    .brand-sub { font-size:.87rem; color:var(--ink-dim); line-height:1.8; margin-bottom:36px; }

    /* Steps d'inscription */
    .brand-steps { display:flex; flex-direction:column; gap:12px; text-align:left; }
    .step-item {
      display:flex; align-items:center; gap:14px;
      padding:14px 18px;
      background:var(--gold-dim);
      border:1px solid var(--border);
      border-radius:10px;
    }
    .step-num {
      width:28px; height:28px; border-radius:50%;
      background:var(--gold); color:var(--bg);
      display:flex; align-items:center; justify-content:center;
      font-size:.75rem; font-weight:700;
      flex-shrink:0;
    }
    .step-item span { font-size:.82rem; color:var(--ink-dim); }

    .brand-deco {
      position:absolute; bottom:0; left:0;
      width:160px; height:160px;
      border-right:1px solid var(--border);
      border-top:1px solid var(--border);
      border-radius:0 120px 0 0;
      opacity:.4;
    }

    @media (max-width:900px) {
      .brand-panel { display:none; }
      .form-panel { padding:32px 24px; }
      .fields-row { grid-template-columns:1fr; }
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
        <h1>Créer votre<br>compte</h1>
        <p>Rejoignez la plateforme juridique de confiance</p>
      </div>

      @if($errors->any())
      <div class="alert-err">
        <ul>
          @foreach($errors->all() as $error)
            <li><i class="fas fa-exclamation-circle" style="margin-right:5px;"></i>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif

      <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="fields-row">
          <div class="field">
            <label for="nom">Nom complet</label>
            <div class="input-wrap">
              <i class="fas fa-user ico"></i>
              <input type="text" id="nom" name="nom" value="{{ old('nom') }}" required placeholder="Jean Dupont">
            </div>
          </div>
          <div class="field">
            <label for="email">Adresse e-mail</label>
            <div class="input-wrap">
              <i class="fas fa-envelope ico"></i>
              <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="vous@exemple.com">
            </div>
          </div>
        </div>

        <div class="field">
          <label for="mot_de_passe">Mot de passe</label>
          <div class="input-wrap">
            <i class="fas fa-lock ico"></i>
            <input type="password" id="mot_de_passe" name="mot_de_passe" required placeholder="Minimum 8 caractères" oninput="checkStrength(this.value)">
            <button type="button" class="pw-toggle" onclick="togglePw('mot_de_passe','icon1')">
              <i class="fas fa-eye" id="icon1"></i>
            </button>
          </div>
          <div class="pw-strength">
            <div class="pw-bar" id="bar1"></div>
            <div class="pw-bar" id="bar2"></div>
            <div class="pw-bar" id="bar3"></div>
            <div class="pw-bar" id="bar4"></div>
            <span class="pw-label" id="pwLabel">—</span>
          </div>
        </div>

        <div class="field">
          <label for="mot_de_passe_confirmation">Confirmer le mot de passe</label>
          <div class="input-wrap">
            <i class="fas fa-lock ico"></i>
            <input type="password" id="mot_de_passe_confirmation" name="mot_de_passe_confirmation" required placeholder="Répétez le mot de passe" oninput="checkConfirm(this.value)">
            <button type="button" class="pw-toggle" onclick="togglePw('mot_de_passe_confirmation','icon2')">
              <i class="fas fa-eye" id="icon2"></i>
            </button>
          </div>
          <div id="matchMsg" style="font-size:.7rem;margin-top:5px;display:none;"></div>
        </div>

        <button type="submit" class="btn-submit">
          <i class="fas fa-user-plus"></i> Créer mon compte
        </button>
      </form>

      <div class="divider">déjà inscrit ?</div>

      <div class="form-footer">
        <a href="{{ route('login') }}"><i class="fas fa-sign-in-alt" style="margin-right:5px;"></i>Se connecter à mon compte</a>
      </div>

    </div>
  </div>

  <!-- BRANDING -->
  <div class="brand-panel">
    <div class="brand-deco"></div>
    <div class="brand-content">
      <i class="fas fa-gavel brand-icon"></i>
      <div class="brand-title">Rejoignez<br><em>RoukLegal</em><br>aujourd'hui</div>
      <p class="brand-sub">Accédez à des conseils juridiques professionnels en quelques minutes seulement.</p>
      <div class="brand-steps">
        @foreach([
          ['Créez votre compte gratuitement'],
          ['Choisissez votre rôle (client ou acteur)'],
          ['Accédez aux articles et experts'],
          ['Posez vos questions et obtenez des réponses'],
        ] as $i => $s)
        <div class="step-item">
          <div class="step-num">{{ $i + 1 }}</div>
          <span>{{ $s[0] }}</span>
        </div>
        @endforeach
      </div>
    </div>
  </div>

</div>

<script>
function togglePw(id, iconId) {
  const input = document.getElementById(id);
  const icon  = document.getElementById(iconId);
  input.type  = input.type === 'password' ? 'text' : 'password';
  icon.className = input.type === 'password' ? 'fas fa-eye' : 'fas fa-eye-slash';
}

const colors = { 1:'#e74c3c', 2:'#e67e22', 3:'#f1c40f', 4:'#27ae60' };
const labels = { 0:'—', 1:'Faible', 2:'Moyen', 3:'Bon', 4:'Fort' };

function checkStrength(val) {
  let score = 0;
  if(val.length >= 8) score++;
  if(/[A-Z]/.test(val)) score++;
  if(/[0-9]/.test(val)) score++;
  if(/[^A-Za-z0-9]/.test(val)) score++;
  const c = score > 0 ? colors[score] : 'var(--border)';
  for(let i=1;i<=4;i++) {
    document.getElementById('bar'+i).style.background = i <= score ? c : 'var(--border)';
  }
  const lbl = document.getElementById('pwLabel');
  lbl.textContent = labels[score];
  lbl.style.color = score > 0 ? c : 'var(--ink-dim)';
}

function checkConfirm(val) {
  const pw  = document.getElementById('mot_de_passe').value;
  const msg = document.getElementById('matchMsg');
  msg.style.display = val.length > 0 ? 'block' : 'none';
  if(val === pw) {
    msg.textContent = '✓ Les mots de passe correspondent';
    msg.style.color = '#27ae60';
  } else {
    msg.textContent = '✗ Les mots de passe ne correspondent pas';
    msg.style.color = '#e74c3c';
  }
}
</script>
</body>
</html>