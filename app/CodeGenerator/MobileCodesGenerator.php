<?php


namespace App\CodeGenerator;

class MobileCodesGenerator
{

    public static function generate()
    {
        return random_int(100000, 999999);
    }
}
