<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Réinitialiser le mot de passe — RoukLegal</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
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
.form-title{font-family:'Playfair Display',serif;font-size:1.6rem;font-weight:700;color:var(--ink);margin-bottom:6px;}
.form-sub{font-size:.88rem;color:var(--ink-dim);margin-bottom:24px;line-height:1.6;}

.alert-err{
  display:flex;align-items:center;gap:10px;
  padding:12px 16px;background:rgba(192,57,43,.08);
  border:1px solid rgba(192,57,43,.22);border-radius:10px;
  font-size:.83rem;color:var(--red);margin-bottom:20px;
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

.btn-submit{
  width:100%;padding:13px;border-radius:10px;
  background:var(--ink);color:#fff;border:none; 
  font-family:'DM Sans',sans-serif;font-size:.92rem;font-weight:600;
  cursor:pointer;
  transition:background .18s,transform .15s;
}
.btn-submit:hover{transform:translateY(-1px);}
</style>
</head>
<body>
  <div class="form-wrap">
    <h1 class="form-title">Nouveau mot de passe</h1>
    <p class="form-sub">Veuillez définir votre nouveau mot de passe sécurisé ci-dessous.</p>

    @if($errors->any())
    <div class="alert-err">
      <i class="fas fa-exclamation-circle" style="flex-shrink:0;"></i>
      <div>@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
    </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
      @csrf
      <input type="hidden" name="token" value="{{ $token }}">

      <div class="field">
        <label for="email">Adresse e-mail</label>
        <div class="field-wrap">
          <i class="fas fa-envelope fi"></i>
          <input type="email" id="email" name="email" value="{{ request()->email }}" required readonly style="opacity:0.7">
        </div>
      </div>

      <div class="field">
        <label for="password">Nouveau mot de passe</label>
        <div class="field-wrap">
          <i class="fas fa-lock fi"></i>
          <input type="password" id="password" name="password" required>
        </div>
      </div>

      <div class="field">
        <label for="password_confirmation">Confirmer le mot de passe</label>
        <div class="field-wrap">
          <i class="fas fa-lock fi"></i>
          <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>
      </div>

      <button type="submit" class="btn-submit">Réenregistrer mon accès</button>
    </form>
  </div>
</body>
</html>
