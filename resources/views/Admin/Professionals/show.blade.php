@extends('layouts.app')

@section('content')
    <div class="container py-2">
        <div class="row">
            <div class="col-md-4 border border-2 rounded border-secondary">
                @if (!$professional->photo)
                    <img src=" {{ asset('img/not_found.jpg') }} " alt="not_found_photo" class="img-fluid py-2 h-100">
                @else
                    <img src=" {{ asset('storage/' . $professional->photo) }} " alt="{{ $professional->id }}_photo" class="img-fluid py-2 h-100">
                @endif
            </div>
            <div class="col-md-4 border border-2 rounded border border-success">
                <h4 class="mt-3">Prestazioni eseguite </h4>
                <p>{{ $professional->performance }}</p>
            </div>
            <div class="col-md-4 border border-2 rounded border border-success">
                <h4 class="mt-3">Recensioni ricevute</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 border border-2 rounded border-secondary">
                <h1 class="h2">{{ $professional->user->name }} {{ $professional->user->surname }}</h1>
                <p><strong>Indirizzo: </strong>{{ $professional->user->address }}</p>
                <p><strong>Studio medico: </strong>{{ $professional->medical_address }}</p>
                <p><strong>Telefono: </strong>{{ $professional->phone }}</p>
                <p><strong>Email: </strong>{{ $professional->user->email }}</p>
            </div>
            <div class="col-md-4 border border-2 rounded border-success">
                <h4 class="my-3">Specializzato in </h4>
                <div class="d-flex gap-3 flex-wrap">
                    @foreach ($professional->specialties as $specialty)
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
