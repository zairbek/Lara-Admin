@php
    /** @var \Future\LaraAdmin\Models\User $user */
@endphp

@extends('future::layouts.admin')

@section('title', 'Список пользователей')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="card-tools float-left">
                <a href="{{ route('future.pages.settings.users.create') }}" class="btn btn-sm btn-primary"
                   title="Добавить пользователя">Добавить пользователя</a>
            </div>
            <div class="card-tools">
                <form
                        method="get" action="{{ route('future.pages.settings.users.index') }}"
                        class="input-group input-group-sm" style="width: 300px;"
                >
                    <div class="input-group-prepend">
                        <select name="field" class="btn btn-default dropdown-toggle">
                            <option value='id' @if(request()->get('field') === 'id') selected @endif>ID</option>
                            <option value='name' @if(request()->get('field') === 'name') selected @endif>Имя фамилия
                            </option>
                            <option value='email' @if(request()->get('field') === 'email') selected @endif>Email
                            </option>
                            <option value='roles' @if(request()->get('field') === 'roles') selected @endif>Группа
                            </option>
                        </select>
                    </div>

                    <input type="text" name="search" class="form-control float-right" placeholder="Search"
                           value="{{ request()->get('search') }}">

                    @if(request()->exists(['field', 'search']))
                        <div class="input-group-append">
                            <a class="btn btn-default" href="{{ route('future.pages.settings.users.index') }}">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    @endif

                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0" style="max-height: 70vh;">
            <table class="table table-head-fixed table-hover text-nowrap">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Группа</th>
                    <th style="width: 150px;"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>
                            <a href="{{ route('future.pages.settings.users.show', $user->getKey()) }}">{{ $user->getKey() }}</a>
                        </td>
                        <td>
                            <a href="{{ route('future.pages.settings.users.show', $user->getKey()) }}">{{ $user->getName() }}</a>
                        </td>
                        <td>
                            <a href="{{ route('future.pages.settings.users.show', $user->getKey()) }}">{{ $user->email }}</a>
                        </td>
                        <td><span class="tag tag-danger">{{ $user->active }}</span></td>
                        <td>{{ $user->roles->implode('title', ', ') }}</td>
                        <td>
                            <a href="{{ route('future.pages.settings.users.destroy', $user->getKey()) }}"
                               class="btn btn-sm btn-outline-danger btn-confirm" title="Удалить"
                               data-method="delete" data-title="{{ $user->getName() }}"
                            >
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            {{ $users->links('future::components.pagination.default') }}
        </div>
    </div>
@endsection
