<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Inscription — RoukLegal</title>
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
  --orange:   #d97c38;
  --radius:   12px;
}
body{font-family:'DM Sans',sans-serif;background:var(--bg);color:var(--ink);min-height:100vh;display:flex;}
body::before{
  content:'';position:fixed;inset:0;
  background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
  pointer-events:none;z-index:9999;opacity:.2;
}

.left{flex:1;display:flex;flex-direction:column;justify-content:center;align-items:center;padding:48px;min-height:100vh;background:var(--bg);overflow-y:auto;}
.form-wrap{width:100%;max-width:460px;padding:20px 0;}

.logo{display:flex;align-items:center;gap:10px;font-family:'Playfair Display',serif;font-size:1.4rem;font-weight:700;color:var(--ink);text-decoration:none;margin-bottom:36px;}
.logo .gavel{width:36px;height:36px;background:var(--gold);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:.9rem;color:#fff;flex-shrink:0;}
.logo span{color:var(--gold);}

.form-title{font-family:'Playfair Display',serif;font-size:1.9rem;font-weight:700;color:var(--ink);margin-bottom:6px;}
.form-sub{font-size:.88rem;color:var(--ink-dim);margin-bottom:28px;line-height:1.6;}

/* Barre étapes */
.steps-bar{display:flex;align-items:center;gap:0;margin-bottom:28px;}
.step-item{display:flex;align-items:center;gap:8px;flex:1;}
.step-item:last-child{flex:0;}
.step-circle{width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:.72rem;font-weight:700;flex-shrink:0;transition:all .2s;}
.step-circle.active{background:var(--gold);color:#fff;box-shadow:0 0 0 4px var(--gold-dim);}
.step-circle.pending{background:var(--bg3);color:var(--ink-dim);border:1.5px solid var(--border);}
.step-line{flex:1;height:1px;background:var(--border);margin:0 8px;}

.alert-err{display:flex;align-items:flex-start;gap:10px;padding:12px 16px;background:rgba(192,57,43,.08);border:1px solid rgba(192,57,43,.22);border-radius:10px;font-size:.83rem;color:var(--red);margin-bottom:20px;}

.trial-badge{display:flex;align-items:center;gap:10px;padding:12px 16px;background:var(--gold-dim);border:1px solid rgba(194,96,26,.2);border-radius:10px;font-size:.8rem;color:var(--gold);margin-bottom:20px;}

.field{margin-bottom:16px;}
.field label{display:block;font-size:.82rem;font-weight:500;color:var(--ink);margin-bottom:6px;}
.field-wrap{position:relative;}
.field-wrap i.fi{position:absolute;left:14px;top:50%;transform:translateY(-50%);color:var(--ink-dim);font-size:.85rem;pointer-events:none;}
.field input,.field select{
  width:100%;padding:11px 14px 11px 40px;
  border:1.5px solid var(--border);border-radius:10px;
  font-family:'DM Sans',sans-serif;font-size:.9rem;color:var(--ink);
  background:var(--bg2);outline:none;
  transition:border-color .18s,box-shadow .18s,background .18s;
}
.field input:focus,.field select:focus{border-color:var(--gold);box-shadow:0 0 0 3px var(--gold-dim);background:var(--bg);}
.toggle-pw{position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--ink-dim);cursor:pointer;font-size:.85rem;}
.toggle-pw:hover{color:var(--gold);}

/* Force mot de passe */
.pw-bars{display:flex;gap:4px;margin-top:8px;margin-bottom:4px;}
.pw-bar{flex:1;height:3px;border-radius:2px;background:var(--border);transition:background .3s;}
.pw-bar.weak{background:var(--red);}
.pw-bar.fair{background:var(--orange);}
.pw-bar.good{background:var(--gold);}
.pw-bar.strong{background:var(--green);}
.pw-text{font-size:.72rem;color:var(--ink-dim);}
.pw-match{font-size:.72rem;margin-top:5px;}
.pw-match.ok{color:var(--green);}
.pw-match.no{color:var(--red);}

.btn-submit{
  width:100%;padding:13px;border-radius:10px;
  background:var(--gold);color:#fff;border:none;
  font-family:'DM Sans',sans-serif;font-size:.92rem;font-weight:600;
  cursor:pointer;transition:background .18s,transform .15s,box-shadow .18s;
  box-shadow:0 4px 16px rgba(194,96,26,.25);
  display:flex;align-items:center;justify-content:center;gap:8px;margin-top:4px;
}
.btn-submit:hover{background:var(--gold-lt);transform:translateY(-1px);box-shadow:0 8px 24px rgba(194,96,26,.35);}

.terms{font-size:.75rem;color:var(--ink-dim);text-align:center;margin-top:12px;line-height:1.6;}
.terms a{color:var(--gold);}
.login-link{text-align:center;font-size:.85rem;color:var(--ink-dim);margin-top:16px;}
.login-link a{color:var(--gold);font-weight:600;text-decoration:none;}
.login-link a:hover{text-decoration:underline;}

/* DROITE */
.right{width:420px;flex-shrink:0;background:var(--navy);display:flex;flex-direction:column;justify-content:center;padding:64px 48px;position:relative;overflow:hidden;}
.right::before{content:'';position:absolute;top:-150px;right:-150px;width:400px;height:400px;border-radius:50%;background:radial-gradient(circle,rgba(194,96,26,.12) 0%,transparent 70%);}
.right-content{position:relative;z-index:1;}
.right-logo{display:flex;align-items:center;gap:10px;font-family:'Playfair Display',serif;font-size:1.6rem;font-weight:700;color:#f5f0e8;margin-bottom:6px;}
.right-logo .gavel{width:36px;height:36px;background:var(--gold);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:.9rem;color:#fff;}
.right-logo span{color:var(--gold);}
.right-tagline{font-size:.75rem;color:rgba(245,240,232,.45);margin-bottom:40px;letter-spacing:.08em;text-transform:uppercase;}
.right-title{font-family:'Playfair Display',serif;font-size:1.4rem;font-weight:700;color:#f5f0e8;line-height:1.35;margin-bottom:12px;}
.right-sub{font-size:.84rem;color:rgba(245,240,232,.55);line-height:1.8;margin-bottom:28px;}

.offer-card{background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);border-radius:14px;padding:20px 22px;margin-bottom:16px;}
.offer-title{font-family:'Playfair Display',serif;font-size:.95rem;color:#f5f0e8;font-weight:700;margin-bottom:3px;}
.offer-sub{font-size:.75rem;color:rgba(245,240,232,.4);margin-bottom:14px;}
.offer-items{display:flex;flex-direction:column;gap:7px;}
.offer-item{display:flex;align-items:center;gap:8px;font-size:.78rem;color:rgba(245,240,232,.65);}
.offer-item i{color:var(--gold-lt);width:12px;text-align:center;}

.right-disclaimer{font-size:.7rem;color:rgba(245,240,232,.3);line-height:1.6;margin-top:14px;}

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

    <h1 class="form-title">Créer un compte</h1>
    <p class="form-sub">Rejoignez RoukLegal et accédez à des conseils juridiques professionnels.</p>

    <div class="steps-bar">
      <div class="step-item">
        <div class="step-circle active">1</div>
        <div class="step-line"></div>
      </div>
      <div class="step-item">
        <div class="step-circle pending">2</div>
        <div class="step-line"></div>
      </div>
      <div class="step-item">
        <div class="step-circle pending">3</div>
      </div>
    </div>

    @if($errors->any())
    <div class="alert-err">
      <i class="fas fa-exclamation-circle" style="flex-shrink:0;margin-top:2px;"></i>
      <div>@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
    </div>
    @endif

    <div class="trial-badge">
      <i class="fas fa-gift"></i>
      <span><strong>2 semaines d'essai gratuit</strong> — Aucune carte bancaire requise</span>
    </div>

    <form method="POST" action="{{ route('register') }}">
      @csrf

      <div class="field">
        <label for="nom">Nom complet <span style="color:var(--red)">*</span></label>
        <div class="field-wrap">
          <i class="fas fa-user fi"></i>
          <input type="text" id="nom" name="nom" placeholder="Votre nom complet" value="{{ old('nom') }}" required>
        </div>
      </div>

      <div class="field">
        <label for="email">Adresse e-mail <span style="color:var(--red)">*</span></label>
        <div class="field-wrap">
          <i class="fas fa-envelope fi"></i>
          <input type="email" id="email" name="email" placeholder="votre@email.com" value="{{ old('email') }}" required>
        </div>
      </div>

      <div class="field">
        <label for="mot_de_passe">Mot de passe <span style="color:var(--red)">*</span></label>
        <div class="field-wrap">
          <i class="fas fa-lock fi"></i>
          <input type="password" id="mot_de_passe" name="mot_de_passe" placeholder="Minimum 8 caractères" required oninput="checkStrength(this.value)">
          <button type="button" class="toggle-pw" onclick="togglePw('mot_de_passe','ico1')"><i class="fas fa-eye" id="ico1"></i></button>
        </div>
        <div class="pw-bars">
          <div class="pw-bar" id="b1"></div><div class="pw-bar" id="b2"></div>
          <div class="pw-bar" id="b3"></div><div class="pw-bar" id="b4"></div>
        </div>
        <div class="pw-text" id="pw-label">Entrez un mot de passe</div>
      </div>

      <div class="field">
        <label for="mot_de_passe_confirmation">Confirmer le mot de passe <span style="color:var(--red)">*</span></label>
        <div class="field-wrap">
          <i class="fas fa-lock fi"></i>
          <input type="password" id="mot_de_passe_confirmation" name="mot_de_passe_confirmation" placeholder="Répétez votre mot de passe" required oninput="checkMatch()">
          <button type="button" class="toggle-pw" onclick="togglePw('mot_de_passe_confirmation','ico2')"><i class="fas fa-eye" id="ico2"></i></button>
        </div>
        <div class="pw-match" id="match-msg"></div>
      </div>

      <button type="submit" class="btn-submit"><i class="fas fa-user-plus"></i> Créer mon compte</button>
    </form>

    <p class="terms">En créant un compte, vous acceptez nos <a href="#">Conditions d'utilisation</a> et notre <a href="#">Politique de confidentialité</a>.</p>
    <div class="login-link">Déjà un compte ? <a href="{{ route('login') }}">Se connecter</a></div>

  </div>
</div>

<div class="right">
  <div class="right-content">
    <div class="right-logo"><div class="gavel"><i class="fas fa-gavel"></i></div>Rouk<span>Legal</span></div>
    <div class="right-tagline">Plateforme juridique professionnelle</div>
    <h2 class="right-title">Commencez gratuitement pendant 2 semaines</h2>
    <p class="right-sub">Accédez à toutes les fonctionnalités sans engagement.</p>
    <div class="offer-card">
      <div class="offer-title">Inclus dans l'essai gratuit</div>
      <div class="offer-sub">14 jours · Aucune carte requise</div>
      <div class="offer-items">
        @foreach(['Accès illimité aux articles juridiques','Poser des questions aux experts','Messagerie sécurisée','Annuaire des acteurs juridiques','Prise de rendez-vous (10 000 FCFA/séance)'] as $f)
        <div class="offer-item"><i class="fas fa-check"></i> {{ $f }}</div>
        @endforeach
      </div>
    </div>
    <div class="offer-card">
      <div class="offer-title">Vous êtes professionnel du droit ?</div>
      <div class="offer-sub">Rejoignez en tant qu'acteur juridique</div>
      <div class="offer-items">
        @foreach(['Publiez vos articles','Répondez aux questions','Gérez vos créneaux & RDV','Percevez 80% du tarif de consultation'] as $f)
        <div class="offer-item"><i class="fas fa-check"></i> {{ $f }}</div>
        @endforeach
      </div>
    </div>
    <p class="right-disclaimer">Après l'essai, un abonnement mensuel est requis. Résiliable à tout moment.</p>
  </div>
</div>

<script>
function togglePw(id,ico){
  const inp=document.getElementById(id);const ic=document.getElementById(ico);
  inp.type=inp.type==='password'?'text':'password';
  ic.className=inp.type==='password'?'fas fa-eye':'fas fa-eye-slash';
}
function checkStrength(v){
  const bars=[document.getElementById('b1'),document.getElementById('b2'),document.getElementById('b3'),document.getElementById('b4')];
  const lbl=document.getElementById('pw-label');
  bars.forEach(b=>{b.className='pw-bar';});
  if(!v){lbl.textContent='Entrez un mot de passe';return;}
  let s=0;
  if(v.length>=8)s++;if(/[A-Z]/.test(v))s++;if(/[0-9]/.test(v))s++;if(/[^A-Za-z0-9]/.test(v))s++;
  const cls=['weak','fair','good','strong'];
  const lbls=['Trop faible','Passable','Bien','Fort'];
  for(let i=0;i<s;i++)bars[i].className='pw-bar '+cls[s-1];
  lbl.textContent='Force : '+lbls[s-1];
  lbl.style.color=s<=1?'var(--red)':s===2?'var(--orange)':s===3?'var(--gold)':'var(--green)';
}
function checkMatch(){
  const pw=document.getElementById('mot_de_passe').value;
  const cf=document.getElementById('mot_de_passe_confirmation').value;
  const msg=document.getElementById('match-msg');
  if(!cf){msg.textContent='';return;}
  if(pw===cf){msg.className='pw-match ok';msg.innerHTML='<i class="fas fa-check"></i> Les mots de passe correspondent';}
  else{msg.className='pw-match no';msg.innerHTML='<i class="fas fa-times"></i> Les mots de passe ne correspondent pas';}
}
</script>
</body>
</html>