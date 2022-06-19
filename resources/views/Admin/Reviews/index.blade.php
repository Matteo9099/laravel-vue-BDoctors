@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
            <p>Oggi {{\Illuminate\Support\Carbon::now()}}</p>
        </div>
    @endif
    @if (session('fail'))
        <div class="alert alert-danger">
            {{ session('fail') }}
            <p>Oggi {{\Illuminate\Support\Carbon::now()}}</p>
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <span class="badge rounded-pill bg-black text-white p-1">{{ $error }}</span>
                @endforeach
            @endif
        </div>
    @endif

        {{-- Nessuna recensione --}}

        @if (count($reviews) === 0)
            <div class="container text-center mt-5 py-3 border shadow-lg">
                <h2>Nessuna recensione ricevuta</h2>
                <a href="{{route('admin.home')}}"><button class="btn btn-primary text-white mb-3" aria-current="page"><i class="fa-solid fa-house-user"></i> Dashboard</button></a>
            </div>
        @else

        <div class="container border p-4 bg-light">
            <div class="text-center">
                <a href="{{route('admin.home')}}"><button class="btn btn-primary text-white mb-3" aria-current="page"><i class="fa-solid fa-house-user"></i> Dashboard</button></a>
            </div>

            @foreach ($reviews as $review)
                <div class="d-flex justify-content-between">
                    <h4>Recensione scritta da - {{$review->author}}</h4>
                    <span class="text-secondary">{{$review->created_at->format('d m Y H:m:s')}}</span>
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
                {{-- offcanvas per risposta--}}
                <p>
                    <a class="btn btn-success my-4 text-white" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Rispondi
                    </a>
                </p>
                <div class="collapse" id="collapseExample">
                    <div class="card card-body">
                        <p class="h4 text-center my-3">Rispondi al signor {{$review->author}}</p>
                        <form action="{{route('admin.reviewDoctorRes', $review->id)}}" class="my-4" method="POST">
                            @csrf
                            <div class="container">
                                <div class="row">
                                    <div class="col-6 offset-3">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="title" id="title"
                                                placeholder="Titolo">
                                            <label for="title" class="fw-bold">Titolo</label>
                                        </div>
                                        <div class="mb-3">
                                            <textarea rows="10" cols="50" class="form-control" placeholder="Lascia la tua risposta" id="content" name="content"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col d-flex justify-content-center">
                                        <button type="submit" class="btn btn-primary w-25">Invia</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <hr>
            @endforeach
        </div>
    @endif




@endsection
