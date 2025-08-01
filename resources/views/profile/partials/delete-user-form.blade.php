<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
    Eliminar Cuenta
</button>

<!-- Modal Bootstrap -->
<div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('profile.destroy') }}">
      @csrf
      @method('delete')

      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-danger" id="confirmUserDeletionLabel">¿Estás seguro que quieres eliminar tu cuenta?</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <p>Una vez eliminada, todos tus datos se perderán permanentemente.</p>

          <div class="mb-3">
            <label for="password" class="form-label">Contraseña para confirmar</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
            @error('password')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-danger">Eliminar Cuenta</button>
        </div>
      </div>

    </form>
  </div>
</div>
