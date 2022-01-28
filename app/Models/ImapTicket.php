<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class ImapTicket extends Model
{
    protected $primaryKey = 'uuid';
    public $incrementing = false;

    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['subject', 'message'];
    protected $casts = [
    'last_touched_at' => 'datetime',
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
    
    public function replies()
    {
        return $this->hasMany(ImapReply::class)
            ->orderBy('created_at', 'desc');
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

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function notes()
    {
        return $this->hasMany(ImapTicketNote::class)
           ->where('note_staff_id', auth()->user()->id)
            ->orderBy('created_at', 'desc');
    }

    public function internalNotes()
    {
        return $this->hasMany(ImapTicketInternalNote::class)
            ->orderBy('created_at', 'desc');
    }

    public function attachments()
    {
        return $this->hasMany(ImapTicketAttachment::class)
            ->orderBy('created_at', 'desc');
    }

    public function statusLives()
    {
        return $this->hasMany(ImapTicketStatusLife::class)
            ->orderBy('created_at', 'desc');
    }

    /*
    Check weather the ticket is unread for the logged in person.
    person ccan be a user or staff
     */
    public function getTicketUnreadAttribute()
    {
        if (Auth::check() && Auth::user()->role === 'staff' && $this->attributes['staff_unread']) {
            return true;
        } else {
            return false;
        }
    }
}
