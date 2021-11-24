@extends('future::layouts.auth')

@php
  $title = 'Авторизация';
@endphp

@section('content')
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Войдите, чтобы начать сеанс</p>

            <form action="{{ route('admin.auth.sign-in.post') }}" method="post">
                @csrf
                @method('POST')
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
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Пароль">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    @error('password')
                        <span class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">Запомнить меня</label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Войти</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <p class="mb-1 mt-3">
                <a href="{{ route('admin.auth.forgot-password') }}">Я забыл свой пароль</a>
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>
@endsection
