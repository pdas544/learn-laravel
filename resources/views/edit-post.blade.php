<x-layout pageTitle="Editing {{ $post->title }}">
    <div class="container py-md-5 container--narrow">
        <a href="/post/{{ $post->id }}" class="btn btn-secondary mb-3"><i class="fas fa-arrow-left"></i> Back to View
            Post</a>
        <div class="row justify-content-center shadow border rounded p-3">

            <form action="/post/{{ $post->id }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="post-title" class="text-muted mb-1"><small>Title</small></label>
                    <input value="{{ old('title', $post->title) }}" name="title" id="post-title"
                        class="form-control form-control-lg form-control-title" type="text"
                        placeholder="Enter post title here" autocomplete="off" />
                    @error('title')
                        <p class="m-0 small alert alert-danger shadow-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="post-body" class="text-muted mb-1"><small>Body Content</small></label>
                    <textarea name="body" id="post-body" class="body-content tall-textarea form-control" type="text"
                        placeholder="Write post content here...">{{ old('body', $post->body) }}</textarea>
                    @error('body')
                        <p class="m-0 small alert alert-danger shadow-sm">{{ $message }}</p>
                    @enderror
                </div>

                <button class="btn btn-primary mt-3">Update Post</button>
            </form>
        </div>
    </div>
</x-layout>
