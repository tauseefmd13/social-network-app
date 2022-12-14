<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public const TYPE_POST = 'post';
    public const TYPE_PAGE = 'page';
    public const TYPE_GROUP = 'group';

    public const STATUS_ACTIVE = 'active';
    public const STATUS_DRAFT = 'draft';
    public const STATUS_BANNED = 'banned';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'caption',
        'type',
        'status',
    ];

    public function getCreatedAtAttribute($value)
    {
        return date('Y-m-d H:i:s', strtotime($value));
    }

    public function getUpdatedAtAttribute($value)
    {
        return date('Y-m-d H:i:s', strtotime($value));
    }

    // check if authenticated user has liked this post
    public function scopeHasLiked()
    {
        foreach ($this->likes as $like) {
            if ($like->user_id == auth()->user()->id) {
                return true;
            }
        }
        return false;
    }

    public function scopeIsShared()
    {
        return $this->hasOne(Share::class, 'post_id', 'id') != null;
    }

    public function scopeGetAttribute($query, $key)
    {
        foreach ($this->post_attributes as $attribute) {
            if ($attribute->key == $key) {
                return $attribute->value;
            }
        }
        return '';
    }

    public function shared_post()
    {
        return $this->hasOne(Share::class, 'post_id', 'id');
    }

    // how many shares this post got
    public function shares()
    {
        return $this->hasMany(Share::class, 'shared_post_id', 'id')
            ->orderBy('id', 'DESC');
    }

    // comments on this post
    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id', 'id')
            ->orderBy('id', 'DESC');
    }

    // all people who has liked this post
    public function likes()
    {
        return $this->hasMany(Like::class, 'post_id', 'id');
    }

    // the user this post belongs to
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // all the attachments attached with this post
    public function post_attachments()
    {
        return $this->hasMany(PostAttachment::class, 'post_id', 'id');
    }

    public function post_attributes()
    {
        return $this->hasMany(PostAttribute::class, 'post_id', 'id');
    }
}
