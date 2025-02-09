<x-layout>
    <div class="container container--narrow py-md-5">
    <h2 class="text-center mb-3">Upload your new avatar</h2>
    <form action="/manage-avatar" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="avatar-file" class="text-muted mb-1">Select an image file</label>
        <input type="file" id="avatar-file" class="form-control" name="avatar" accept="image/*" required>
        @error('avatar')
            <p class="alert small alert-danger shadow-sm">{{$message}}</p>
        @enderror
        <button class="btn btn-primary mt-3">Save</button>
    </div>
    </form>

    </div>
</x-layout>