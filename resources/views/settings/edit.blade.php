@extends('layouts.app')

@section('title', 'Paramètres — RoukLegal')

@section('page-title')
  Paramètres <span>/ Compte</span>
@endsection

@section('topbar-actions')
  <a href="{{ auth()->user()->role === 'acteur_juridique' ? route('acteur.dashboard') : route('client.dashboard') }}" class="rl-btn-outline">
    <i class="fas fa-arrow-left"></i> Tableau de bord
  </a>
@endsection

@section('content')
<div style="display:grid;grid-template-columns:1fr 280px;gap:28px;align-items:start;max-width:900px;">

  {{-- FORMULAIRE --}}
  <div class="rl-card fade-up">
    <div class="rl-card-header">
      <span class="rl-card-title">Informations du compte</span>
    </div>

    <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
      @csrf

      {{-- Nom --}}
      <div class="rl-form-group">
        <label class="rl-label" for="nom">
          <i class="fas fa-user" style="color:var(--gold);margin-right:6px;"></i>Nom complet
        </label>
        <input type="text" id="nom" name="nom" class="rl-input" value="{{ old('nom', $user->nom) }}">
        @error('nom')<div style="font-size:.75rem;color:var(--red);margin-top:4px;">{{ $message }}</div>@enderror
      </div>

      {{-- Email --}}
      <div class="rl-form-group">
        <label class="rl-label" for="email">
          <i class="fas fa-envelope" style="color:var(--gold);margin-right:6px;"></i>Adresse e-mail
        </label>
        <input type="email" id="email" name="email" class="rl-input" value="{{ old('email', $user->email) }}">
        @error('email')<div style="font-size:.75rem;color:var(--red);margin-top:4px;">{{ $message }}</div>@enderror
      </div>

      {{-- Photo de profil --}}
      <div class="rl-form-group">
        <label class="rl-label">
          <i class="fas fa-camera" style="color:var(--gold);margin-right:6px;"></i>Photo de profil
        </label>

        @if($user->profile_photo)
        <div style="display:flex;align-items:center;gap:16px;margin-bottom:12px;padding:14px 16px;background:var(--surface2);border-radius:10px;border:1px solid var(--border);">
          <img src="{{ asset('storage/'.$user->profile_photo) }}" alt="Photo de profil"
               style="width:60px;height:60px;border-radius:50%;object-fit:cover;border:2px solid var(--gold);">
          <div>
            <div style="font-size:.82rem;color:var(--txt);margin-bottom:6px;">Photo actuelle</div>
            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:.8rem;color:var(--red);">
              <input type="checkbox" name="remove_photo" value="1" style="accent-color:var(--red);">
              Supprimer cette photo
            </label>
          </div>
        </div>
        @endif

        <div id="dropzone"
             style="border:2px dashed var(--border);border-radius:10px;padding:24px;text-align:center;cursor:pointer;transition:border-color .2s;"
             onclick="document.getElementById('profile_photo').click()"
             ondragover="event.preventDefault();this.style.borderColor='var(--gold)'"
             ondragleave="this.style.borderColor='var(--border)'"
             ondrop="handleDrop(event)">
          <div id="dropContent">
            <div style="font-size:1.8rem;margin-bottom:8px;">📷</div>
            <div style="font-size:.85rem;color:var(--txt-muted);">Cliquez ou glissez une image ici</div>
            <div style="font-size:.72rem;color:var(--txt-muted);margin-top:4px;">JPG, PNG · max 2 Mo</div>
          </div>
          <div id="previewWrap" style="display:none;">
            <img id="previewImg" style="max-height:100px;border-radius:8px;border:2px solid var(--gold);">
            <div id="previewName" style="font-size:.75rem;color:var(--txt-muted);margin-top:6px;"></div>
          </div>
        </div>
        <input type="file" id="profile_photo" name="profile_photo" accept="image/*" style="display:none;" onchange="previewPhoto(this)">
        @error('profile_photo')<div style="font-size:.75rem;color:var(--red);margin-top:4px;">{{ $message }}</div>@enderror
      </div>

      {{-- Thème --}}
      <div class="rl-form-group">
        <label class="rl-label">
          <i class="fas fa-adjust" style="color:var(--gold);margin-right:6px;"></i>Thème de l'interface
        </label>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
          @foreach(['light'=>['☀️','Clair','Interface lumineuse'],'dark'=>['🌙','Sombre','Interface sombre']] as $val=>$info)
          <label style="display:flex;align-items:center;gap:12px;padding:14px 16px;border-radius:10px;border:2px solid {{ $user->theme===$val ? 'var(--gold)' : 'var(--border)' }};cursor:pointer;transition:border-color .15s;background:{{ $user->theme===$val ? 'var(--gold-dim)' : 'var(--surface2)' }};">
            <input type="radio" name="theme" value="{{ $val }}" {{ $user->theme===$val ? 'checked' : '' }} style="accent-color:var(--gold);">
            <div>
              <div style="font-size:1rem;margin-bottom:2px;">{{ $info[0] }}</div>
              <div style="font-size:.82rem;font-weight:600;color:var(--ink);">{{ $info[1] }}</div>
              <div style="font-size:.72rem;color:var(--txt-muted);">{{ $info[2] }}</div>
            </div>
          </label>
          @endforeach
        </div>
        @error('theme')<div style="font-size:.75rem;color:var(--red);margin-top:4px;">{{ $message }}</div>@enderror
      </div>

      <div style="display:flex;gap:12px;">
        <button type="submit" class="rl-btn"><i class="fas fa-save"></i> Enregistrer</button>
        <a href="{{ auth()->user()->role === 'acteur_juridique' ? route('acteur.dashboard') : route('client.dashboard') }}" class="rl-btn-outline">Annuler</a>
      </div>

    </form>
  </div>

  {{-- COLONNE DROITE --}}
  <div style="display:flex;flex-direction:column;gap:20px;position:sticky;top:calc(var(--topbar-h) + 24px);">

    {{-- Aperçu profil --}}
    <div class="rl-card fade-up" style="animation-delay:.1s;text-align:center;">
      <div class="rl-card-header"><span class="rl-card-title">Aperçu</span></div>
      <div style="width:72px;height:72px;border-radius:50%;background:var(--gold-dim);border:2px solid var(--gold);display:flex;align-items:center;justify-content:center;overflow:hidden;margin:0 auto 12px;" id="profilePreviewCircle">
        @if($user->profile_photo)
          <img src="{{ asset('storage/'.$user->profile_photo) }}" id="profilePreviewImg" style="width:100%;height:100%;object-fit:cover;"/>
        @else
          <span id="profileInitials" style="font-family:'Playfair Display',serif;font-size:1.4rem;font-weight:700;color:var(--gold);">{{ strtoupper(substr($user->nom,0,2)) }}</span>
        @endif
      </div>
      <div style="font-family:'Playfair Display',serif;font-size:.95rem;font-weight:600;color:var(--ink);" id="previewNom">{{ $user->nom }}</div>
      <div style="font-size:.78rem;color:var(--txt-muted);margin-top:4px;">{{ $user->email }}</div>
      <div style="margin-top:8px;"><span class="rl-badge rl-badge-gold">{{ ucfirst($user->role) }}</span></div>
    </div>

    {{-- Zone danger --}}
    <div class="rl-card fade-up" style="animation-delay:.15s;border-color:rgba(231,76,60,.2);">
      <div class="rl-card-header">
        <span class="rl-card-title" style="color:var(--red);">Zone de danger</span>
      </div>
      <div style="font-size:.82rem;color:var(--txt-muted);margin-bottom:14px;">
        La suppression du compte est irréversible. Toutes vos données seront effacées.
      </div>
      <button onclick="confirmDelete()" style="display:flex;align-items:center;gap:8px;width:100%;padding:10px 14px;background:var(--red-dim);border:1px solid rgba(231,76,60,.3);border-radius:8px;color:var(--red);font-size:.83rem;cursor:pointer;justify-content:center;transition:background .15s;" onmouseover="this.style.background='var(--red)';this.style.color='white'" onmouseout="this.style.background='var(--red-dim)';this.style.color='var(--red)'">
        <i class="fas fa-trash"></i> Supprimer mon compte
      </button>
      <form id="deleteForm" method="POST" action="{{ route('settings.destroy') }}" style="display:none;">
        @csrf @method('DELETE')
      </form>
    </div>

  </div>

</div>
@endsection

@section('scripts')
<script>
// Prévisualisation photo
function previewPhoto(input) {
  if(!input.files?.[0]) return;
  const file = input.files[0];
  const reader = new FileReader();
  reader.onload = e => {
    document.getElementById('dropContent').style.display = 'none';
    const wrap = document.getElementById('previewWrap');
    wrap.style.display = 'block';
    document.getElementById('previewImg').src = e.target.result;
    document.getElementById('previewName').textContent = file.name;
    // Mise à jour aperçu sidebar
    const circle = document.getElementById('profilePreviewCircle');
    const initials = document.getElementById('profileInitials');
    let img = document.getElementById('profilePreviewImg');
    if(!img) {
      img = document.createElement('img');
      img.id = 'profilePreviewImg';
      img.style = 'width:100%;height:100%;object-fit:cover;';
      if(initials) initials.replaceWith(img);
      else circle.appendChild(img);
    }
    img.src = e.target.result;
  };
  reader.readAsDataURL(file);
}

function handleDrop(e) {
  e.preventDefault();
  document.getElementById('dropzone').style.borderColor = 'var(--border)';
  const file = e.dataTransfer.files[0];
  if(file?.type.startsWith('image/')) {
    const dt = new DataTransfer();
    dt.items.add(file);
    const input = document.getElementById('profile_photo');
    input.files = dt.files;
    previewPhoto(input);
  }
}

// Mise à jour nom en temps réel
document.getElementById('nom')?.addEventListener('input', function() {
  const el = document.getElementById('previewNom');
  if(el) el.textContent = this.value || '—';
  const init = document.getElementById('profileInitials');
  if(init) init.textContent = this.value.substring(0,2).toUpperCase();
});

// Suppression compte
function confirmDelete() {
  if(confirm('Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.')) {
    document.getElementById('deleteForm').submit();
  }
}
</script>
@endsection