@extends('future::layouts.auth')

@php
    $title = 'Вход';
@endphp

@section('content')

    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">
                @if (session('status'))
                    {{ session('status') }}
                @else
                   Вы забыли свой пароль? Здесь вы можете легко восстановить новый пароль.
                @endif
            </p>
            <form action="{{ route('admin.auth.forgot-password.post') }}" method="post">
                @method('post')
                @csrf
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    @error('email')
                        <span class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Запросить новый пароль</button>
                    </div>
                </div>
            </form>

            <p class="mt-3 mb-1">
                <a href="{{ route('admin.auth.sign-in') }}">Войти</a>
            </p>
        </div>
    </div>

@endsection
