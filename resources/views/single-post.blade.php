<x-layout :pageTitle="$post->title">
    <div class="container py-md-5 container--narrow">
        <div class="d-flex justify-content-between">
            <h2>{{ $post->title }}</h2>
            @can('update', $post)
                <span class="pt-2">
                    <a wire:navigate href="/post/{{ $post->id }}/edit" class="text-primary mr-2" data-toggle="tooltip"
                        data-placement="top" title="Edit"><i class="fas fa-edit"></i></a>
                    <livewire:deletepost :post="$post" />
                </span>
            @endcan

        </div>

        <p class="text-muted small mb-4">
            <a href="/profile/{{ $post->user->username }}"><img class="avatar-tiny"
                    src="{{ $post->user->avatar }}" /></a>
            Posted by <a href="/profile/{{ $post->user->username }}">{{ $post->user->username }}</a> on
            {{ $post->created_at->format('d-m-Y, g:i a') }}
        </p>

        <div class="body-content">
            {!! $post->body !!}
        </div>
    </div>
</x-layout>
