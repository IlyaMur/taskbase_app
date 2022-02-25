@extends('layouts.app')


@section('content')
    <header class="flex items-center mb-3 py-4">
        <div class="flex justify-between w-full items-end">
            <p class="text-grey text-sm font-normal">
                <a href="/projects" class="text-grey text-sm font-normal no-underline">My projects</a>
                / {{ $project->title }}
            </p>
            <a href="/projects/create" class="button">New project</a>
        </div>
    </header>

    <main>
        <div class="lg:flex -mx-3">
            <div class="lg:w-3/4 px-3 mb-6">
                <div class="mb-8">
                    <h2 class="text-lg text-grey font-normal mb-3">Tasks</h2>
                    @foreach ($project->tasks as $task)
                        <div class="card mb-3">
                            {{ $task['body'] }}
                        </div>
                    @endforeach

                    <div class="card mb-3">
                        <form action="{{ $project->path() . '/tasks' }}" method="post">
                            @csrf
                            <input name="body" class="w-full" type="text" placeholder="Begin adding tasks...">
                        </form>
                    </div>

                </div>
                <div>
                    <h2 class="text-lg text-grey font-normal mb-3">General Notes</h2>
                    <textarea class="card w-full" style="min-height: 200px">{{ $project->description }}</textarea>
                </div>
            </div>

            <div class="lg:w-1/4 px-3">
                <x-card :project="$project" />
            </div>
        </div>
    </main>
@endsection
