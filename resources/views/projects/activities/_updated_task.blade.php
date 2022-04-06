{{ auth()->user() == $activity->user ? 'Вы обновили' : "{$activity->user->name} обновил" }} задачу
"{{ $activity->subject->body }}"
