@extends('layouts.app')

@section('title', 'Choisir votre rôle — RoukLegal')

@section('page-title')
  Bienvenue <span>/ Choisir votre rôle</span>
@endsection

@section('content')
<div style="max-width:680px;margin:0 auto;display:flex;flex-direction:column;gap:28px;">

  {{-- BANNIÈRE BIENVENUE --}}
  <div class="rl-card fade-up" style="background:linear-gradient(135deg,#111820,#1a2535);border-color:rgba(201,168,76,.25);text-align:center;padding:40px 32px;">
    <div style="width:64px;height:64px;border-radius:50%;background:var(--gold-dim);border:2px solid var(--gold);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:1.6rem;">
      👋
    </div>
    <div style="font-family:'Playfair Display',serif;font-size:1.6rem;font-weight:700;color:var(--ink);margin-bottom:10px;">
      Bienvenue, {{ Auth::user()->nom }} !
    </div>
    <div style="font-size:.9rem;color:rgba(245,240,232,.6);line-height:1.7;max-width:420px;margin:0 auto;">
      Votre compte a été créé avec succès. Choisissez maintenant votre rôle sur la plateforme.
    </div>
  </div>

  {{-- CARTES DE SÉLECTION --}}
  <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">

    {{-- CLIENT --}}
    <form method="POST" action="{{ route('auth.selectRole') }}">
      @csrf
      <input type="hidden" name="role" value="client">
      <button type="submit"
        style="width:100%;background:var(--surface);border:2px solid var(--border);border-radius:var(--radius);padding:36px 24px;cursor:pointer;text-align:center;display:flex;flex-direction:column;align-items:center;gap:0;transition:border-color .2s,transform .2s,box-shadow .2s;position:relative;overflow:hidden;"
        onmouseover="this.style.borderColor='var(--gold)';this.style.transform='translateY(-4px)';this.style.boxShadow='0 16px 48px rgba(0,0,0,.2)'"
        onmouseout="this.style.borderColor='var(--border)';this.style.transform='none';this.style.boxShadow='none'">

        {{-- Accent top --}}
        <div style="position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,transparent,var(--gold),transparent);opacity:0;transition:opacity .2s;" class="card-accent"></div>

        <div style="width:72px;height:72px;border-radius:50%;background:var(--gold-dim);border:2px solid var(--border);display:flex;align-items:center;justify-content:center;font-size:2rem;margin-bottom:20px;transition:border-color .2s,background .2s;">
          👤
        </div>
        <div style="font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:700;color:var(--ink);margin-bottom:10px;">Client</div>
        <div style="font-size:.82rem;color:var(--txt-muted);line-height:1.7;margin-bottom:20px;">
          Posez vos questions juridiques à des experts qualifiés et consultez leurs articles.
        </div>
        <div style="display:flex;flex-direction:column;gap:6px;width:100%;text-align:left;margin-bottom:20px;">
          @foreach(['Accès aux articles juridiques','Poser des questions aux experts','Messagerie privée','Essai gratuit 2 semaines'] as $f)
          <div style="display:flex;align-items:center;gap:8px;font-size:.75rem;color:var(--txt-muted);">
            <span style="color:var(--green);flex-shrink:0;">✓</span> {{ $f }}
          </div>
          @endforeach
        </div>
        <div style="padding:10px 28px;background:var(--gold);border-radius:8px;font-size:.82rem;font-weight:600;color:#111820;">
          Choisir ce rôle
        </div>
      </button>
    </form>

    {{-- ACTEUR JURIDIQUE --}}
    <form method="POST" action="{{ route('auth.selectRole') }}">
      @csrf
      <input type="hidden" name="role" value="acteur_juridique">
      <button type="submit"
        style="width:100%;background:var(--surface);border:2px solid var(--border);border-radius:var(--radius);padding:36px 24px;cursor:pointer;text-align:center;display:flex;flex-direction:column;align-items:center;gap:0;transition:border-color .2s,transform .2s,box-shadow .2s;position:relative;overflow:hidden;"
        onmouseover="this.style.borderColor='var(--blue)';this.style.transform='translateY(-4px)';this.style.boxShadow='0 16px 48px rgba(0,0,0,.2)'"
        onmouseout="this.style.borderColor='var(--border)';this.style.transform='none';this.style.boxShadow='none'">

        <div style="width:72px;height:72px;border-radius:50%;background:rgba(52,152,219,.08);border:2px solid var(--border);display:flex;align-items:center;justify-content:center;font-size:2rem;margin-bottom:20px;">
          ⚖️
        </div>
        <div style="font-family:'Playfair Display',serif;font-size:1.1rem;font-weight:700;color:var(--ink);margin-bottom:10px;">Acteur Juridique</div>
        <div style="font-size:.82rem;color:var(--txt-muted);line-height:1.7;margin-bottom:20px;">
          Partagez votre expertise en publiant des articles et en répondant aux questions.
        </div>
        <div style="display:flex;flex-direction:column;gap:6px;width:100%;text-align:left;margin-bottom:20px;">
          @foreach(['Publier des articles juridiques','Répondre aux questions clients','Profil professionnel public','Messagerie sécurisée'] as $f)
          <div style="display:flex;align-items:center;gap:8px;font-size:.75rem;color:var(--txt-muted);">
            <span style="color:var(--blue);flex-shrink:0;">✓</span> {{ $f }}
          </div>
          @endforeach
        </div>
        <div style="padding:10px 28px;background:var(--blue);border-radius:8px;font-size:.82rem;font-weight:600;color:white;">
          Choisir ce rôle
        </div>
      </button>
    </form>

  </div>

  {{-- AVERTISSEMENT --}}
  <div style="display:flex;align-items:center;gap:12px;padding:14px 18px;background:rgba(230,126,34,.08);border:1px solid rgba(230,126,34,.2);border-radius:10px;font-size:.82rem;color:var(--orange);">
    <i class="fas fa-exclamation-triangle" style="flex-shrink:0;"></i>
    <span><strong>Attention :</strong> Ce choix est définitif. Vous ne pourrez pas changer de rôle ultérieurement.</span>
  </div>

</div>
@endsection