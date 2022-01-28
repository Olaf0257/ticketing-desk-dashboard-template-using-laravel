<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    use HasFactory;

    protected $fillable = ['name', 'status', 'description', 'role'];
}
