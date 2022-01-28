<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KbCategory extends Model
{
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    use HasFactory;
    protected $fillable = ['name','icon','description'];
    
    public function category(){
        
        return $this->hasMany(kb_article::class);
        }
}
