<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Type;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['type_id','title', 'slug', 'cover_image', 'description', 'github_link', 'website_link'];

    public static function generateSlug($string)
    {
        return Str::slug($string, '-');
    }
    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class); // THIS PROJECT BELONGS TO A TYPE
    }
    public function technologies(): BelongsToMany
    {
        return $this->belongsToMany(Technology::class);
    }
    
}
