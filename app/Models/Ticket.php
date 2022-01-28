<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Ticket extends Model
{
    protected $primaryKey = 'uuid';
    public $incrementing = false;

    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['title', 'message', 'user_id', 'staff_id'];
    protected $casts = [
    'last_touched_at' => 'datetime',
    ];

    public function replies()
    {
        return $this->hasMany(TicketReply::class)
            ->orderBy('created_at', 'desc');
    }

    public function lives()
    {
        return $this->hasMany(TicketStatusLife::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function ticketUser()
    {
        return $this->belongsTo(User::class, 'ticket_user_id');
    }

    public function openedUser()
    {
        return $this->belongsTo(User::class, 'opened_user_id');
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function ticketUrgency()
    {
        return $this->belongsTo(TicketUrgency::class);
    }

    public function ticketStatus()
    {
        return $this->belongsTo(TicketStatus::class);
    }

    public function notes()
    {
        return $this->hasMany(TicketNote::class)
           ->where('note_user_id', auth()->user()->id)
            ->orderBy('created_at', 'desc');
    }

    public function internalNotes()
    {
        return $this->hasMany(TicketInternalNote::class)
            ->orderBy('created_at', 'desc');
    }

    public function attachments()
    {
        return $this->hasMany(TicketAttachment::class)
            ->orderBy('created_at', 'desc');
    }

    public function statusLives()
    {
        return $this->hasMany(TicketStatusLife::class)
            ->orderBy('created_at', 'desc');
    }

    /*
    Check weather the ticket is unread for the logged in person.
    person ccan be a user or staff
     */
    public function getTicketUnreadAttribute()
    {
        if (Auth::user()->role === 'user' && $this->attributes['user_unread']) {
            return true;
        } elseif (Auth::check() && Auth::user()->role === 'staff' && $this->attributes['staff_unread']) {
            return true;
        } else {
            return false;
        }
    }
}
