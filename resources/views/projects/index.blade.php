@extends('layouts.app')


@section('content')
    <header class="flex items-center mb-3 py-4">
        <div class="flex justify-between w-full items-end">
            <h2 class="text-grey text-sm font-normal">Мои проекты</h2>
            <a href="/projects/create" class="button">Новый проект</a>
        </div>
    </header>

    <main class="lg:flex lg:flex-wrap -mx-3">
        @forelse ($projects as $project)
            <div class="lg:w-1/3 px-3 pb-6">
                <x-card :project="$project" />
            </div>
        @empty
            <div>Проектов пока нет...</div>
        @endforelse
    </main>
@endsection
