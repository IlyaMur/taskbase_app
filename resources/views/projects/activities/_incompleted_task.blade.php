{{ auth()->user() == $activity->user ? 'Вы активировали' : "{$activity->user->name} активировал" }} задачу
"{{ $activity->subject->body }}"
