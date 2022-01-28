<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class ImapReply extends Model
{
    protected $primaryKey = 'uuid';
    public $incrementing = false;

    use HasFactory;
    use SoftDeletes;

    public function ticket()
    {
        return $this->belongsTo(ImapTicket::class, 'imap_ticket_uuid');
    }

    public function repliedUser()
    {
        return $this->belongsTo(User::class, 'replied_staff_id');
    }

    public function attachments()
    {
        return $this->hasMany(ImapReplyAttachment::class)
            ->orderBy('created_at', 'desc');
    }
}
