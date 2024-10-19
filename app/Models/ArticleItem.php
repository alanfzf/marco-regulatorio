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
        'item_comment',
        'item_evidence',
        'maturity_id',
        'article_id',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function maturity()
    {
        return $this->belongsTo(MaturityLevel::class, 'maturity_id');
    }
}
