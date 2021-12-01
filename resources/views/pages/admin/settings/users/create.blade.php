@php
    /** @var \Future\LaraAdmin\Models\User $user */
    /** @var \Spatie\Permission\Models\Role $role */
@endphp

@extends('future::layouts.admin')

@section('title', 'Создание пользователя')

@section('content')


    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Настройки</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">

                        <div class="tab-pane active" id="settings">
                            <form class="form-horizontal"
                                  action="{{ route('future.pages.settings.users.store') }}"
                                  method="post"
                            >
                                @csrf

                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label">ФИО</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="first_name"
                                               class="form-control @error('first_name') is-invalid @enderror"
                                               placeholder="Имя" value="{{ old('first_name') }}">
                                        @error('first_name')<span
                                                class="error invalid-feedback">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" name="last_name"
                                               class="form-control @error('last_name') is-invalid @enderror"
                                               placeholder="Фамилия" value="{{ old('last_name') }}">
                                        @error('last_name')<span
                                                class="error invalid-feedback">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" name="second_name"
                                               class="form-control @error('second_name') is-invalid @enderror"
                                               placeholder="Отчество" value="{{ old('second_name') }}">
                                        @error('second_name')<span
                                                class="error invalid-feedback">{{ $message }}</span>@enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" name="email"
                                               class="form-control @error('email') is-invalid @enderror" id="inputEmail"
                                               placeholder="Email" value="{{ old('email') }}">
                                        @error('email')<span
                                                class="error invalid-feedback">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputName2" class="col-sm-2 col-form-label">Логин</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="login"
                                               class="form-control @error('login') is-invalid @enderror" id="inputName2"
                                               placeholder="Логин" value="{{ old('login') }}">
                                        @error('login')<span
                                                class="error invalid-feedback">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Пароль</label>
                                    <div class="col-sm-5">
                                        <input type="password" name="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               placeholder="Придумайте пароль">
                                        @error('password')<span
                                                class="error invalid-feedback">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="col-sm-5">
                                        <input type="password" name="password_confirmation" class="form-control"
                                               placeholder="Подтвердите пароль">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Телефон номер</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="phone_number"
                                               class="form-control @error('phone_number') is-invalid @enderror"
                                               placeholder="Телефон номер" value="{{ old('phone_number') }}">
                                        @error('phone_number')<span
                                                class="error invalid-feedback">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Дата рождения</label>
                                    <div class="col-sm-10">
                                        <input type="date" name="birthday"
                                               class="form-control @error('birthday') is-invalid @enderror"
                                               placeholder="Дата рождение" value="{{ old('birthday') }}">
                                        @error('birthday')<span
                                                class="error invalid-feedback">{{ $message }}</span>@enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <div class="checkbox">
                                            <label>
                                                <input name="active" type="checkbox"
                                                       @if(old('active') === '1') value="1" checked="checked"
                                                       @else value="0" @endif> Активность
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Группы</label>
                                    <div class="col-sm-10">
                                        <select multiple name="roles[]"
                                                class="form-control @error('roles') is-invalid @enderror">
                                            @foreach($roles as $role)
                                                <option value="{{ $role->name }}"
                                                        @if(old('roles') && in_array($role->name, old('roles'), true)) selected @endif>{{ $role->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('roles')<span
                                                class="error invalid-feedback">{{ $message }}</span>@enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <a href="{{ route('future.pages.settings.users.index') }}"
                                           class="btn btn-sm btn-default">Назад</a>
                                        <button type="submit" class="btn btn-sm btn-primary">Создать</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                    <!-- /.tab-content -->
                </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>

@endsection
