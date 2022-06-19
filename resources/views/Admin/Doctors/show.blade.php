@extends('layouts.app')

@section('content')
    <div class="container py-2">
        <div class="row">
            <div class="col-md-4 border border-2 rounded border-secondary">
                @if (!$doctor->photo)
                    <img src=" {{ asset('img/not_found.jpg') }} " alt="not_found_photo" class="img-fluid py-2 h-100">
                @else
                    <img src=" {{ asset('storage/' . $doctor->photo) }} " alt="{{ $doctor->id }}_photo" class="img-fluid py-2 h-100">
                @endif
            </div>
            <div class="col-md-4 border border-2 rounded border border-success">
                <h4 class="mt-3">Prestazioni eseguite </h4>
                <p>{{ $doctor->performance }}</p>
            </div>
            <div class="col-md-4 border border-2 rounded border border-success">
                <h4 class="mt-3">Recensioni ricevute</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 border border-2 rounded border-secondary">
                <h1 class="h2">{{ $doctor->user->name }} {{ $doctor->user->surname }}</h1>
                <p><strong>Indirizzo: </strong>{{ $doctor->user->address }}</p>
                <p><strong>Studio medico: </strong>{{ $doctor->medical_address }}</p>
                <p><strong>Telefono: </strong>{{ $doctor->phone }}</p>
                <p><strong>Email: </strong>{{ $doctor->user->email }}</p>
                @if (!$doctor->cv)
                    <p class="text-danger">Nessun cv caricato</p>
                @else
                    {{-- <p><strong>Scarica il tuo cv -> </strong> <a href="{{ route('admin.downloadCv') }}">Clicca qui</a> </p> --}}
                    <p><strong>Scarica il tuo cv -> </strong> <a href="{{  url('storage/'. Auth::user()->doctor->cv)  }}">Clicca qui</a> </p>
                @endif
            </div>
            <div class="col-md-4 border border-2 rounded border-success">
                <h4 class="my-3">Specializzato in </h4>
                <div class="d-flex gap-3 flex-wrap">
                    @foreach ($doctor->specialties as $specialty)
                        <span class="badge rounded-pill bg-info text-dark">{{ $specialty->name }}</span>
                    @endforeach
                </div>
            </div>
            <div class="col-md-4 border border-2 rounded border border-success">
                <h4 class="mt-3">Contatti ricevuti</h4>
            </div>
        </div>

    </div>
@endsection
