<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LicenseRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'license_id',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function license()
    {
        return $this->belongsTo(License::class);
    }
}