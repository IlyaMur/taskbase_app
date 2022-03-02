<?php

namespace App\Traits;

use App\Models\Activity;
use Illuminate\Support\Arr;

trait RecordsActivity
{
    public $oldAttributes = [];

    /**
     * Boot the trait.
     */
    public static function bootRecordsActivity()
    {
        $recordableEvents = isset(static::$recordableEvents) ?
            static::$recordableEvents : ['created', 'updated', 'deleted'];

        foreach ($recordableEvents as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($model->activityDescription($event));
            });

            if ($event === 'updated') {
                static::updating(function ($model) {
                    $model->oldAttributes = $model->getOriginal();
                });
            }
        }
    }

    public function activityDescription($description)
    {
        return "{$description}_" . strtolower(class_basename($this));
    }

    public function recordActivity($description)
    {
        $this->activity()->create([
            'description' => $description,
            'changes' => $this->activityChanges(),
            'project_id' => class_basename($this) === 'Project' ? $this->id : $this->project_id
        ]);
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }

    public function activityChanges()
    {
        if (!$this->wasChanged()) {
            return null;
        }

        return [
            'before' => Arr::except(array_diff($this->oldAttributes, $this->getAttributes()), 'updated_at'),
            'after' => Arr::except($this->getChanges(), 'updated_at')
        ];
    }
}
