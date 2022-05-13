@extends('layouts.app')

@section('content')

<div class="container border p-4 bg-light">
    @foreach ($reviews as $review)
    <div class="d-flex justify-content-between">
        <h4>Recensione scritta da - {{$review->author}}</h4>
        <span class="text-secondary">{{$review->created_at}}</span>
    </div>
        <div class="d-flex">
            <p>Valutazione {{$review->vote}} <i class="fa-solid fa-star"></i></p>
            @if ($review->vote >= 3)
                <span class="text-success ms-3">Buona</span>
            @else
                <span class="text-danger ms-3">Pessima</span>
            @endif
        </div>
        <h5 class="fw-bold">{{$review->title}}</h5>
        <p>{{$review->review}}</p>
        <hr>
    @endforeach
</div>
    
</div>

@endsection
