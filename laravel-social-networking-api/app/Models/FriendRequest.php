<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FriendRequest extends Model
{
    use HasFactory;

    public const STATUS_SENT = 'sent';
    public const STATUS_ACCEPTED = 'accepted';
    public const STATUS_DECLINED = 'declined';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'sent_to',
        'status',
    ];

    public function scopeIsSent()
    {
        return $this->status == self::STATUS_SENT;
    }

    public function scopeIsAccepted()
    {
        return $this->status == self::STATUS_ACCEPTED;
    }

    public function scopeIsDeclined()
    {
        return $this->status == self::STATUS_DECLINED;
    }

    public function other_user()
    {
        if ($this->user->id == auth()->user()->id) {
            return $this->sent_to_user();
        }
        
        return $this->user();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function sent_to_user()
    {
        return $this->belongsTo(User::class, 'sent_to', 'id');
    }
}
