<div class="modal-body">
    <div class="form-group">
        <label for="name">Category Name</label>
        <input wire:model.defer="name" type="text"
            class="form-control @error('name') is-invalid @enderror" id="name" name="name">
        @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="description">Description <small>(optional)</small></label>
        <input wire:model.defer="description" type="text"
            class="form-control @error('description') is-invalid @enderror" id="description"
            name="description">
        @error('description')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>