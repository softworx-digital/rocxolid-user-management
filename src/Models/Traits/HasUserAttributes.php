<?php

namespace Softworx\RocXolid\UserManagement\Models\Traits;

use Auth;
use Softworx\RocXolid\UserManagement\Models\User;

trait HasUserAttributes
{
    protected static $user_attributes = [
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public static function boot()
    {
        parent::boot();

        if ($user = Auth::guard('rocXolid')->user()) {
            static::creating(function ($model) use ($user) {
                if (in_array('created_by', $model::$user_attributes)) {
                    $model->created_by = $user->getKey();
                }

                if (in_array('updated_by', $model::$user_attributes)) {
                    $model->updated_by = $user->getKey();
                }
            });

            static::updating(function ($model) use ($user) {
                if (in_array('updated_by', $model::$user_attributes)) {
                    $model->created_by = $user->getKey();
                }
            });

            static::deleting(function ($model) use ($user) {
                if (in_array('deleted_by', $model::$user_attributes)) {
                    $model->deleted_by = $user->getKey();
                    $model->save();
                }
            });
        }
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
