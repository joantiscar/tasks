@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verifica el teu correu') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('S\'ha enviat un enllaç nou al teu correu.') }}
                        </div>
                    @endif

                    {{ __('Abans de continuar, has de mirar el teu correu.') }}
                    {{ __('Si no has rebut cap correu') }}, <a href="{{ route('verification.resend') }}">{{ __('fes click aqui per a rebre un nou link') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
