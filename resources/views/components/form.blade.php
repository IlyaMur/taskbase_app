<form class="lg:w-1/2 lg:mx-auto bg-white py-12 px-16 rounded shadow" action="{{ $action }}" method="post">
    <h1 class="text-2xl font-normal mb-10 text-center">{{ $formTitle }}</h1>

    @csrf
    @method($method)

    <div class="field mb-6">
        <label class="label text-sm mb-2 block" for="title">Заголовок</label>

        <div class="control">
            <input type="text" value="{{ $project->title }}"
                class="input bg-transparent border border-grey-light rounded p-2 text-xs w-full" name="title"
                placeholder="Заголовок...">
        </div>
    </div>

    <div class="field mb-6">
        <label class="label text-sm mb-2 block" for="description">Описание</label>

        <div class="control">
            <textarea name="description" rows="10"
                class="textarea bg-transparent border border-grey-light rounded p-2 text-xs w-full"
                placeholder="Описание проекта...">{{ $project->description }}</textarea>
        </div>
    </div>

    <div class="field">
        <div class="control">
            <button type="submit"
                class="text-grey button no-underline bg-blue-400 text-white no-underline rounded-lg shadow-lg text-sm py-2 px-5 is-link mr-2">
                {{ $buttonTitle }}
            </button>
            <a href="{{ $project->path() ?? '' }}">Вернуться</a>
        </div>
    </div>

    @if ($errors->any())
        <div class="field mt-6">
            @foreach ($errors->all() as $error)
                <li class="text-sm text-red">{{ $error }}</li>
            @endforeach
        </div>
    @endif
</form>
