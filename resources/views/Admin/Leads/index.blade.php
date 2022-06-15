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

    @if (count($leads) === 0)
        <div class="container text-center mt-5 py-3 border shadow-lg">
            <h2>Nessun messaggio ricevuto</h2>
            <a href="{{route('admin.home')}}"><button class="btn btn-primary text-white mb-3" aria-current="page"><i class="fa-solid fa-house-user"></i> Dashboard</button></a>
        </div>
    @else

        <div class="container border p-4 bg-light">
            <div class="text-center">
                <a href="{{route('admin.home')}}"><button class="btn btn-primary text-white mb-3" aria-current="page"><i class="fa-solid fa-house-user"></i> Dashboard</button></a>
            </div>

            @foreach ($leads as $lead)
                <div class="d-flex justify-content-between">
                    <h4>Messaggio ricevuto da - {{$lead->author}}</h4>
                    <span class="text-secondary">{{$lead->created_at}}</span>
                </div>
                <p>{{$lead->message}}</p>
                {{-- offcanvas per risposta--}}
                <p>
                    <a class="btn btn-success my-4 text-white" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                        Rispondi
                    </a>
                </p>
                <div class="collapse" id="collapseExample">
                    <div class="card card-body">
                        <p class="h4 text-center my-3">Rispondi al signor {{$lead->author}}</p>
                        <form action="{{route('admin.leadProfessionalRes', $lead->id)}}" class="my-4" method="POST">
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
