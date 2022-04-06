{{ auth()->user() == $activity->user ? 'Вы завершили' : "{$activity->user->name} завершил" }} задачу
"{{ $activity->subject->body }}"
