<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    
    use HasFactory;
    
    protected $fillable = ['subject','message','status','language_id'];
    public function languages(){
    
        return $this->belongsTo(Language::class, 'language_id');
        }
}