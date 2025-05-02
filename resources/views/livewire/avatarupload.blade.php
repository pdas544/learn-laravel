<form wire:submit="save" action="/manage-avatar" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="avatar-file" class="text-muted mb-1">Select an image file</label>
                <input wire:loading.attr="disabled" wire:target="avatar" wire:model="avatar" type="file" id="avatar-file" class="form-control" name="avatar" accept="image/*">
                @error('avatar')
                    <p class="alert small alert-danger shadow-sm">{{ $message }}</p>
                @enderror
                <button wire:loading.attr="disabled" wire:target="avatar" class="btn btn-primary mt-3">Save</button>  
            </div>
           
        </form>