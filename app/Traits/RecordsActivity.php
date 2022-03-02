<?php

namespace App\Traits;

use Illuminate\Support\Arr;

trait RecordsActivity
{
    public function recordActivity($description)
    {
        $this->activity()->create([
            'description' => $description,
            'changes' => $this->activityChanges(),
            'project_id' => class_basename($this) === 'Project' ? $this->id : $this->project_id
        ]);
    }

    public function activityChanges()
    {
        if (!$this->wasChanged()) {
            return null;
        }

        return [
            'before' => Arr::except(array_diff($this->old, $this->getAttributes()), 'updated_at'),
            'after' => Arr::except($this->getChanges(), 'updated_at')
        ];
    }
}
