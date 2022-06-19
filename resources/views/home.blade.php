@extends('layouts.app')

@section('content')
<div class="container">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    {{-- <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('') }}</div>

                <div class="card-body">

                    <h4>Bentornato signor {{ $doctor->user->name }}</h4>
                </div>
            </div>
        </div>
    </div> --}}
    <h1>ciao</h1>
</div>
@endsection
