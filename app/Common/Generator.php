<?php

namespace App\Common;

class Generator
{
    public static function guid($prefix = null)
    {
        return strtoupper(md5($prefix . uniqid(rand(), true)));
    }
}