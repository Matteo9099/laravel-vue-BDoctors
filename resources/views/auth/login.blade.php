@extends('layouts.app')

@section('content')

<div class="container col-xl-10 col-xxl-8 px-4 py-5">
    <div class="row align-items-center g-lg-5 py-5 gy-4">
        <div class="col-lg-7 text-center text-lg-start">
            <h1 class="display-4 fw-bold lh-1 mb-3">Bdoctors</h1>
            <img src="{{asset('img/carousel-1.png')}}" alt="login_img" width="100%" height="380px" style="object-fit: cover">
        </div>
        <div class="col-md-10 mx-auto col-lg-5">
            <form method="POST" action="{{route('login')}}" class="p-4 p-md-5 border rounded-3 bg-light shadow">
                @csrf
                <div class="form-group mb-3">
                    <label for="email" class="form-label text-muted">{{ __('E-mail') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="password" class="form-label text-muted">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="checkbox mb-3">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        {{ __('Ricordami') }}
                    </label>
                </div>

                <button class="w-100 btn btn-lg btn-primary text-white" type="submit">Accedi</button>
                <hr class="my-4">
                <div class="form-group row mb-0">
                    <div class="d-flex  justify-content-center mt-3">
                        @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Hai dimenticato la tua password?') }}
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
