@extends('layouts.app')

@section('content')
    <x-form :project="$project" action="/projects/" formTitle="Создать проект" buttonTitle="Создать" method="post" />
@endsection
