@extends('future::layouts.auth')

@php
    $title = 'Вход';
@endphp

@section('content')
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Вы находитесь всего в одном шаге от нового пароля, восстановите его сейчас.</p>

            <form action="login.html" method="post">
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Пароль">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Подтвердить пароль">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Измени пароль</button>
                    </div>
                </div>
            </form>

            <p class="mt-3 mb-1">
                <a href="{{ route('admin.auth.sign-in') }}">Войти</a>
            </p>
        </div>
    </div>
@endsection
