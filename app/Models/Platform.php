<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'type',
        'icon',
        'status',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function posts()
    {
        return $this->belongsToMany(Post::class,'post_platform')
            ->withTimestamps();
    }

    public function setIconAttribute($value)
    {
        if ($value) {
            // Store the image in the 'public/ads' directory
            $imageName = time() . '_' . $value->getClientOriginalName(); // Unique name
            $value->move(public_path('assets/images/platform'), $imageName); // Move to public/ads
            $this->attributes['icon'] = $imageName; // Save the path
        }
    }

    public function getIconAttribute()
    {
        return asset('assets/images/platform/' . $this->attributes['icon']); // Use the public path with the image name
        
    }

    public function scopeActive($query){
        return $query->where('status','active');
    }
} 