<?php

declare(strict_types=1);

namespace PAQT\Assert;

use Webmozart\Assert\Assert as WebmozartAssert;

class Assert extends WebmozartAssert
{
    protected static function valueToString($value): string
    {
        if (is_object($value) && enum_exists($value::class)) {
            return $value::class . '::' . $value->name;
        }

        return parent::valueToString($value);
    }
}
