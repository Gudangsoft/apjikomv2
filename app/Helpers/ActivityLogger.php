<?php

namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    /**
     * Log an activity
     *
     * @param string $type Type of activity (registration, post, login, etc)
     * @param string $action Action performed (created, updated, deleted, etc)
     * @param mixed $model Related model instance or model class name string
     * @param string $description Description of the activity
     * @param array $properties Additional properties
     * @return ActivityLog
     */
    public static function log($type, $action, $model = null, $description = null, $properties = [])
    {
        // Handle if model is a string (class name) or object
        $modelType = null;
        $modelId = null;
        
        if ($model) {
            if (is_string($model)) {
                // If model is a string, use it as model_type
                $modelType = $model;
            } elseif (is_object($model)) {
                // If model is an object, get its class and id
                $modelType = get_class($model);
                $modelId = $model->id ?? null;
            }
        }
        
        return ActivityLog::create([
            'type' => $type,
            'action' => $action,
            'description' => $description,
            'user_id' => Auth::id(),
            'model_type' => $modelType,
            'model_id' => $modelId,
            'properties' => $properties,
        ]);
    }

    /**
     * Log registration activity
     */
    public static function logRegistration($member)
    {
        return self::log(
            'registration',
            'created',
            $member,
            "Member baru mendaftar: {$member->user->name}"
        );
    }

    /**
     * Log post creation
     */
    public static function logPost($post, $type = 'news')
    {
        return self::log(
            'post',
            'created',
            $post,
            ucfirst($type) . " baru dibuat: {$post->title}"
        );
    }

    /**
     * Log login
     */
    public static function logLogin($user)
    {
        return self::log(
            'auth',
            'login',
            $user,
            "{$user->name} login ke sistem"
        );
    }

    /**
     * Log logout
     */
    public static function logLogout($user)
    {
        return self::log(
            'auth',
            'logout',
            "{$user->name} logout dari sistem",
            $user
        );
    }
}
