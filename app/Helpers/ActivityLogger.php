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
     * @param string $description Description of the activity
     * @param mixed $model Related model instance
     * @param array $properties Additional properties
     * @return ActivityLog
     */
    public static function log($type, $action, $description, $model = null, $properties = [])
    {
        return ActivityLog::create([
            'type' => $type,
            'action' => $action,
            'description' => $description,
            'user_id' => Auth::id(),
            'model_type' => $model ? get_class($model) : null,
            'model_id' => $model ? $model->id : null,
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
            "Member baru mendaftar: {$member->user->name}",
            $member
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
            ucfirst($type) . " baru dibuat: {$post->title}",
            $post
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
            "{$user->name} login ke sistem",
            $user
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
