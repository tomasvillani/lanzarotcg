<div class="container my-5">
    <h2 class="mb-4">Actualizar Contraseña</h2>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="mb-3">
            <label for="current_password" class="form-label">Contraseña Actual</label>
            <input 
                type="password" 
                class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" 
                id="current_password" 
                name="current_password" 
                required 
                autocomplete="current-password"
            >
            @error('current_password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Nueva Contraseña</label>
            <input 
                type="password" 
                class="form-control @error('password', 'updatePassword') is-invalid @enderror" 
                id="password" 
                name="password" 
                required 
                autocomplete="new-password"
            >
            @error('password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
            <input 
                type="password" 
                class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" 
                id="password_confirmation" 
                name="password_confirmation" 
                required 
                autocomplete="new-password"
            >
            @error('password_confirmation', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Guardar Contraseña</button>

        @if (session('status') === 'password-updated')
            <div class="alert alert-success mt-3" role="alert">
                Contraseña actualizada correctamente.
            </div>
        @endif
    </form>
</div>
