<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Connexion — RoukLegal</title>
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
  --red:      #c0392b;
  --green:    #1e7e50;
  --radius:   12px;
}
body{
  font-family:'DM Sans',sans-serif;
  background:var(--bg);color:var(--ink);
  min-height:100vh;display:flex;
}
body::before{
  content:'';position:fixed;inset:0;
  background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
  pointer-events:none;z-index:9999;opacity:.2;
}

/* GAUCHE */
.left{
  flex:1;display:flex;flex-direction:column;
  justify-content:center;align-items:center;
  padding:48px;min-height:100vh;
  background:var(--bg);
}
.form-wrap{width:100%;max-width:420px;}

.logo{
  display:flex;align-items:center;gap:10px;
  font-family:'Playfair Display',serif;font-size:1.4rem;font-weight:700;
  color:var(--ink);text-decoration:none;margin-bottom:40px;
}
.logo .gavel{
  width:36px;height:36px;background:var(--gold);border-radius:8px;
  display:flex;align-items:center;justify-content:center;
  font-size:.9rem;color:#fff;flex-shrink:0;
}
.logo span{color:var(--gold);}

.form-title{font-family:'Playfair Display',serif;font-size:1.9rem;font-weight:700;color:var(--ink);margin-bottom:6px;}
.form-sub{font-size:.88rem;color:var(--ink-dim);margin-bottom:32px;line-height:1.6;}

.alert-err{
  display:flex;align-items:center;gap:10px;
  padding:12px 16px;background:rgba(192,57,43,.08);
  border:1px solid rgba(192,57,43,.22);border-radius:10px;
  font-size:.83rem;color:var(--red);margin-bottom:20px;
}
.alert-ok{
  display:flex;align-items:center;gap:10px;
  padding:12px 16px;background:rgba(30,126,80,.08);
  border:1px solid rgba(30,126,80,.22);border-radius:10px;
  font-size:.83rem;color:var(--green);margin-bottom:20px;
}

.field{margin-bottom:18px;}
.field label{display:block;font-size:.82rem;font-weight:500;color:var(--ink);margin-bottom:6px;}
.field-wrap{position:relative;}
.field-wrap i.fi{
  position:absolute;left:14px;top:50%;transform:translateY(-50%);
  color:var(--ink-dim);font-size:.85rem;pointer-events:none;
}
.field input{
  width:100%;padding:11px 14px 11px 40px;
  border:1.5px solid var(--border);border-radius:10px;
  font-family:'DM Sans',sans-serif;font-size:.9rem;color:var(--ink);
  background:var(--bg2);outline:none;
  transition:border-color .18s,box-shadow .18s,background .18s;
}
.field input:focus{border-color:var(--gold);box-shadow:0 0 0 3px var(--gold-dim);background:var(--bg);}
.toggle-pw{position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--ink-dim);cursor:pointer;font-size:.85rem;}
.toggle-pw:hover{color:var(--gold);}

.field-footer{display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;font-size:.8rem;}
.remember{display:flex;align-items:center;gap:6px;color:var(--ink-dim);}
.remember input[type=checkbox]{accent-color:var(--gold);}
.forgot{color:var(--gold);text-decoration:none;font-weight:500;}
.forgot:hover{text-decoration:underline;}

.btn-submit{
  width:100%;padding:13px;border-radius:10px;
  background:var(--gold);color:#fff;border:none;
  font-family:'DM Sans',sans-serif;font-size:.92rem;font-weight:600;
  cursor:pointer;
  transition:background .18s,transform .15s,box-shadow .18s;
  box-shadow:0 4px 16px rgba(194,96,26,.25);
  display:flex;align-items:center;justify-content:center;gap:8px;
}
.btn-submit:hover{background:var(--gold-lt);transform:translateY(-1px);box-shadow:0 8px 24px rgba(194,96,26,.35);}

.divider{display:flex;align-items:center;gap:12px;margin:20px 0;font-size:.78rem;color:var(--ink-dim);}
.divider::before,.divider::after{content:'';flex:1;height:1px;background:var(--border);}

.register-link{text-align:center;font-size:.85rem;color:var(--ink-dim);}
.register-link a{color:var(--gold);font-weight:600;text-decoration:none;}
.register-link a:hover{text-decoration:underline;}

/* DROITE */
.right{
  width:480px;flex-shrink:0;
  background:var(--navy);
  display:flex;flex-direction:column;justify-content:center;
  padding:64px 48px;position:relative;overflow:hidden;
}
.right::before{
  content:'';position:absolute;top:-150px;right:-150px;
  width:400px;height:400px;border-radius:50%;
  background:radial-gradient(circle,rgba(194,96,26,.12) 0%,transparent 70%);
}
.right::after{
  content:'';position:absolute;bottom:-100px;left:-80px;
  width:300px;height:300px;border-radius:50%;
  background:rgba(255,255,255,.02);
}
.right-content{position:relative;z-index:1;}
.right-logo{
  display:flex;align-items:center;gap:10px;
  font-family:'Playfair Display',serif;font-size:1.6rem;font-weight:700;color:#f5f0e8;
  margin-bottom:6px;
}
.right-logo .gavel{width:36px;height:36px;background:var(--gold);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:.9rem;color:#fff;}
.right-logo span{color:var(--gold);}
.right-tagline{font-size:.75rem;color:rgba(245,240,232,.45);margin-bottom:44px;letter-spacing:.08em;text-transform:uppercase;}
.right-title{font-family:'Playfair Display',serif;font-size:1.5rem;font-weight:700;color:#f5f0e8;line-height:1.35;margin-bottom:12px;}
.right-sub{font-size:.85rem;color:rgba(245,240,232,.58);line-height:1.8;margin-bottom:36px;}
.features{display:flex;flex-direction:column;gap:16px;}
.feature{display:flex;align-items:center;gap:14px;}
.feature-icon{
  width:38px;height:38px;border-radius:9px;
  background:rgba(194,96,26,.18);border:1px solid rgba(194,96,26,.25);
  display:flex;align-items:center;justify-content:center;
  font-size:.85rem;color:var(--gold-lt);flex-shrink:0;
}
.feature-text{font-size:.82rem;color:rgba(245,240,232,.6);line-height:1.5;}
.feature-text strong{color:#f5f0e8;display:block;font-size:.84rem;margin-bottom:1px;}

.right-badge{
  margin-top:36px;padding:16px 20px;
  background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);
  border-radius:12px;display:flex;align-items:center;gap:0;
}
.badge-item{flex:1;text-align:center;}
.badge-item+.badge-item{border-left:1px solid rgba(255,255,255,.1);}
.badge-val{font-family:'Playfair Display',serif;font-size:1.5rem;font-weight:700;color:var(--gold-lt);}
.badge-label{font-size:.7rem;color:rgba(245,240,232,.4);margin-top:2px;}

@media(max-width:900px){.right{display:none;}}
</style>
</head>
<body>
<div class="left">
  <div class="form-wrap">

    <a class="logo" href="{{ route('home') }}">
      <div class="gavel"><i class="fas fa-gavel"></i></div>
      Rouk<span>Legal</span>
    </a>

    <h1 class="form-title">Bon retour !</h1>
    <p class="form-sub">Connectez-vous à votre espace pour accéder à vos consultations et messages.</p>

    @if($errors->any())
    <div class="alert-err"><i class="fas fa-exclamation-circle"></i><span>{{ $errors->first() }}</span></div>
    @endif
    @if(session('status'))
    <div class="alert-ok"><i class="fas fa-check-circle"></i>{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
      @csrf
      <div class="field">
        <label for="email">Adresse e-mail</label>
        <div class="field-wrap">
          <i class="fas fa-envelope fi"></i>
          <input type="email" id="email" name="email" placeholder="votre@email.com" value="{{ old('email') }}" required autocomplete="email">
        </div>
      </div>
      <div class="field">
        <label for="password">Mot de passe</label>
        <div class="field-wrap">
          <i class="fas fa-lock fi"></i>
          <input type="password" id="password" name="mot_de_passe" placeholder="••••••••" required autocomplete="current-password">
          <button type="button" class="toggle-pw" onclick="togglePw()"><i class="fas fa-eye" id="pw-icon"></i></button>
        </div>
      </div>
      <div class="field-footer">
        <label class="remember"><input type="checkbox" name="remember"> Se souvenir de moi</label>
        <a class="forgot" href="#">Mot de passe oublié ?</a>
      </div>
      <button type="submit" class="btn-submit"><i class="fas fa-sign-in-alt"></i> Se connecter</button>
    </form>

    <div class="divider">ou</div>
    <div class="register-link">Pas encore de compte ? <a href="{{ route('register') }}">Créer un compte gratuit</a></div>

  </div>
</div>

<div class="right">
  <div class="right-content">
    <div class="right-logo"><div class="gavel"><i class="fas fa-gavel"></i></div>Rouk<span>Legal</span></div>
    <div class="right-tagline">Plateforme juridique professionnelle</div>
    <h2 class="right-title">Votre conseiller juridique, disponible 24h/24</h2>
    <p class="right-sub">Des experts qualifiés à votre écoute pour toutes vos questions de droit.</p>
    <div class="features">
      @foreach([
        ['fas fa-question-circle','Questions juridiques','Posez vos questions, obtenez des réponses claires.'],
        ['fas fa-calendar-check','Rendez-vous en ligne','Consultez un expert selon ses créneaux disponibles.'],
        ['fas fa-lock','Confidentialité garantie','Vos échanges sont 100% sécurisés et confidentiels.'],
        ['fas fa-clock','Essai gratuit','2 semaines d\'accès complet sans engagement.'],
      ] as $f)
      <div class="feature">
        <div class="feature-icon"><i class="{{ $f[0] }}"></i></div>
        <div class="feature-text"><strong>{{ $f[1] }}</strong>{{ $f[2] }}</div>
      </div>
      @endforeach
    </div>
    <div class="right-badge">
      <div class="badge-item"><div class="badge-val">98%</div><div class="badge-label">Satisfaction client</div></div>
      <div class="badge-item"><div class="badge-val">48</div><div class="badge-label">Experts vérifiés</div></div>
      <div class="badge-item"><div class="badge-val">3 200+</div><div class="badge-label">Clients actifs</div></div>
    </div>
  </div>
</div>

<script>
function togglePw(){
  const inp=document.getElementById('password');
  const ico=document.getElementById('pw-icon');
  inp.type=inp.type==='password'?'text':'password';
  ico.className=inp.type==='password'?'fas fa-eye':'fas fa-eye-slash';
}
</script>
</body>
</html>