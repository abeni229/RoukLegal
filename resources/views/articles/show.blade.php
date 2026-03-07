@extends('layouts.app')

@section('title', $article->title . ' — RoukLegal')

@section('page-title')
  Articles <span>/ Lecture</span>
@endsection

@section('topbar-actions')
  <a href="{{ route('articles.index') }}" class="rl-btn-outline">
    <i class="fas fa-arrow-left"></i> Retour aux articles
  </a>
@endsection

@section('content')
<div style="display:grid;grid-template-columns:1fr 320px;gap:28px;align-items:start;">

  {{-- ARTICLE PRINCIPAL --}}
  <div style="display:flex;flex-direction:column;gap:24px;">

    {{-- Contenu --}}
    <div class="rl-card fade-up">
      <div style="margin-bottom:20px;padding-bottom:20px;border-bottom:1px solid var(--border);">
        <h1 style="font-family:'Playfair Display',serif;font-size:1.5rem;font-weight:700;color:var(--ink);line-height:1.4;margin-bottom:14px;">
          {{ $article->title }}
        </h1>
        <div style="display:flex;flex-wrap:wrap;gap:14px;font-size:.78rem;color:var(--txt-muted);">
          <span><i class="fas fa-user" style="margin-right:4px;color:var(--gold);"></i>{{ $article->user->nom }}</span>
          <span><i class="fas fa-briefcase" style="margin-right:4px;color:var(--gold);"></i>{{ $article->user->profession?->nom ?? 'Expert' }}</span>
          <span><i class="fas fa-calendar" style="margin-right:4px;color:var(--gold);"></i>{{ $article->created_at->format('d/m/Y') }}</span>
          <span><i class="fas fa-eye" style="margin-right:4px;color:var(--gold);"></i>{{ $article->views }} vue(s)</span>
        </div>
      </div>
      <div style="line-height:1.9;color:var(--txt);font-size:.95rem;word-wrap:break-word;">
        {!! nl2br(e($article->content)) !!}
      </div>
    </div>

    {{-- SECTION NOTATION (client uniquement) --}}
    @if(Auth::check() && Auth::user()->role === 'client')
    <div class="rl-card fade-up" style="animation-delay:.1s;">
      <div class="rl-card-header">
        <span class="rl-card-title">Évaluer cet article</span>
        <span class="rl-badge rl-badge-gold">Votre avis compte</span>
      </div>
      <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap;">
        <div id="starRating" style="display:flex;gap:6px;">
          @for($i=1;$i<=5;$i++)
          <span class="star" data-value="{{ $i }}" style="font-size:1.8rem;cursor:pointer;color:var(--border);transition:color .15s;">★</span>
          @endfor
        </div>
        <div id="ratingLabel" style="font-size:.85rem;color:var(--txt-muted);">Cliquez pour noter</div>
      </div>
      <form method="POST" action="#" id="ratingForm" style="margin-top:14px;display:none;">
        @csrf
        <input type="hidden" name="note" id="ratingValue">
        <div class="rl-form-group">
          <label class="rl-label" for="ratingComment">Commentaire (optionnel)</label>
          <textarea id="ratingComment" name="commentaire" class="rl-textarea" rows="3" placeholder="Partagez votre avis sur cet article…"></textarea>
        </div>
        <button type="submit" class="rl-btn"><i class="fas fa-star"></i> Soumettre l'évaluation</button>
      </form>
    </div>
    @endif

    {{-- QUESTIONS --}}
    <div class="rl-card fade-up" style="animation-delay:.15s;">
      <div class="rl-card-header">
        <span class="rl-card-title">Questions des clients</span>
        <span class="rl-badge rl-badge-blue">{{ $article->questions()->count() }} question(s)</span>
      </div>

      @if($article->questions()->count() > 0)
      <div style="display:flex;flex-direction:column;gap:16px;margin-bottom:24px;">
        @foreach($article->questions()->with(['user','reponses'])->get() as $q)
        <div style="padding:16px;background:var(--surface2);border-radius:10px;border-left:3px solid {{ $q->reponses->count()>0 ? 'var(--green)' : 'var(--orange)' }};" data-question-id="{{ $q->id }}">
          <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:12px;margin-bottom:8px;">
            <div>
              <span style="font-size:.82rem;font-weight:600;color:var(--ink);">{{ $q->user->nom }}</span>
              <span style="font-size:.72rem;color:var(--txt-muted);margin-left:8px;">{{ $q->created_at->diffForHumans() }}</span>
            </div>
            @if(Auth::user()->id === $article->user_id && Auth::user()->role === 'acteur_juridique')
              @if($q->reponses->count() > 0)
                <span class="rl-badge rl-badge-green">✓ Répondu</span>
              @else
                <button class="rl-btn" style="padding:4px 12px;font-size:.75rem;" onclick="openModal({{ $q->id }},'{{ addslashes($q->titre) }}','')">
                  <i class="fas fa-reply"></i> Répondre
                </button>
              @endif
            @endif
          </div>
          <div style="font-size:.88rem;color:var(--txt);margin-bottom:8px;">{{ $q->titre }}</div>
          @if($q->contenu)
          <div style="font-size:.82rem;color:var(--txt-muted);">{{ $q->contenu }}</div>
          @endif
          @if($q->reponses->count() > 0)
          <div style="margin-top:12px;padding:12px 14px;background:var(--green-dim);border-radius:8px;border-left:3px solid var(--green);">
            <div style="font-size:.72rem;font-weight:600;color:var(--green);margin-bottom:6px;"><i class="fas fa-check-circle"></i> Réponse de {{ $article->user->nom }}</div>
            <div style="font-size:.85rem;color:var(--txt);line-height:1.6;">{{ $q->reponses->first()->contenu }}</div>
          </div>
          @endif
        </div>
        @endforeach
      </div>
      @else
      <div style="text-align:center;padding:24px;color:var(--txt-muted);font-size:.88rem;margin-bottom:20px;">
        <div style="font-size:2rem;margin-bottom:8px;">💬</div>
        Aucune question pour le moment. Soyez le premier !
      </div>
      @endif

      {{-- Formulaire question client --}}
      @if(Auth::check() && Auth::user()->role === 'client')
        @if($canAskQuestion)
        <div style="padding-top:20px;border-top:1px solid var(--border);">
          <div style="font-family:'Playfair Display',serif;font-size:1rem;color:var(--ink);margin-bottom:16px;">Poser une question</div>
          <form method="POST" action="{{ route('articles.storeQuestion', $article->id) }}">
            @csrf
            <div class="rl-form-group">
              <label class="rl-label" for="titre">Votre question <span style="color:var(--red)">*</span></label>
              <input type="text" id="titre" name="titre" class="rl-input" placeholder="Posez votre question clairement…" required value="{{ old('titre') }}">
              @error('titre')<div style="font-size:.75rem;color:var(--red);margin-top:4px;">{{ $message }}</div>@enderror
            </div>
            <div class="rl-form-group">
              <label class="rl-label" for="contenu">Détails (optionnel)</label>
              <textarea id="contenu" name="contenu" class="rl-textarea" rows="3" placeholder="Donnez plus de contexte…">{{ old('contenu') }}</textarea>
            </div>
            <button type="submit" class="rl-btn"><i class="fas fa-paper-plane"></i> Envoyer la question</button>
          </form>
        </div>
        @else
        <div style="padding:20px;background:var(--orange-dim);border-radius:10px;border:1px solid rgba(230,126,34,.25);text-align:center;">
          <div style="font-size:1.5rem;margin-bottom:8px;">🔒</div>
          <div style="font-weight:600;color:var(--orange);margin-bottom:6px;">Accès limité</div>
          <div style="font-size:.83rem;color:var(--txt-muted);margin-bottom:14px;">Souscrivez pour poser des questions aux experts.</div>
          <button class="rl-btn" onclick="openSubscriptionModal()"><i class="fas fa-credit-card"></i> Accéder au service</button>
        </div>
        @endif
      @elseif(!Auth::check())
      <div class="rl-alert rl-alert-info">
        <i class="fas fa-info-circle"></i>
        <a href="{{ route('login') }}" style="color:var(--blue);font-weight:600;">Connectez-vous</a> pour poser une question.
      </div>
      @endif

    </div><!-- /questions card -->

  </div><!-- /colonne gauche -->

  {{-- COLONNE DROITE --}}
  <div style="display:flex;flex-direction:column;gap:20px;position:sticky;top:calc(var(--topbar-h) + 24px);">

    {{-- Profil auteur --}}
    <div class="rl-card fade-up" style="animation-delay:.05s;text-align:center;">
      <div style="width:72px;height:72px;border-radius:50%;background:var(--gold-dim);border:2px solid var(--gold);display:flex;align-items:center;justify-content:center;overflow:hidden;margin:0 auto 12px;">
        @if($article->user->photo_professionnelle)
          <img src="{{ asset('storage/'.$article->user->photo_professionnelle) }}" style="width:100%;height:100%;object-fit:cover;"/>
        @else
          <span style="font-family:'Playfair Display',serif;font-size:1.4rem;font-weight:700;color:var(--gold);">{{ strtoupper(substr($article->user->nom,0,2)) }}</span>
        @endif
      </div>
      <div style="font-family:'Playfair Display',serif;font-size:1rem;font-weight:600;color:var(--ink);">{{ $article->user->nom }}</div>
      <div style="margin:6px 0;"><span class="rl-badge rl-badge-gold">{{ $article->user->profession?->nom ?? 'Expert juridique' }}</span></div>
      @if($article->user->description)
      <div style="font-size:.78rem;color:var(--txt-muted);line-height:1.5;text-align:left;margin:10px 0;">
        {{ Str::limit($article->user->description, 150) }}
      </div>
      @endif
      @if(Auth::check() && Auth::user()->role === 'client')
      <a href="{{ route('messages.conversation', $article->user->id) }}" class="rl-btn" style="width:100%;justify-content:center;margin-top:8px;">
        <i class="fas fa-comments"></i> Contacter
      </a>
      @endif
    </div>

    {{-- Articles connexes --}}
    @php $related = $article->user->articles()->where('id','!=',$article->id)->limit(3)->get(); @endphp
    @if($related->count() > 0)
    <div class="rl-card fade-up" style="animation-delay:.1s;">
      <div class="rl-card-header"><span class="rl-card-title">Articles du même auteur</span></div>
      <div style="display:flex;flex-direction:column;gap:12px;">
        @foreach($related as $r)
        <a href="{{ route('articles.show', $r->id) }}" style="display:block;padding:10px 12px;background:var(--surface2);border-radius:8px;border:1px solid var(--border);text-decoration:none;transition:border-color .15s;" onmouseover="this.style.borderColor='var(--gold)'" onmouseout="this.style.borderColor='var(--border)'">
          <div style="font-size:.83rem;font-weight:500;color:var(--ink);margin-bottom:4px;">{{ Str::limit($r->title, 50) }}</div>
          <div style="font-size:.72rem;color:var(--txt-muted);"><i class="fas fa-eye" style="margin-right:4px;"></i>{{ $r->views }} vue(s)</div>
        </a>
        @endforeach
      </div>
    </div>
    @endif

  </div><!-- /colonne droite -->

</div>

{{-- MODAL RÉPONSE (acteur) --}}
<div id="responseModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:999;align-items:center;justify-content:center;">
  <div style="background:var(--surface);border-radius:var(--radius);padding:32px;width:100%;max-width:580px;margin:24px;animation:fadeUp .25s ease;">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
      <div style="font-family:'Playfair Display',serif;font-size:1.1rem;color:var(--ink);">Répondre à la question</div>
      <button onclick="closeModal()" style="background:none;border:none;font-size:1.2rem;cursor:pointer;color:var(--txt-muted);">✕</button>
    </div>
    <form method="POST" action="" id="responseForm">
      @csrf
      <div class="rl-form-group">
        <label class="rl-label">Question</label>
        <div id="modalQuestion" style="padding:10px 14px;background:var(--surface2);border-radius:8px;border:1px solid var(--border);font-size:.88rem;color:var(--txt);"></div>
      </div>
      <div class="rl-form-group">
        <label class="rl-label">Votre réponse <span style="color:var(--red)">*</span></label>
        <textarea class="rl-textarea" id="responseContent" name="contenu" rows="5" required placeholder="Répondez clairement…"></textarea>
      </div>
      <div id="modalError" class="rl-alert rl-alert-error" style="display:none;margin-bottom:12px;"></div>
      <div style="display:flex;gap:12px;justify-content:flex-end;">
        <button type="button" onclick="closeModal()" class="rl-btn-outline">Annuler</button>
        <button type="submit" class="rl-btn"><i class="fas fa-paper-plane"></i> Envoyer</button>
      </div>
    </form>
  </div>
</div>

{{-- MODAL ABONNEMENT --}}
<div id="subscriptionModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:999;align-items:center;justify-content:center;">
  <div style="background:var(--surface);border-radius:var(--radius);padding:32px;width:100%;max-width:480px;margin:24px;animation:fadeUp .25s ease;">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
      <div style="font-family:'Playfair Display',serif;font-size:1.1rem;color:var(--ink);">Accéder au service</div>
      <button onclick="closeSubscriptionModal()" style="background:none;border:none;font-size:1.2rem;cursor:pointer;color:var(--txt-muted);">✕</button>
    </div>
    <div style="display:flex;flex-direction:column;gap:16px;">
      <div style="padding:20px;background:var(--green-dim);border-radius:10px;border:1px solid rgba(39,174,96,.25);text-align:center;">
        <div style="font-size:1.8rem;margin-bottom:8px;">🎁</div>
        <div style="font-family:'Playfair Display',serif;font-size:1.1rem;color:var(--green);margin-bottom:6px;">Essai gratuit — 2 semaines</div>
        <div style="font-size:.82rem;color:var(--txt-muted);margin-bottom:14px;">Accès complet, sans engagement</div>
        <button class="rl-btn" style="background:var(--green);width:100%;justify-content:center;" onclick="startTrial()">
          <i class="fas fa-play"></i> Commencer l'essai
        </button>
      </div>
      <div style="padding:20px;background:var(--gold-dim);border-radius:10px;border:1px solid rgba(201,168,76,.25);text-align:center;">
        <div style="font-size:1.8rem;margin-bottom:8px;">⭐</div>
        <div style="font-family:'Playfair Display',serif;font-size:1.1rem;color:var(--gold);margin-bottom:6px;">Abonnement mensuel</div>
        <div style="font-size:.82rem;color:var(--txt-muted);margin-bottom:14px;">Accès illimité à toutes les fonctionnalités</div>
        <button class="rl-btn" style="width:100%;justify-content:center;" onclick="alert('Paiement à implémenter')">
          <i class="fas fa-credit-card"></i> Souscrire
        </button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
// Modal réponse
function openModal(qId, qTitle, content) {
  document.getElementById('responseForm').action = `/acteur/questions/${qId}/respond`;
  document.getElementById('modalQuestion').textContent = qTitle;
  document.getElementById('responseContent').value = content;
  document.getElementById('modalError').style.display = 'none';
  document.getElementById('responseModal').style.display = 'flex';
  document.body.style.overflow = 'hidden';
}
function closeModal() {
  document.getElementById('responseModal').style.display = 'none';
  document.body.style.overflow = '';
}
document.getElementById('responseModal')?.addEventListener('click', e => { if(e.target===e.currentTarget) closeModal(); });
document.getElementById('responseForm')?.addEventListener('submit', function(e) {
  const v = document.getElementById('responseContent').value.trim();
  const err = document.getElementById('modalError');
  if(v.length<10){ e.preventDefault(); err.textContent='Minimum 10 caractères.'; err.style.display='flex'; }
  else if(v.length>5000){ e.preventDefault(); err.textContent='Maximum 5000 caractères.'; err.style.display='flex'; }
});

// Modal abonnement
function openSubscriptionModal() {
  document.getElementById('subscriptionModal').style.display = 'flex';
  document.body.style.overflow = 'hidden';
}
function closeSubscriptionModal() {
  document.getElementById('subscriptionModal').style.display = 'none';
  document.body.style.overflow = '';
}
document.getElementById('subscriptionModal')?.addEventListener('click', e => { if(e.target===e.currentTarget) closeSubscriptionModal(); });

// Essai gratuit
function startTrial() {
  fetch('{{ route("client.startTrial") }}', {
    method: 'POST',
    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
  }).then(r=>r.json()).then(d => {
    if(d.success) { closeSubscriptionModal(); location.reload(); }
    else alert(d.message);
  });
}

// Notation par étoiles
const stars = document.querySelectorAll('.star');
let selectedNote = 0;
const labels = ['','Mauvais','Passable','Bien','Très bien','Excellent'];
stars.forEach(s => {
  s.addEventListener('mouseover', function() {
    const v = +this.dataset.value;
    stars.forEach((st,i) => st.style.color = i<v ? 'var(--gold)' : 'var(--border)');
    document.getElementById('ratingLabel').textContent = labels[v];
  });
  s.addEventListener('mouseout', () => {
    stars.forEach((st,i) => st.style.color = i<selectedNote ? 'var(--gold)' : 'var(--border)');
    document.getElementById('ratingLabel').textContent = selectedNote ? labels[selectedNote] : 'Cliquez pour noter';
  });
  s.addEventListener('click', function() {
    selectedNote = +this.dataset.value;
    document.getElementById('ratingValue').value = selectedNote;
    document.getElementById('ratingForm').style.display = 'block';
    document.getElementById('ratingLabel').textContent = labels[selectedNote];
  });
});
</script>
@endsection