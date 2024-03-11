<?php 

// app/Helpers/RutHelper.php

namespace App\Helpers;

use Nkey\Rut\Rut;

class RutHelper
{
    public static function format($rut)
    {
        return Rut::parse($rut)->format();
    }
}
