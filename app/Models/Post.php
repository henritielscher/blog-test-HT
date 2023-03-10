<?php

namespace App\Models;

use App\Notifications\PostCreated;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;

class Post extends Model
{
    protected $fillable = [
        'title',
        'body',
        'user_id',
        'category_id',
        'is_published',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(
            function ($post) {
                if (is_null($post->user_id)) {
                    $post->user_id = auth()->user()->id;
                }
            }
        );

        static::updating(function ($post) {
            if (is_null($post->user_id)) {
                $post->user_id = auth()->user()->id;
            }
        });

        static::deleting(
            function ($post) {
                $post->comments()->delete();
                $post->tags()->detach();
            }
        );

        static::created(function (Post $post) {
            /** @var User|null */
            $admin = User::all()->where("is_admin", "=", 1)->first();

            if (!$admin) {
                return;
            }

            Notification::send($admin, new PostCreated($post));
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeDrafted($query)
    {
        return $query->where('is_published', false);
    }

    public function getPublishedAttribute()
    {
        return ($this->is_published) ? 'Yes' : 'No';
    }
}
