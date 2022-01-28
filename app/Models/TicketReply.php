<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketReply extends Model
{
    protected $primaryKey = 'uuid';
    public $incrementing = false;

    use HasFactory;
    use SoftDeletes;

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function repliedUser()
    {
        return $this->belongsTo(User::class, 'replied_user_id');
    }

    public function attachments()
    {
        return $this->hasMany(TicketReplyAttachment::class)
            ->orderBy('created_at', 'desc');
    }
}
