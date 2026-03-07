@extends('layouts.app')

@section('title', 'Questions Reçues — RoukLegal')

@section('page-title')
  Questions <span>/ Reçues</span>
@endsection

@section('topbar-actions')
  <a href="{{ route('articles.create') }}" class="rl-btn">
    <i class="fas fa-pen"></i> Nouvel article
  </a>
@endsection

@section('content')
<div style="display:flex;flex-direction:column;gap:24px;">

  {{-- STATS RAPIDES --}}
  <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;">
    <div class="rl-stat-card fade-up" style="--accent:var(--gold);">
      <div class="rl-stat-header"><span class="rl-stat-label">Total reçues</span><span>❓</span></div>
      <div class="rl-stat-value">{{ $questions->total() }}</div>
      <div class="rl-stat-sub">Sur tous vos articles</div>
    </div>
    <div class="rl-stat-card fade-up" style="--accent:var(--orange);animation-delay:.08s">
      <div class="rl-stat-header"><span class="rl-stat-label">En attente</span><span>⏳</span></div>
      <div class="rl-stat-value">{{ $questions->filter(fn($q)=>$q->reponses->count()===0)->count() }}</div>
      <div class="rl-stat-sub">À traiter</div>
    </div>
    <div class="rl-stat-card fade-up" style="--accent:var(--green);animation-delay:.13s">
      <div class="rl-stat-header"><span class="rl-stat-label">Répondues</span><span>✅</span></div>
      <div class="rl-stat-value">{{ $questions->filter(fn($q)=>$q->reponses->count()>0)->count() }}</div>
      <div class="rl-stat-sub">Sur cette page</div>
    </div>
  </div>

  {{-- LISTE DES QUESTIONS --}}
  @if($questions->count() > 0)
  <div style="display:flex;flex-direction:column;gap:16px;">
    @foreach($questions as $question)
    <div class="rl-card fade-up" data-question-id="{{ $question->id }}" style="animation-delay:{{ $loop->index * 0.05 }}s">
      <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:14px;">
        <div style="flex:1;min-width:0;">
          <div style="font-family:'Playfair Display',serif;font-size:1rem;font-weight:500;color:var(--ink);margin-bottom:6px;">
            {{ $question->titre }}
          </div>
          <div style="display:flex;flex-wrap:wrap;gap:10px;font-size:.75rem;color:var(--txt-muted);">
            <span><i class="fas fa-user" style="margin-right:4px;"></i>{{ $question->user->nom ?? 'Client' }}</span>
            <span>•</span>
            <span>
              <i class="fas fa-newspaper" style="margin-right:4px;"></i>
              <a href="{{ route('articles.show', $question->article->id) }}" style="color:var(--gold);text-decoration:none;font-weight:500;">
                {{ Str::limit($question->article->title ?? 'Article', 40) }}
              </a>
            </span>
            <span>•</span>
            <span><i class="fas fa-clock" style="margin-right:4px;"></i>{{ $question->created_at->format('d/m/Y à H:i') }}</span>
          </div>
        </div>
        <span class="rl-badge {{ $question->reponses->count() > 0 ? 'rl-badge-green' : 'rl-badge-orange' }}">
          {{ $question->reponses->count() > 0 ? '✓ Répondu' : '⏳ À répondre' }}
        </span>
      </div>

      {{-- Contenu question --}}
      <div style="padding:14px 16px;background:var(--surface2);border-radius:8px;border-left:3px solid var(--blue);font-size:.88rem;color:var(--txt);margin-bottom:14px;line-height:1.6;">
        {{ $question->contenu }}
      </div>

      {{-- Réponse existante --}}
      @if($question->reponses->count() > 0)
      <div style="padding:14px 16px;background:var(--green-dim);border-radius:8px;border-left:3px solid var(--green);margin-bottom:14px;">
        <div style="font-size:.75rem;font-weight:600;color:var(--green);margin-bottom:6px;">
          <i class="fas fa-check-circle"></i> Votre réponse — {{ $question->reponses->first()->created_at->format('d/m/Y à H:i') }}
        </div>
        <div style="font-size:.88rem;color:var(--txt);line-height:1.6;">{{ $question->reponses->first()->contenu }}</div>
      </div>
      <button class="rl-btn-outline" style="font-size:.8rem;padding:6px 14px;" onclick="openModal({{ $question->id }}, '{{ addslashes($question->titre) }}', '{{ addslashes($question->reponses->first()->contenu) }}')">
        <i class="fas fa-edit"></i> Modifier la réponse
      </button>
      @else
      <button class="rl-btn" style="font-size:.8rem;padding:6px 14px;" onclick="openModal({{ $question->id }}, '{{ addslashes($question->titre) }}', '')">
        <i class="fas fa-reply"></i> Répondre
      </button>
      @endif
    </div>
    @endforeach
  </div>

  {{-- PAGINATION --}}
  <div style="display:flex;justify-content:center;margin-top:8px;">
    {{ $questions->links() }}
  </div>

  @else
  <div class="rl-card" style="text-align:center;padding:48px 32px;">
    <div style="font-size:3rem;margin-bottom:16px;">📭</div>
    <div style="font-family:'Playfair Display',serif;font-size:1.2rem;color:var(--ink);margin-bottom:8px;">Aucune question reçue</div>
    <div style="font-size:.88rem;color:var(--txt-muted);margin-bottom:24px;">Publiez des articles pour recevoir des questions de clients.</div>
    <a href="{{ route('articles.create') }}" class="rl-btn"><i class="fas fa-pen-fancy"></i> Écrire un article</a>
  </div>
  @endif

</div>

{{-- MODAL RÉPONSE --}}
<div id="responseModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:999;align-items:center;justify-content:center;">
  <div style="background:var(--surface);border-radius:var(--radius);padding:32px;width:100%;max-width:600px;margin:24px;box-shadow:0 20px 60px rgba(0,0,0,.2);animation:fadeUp .25s ease;">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;">
      <div style="font-family:'Playfair Display',serif;font-size:1.15rem;color:var(--ink);">Répondre à la question</div>
      <button onclick="closeModal()" style="background:none;border:none;font-size:1.2rem;cursor:pointer;color:var(--txt-muted);">✕</button>
    </div>

    <form method="POST" action="" id="responseForm">
      @csrf
      <div class="rl-form-group">
        <label class="rl-label">Question</label>
        <div id="modalQuestion" style="padding:12px 14px;background:var(--surface2);border-radius:8px;border:1px solid var(--border);font-size:.88rem;color:var(--txt);line-height:1.5;"></div>
      </div>
      <div class="rl-form-group">
        <label class="rl-label" for="responseContent">Votre réponse <span style="color:var(--red)">*</span></label>
        <textarea class="rl-textarea" id="responseContent" name="contenu" rows="6" placeholder="Fournissez une réponse claire et complète…" required></textarea>
        <div style="font-size:.72rem;color:var(--txt-muted);margin-top:4px;">Entre 10 et 5000 caractères</div>
      </div>
      <div id="modalError" class="rl-alert rl-alert-error" style="display:none;margin-bottom:16px;"></div>
      <div style="display:flex;gap:12px;justify-content:flex-end;">
        <button type="button" onclick="closeModal()" class="rl-btn-outline">Annuler</button>
        <button type="submit" class="rl-btn"><i class="fas fa-paper-plane"></i> Envoyer</button>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script>
function openModal(questionId, questionTitle, currentContent) {
  document.getElementById('responseForm').action = `/acteur/questions/${questionId}/respond`;
  document.getElementById('modalQuestion').textContent = questionTitle;
  document.getElementById('responseContent').value = currentContent;
  document.getElementById('modalError').style.display = 'none';
  document.getElementById('responseModal').style.display = 'flex';
  document.body.style.overflow = 'hidden';
}
function closeModal() {
  document.getElementById('responseModal').style.display = 'none';
  document.body.style.overflow = '';
}
document.getElementById('responseForm')?.addEventListener('submit', function(e) {
  const content = document.getElementById('responseContent').value.trim();
  const err = document.getElementById('modalError');
  if (content.length < 10) {
    e.preventDefault(); err.textContent = 'La réponse doit contenir au minimum 10 caractères.'; err.style.display = 'flex';
  } else if (content.length > 5000) {
    e.preventDefault(); err.textContent = 'La réponse ne doit pas dépasser 5000 caractères.'; err.style.display = 'flex';
  }
});
document.getElementById('responseModal').addEventListener('click', function(e) {
  if (e.target === this) closeModal();
});
</script>
@endsection