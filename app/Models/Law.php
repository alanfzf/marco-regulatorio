<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Law extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'law_name',
        'law_description',
        'law_publish_date',
        'law_url_reference',
        'law_image',
    ];

    public function managers()
    {
        return $this->belongsToMany(User::class, 'law_managers')
            ->using(LawManager::class)->withTimestamps();
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function items()
    {
        return $this->hasManyThrough(ArticleItem::class, Article::class);
    }
}
