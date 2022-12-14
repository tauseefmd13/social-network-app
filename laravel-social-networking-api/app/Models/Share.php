<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    use HasFactory;

    public const TYPE_TIMELINE = 'timeline';
    public const TYPE_PAGE = 'page';
    public const TYPE_GROUP = 'group';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'shared_post_id',
        'post_id',
        'user_id',
        'type',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    public function shared_post()
    {
        return $this->belongsTo(Post::class, 'shared_post_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
