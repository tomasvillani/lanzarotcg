<div class="container my-5">
    <h2 class="mb-4">Actualizar Información del Perfil</h2>

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input 
                type="text" 
                class="form-control @error('name') is-invalid @enderror" 
                id="name" 
                name="name" 
                value="{{ old('name', $user->name) }}" 
                required 
                autofocus
            >
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input 
                type="email" 
                class="form-control @error('email') is-invalid @enderror" 
                id="email" 
                name="email" 
                value="{{ old('email', $user->email) }}" 
                required
            >
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 alert alert-warning p-2">
                    Tu correo electrónico no está verificado.
                    <form id="send-verification" method="post" action="{{ route('verification.send') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">Haz clic aquí para reenviar el email de verificación.</button>
                    </form>
                    @if (session('status') === 'verification-link-sent')
                        <div class="text-success small mt-1">Se ha enviado un nuevo enlace de verificación.</div>
                    @endif
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Guardar Cambios</button>

        @if (session('status') === 'profile-updated')
            <div class="alert alert-success mt-3" role="alert">
                ¡Perfil actualizado correctamente!
            </div>
        @endif
    </form>
</div>
