<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class LicenseCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'description'
    ];

    public function licenses()
    {
        return $this->hasMany(License::class, 'license_category_id');
    }
}
