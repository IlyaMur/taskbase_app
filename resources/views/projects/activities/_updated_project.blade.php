@if (count($activity->changes['after']) === 1)
    {{ auth()->user()->name }} создал {{ key($activity->changes['after']) }} в проекте
@else
    {{ auth()->user()->name }} обновил {{ key($activity->changes['after']) }} в проекте
@endif
