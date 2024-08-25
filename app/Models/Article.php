<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;


    protected $fillable = [
        'article_name',
        'law_id'
    ];


    public function law()
    {
        return $this->belongsTo(Law::class);
    }

    public function items()
    {
        return $this->hasMany(ArticleItem::class);
    }
}
