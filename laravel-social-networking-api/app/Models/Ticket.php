<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Ticket extends Model
{
    use HasFactory;

    public const STATUS_OPEN = 'open';
    public const STATUS_CLOSED = 'closed';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'attachment',
        'status',
    ];

    public function getAttachmentAttribute($value)
    {
        return Storage::exists($value) ? asset('public/' . Storage::url($value)) : '';
    }

    public function unread_responses()
    {
        return $this->responses()->where('is_read', '=', \App\Models\TicketResponse::UNREAD_TICKET);
    }

    public function responses()
    {
        return $this->hasMany(TicketResponse::class, 'ticket_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
