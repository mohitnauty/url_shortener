<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortUrls extends Model
{
    use HasFactory;

    protected $fillable = ['short_code', 'original_url', 'company_id', 'user_id', 'hits'];

    public static function base62($num)
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = '';

        while ($num > 0) {
            $code = $chars[$num % 62] . $code;
            $num = intdiv($num, 62);
        }

        return $code;
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Companies::class);
    }

    public function checkUrl($shortCode){
        return ShortUrls::where(['short_code' => $shortCode])->first();
    }
}
