<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    
    use HasFactory;
    
    protected $fillable = ['name', 'tag_color','text_color'];

    public function tickets()
    {
        return $this->belongsToMany(Ticket::class);
    }

    public function imapTickets()
    {
        return $this->belongsToMany(ImapTicket::class);
    }
}
