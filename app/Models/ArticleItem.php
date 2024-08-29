<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'item_title',
        'item_description',
        'item_is_informative',
        'item_is_complete',
        'item_comment',
        'article_id',
        'maturity_level_id'
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function maturity()
    {
        return $this->belongsTo(Maturity::class, 'maturity_level_id');
    }
}
