<div>
    <form wire:submit="save">
        {{ $this->form }}

        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-primary">
                <i class="bx bx-save me-1"></i> Simpan
            </button>
        </div>
    </form>
</div>
