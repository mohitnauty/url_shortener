<?php

namespace App\Services;

class ShortUrlsService
{
    private $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    private $base = 62;

    private $secret = 123457;
    private $offset = 98765;

    public function encode($id)
    {
        $num = ($id * $this->secret) + $this->offset;

        $str = '';
  
        while ($num > 0) {
            $str = $this->chars[$num % $this->base] . $str;
            $num = intdiv($num, $this->base);
        }

        return $str;
    }
}