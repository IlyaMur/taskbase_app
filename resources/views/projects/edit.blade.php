@extends('layouts.app')


@section('content')
    <x-form :project="$project" :action="$project->path()" formTitle="Редактировать проект" buttonTitle="Редактировать"
        method="patch" />
@endsection
