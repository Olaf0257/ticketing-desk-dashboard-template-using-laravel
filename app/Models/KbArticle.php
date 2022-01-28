<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KbArticle extends Model
{
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    use HasFactory;
    protected $fillable = ['category_id','title','status','description','page_title', 'meta_description', 'meta_keyword', 'slug'];

    public function categories()
    {
        return $this->belongsTo(KbCategory::class, 'category_id');
    }
}
