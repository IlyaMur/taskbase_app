@extends('layouts.app')


@section('content')
    <header class="flex items-center mb-3 py-4">
        <div class="flex justify-between w-full items-end">
            <p class="text-grey text-sm font-normal">
                <a href="/projects" class="text-grey text-sm font-normal no-underline">Мои проекты</a>
                / {{ $project->title }}
            </p>
            <a href="/projects/create" class="button">Новый проект</a>
        </div>
    </header>

    <main>
        <div class="lg:flex -mx-3">
            <div class="lg:w-3/4 px-3 mb-6">
                <div class="mb-8">
                    <h2 class="text-lg text-grey font-normal mb-3">Задачи</h2>
                    @foreach ($project->tasks as $task)
                        <div class="card mb-3">
                            <form method="post" action="{{ $task->path() }}">
                                @method('PATCH')
                                @csrf

                                <div class="flex items-center">
                                    <input class="w-full {{ $task->completed ? 'text-grey' : '' }}" type="text"
                                        name="body" value=" {{ $task['body'] }}">
                                    <input {{ $task->completed ? 'checked' : '' }} type="checkbox" name="completed"
                                        onChange="this.form.submit()">
                                </div>
                            </form>
                        </div>
                    @endforeach

                    <div class="card mb-3">
                        <form action="{{ $project->path() . '/tasks' }}" method="post">
                            @csrf
                            <input name="body" class="w-full" type="text" placeholder="Добавить задачу...">
                        </form>
                    </div>

                </div>
                <div>
                    <h2 class="text-lg text-grey font-normal mb-3">Заметки</h2>
                    <textarea class="card w-full" style="min-height: 200px">{{ $project->description }}</textarea>
                </div>
            </div>

            <div class="lg:w-1/4 px-3">
                <x-card :project="$project" />
            </div>
        </div>
    </main>
@endsection
