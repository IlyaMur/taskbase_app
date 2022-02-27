<form action="{{ $action }}" method="post">
    @csrf
    @method($method)
    <div class="field">
        <label for="title">Заголовок</label>
        <div class="control">
            <input required type="text" name="title" id="title" value="{{ $project->title }}">
        </div>
    </div>

    <div class="field">
        <label for="description">Описание</label>

        <div class="control">
            <textarea required class="textarea" name="description" id="description" cols="30"
                rows="10">{{ $project->description }}</textarea>
        </div>
    </div>

    <button class="button">{{ $buttonTitle }}</button>
    <a href="{{ $project->path() ?? '' }}">Вернуться</a>
</form>
@if ($errors->any())
    <div class="field mt-6">
        @foreach ($errors->all() as $error)
            <li class="text-sm text-red">{{ $error }}</li>
        @endforeach
    </div>
@endif
