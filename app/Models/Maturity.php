<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Maturity extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'matuirity_name',
        'maturity_description',
        'matuirity_level',
    ];

    public function articles()
    {
        return $this->hasMany(ArticleItem::class, 'maturity_level_id');
    }
}
