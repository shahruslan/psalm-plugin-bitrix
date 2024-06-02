<?php

declare(strict_types=1);

namespace Shahruslan\PsalmPluginBitrix;

use Bitrix\Main\Loader;

class CustomLoader extends Loader
{
    public static function getClasses()
    {
        return self::$autoLoadClasses;
    }
}
