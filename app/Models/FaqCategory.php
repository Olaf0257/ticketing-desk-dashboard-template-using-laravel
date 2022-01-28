<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqCategory extends Model
{
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    use HasFactory;
    protected $fillable = ['name'];
    
    public function category(){
        
        return $this->hasMany(faq::class);
        }
}
