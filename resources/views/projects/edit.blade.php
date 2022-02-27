@extends('layouts.app')


@section('content')
    <h1>Редактировать проект</h1>

    <form action="{{ $project->path() }}" method="post">
        @csrf
        @method('path')
        <div class="field">
            <label for="title">Заголовок</label>
            <div class="control">
                <input type="text" name="title" id="title" value="{{ $project->title }}">
            </div>
        </div>

        <div class="field">
            <label for="description">Описание</label>

            <div class="control">
                <textarea class="textarea" name="description" id="description" cols="30"
                    rows="10">{{ $project->description }}</textarea>
            </div>
        </div>

        <button class="button">Редактировать проект</button>
        <a href="{{ $project->path() }}">Вернуться</a>
    </form>
@endsection
