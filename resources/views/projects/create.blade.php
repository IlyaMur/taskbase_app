@extends('layouts.app')


@section('content')
    <h1>Create a Project</h1>

    <form action="/projects" method="post">
        @csrf
        <div class="field">
            <label for="title">Title</label>
            <div class="control"><input type="text" name="title" id="title"></div>
        </div>

        <div class="field">
            <label for="description">Description</label>

            <div class="control">
                <textarea class="textarea" name="description" id="description" cols="30" rows="10"></textarea>
            </div>
        </div>

        <button>Create a project</button>
        <a href="/projects">Cancel</a>
    </form>
@endsection
