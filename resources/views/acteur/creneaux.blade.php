@extends('layouts.app')

@section('title', 'Mes Créneaux — RoukLegal')

@section('page-title')
  Disponibilités <span>/ Mes créneaux</span>
@endsection

@section('topbar-actions')
  <a href="{{ route('acteur.dashboard') }}" class="rl-btn-outline">
    <i class="fas fa-arrow-left"></i> Dashboard
  </a>
@endsection

@section('content')
@php
  $jours = ['lundi','mardi','mercredi','jeudi','vendredi','samedi','dimanche'];
  $emojis = ['lundi'=>'Mon','mardi'=>'Tue','mercredi'=>'Wed','jeudi'=>'Thu','vendredi'=>'Fri','samedi'=>'Sat','dimanche'=>'Sun'];
@endphp

<div style="display:grid;grid-template-columns:1fr 320px;gap:28px;align-items:start;">

  {{-- CALENDRIER HEBDOMADAIRE --}}
  <div style="display:flex;flex-direction:column;gap:20px;">

    {{-- En-tête --}}
    <div class="rl-card fade-up" style="padding:20px 24px;">
      <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
        <div>
          <div style="font-family:'Playfair Display',serif;font-size:1.1rem;color:var(--ink);margin-bottom:4px;">Calendrier hebdomadaire</div>
          <div style="font-size:.78rem;color:var(--txt-muted);">Définissez vos créneaux disponibles chaque semaine. Les clients pourront réserver sur ces horaires.</div>
        </div>
        <div style="display:flex;align-items:center;gap:10px;font-size:.75rem;color:var(--txt-muted);">
          <span style="display:flex;align-items:center;gap:5px;"><span style="width:10px;height:10px;border-radius:50%;background:var(--green);display:inline-block;"></span>Actif</span>
          <span style="display:flex;align-items:center;gap:5px;"><span style="width:10px;height:10px;border-radius:50%;background:var(--border);display:inline-block;"></span>Désactivé</span>
        </div>
      </div>
    </div>

    {{-- Grille des jours --}}
    @foreach($jours as $jour)
    @php $creneauxJour = $creneaux[$jour] ?? collect(); @endphp
    <div class="rl-card fade-up" style="animation-delay:{{ array_search($jour,$jours) * 0.05 }}s;">
      <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;padding-bottom:14px;border-bottom:1px solid var(--border);">
        <div style="display:flex;align-items:center;gap:12px;">
          <div style="width:44px;height:44px;border-radius:10px;background:var(--gold-dim);border:1px solid var(--border);display:flex;flex-direction:column;align-items:center;justify-content:center;">
            <span style="font-size:.55rem;font-weight:700;color:var(--gold);text-transform:uppercase;letter-spacing:.05em;">{{ $emojis[$jour] }}</span>
          </div>
          <div>
            <div style="font-family:'Playfair Display',serif;font-size:.95rem;font-weight:600;color:var(--ink);text-transform:capitalize;">{{ $jour }}</div>
            <div style="font-size:.72rem;color:var(--txt-muted);">{{ $creneauxJour->where('actif',true)->count() }} créneau(x) actif(s)</div>
          </div>
        </div>
        <button onclick="toggleForm('form-{{ $jour }}')"
          style="display:flex;align-items:center;gap:6px;padding:7px 14px;background:var(--gold-dim);border:1px solid var(--border);border-radius:8px;color:var(--gold);font-size:.75rem;font-weight:600;cursor:pointer;transition:background .15s;"
          onmouseover="this.style.background='rgba(201,168,76,.18)'" onmouseout="this.style.background='var(--gold-dim)'">
          <i class="fas fa-plus"></i> Ajouter
        </button>
      </div>

      {{-- Créneaux existants --}}
      @if($creneauxJour->count() > 0)
      <div style="display:flex;flex-direction:column;gap:8px;margin-bottom:14px;">
        @foreach($creneauxJour as $c)
        <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 14px;background:var(--surface2);border-radius:8px;border:1px solid {{ $c->actif ? 'rgba(39,174,96,.2)' : 'var(--border)' }};">
          <div style="display:flex;align-items:center;gap:10px;">
            <div style="width:8px;height:8px;border-radius:50%;background:{{ $c->actif ? 'var(--green)' : 'var(--border)' }};flex-shrink:0;"></div>
            <span style="font-size:.88rem;font-weight:500;color:var(--ink);">
              {{ substr($c->heure_debut,0,5) }} — {{ substr($c->heure_fin,0,5) }}
            </span>
          </div>
          <div style="display:flex;align-items:center;gap:6px;">
            <form method="POST" action="{{ route('acteur.creneaux.toggle', $c->id) }}">
              @csrf @method('PATCH')
              <button type="submit"
                style="padding:5px 10px;border-radius:6px;border:1px solid var(--border);background:transparent;font-size:.72rem;color:{{ $c->actif ? 'var(--orange)' : 'var(--green)' }};cursor:pointer;">
                {{ $c->actif ? 'Désactiver' : 'Activer' }}
              </button>
            </form>
            <form method="POST" action="{{ route('acteur.creneaux.destroy', $c->id) }}" onsubmit="return confirm('Supprimer ce créneau ?')">
              @csrf @method('DELETE')
              <button type="submit"
                style="padding:5px 10px;border-radius:6px;border:1px solid rgba(231,76,60,.3);background:var(--red-dim);font-size:.72rem;color:var(--red);cursor:pointer;">
                <i class="fas fa-trash"></i>
              </button>
            </form>
          </div>
        </div>
        @endforeach
      </div>
      @else
      <div style="font-size:.8rem;color:var(--txt-muted);padding:8px 0;margin-bottom:10px;">Aucun créneau pour ce jour.</div>
      @endif

      {{-- Formulaire ajout (caché par défaut) --}}
      <div id="form-{{ $jour }}" style="display:none;padding:16px;background:var(--surface2);border-radius:10px;border:1px solid var(--border);">
        <form method="POST" action="{{ route('acteur.creneaux.store') }}">
          @csrf
          <input type="hidden" name="jour_semaine" value="{{ $jour }}">
          <div style="display:grid;grid-template-columns:1fr 1fr auto;gap:10px;align-items:end;">
            <div>
              <label style="font-size:.7rem;font-weight:600;color:var(--txt-muted);text-transform:uppercase;letter-spacing:.06em;display:block;margin-bottom:5px;">Début</label>
              <input type="time" name="heure_debut" class="rl-input" style="padding:8px 12px;" required>
            </div>
            <div>
              <label style="font-size:.7rem;font-weight:600;color:var(--txt-muted);text-transform:uppercase;letter-spacing:.06em;display:block;margin-bottom:5px;">Fin</label>
              <input type="time" name="heure_fin" class="rl-input" style="padding:8px 12px;" required>
            </div>
            <button type="submit" class="rl-btn" style="padding:8px 16px;font-size:.8rem;white-space:nowrap;">
              <i class="fas fa-check"></i> Sauver
            </button>
          </div>
        </form>
      </div>

    </div>
    @endforeach

  </div>

  {{-- COLONNE DROITE --}}
  <div style="display:flex;flex-direction:column;gap:20px;position:sticky;top:calc(var(--topbar-h) + 24px);">

    {{-- Résumé --}}
    <div class="rl-card fade-up" style="animation-delay:.1s;">
      <div class="rl-card-header"><span class="rl-card-title">Résumé</span></div>
      @php
        $totalActifs = 0;
        foreach($creneaux as $c) { $totalActifs += $c->where('actif',true)->count(); }
        $joursActifs = $creneaux->filter(fn($c) => $c->where('actif',true)->count() > 0)->count();
      @endphp
      <div style="display:flex;flex-direction:column;gap:12px;">
        @foreach([
          ['📅','Jours disponibles',$joursActifs.' / 7'],
          ['⏰','Créneaux actifs',$totalActifs],
          ['💰','Tarif par RDV','10 000 FCFA'],
          ['📊','Commission plateforme','20%'],
          ['💵','Votre part','8 000 FCFA / RDV'],
        ] as $s)
        <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 0;border-bottom:1px solid var(--border);">
          <div style="font-size:.8rem;color:var(--txt-muted);">{{ $s[0] }} {{ $s[1] }}</div>
          <div style="font-size:.85rem;font-weight:600;color:var(--ink);">{{ $s[2] }}</div>
        </div>
        @endforeach
      </div>
    </div>

    {{-- Conseils --}}
    <div class="rl-card fade-up" style="animation-delay:.15s;background:linear-gradient(135deg,#111820,#1a2535);border-color:rgba(201,168,76,.2);">
      <div style="font-family:'Playfair Display',serif;font-size:.95rem;color:var(--gold);margin-bottom:14px;">💡 Conseils</div>
      <div style="display:flex;flex-direction:column;gap:10px;font-size:.78rem;color:rgba(255,255,255,.6);">
        <div>Définissez au moins <strong style="color:var(--gold);">3 jours</strong> de disponibilité pour maximiser vos réservations.</div>
        <div>Les créneaux doivent durer au minimum <strong style="color:var(--gold);">30 minutes</strong>.</div>
        <div>Vous pouvez <strong style="color:var(--gold);">désactiver temporairement</strong> un créneau sans le supprimer.</div>
      </div>
    </div>

    {{-- Lien RDV --}}
    <a href="{{ route('acteur.rendezVous') }}" style="display:flex;align-items:center;gap:12px;padding:16px;background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);text-decoration:none;transition:border-color .15s;" onmouseover="this.style.borderColor='var(--gold)'" onmouseout="this.style.borderColor='var(--border)'">
      <i class="fas fa-calendar-check" style="color:var(--gold);font-size:1.2rem;width:20px;"></i>
      <div>
        <div style="font-size:.85rem;font-weight:600;color:var(--ink);">Mes rendez-vous</div>
        <div style="font-size:.72rem;color:var(--txt-muted);">Voir les réservations reçues</div>
      </div>
      <i class="fas fa-chevron-right" style="color:var(--gold);font-size:.75rem;margin-left:auto;"></i>
    </a>

  </div>

</div>
@endsection

@section('scripts')
<script>
function toggleForm(id) {
  const el = document.getElementById(id);
  el.style.display = el.style.display === 'none' ? 'block' : 'none';
}
</script>
@endsection