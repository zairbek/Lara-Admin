@php
    /** @var \Future\LaraAdmin\Models\User $user */
    /** @var \Spatie\Permission\Models\Role $role */
@endphp

@extends('future::layouts.admin')

@section('title', $user->getName())

@section('content')

    <div class="row">
        <div class="col-md-3">

            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle"
                             src="{{ $user->getAvatarUrl() ?? asset('dist/img/avatar5.png') }}"
                             alt="{{ $user->getName() }}">
                    </div>
                    <h3 class="profile-username text-center">{{ $user->getName() }}</h3>
                    <p class="text-muted text-center">{{ $user->roles->implode('title', ', ') }}</p>
                </div>
            </div>

        </div>


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
                            <div class="form-horizontal">
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label">ФИО</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="first_name"
                                               class="form-control @error('first_name') is-invalid @enderror"
                                               placeholder="Имя" value="{{ $user->first_name }}">
                                        @error('first_name')<span
                                                class="error invalid-feedback">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="text" name="last_name"
                                               class="form-control @error('last_name') is-invalid @enderror"
                                               placeholder="Фамилия" value="{{ $user->last_name }}">
                                        @error('last_name')<span
                                                class="error invalid-feedback">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" name="second_name"
                                               class="form-control @error('second_name') is-invalid @enderror"
                                               placeholder="Отчество" value="{{ $user->second_name }}">
                                        @error('second_name')<span
                                                class="error invalid-feedback">{{ $message }}</span>@enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" name="email"
                                               class="form-control @error('email') is-invalid @enderror" id="inputEmail"
                                               placeholder="Email" value="{{ $user->email }}">
                                        @error('email')<span
                                                class="error invalid-feedback">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputName2" class="col-sm-2 col-form-label">Логин</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="login"
                                               class="form-control @error('login') is-invalid @enderror" id="inputName2"
                                               placeholder="Логин" value="{{ $user->login }}">
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
                                               placeholder="Телефон номер" value="{{ $user->phone_number }}">
                                        @error('phone_number')<span
                                                class="error invalid-feedback">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Дата рождения</label>
                                    <div class="col-sm-10">
                                        <input type="date" name="birthday"
                                               class="form-control @error('birthday') is-invalid @enderror"
                                               placeholder="Дата рождение"
                                               value="{{ $user->birthday?->format('Y-m-d') }}">
                                        @error('birthday')<span
                                                class="error invalid-feedback">{{ $message }}</span>@enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <div class="checkbox">
                                            <label>
                                                <input name="active" type="checkbox" @if($user->active) value="1"
                                                       checked="checked" @else value="0" @endif> Активность
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
                                                        @if($user->hasRole($role)) selected @endif>{{ $role->title }}</option>
                                            @endforeach
                                        </select>
                                        @error('roles')<span
                                                class="error invalid-feedback">{{ $message }}</span>@enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <a href="{{ route('future.pages.users.index') }}"
                                           class="btn btn-sm btn-default">Назад</a>
                                        <a href="{{ route('future.pages.users.edit', $user->id) }}"
                                           class="btn btn-sm btn-primary">Редактировать</a>
                                    </div>
                                </div>
                            </div>
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
