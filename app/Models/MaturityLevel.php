<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaturityLevel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'maturity_name',
        'maturity_description',
        'matuirity_level',
    ];

    public function articles()
    {
        return $this->hasMany(ArticleItem::class, 'maturity_id');
    }
}
