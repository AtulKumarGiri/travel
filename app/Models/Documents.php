<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class Documents extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'type',
        'is_private',
        'shared_with',
        'created_by',
        'updated_by',
        'status',
    ];

    protected $casts = [
        'shared_with' => 'array', 
    ];
    
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    
    public function scopeVisibleTo($query, $userId)
    {
        return $query->where(function($q) use ($userId) {
            $q->where('privacy', 'private')->where('created_by', $userId)
              ->orWhereJsonContains('shared_with', $userId);
        });
    }
    
    protected static function booted()
    {
        static::creating(function ($document) {
            if (Auth::check()) {
                $document->created_by = Auth::id();
            }
        });
    }
}
