<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActivityLog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'loggable_type',
        'loggable_id',
        'action',
        'description',
        'user_id',
        'user_type',
        'ip_address',
        'user_agent',
        'previous_data',
        'updated_data',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'previous_data' => 'array',
        'updated_data' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that performed the action.
     */
    public function user(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the related model.
     */
    public function loggable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Scope a query to only include library activities.
     */
    public function scopeLibraryActivities($query)
    {
        return $query->where('loggable_type', 'like', '%Book%')
                    ->orWhere('loggable_type', 'like', '%Library%')
                    ->orWhere('loggable_type', 'like', '%Category%');
    }

    /**
     * Scope a query to only include activities for a specific model.
     */
    public function scopeForModel($query, $model)
    {
        return $query->where('loggable_type', get_class($model))
                    ->where('loggable_id', $model->id);
    }

    /**
     * Scope a query to only include activities by a specific user.
     */
    public function scopeByUser($query, $user)
    {
        return $query->where('user_type', get_class($user))
                    ->where('user_id', $user->id);
    }

    /**
     * Get the activity description with timestamp.
     */
    public function getDescriptionWithDateAttribute(): string
    {
        return "[" . $this->created_at->format('M j, Y g:i A') . "] " . $this->description;
    }

    /**
     * Log a new activity.
     */
    public static function logActivity($loggable, $action, $description, $user = null, $previousData = null, $updatedData = null): ActivityLog
    {
        $user = $user ?? \Illuminate\Support\Facades\Auth::user();

        return self::create([
            'loggable_type' => get_class($loggable),
            'loggable_id' => $loggable->id,
            'action' => $action,
            'description' => $description,
            'user_id' => $user ? $user->id : null,
            'user_type' => $user ? get_class($user) : null,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'previous_data' => $previousData,
            'updated_data' => $updatedData,
        ]);
    }
}