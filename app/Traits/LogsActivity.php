<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    public static function bootLogsActivity()
    {
        static::created(function ($model) {
            $model->logActivity('created');
        });

        static::updated(function ($model) {
            $model->logActivity('updated');
        });

        static::deleted(function ($model) {
            $model->logActivity('deleted');
        });
    }

    public function activities()
    {
        return $this->morphMany(ActivityLog::class, 'subject');
    }

    public function logActivity($action, $description = null)
    {
        if (!Auth::check()) {
            return;
        }

        $description = $description ?? $this->getActivityDescription($action);

        return ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'description' => $description,
            'subject_type' => get_class($this),
            'subject_id' => $this->id,
            'properties' => $this->getActivityProperties()
        ]);
    }

    protected function getActivityDescription($action): string
    {
        $modelName = class_basename($this);
        return ucfirst($action) . " {$modelName} #{$this->id}";
    }

    protected function getActivityProperties(): array
    {
        return [
            'old' => $this->getOriginal(),
            'attributes' => $this->getAttributes()
        ];
    }
} 