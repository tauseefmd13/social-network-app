<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public const ROLE_ADMIN = 1;
    public const ROLE_USER = 2;

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'phone',
        'profile_image',
        'cover_photo',
        'gender',
        'dob',
        'about_me',
        'device_name',
        'device_token',
        'provider_name',
        'provider_id',
        'status',
        'country_id',
        'state_id',
        'city_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getProfileImageAttribute($value)
    {
        if (Storage::exists($value)) {
            return asset('public/' . Storage::url($value));
        } else {
            return asset('/public/assets/img/default_profile.jpg');
        }
    }

    public function getCoverPhotoAttribute($value)
    {
        if (Storage::exists($value)) {
            return asset('public/' . Storage::url($value));
        } else {
            return asset('/public/assets/img/default_cover.jpg');
        }
    }

    public function scopeIsAdmin()
    {
        return $this->role_id == self::ROLE_ADMIN;
    }

    public function scopeIsFriendRequestSentOrReceived($query, $user_id)
    {
        foreach ($this->friend_requests() as $friend_request) {
            if ($friend_request->sent_to == $user_id || $friend_request->user_id == $user_id) {
                return true;
            }
        }
        return false;
    }

    public function scopeIsFriendRequestSent($query, $user_id)
    {
        foreach ($this->friend_requests_sent as $friend_request) {
            if ($friend_request->sent_to == $user_id) {
                return true;
            }
        }
        return false;
    }

    public function scopeIsFriend($query, $user_id)
    {
        foreach ($this->friends() as $friend) {
            if ($friend->other_user->id == $user_id) {
                return true;
            }
        }
        return false;
    }

    public function scopeFriends()
    {
        return $this->friend_requests()->where('status', '=', \App\Models\FriendRequest::STATUS_ACCEPTED);
    }

    public function scopeGetUnreadTickets()
    {
        $responses = 0;
        foreach ($this->tickets as $ticket) {
            $responses += $ticket->unread_responses()->count();
        }
        return $responses;
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id', 'id')
            ->where('status', '=', \App\Models\Post::STATUS_ACTIVE);
    }

    public function friend_requests()
    {
        return $this->friend_requests_sent->merge($this->friend_requests_received);
    }

    public function friend_requests_sent()
    {
        return $this->hasMany(FriendRequest::class, 'user_id', 'id');
    }

    public function friend_requests_received()
    {
        return $this->hasMany(FriendRequest::class, 'sent_to', 'id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
    
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'user_id', 'id')
            ->orderBy('id', 'DESC');
    }
}
