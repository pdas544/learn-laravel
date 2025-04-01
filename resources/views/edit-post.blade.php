<x-layout pageTitle="Editing {{ $post->title }}">
    <div class="container py-md-5 container--narrow">
        <a href="/post/{{ $post->id }}" class="btn btn-secondary mb-3"><i class="fas fa-arrow-left"></i> Back to View
            Post</a>
        <div class="row justify-content-center shadow border rounded p-3">

            <livewire:editpost :post="$post" />
        </div>
    </div>
</x-layout>
