@extends('layouts.app')

@section('title', 'Mon Profil Professionnel — RoukLegal')

@section('page-title')
  Mon Profil <span>/ Informations professionnelles</span>
@endsection

@section('topbar-actions')
  <a href="{{ route('acteur.dashboard') }}" class="rl-btn-outline">
    <i class="fas fa-arrow-left"></i> Retour au dashboard
  </a>
@endsection

@section('content')
<div style="display:grid;grid-template-columns:1fr 340px;gap:28px;align-items:start;">

  {{-- FORMULAIRE PRINCIPAL --}}
  <div style="display:flex;flex-direction:column;gap:24px;">

    {{-- Photo professionnelle --}}
    <div class="rl-card fade-up">
      <div class="rl-card-header">
        <span class="rl-card-title">Photo professionnelle</span>
        <span class="rl-badge rl-badge-gold">Visible par les clients</span>
      </div>
      <form method="POST" action="{{ route('acteur.profile.update') }}" enctype="multipart/form-data">
        @csrf
        <div style="display:flex;align-items:center;gap:24px;margin-bottom:20px;">
          <div style="width:90px;height:90px;border-radius:50%;background:var(--gold-dim);border:2px solid var(--gold);display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0;">
            @if($user->photo_professionnelle)
              <img src="{{ asset('storage/'.$user->photo_professionnelle) }}" alt="Photo" style="width:100%;height:100%;object-fit:cover;"/>
            @else
              <span style="font-family:'Playfair Display',serif;font-size:1.8rem;font-weight:700;color:var(--gold);">
                {{ strtoupper(substr($user->nom, 0, 2)) }}
              </span>
            @endif
          </div>
          <div style="flex:1;">
            <label class="rl-label">Changer la photo</label>
            <input type="file" name="photo_professionnelle" class="rl-input" accept="image/*" style="padding:6px 10px;cursor:pointer;">
            <div style="font-size:.72rem;color:var(--txt-muted);margin-top:4px;">JPEG ou PNG, max 15 Mo</div>
            @if($user->photo_professionnelle)
            <div style="margin-top:10px;display:flex;align-items:center;gap:8px;">
              <input type="checkbox" name="remove_professional" value="1" id="remove_professional" style="accent-color:var(--red);">
              <label for="remove_professional" style="font-size:.8rem;color:var(--red);cursor:pointer;">Supprimer la photo actuelle</label>
            </div>
            @endif
          </div>
        </div>

        {{-- Profession --}}
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px;">
          <div class="rl-form-group" style="margin-bottom:0;">
            <label class="rl-label" for="profession_id">
              <i class="fas fa-briefcase" style="color:var(--gold);margin-right:6px;"></i>Spécialité juridique
            </label>
            <select id="profession_id" name="profession_id" class="rl-select">
              <option value="">-- Sélectionnez --</option>
              @foreach($professions as $prof)
                <option value="{{ $prof->id }}" {{ $user->profession_id == $prof->id ? 'selected' : '' }}>
                  {{ $prof->nom }}
                </option>
              @endforeach
            </select>
            @error('profession_id')<div style="font-size:.75rem;color:var(--red);margin-top:4px;">{{ $message }}</div>@enderror
          </div>
          <div class="rl-form-group" style="margin-bottom:0;">
            <label class="rl-label" for="profession_libre">
              <i class="fas fa-pencil-alt" style="color:var(--gold);margin-right:6px;"></i>Autre spécialité (libre)
            </label>
            <input type="text" id="profession_libre" name="profession_libre" class="rl-input"
              value="{{ old('profession_libre', $user->profession_libre) }}"
              placeholder="Si non listée ci-dessus…">
            @error('profession_libre')<div style="font-size:.75rem;color:var(--red);margin-top:4px;">{{ $message }}</div>@enderror
          </div>
        </div>

        {{-- Description --}}
        <div class="rl-form-group">
          <label class="rl-label" for="description">
            <i class="fas fa-align-left" style="color:var(--gold);margin-right:6px;"></i>Description professionnelle
          </label>
          <textarea id="description" name="description" class="rl-textarea" rows="7"
            placeholder="Présentez-vous, vos expériences et domaines d'expertise…">{{ old('description', $user->description) }}</textarea>
          <div style="font-size:.72rem;color:var(--txt-muted);margin-top:4px;">
            <i class="fas fa-info-circle"></i> Décrivez vos expériences, formations et domaines d'expertise. Max 5000 caractères.
          </div>
          @error('description')<div style="font-size:.75rem;color:var(--red);margin-top:4px;">{{ $message }}</div>@enderror
        </div>

        <div style="display:flex;gap:12px;">
          <button type="submit" class="rl-btn"><i class="fas fa-save"></i> Enregistrer les modifications</button>
          <a href="{{ route('acteur.dashboard') }}" class="rl-btn-outline"><i class="fas fa-times"></i> Annuler</a>
        </div>
      </form>
    </div>

  </div>

  {{-- COLONNE DROITE --}}
  <div style="display:flex;flex-direction:column;gap:20px;">

    {{-- Aperçu profil --}}
    <div class="rl-card fade-up" style="animation-delay:.1s">
      <div class="rl-card-header">
        <span class="rl-card-title">Aperçu profil</span>
      </div>
      <div style="text-align:center;padding:8px 0 16px;">
        <div style="width:72px;height:72px;border-radius:50%;background:var(--gold-dim);border:2px solid var(--gold);display:flex;align-items:center;justify-content:center;overflow:hidden;margin:0 auto 12px;">
          @if($user->photo_professionnelle)
            <img src="{{ asset('storage/'.$user->photo_professionnelle) }}" style="width:100%;height:100%;object-fit:cover;"/>
          @else
            <span style="font-family:'Playfair Display',serif;font-size:1.4rem;font-weight:700;color:var(--gold);">{{ strtoupper(substr($user->nom,0,2)) }}</span>
          @endif
        </div>
        <div style="font-family:'Playfair Display',serif;font-size:1rem;font-weight:600;color:var(--ink);">{{ $user->nom }}</div>
        <div style="margin-top:6px;">
          <span class="rl-badge rl-badge-gold">
            {{ $user->profession?->nom ?? $user->profession_libre ?? 'Spécialité non définie' }}
          </span>
        </div>
        @if($user->description)
        <div style="font-size:.78rem;color:var(--txt-muted);margin-top:10px;line-height:1.5;text-align:left;">
          {{ Str::limit($user->description, 120) }}
        </div>
        @endif
      </div>
    </div>

    {{-- Conseils --}}
    <div class="rl-card fade-up" style="animation-delay:.15s;background:linear-gradient(135deg,#111820,#1a2535);border-color:rgba(201,168,76,.2);">
      <div style="font-family:'Playfair Display',serif;font-size:1rem;color:var(--gold);margin-bottom:14px;">
        💡 Conseils pour votre profil
      </div>
      <div style="display:flex;flex-direction:column;gap:10px;">
        @foreach([
          'Précisez votre spécialité juridique',
          'Listez vos domaines d\'expertise',
          'Mentionnez vos formations',
          'Décrivez votre expérience',
          'Ajoutez une photo professionnelle',
        ] as $conseil)
        <div style="display:flex;align-items:center;gap:10px;font-size:.82rem;color:rgba(255,255,255,.7);">
          <span style="color:var(--gold);flex-shrink:0;">✓</span> {{ $conseil }}
        </div>
        @endforeach
      </div>
    </div>

    {{-- Liens rapides --}}
    <div class="rl-card fade-up" style="animation-delay:.2s;">
      <div class="rl-card-header"><span class="rl-card-title">Liens rapides</span></div>
      <div style="display:flex;flex-direction:column;gap:10px;">
        <a href="{{ route('articles.dashboard') }}" style="display:flex;align-items:center;gap:10px;padding:10px 14px;background:var(--surface2);border-radius:8px;border:1px solid var(--border);text-decoration:none;font-size:.85rem;color:var(--txt);transition:border-color .15s;" onmouseover="this.style.borderColor='var(--gold)'" onmouseout="this.style.borderColor='var(--border)'">
          <i class="fas fa-newspaper" style="color:var(--gold);width:16px;"></i> Mes articles
          <span style="margin-left:auto;color:var(--txt-muted);">›</span>
        </a>
        <a href="{{ route('acteur.questions') }}" style="display:flex;align-items:center;gap:10px;padding:10px 14px;background:var(--surface2);border-radius:8px;border:1px solid var(--border);text-decoration:none;font-size:.85rem;color:var(--txt);transition:border-color .15s;" onmouseover="this.style.borderColor='var(--gold)'" onmouseout="this.style.borderColor='var(--border)'">
          <i class="fas fa-question-circle" style="color:var(--gold);width:16px;"></i> Questions reçues
          <span style="margin-left:auto;color:var(--txt-muted);">›</span>
        </a>
        <a href="{{ route('settings.edit') }}" style="display:flex;align-items:center;gap:10px;padding:10px 14px;background:var(--surface2);border-radius:8px;border:1px solid var(--border);text-decoration:none;font-size:.85rem;color:var(--txt);transition:border-color .15s;" onmouseover="this.style.borderColor='var(--gold)'" onmouseout="this.style.borderColor='var(--border)'">
          <i class="fas fa-cog" style="color:var(--gold);width:16px;"></i> Paramètres du compte
          <span style="margin-left:auto;color:var(--txt-muted);">›</span>
        </a>
      </div>
    </div>

  </div>
</div>
@endsection