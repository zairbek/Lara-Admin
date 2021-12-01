@extends('future::layouts.admin')

@section('title', 'Создание доступа')

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
                                  action="{{ route('future.pages.settings.permissions.store') }}"
                                  method="post"
                            >
                                @csrf

                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label">Название доступа</label>
                                    <div class="col-sm-5">
                                        <input type="text" name="title"
                                               class="form-control @error('title') is-invalid @enderror"
                                               placeholder="Название" value="{{ old('title') }}">
                                        @error('title')<span class="error invalid-feedback">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="col-sm-5">
                                        <input type="text" name="name"
                                               class="form-control @error('name') is-invalid @enderror"
                                               placeholder="Код" value="{{ old('name') }}">
                                        @error('name')<span
                                                class="error invalid-feedback">{{ $message }}</span>@enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <a href="{{ route('future.pages.settings.permissions.index') }}"
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
