<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Mot de passe oublié — RoukLegal</title>
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
  --border:   rgba(28,36,52,.12);
  --green:    #1e7e50;
  --radius:   12px;
}
body{
  font-family:'DM Sans',sans-serif;
  background:var(--bg);color:var(--ink);
  min-height:100vh;display:flex;
  align-items:center; justify-content:center;
}
.form-wrap {
  width: 100%; max-width: 420px;
  background: var(--surface, #fff);
  padding: 40px; border-radius: var(--radius);
  box-shadow: 0 10px 30px rgba(0,0,0,.05);
}

.back-btn{
  display:inline-flex;align-items:center;gap:6px;
  color:var(--ink-dim);text-decoration:none;font-size:0.85rem;font-weight:500;
  margin-bottom:20px;transition:color 0.2s;
}
.back-btn:hover{color:var(--gold);}

.form-title{font-family:'Playfair Display',serif;font-size:1.6rem;font-weight:700;color:var(--ink);margin-bottom:6px;}
.form-sub{font-size:.88rem;color:var(--ink-dim);margin-bottom:24px;line-height:1.6;}

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

.btn-submit{
  width:100%;padding:13px;border-radius:10px;
  background:var(--ink);color:#fff;border:none; /* dark button */
  font-family:'DM Sans',sans-serif;font-size:.92rem;font-weight:600;
  cursor:pointer;
  transition:background .18s,transform .15s;
  display:flex;align-items:center;justify-content:center;gap:8px;
}
.btn-submit:hover{transform:translateY(-1px);}

@media(max-width:480px){
  .form-wrap{padding:24px;box-shadow:none;background:transparent;}
}
</style>
</head>
<body>
  <div class="form-wrap">
    <a href="{{ route('login') }}" class="back-btn"><i class="fas fa-arrow-left"></i> Retour à la connexion</a>

    <h1 class="form-title">Mot de passe oublié</h1>
    <p class="form-sub">Entrez votre e-mail pour recevoir un lien de réinitialisation.</p>

    @if(session('status'))
    <div class="alert-ok"><i class="fas fa-check-circle"></i>{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
      @csrf
      <div class="field">
        <label for="email">Adresse e-mail</label>
        <div class="field-wrap">
          <i class="fas fa-envelope fi"></i>
          <input type="email" id="email" name="email" placeholder="votre@email.com" value="{{ old('email') }}" required>
        </div>
      </div>
      <button type="submit" class="btn-submit"><i class="fas fa-paper-plane"></i> Envoyer le lien</button>
    </form>
  </div>
</body>
</html>
