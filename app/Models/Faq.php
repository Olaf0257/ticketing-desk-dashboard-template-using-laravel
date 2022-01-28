<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    use HasFactory;
    protected $fillable = ['category_id','question','answer'];

    public function categories()
    {
        return $this->belongsTo(FaqCategory::class, 'category_id');
    }
}
