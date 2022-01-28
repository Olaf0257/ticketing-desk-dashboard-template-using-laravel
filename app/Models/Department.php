<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Encryptable;

class Department extends Model
{
    use HasFactory;
    use Encryptable;

    protected $fillable = [
        'name', 'description', 'email', 'host',
        'port', 'login', 'password', 'flags',
        'mail_box', 'smtp_port', 'smtp_host', 'smtp_password', 'smtp_encryption'
    ];

    protected $encryptable = [
        'host', 'port', 'password', 'smtp_host',
        'smtp_port', 'smtp_password'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
