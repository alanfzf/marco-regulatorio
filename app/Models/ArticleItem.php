<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_title',
        'item_description',
        'item_is_informative',
        'item_is_complete',
        'article_id'
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
