@php
    /** @var \Spatie\Permission\Models\Role $role */
@endphp

@extends('future::layouts.admin')

@section('title', 'Список доступов')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="card-tools float-left">
                <a href="{{ route('future.pages.settings.permissions.create') }}" class="btn btn-sm btn-primary"
                   title="Добавить пользователя">Добавить доступы</a>
            </div>
            <div class="card-tools">
                <form
                        method="get" action="{{ route('future.pages.settings.permissions.index') }}"
                        class="input-group input-group-sm" style="width: 300px;"
                >
                    <div class="input-group-prepend">
                        <select name="field" class="btn btn-default dropdown-toggle">
                            <option value='id' @if(request()->get('field') === 'id') selected @endif>ID</option>
                            <option value='title' @if(request()->get('field') === 'title') selected @endif>Название</option>
                            <option value='name' @if(request()->get('field') === 'name') selected @endif>Код</option>
                        </select>
                    </div>

                    <input type="text" name="search" class="form-control float-right" placeholder="Search" value="{{ request()->get('search') }}">

                    @if(request()->exists(['field', 'search']))
                        <div class="input-group-append">
                            <a class="btn btn-default" href="{{ route('future.pages.settings.permissions.index') }}">
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
                    <th>Название</th>
                    <th>Код</th>
                </tr>
                </thead>
                <tbody>
                @foreach($permissions as $permission)
                    <tr>
                        <td><a href="{{ route('future.pages.settings.roles.show', $permission->getKey()) }}">{{ $permission->getKey() }}</a></td>
                        <td><a href="{{ route('future.pages.settings.roles.show', $permission->getKey()) }}">{{ $permission->title }}</a></td>
                        <td><a href="{{ route('future.pages.settings.roles.show', $permission->getKey()) }}">{{ $permission->name }}</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            {{ $permissions->links('future::components.pagination.default') }}
        </div>
    </div>
@endsection
