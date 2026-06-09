<?php

namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogger
{
    public static function log($type, $action, $model = null, $description = null, $properties = [])
    {
        $modelType = null;
        $modelId   = null;

        if ($model) {
            if (is_string($model)) {
                $modelType = $model;
            } elseif (is_object($model)) {
                $modelType = get_class($model);
                $modelId   = $model->id ?? null;
            }
        }

        return ActivityLog::create([
            'type'        => $type,
            'action'      => $action,
            'description' => $description,
            'user_id'     => Auth::id(),
            'model_type'  => $modelType,
            'model_id'    => $modelId,
            'properties'  => $properties,
        ]);
    }

    public static function logLogin($user)
    {
        return self::log('auth', 'login', $user,
            "{$user->name} login ke sistem",
            ['ip' => Request::ip(), 'user_agent' => Request::userAgent(), 'role' => $user->role]
        );
    }

    public static function logLogout($user)
    {
        return self::log('auth', 'logout', $user,
            "{$user->name} logout dari sistem",
            ['ip' => Request::ip()]
        );
    }

    public static function logRegistration($member)
    {
        $name = optional($member->user)->name ?? $member->full_name ?? 'Unknown';
        return self::log('registration', 'created', $member, "Member baru mendaftar: {$name}");
    }

    public static function logPost($post, $type = 'news')
    {
        return self::log('post', 'created', $post, ucfirst($type) . " baru dibuat: {$post->title}");
    }

    public static function logCreate($type, $model, $label)
    {
        return self::log($type, 'created', $model, "Tambah {$label}: {$label}");
    }

    public static function logUpdate($type, $model, $label)
    {
        return self::log($type, 'updated', $model, "Update {$label}");
    }

    public static function logDelete($type, $label)
    {
        return self::log($type, 'deleted', null, "Hapus {$label}");
    }
}
