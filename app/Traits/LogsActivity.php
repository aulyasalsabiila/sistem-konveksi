<?php

namespace App\Traits;

use App\Models\ActivityLog;

trait LogsActivity
{
    public static function logActivity($action, $model, $modelId, $description, $changes = null)
    {
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'model' => $model,
            'model_id' => $modelId,
            'description' => $description,
            'changes' => $changes,
            'ip_address' => request()->ip()
        ]);
    }
}