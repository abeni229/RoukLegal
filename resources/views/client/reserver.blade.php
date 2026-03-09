@extends('layouts.app')

@section('title', 'Réserver un RDV — RoukLegal')

@section('page-title')
  Rendez-vous <span>/ Réserver</span>
@endsection

@section('topbar-actions')
  <a href="{{ route('client.acteurs') }}" class="rl-btn-outline">
    <i class="fas fa-arrow-left"></i> Annuaire
  </a>
@endsection

@section('content')
@php
  $jours = ['lundi','mardi','mercredi','jeudi','vendredi','samedi','dimanche'];
  $joursFr = ['lundi'=>'Lun','mardi'=>'Mar','mercredi'=>'Mer','jeudi'=>'Jeu','vendredi'=>'Ven','samedi'=>'Sam','dimanche'=>'Dim'];

  // Générer les 4 prochaines semaines de dates pour chaque jour
  $joursNum = ['lundi'=>1,'mardi'=>2,'mercredi'=>3,'jeudi'=>4,'vendredi'=>5,'samedi'=>6,'dimanche'=>7];
  $datesDisponibles = [];
  foreach($creneaux as $jour => $cs) {
    $cible = $joursNum[$jour];
    $today  = now()->isoWeekday();
    $diff   = $cible >= $today ? $cible - $today : 7 - $today + $cible;
    if($diff === 0) $diff = 7;
    for($w = 0; $w < 4; $w++) {
      $date = now()->addDays($diff + $w * 7)->format('Y-m-d');
      foreach($cs->where('actif', true) as $c) {
        $datesDisponibles[] = [
          'creneau_id'  => $c->id,
          'date'        => $date,
          'date_heure'  => $date . ' ' . $c->heure_debut,
          'label'       => ucfirst($jour) . ' ' . now()->addDays($diff + $w * 7)->format('d/m') . ' · ' . substr($c->heure_debut,0,5) . '–' . substr($c->heure_fin,0,5),
          'jour'        => $jour,
        ];
      }
    }
  }
  usort($datesDisponibles, fn($a,$b) => $a['date_heure'] <=> $b['date_heure']);
@endphp

<div style="display:grid;grid-template-columns:1fr 320px;gap:28px;align-items:start;">

  {{-- FORMULAIRE PRINCIPAL --}}
  <div style="display:flex;flex-direction:column;gap:24px;">

    {{-- Profil acteur --}}
    <div class="rl-card fade-up" style="background:linear-gradient(135deg,#111820,#1a2535);border-color:rgba(201,168,76,.2);">
      <div style="display:flex;align-items:center;gap:16px;">
        <div style="width:56px;height:56px;border-radius:50%;background:var(--gold-dim);border:2px solid var(--gold);display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0;">
          @if($acteur->photo_professionnelle)
            <img src="{{ asset('storage/'.$acteur->photo_professionnelle) }}" style="width:100%;height:100%;object-fit:cover;"/>
          @else
            <span style="font-family:'Playfair Display',serif;font-size:1rem;font-weight:700;color:var(--gold);">{{ strtoupper(substr($acteur->nom,0,2)) }}</span>
          @endif
        </div>
        <div>
          <div style="font-family:'Playfair Display',serif;font-size:1rem;font-weight:600;color:var(--ink);">{{ $acteur->nom }}</div>
          <span class="rl-badge rl-badge-gold" style="margin-top:4px;display:inline-block;">{{ $acteur->profession?->nom ?? 'Expert juridique' }}</span>
        </div>
        <div style="margin-left:auto;text-align:right;">
          <div style="font-family:'Playfair Display',serif;font-size:1.4rem;font-weight:700;color:var(--gold);">10 000</div>
          <div style="font-size:.7rem;color:rgba(255,255,255,.4);">FCFA / séance</div>
        </div>
      </div>
    </div>

    <form method="POST" action="{{ route('client.reserver.payer', $acteur->id) }}" id="reservationForm">
      @csrf

      {{-- ÉTAPE 1 : Choisir un créneau --}}
      <div class="rl-card fade-up" style="animation-delay:.1s;">
        <div class="rl-card-header">
          <span class="rl-card-title">① Choisir un créneau</span>
          <span class="rl-badge rl-badge-gold">{{ count($datesDisponibles) }} disponible(s)</span>
        </div>

        @if(count($datesDisponibles) > 0)

        {{-- Filtre par semaine --}}
        <div style="display:flex;gap:8px;margin-bottom:16px;flex-wrap:wrap;">
          @foreach(['Cette semaine','Semaine+1','Semaine+2','Semaine+3'] as $wi => $wl)
          <button type="button" onclick="filterWeek({{ $wi }})"
            id="week-btn-{{ $wi }}"
            style="padding:6px 14px;border-radius:8px;border:1px solid {{ $wi===0 ? 'var(--gold)' : 'var(--border)' }};background:{{ $wi===0 ? 'var(--gold-dim)' : 'transparent' }};color:{{ $wi===0 ? 'var(--gold)' : 'var(--txt-muted)' }};font-size:.75rem;cursor:pointer;transition:all .15s;">
            {{ $wl }}
          </button>
          @endforeach
        </div>

        <input type="hidden" name="creneau_id" id="creneau_id" required>
        <input type="hidden" name="date_heure" id="date_heure" required>

        <div id="creneauxGrid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:10px;">
          @foreach($datesDisponibles as $idx => $d)
          @php
            $weekOffset = (int) floor((strtotime($d['date']) - strtotime(now()->startOfWeek()->format('Y-m-d'))) / (7 * 86400));
          @endphp
          <button type="button"
            class="creneau-btn week-{{ $weekOffset }}"
            data-creneau="{{ $d['creneau_id'] }}"
            data-datetime="{{ $d['date_heure'] }}"
            data-week="{{ $weekOffset }}"
            onclick="selectCreneau(this, '{{ $d['creneau_id'] }}', '{{ $d['date_heure'] }}')"
            style="padding:12px 14px;background:var(--surface2);border:2px solid var(--border);border-radius:10px;text-align:center;cursor:pointer;transition:all .15s;font-family:'DM Sans',sans-serif;display:{{ $weekOffset === 0 ? 'block' : 'none' }};">
            <div style="font-size:.72rem;color:var(--txt-muted);margin-bottom:4px;">{{ ucfirst($d['jour']) }} {{ \Carbon\Carbon::parse($d['date'])->format('d/m') }}</div>
            <div style="font-size:.88rem;font-weight:600;color:var(--ink);">
              {{ substr($d['date_heure'], -8, 5) }}
            </div>
          </button>
          @endforeach
        </div>

        <div id="selectedLabel" style="margin-top:12px;padding:10px 14px;background:var(--green-dim);border-radius:8px;border:1px solid rgba(39,174,96,.25);font-size:.82rem;color:var(--green);display:none;">
          <i class="fas fa-check-circle" style="margin-right:6px;"></i><span id="selectedText"></span>
        </div>

        @else
        <div style="text-align:center;padding:24px;color:var(--txt-muted);font-size:.85rem;">
          <div style="font-size:2rem;margin-bottom:8px;">📭</div>
          Cet acteur n'a pas encore défini de créneaux disponibles.
        </div>
        @endif
      </div>

      {{-- ÉTAPE 2 : Sujet --}}
      <div class="rl-card fade-up" style="animation-delay:.15s;">
        <div class="rl-card-header"><span class="rl-card-title">② Sujet de la consultation</span></div>
        <div class="rl-form-group">
          <label class="rl-label" for="sujet">Décrivez brièvement votre demande <span style="color:var(--red)">*</span></label>
          <input type="text" id="sujet" name="sujet" class="rl-input" required
            placeholder="Ex : Question sur mon contrat de travail…" value="{{ old('sujet') }}">
          @error('sujet')<div style="font-size:.75rem;color:var(--red);margin-top:4px;">{{ $message }}</div>@enderror
        </div>
      </div>

      {{-- ÉTAPE 3 : Paiement --}}
      <div class="rl-card fade-up" style="animation-delay:.2s;">
        <div class="rl-card-header">
          <span class="rl-card-title">③ Méthode de paiement</span>
          <span style="font-size:.7rem;padding:3px 10px;background:rgba(52,152,219,.1);border-radius:100px;color:var(--blue);border:1px solid rgba(52,152,219,.2);">🔒 Sandbox PayGate</span>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:20px;">
          @foreach([['mobile_money','📱','Mobile Money','MTN / Moov'],['carte','💳','Carte bancaire','Visa / Mastercard']] as $m)
          <label style="display:flex;align-items:center;gap:12px;padding:16px;background:var(--surface2);border:2px solid var(--border);border-radius:10px;cursor:pointer;transition:border-color .15s;" id="method-{{ $m[0] }}">
            <input type="radio" name="methode" value="{{ $m[0] }}" {{ $loop->first ? 'checked' : '' }} style="accent-color:var(--gold);" onchange="selectMethod('{{ $m[0] }}')">
            <div>
              <div style="font-size:1.2rem;margin-bottom:3px;">{{ $m[1] }}</div>
              <div style="font-size:.82rem;font-weight:600;color:var(--ink);">{{ $m[2] }}</div>
              <div style="font-size:.7rem;color:var(--txt-muted);">{{ $m[3] }}</div>
            </div>
          </label>
          @endforeach
        </div>

        {{-- Récapitulatif --}}
        <div style="padding:16px;background:var(--surface2);border-radius:10px;border:1px solid var(--border);margin-bottom:20px;">
          <div style="font-size:.75rem;font-weight:700;color:var(--txt-muted);text-transform:uppercase;letter-spacing:.06em;margin-bottom:12px;">Récapitulatif</div>
          <div style="display:flex;flex-direction:column;gap:8px;">
            @foreach([
              ['Consultation avec '.$acteur->nom,'10 000 FCFA'],
              ['Commission plateforme (20%)','2 000 FCFA'],
              ['Total','10 000 FCFA'],
            ] as $li)
            <div style="display:flex;justify-content:space-between;font-size:.82rem;{{ $loop->last ? 'font-weight:700;color:var(--ink);padding-top:8px;border-top:1px solid var(--border);' : 'color:var(--txt-muted);' }}">
              <span>{{ $li[0] }}</span><span>{{ $li[1] }}</span>
            </div>
            @endforeach
          </div>
        </div>

        <button type="submit" class="rl-btn" style="width:100%;justify-content:center;font-size:.92rem;padding:14px;" id="submitBtn" disabled>
          <i class="fas fa-lock"></i> Payer 10 000 FCFA et réserver
        </button>
        <div style="text-align:center;font-size:.7rem;color:var(--txt-muted);margin-top:10px;">
          <i class="fas fa-shield-alt" style="color:var(--green);margin-right:4px;"></i>Paiement sécurisé via PayGate · Remboursement garanti si refus
        </div>
      </div>

    </form>

  </div>

  {{-- COLONNE DROITE --}}
  <div style="display:flex;flex-direction:column;gap:20px;position:sticky;top:calc(var(--topbar-h) + 24px);">

    {{-- Comment ça marche --}}
    <div class="rl-card fade-up" style="animation-delay:.05s;">
      <div class="rl-card-header"><span class="rl-card-title">Comment ça marche</span></div>
      <div style="display:flex;flex-direction:column;gap:16px;">
        @foreach([
          ['1','Choisissez un créneau','Sélectionnez une date et heure disponibles'],
          ['2','Décrivez votre sujet','Expliquez brièvement votre besoin'],
          ['3','Payez en ligne','Paiement sécurisé via PayGate'],
          ['4','L\'admin valide','Votre paiement est vérifié (24h max)'],
          ['5','L\'acteur confirme','Votre RDV est confirmé'],
        ] as $s)
        <div style="display:flex;gap:12px;align-items:flex-start;">
          <div style="width:24px;height:24px;border-radius:50%;background:var(--gold);display:flex;align-items:center;justify-content:center;font-size:.7rem;font-weight:700;color:var(--bg);flex-shrink:0;">{{ $s[0] }}</div>
          <div>
            <div style="font-size:.82rem;font-weight:600;color:var(--ink);">{{ $s[1] }}</div>
            <div style="font-size:.72rem;color:var(--txt-muted);margin-top:2px;">{{ $s[2] }}</div>
          </div>
        </div>
        @endforeach
      </div>
    </div>

    {{-- Garanties --}}
    <div class="rl-card fade-up" style="animation-delay:.1s;background:linear-gradient(135deg,#111820,#1a2535);border-color:rgba(201,168,76,.2);">
      <div style="font-family:'Playfair Display',serif;font-size:.95rem;color:var(--gold);margin-bottom:12px;">🛡️ Garanties</div>
      <div style="display:flex;flex-direction:column;gap:10px;font-size:.78rem;color:rgba(255,255,255,.65);">
        <div>✓ Remboursement automatique si refus</div>
        <div>✓ Paiement sécurisé PayGate</div>
        <div>✓ Consultation confidentielle</div>
        <div>✓ Support en cas de problème</div>
      </div>
    </div>

  </div>

</div>
@endsection

@section('scripts')
<script>
let selectedWeek = 0;

function filterWeek(w) {
  selectedWeek = w;
  // Mise à jour boutons
  for(let i=0;i<4;i++) {
    const btn = document.getElementById('week-btn-'+i);
    btn.style.borderColor = i===w ? 'var(--gold)' : 'var(--border)';
    btn.style.background  = i===w ? 'var(--gold-dim)' : 'transparent';
    btn.style.color       = i===w ? 'var(--gold)' : 'var(--txt-muted)';
  }
  // Afficher/masquer créneaux
  document.querySelectorAll('.creneau-btn').forEach(b => {
    b.style.display = parseInt(b.dataset.week) === w ? 'block' : 'none';
  });
  // Désélectionner
  document.getElementById('creneau_id').value = '';
  document.getElementById('date_heure').value = '';
  document.getElementById('selectedLabel').style.display = 'none';
  updateSubmit();
}

function selectCreneau(el, creneauId, dateHeure) {
  // Reset tous
  document.querySelectorAll('.creneau-btn').forEach(b => {
    b.style.borderColor = 'var(--border)';
    b.style.background  = 'var(--surface2)';
  });
  // Sélectionner
  el.style.borderColor = 'var(--gold)';
  el.style.background  = 'var(--gold-dim)';
  document.getElementById('creneau_id').value = creneauId;
  document.getElementById('date_heure').value = dateHeure;
  // Afficher label
  const dt = new Date(dateHeure.replace(' ','T'));
  const opts = { weekday:'long', day:'numeric', month:'long' };
  const h = dateHeure.slice(-8,- 3);
  document.getElementById('selectedText').textContent =
    dt.toLocaleDateString('fr-FR', opts) + ' à ' + h;
  document.getElementById('selectedLabel').style.display = 'block';
  updateSubmit();
}

function selectMethod(m) {
  document.querySelectorAll('[id^="method-"]').forEach(el => {
    el.style.borderColor = 'var(--border)';
  });
  document.getElementById('method-'+m).style.borderColor = 'var(--gold)';
}

function updateSubmit() {
  const ok = document.getElementById('creneau_id').value &&
             document.getElementById('date_heure').value;
  const btn = document.getElementById('submitBtn');
  btn.disabled = !ok;
  btn.style.opacity = ok ? '1' : '.5';
  btn.style.cursor  = ok ? 'pointer' : 'not-allowed';
}

// Init
selectMethod('mobile_money');
document.getElementById('submitBtn').style.opacity = '.5';
document.getElementById('submitBtn').style.cursor  = 'not-allowed';
</script>
@endsection