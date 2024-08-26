<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'article_name',
        'article_description',
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
