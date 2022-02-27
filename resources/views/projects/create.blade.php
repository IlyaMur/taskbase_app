@extends('layouts.app')

@section('content')
    <h1>Create a Project</h1>
    <x-form :project="$project" action="/projects/" buttonTitle="Создать проект" method="post" />
@endsection
