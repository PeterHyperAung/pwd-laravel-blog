@extends("layouts.app")
@section("content")
<div class="container">
    <div class="card mb-2">
        <div class="card-body">
            <h5 class="card-title">{{ $article->title }}</h5>
            <div class="card-subtitle mb-2 text-muted small">
                {{ $article->created_at->diffForHumans() }}
            </div>
            <p class="card-text">{{ $article->body }}</p>
            @if($article->user->id === auth()->id())
            <a class="btn btn-warning" href="{{ url("/articles/delete/$article->id") }}">
                Delete
            </a>
            @endif
        </div>
    </div>

    <ul class="list-group mb-2">
        <li class="list-group-item active">
            <b>Comments ({{ count($article->comments) }})</b>
        </li>
        @foreach($article->comments as $comment)
        <li class="list-group-item">
            @if(auth()->id() === $comment->user_id)
            <a href="{{ url("/comments/delete/$comment->id") }}" class="btn-close float-end">
            @endif
            </a>
            {{ $comment->content }}
            <div class="small mt-2">
                By <b>{{ $comment->user->name }}</b>,
                {{ $comment->created_at->diffForHumans() }}
            </div>
        </li>
        @endforeach
    </ul>

    @auth
    <form action="{{ url('/comments/add') }}" method="post" class="mt-4">
        @csrf
        <label for="content" class="text-muted">Comment</label>
        <input class="form-control my-2" name="content" id="content" required />
        <input type="hidden" name="article_id" value="{{$article->id}}" />
        <button class="btn btn-secondary" type="submit">Submit</button>
    </form>
    @endauth
</div>
@endsection