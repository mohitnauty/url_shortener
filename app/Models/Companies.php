<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];
    public function users()
    {
        return $this->hasMany(User::class, 'company_id');
    }

    public function shortUrls()
    {
        return $this->hasMany(ShortUrls::class, 'company_id');
    }
}
