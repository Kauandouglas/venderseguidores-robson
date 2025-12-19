<?php

namespace App\Exceptions\Theme;

use Exception;

class ThemeNotFoundException extends Exception
{
    protected $message = 'Theme not found.';
}
