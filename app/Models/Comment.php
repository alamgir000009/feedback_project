<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "feedback_id",
        "comment"
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function feedback() {
        return $this->belongsTo(Feedback::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($comment) {
            
            $mentionedUsers = $comment->mentioned_users;

            $users = User::select('id','email')->whereIn("username", $mentionedUsers)->get();

            foreach ($users as $user) {
                // Here we can send an email/notifications to notify the user.
            }
        });
    }

    public function getMentionedUsersAttribute()
    {
        $pattern = "/\@(\w+)/";
        preg_match_all($pattern, $this->attributes['comment'], $matches);

        return collect($matches[1])->unique();
    }

}
