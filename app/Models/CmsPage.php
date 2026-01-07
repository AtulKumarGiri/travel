<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CmsPage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title','slug','content','image',
        'meta_title','meta_description','meta_keywords',
        'status','published_at','expires_at',
        'visibility','allowed_roles',
        'parent_id','menu_order','show_in_menu',
        'template','created_by','updated_by'
    ];

    protected $casts = [
        'allowed_roles' => 'array',
        'published_at'  => 'datetime',
        'expires_at'    => 'datetime',
        'show_in_menu'  => 'boolean',
    ];
}
