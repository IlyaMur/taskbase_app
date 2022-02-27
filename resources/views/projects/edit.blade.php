@extends('layouts.app')


@section('content')
    <h1>Редактировать проект</h1>
    <x-form :project="$project" :action="$project->path()" buttonTitle="Редактировать проект" method="patch" />
@endsection
