<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class License extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'description', 
        'license_category_id'
    ];

    public function category()
    {
        return $this->belongsTo(LicenseCategory::class, 'license_category_id');
    }

    public function requests()
    {
        return $this->hasMany(LicenseRequest::class, 'license_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_licenses')
                    ->withTimestamps()
                    ->withPivot('assigned_at', 'expires_at');
    }
}
