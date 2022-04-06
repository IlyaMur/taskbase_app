{{ auth()->user() == $activity->user ? 'Вы создали' : "{$activity->user->name} создал" }} проект
