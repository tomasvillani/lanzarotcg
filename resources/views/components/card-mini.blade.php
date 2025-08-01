<div class="card h-100">
    <img src="{{ $card->imagen ? asset($card->imagen) : asset('img/default-card.png') }}" class="card-img-top" alt="{{ $card->nombre }}">
    <div class="card-body">
        <h5 class="card-title text-center">{{ $card->nombre }}</h5>
        <p><i class="bi bi-tags"></i> {{ $categoriasAmigables[$card->categoria] ?? ucfirst($card->categoria) }}</p>
        <p><i class="bi bi-person-circle"></i> {{ $card->user->name }}</p>
    </div>
</div>
