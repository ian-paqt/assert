<?php

declare(strict_types=1);

namespace PAQT\Assert;

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\EmailValidation;
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

    /** @param null|class-string<EmailValidation> $validation If none specified, FILTER_VALIDATE_EMAIL is used. */
    public static function email($value, $message = '', ?string $validation = null): void
    {
        $message = $message ?: sprintf(
            'Expected a value to be a valid e-mail address. Got: %s',
            self::valueToString($value)
        );
        Assert::string($value, $message);

        if ($validation === null) {
            parent::email($value, $message);
            return;
        }

        $validator = new EmailValidator();

        Assert::true($validator->isValid($value, new $validation()), sprintf($message, self::valueToString($value)));
    }

    /** @param null|class-string<EmailValidation> $validation If none specified, FILTER_VALIDATE_EMAIL is used. */
    public static function nullOrEmail($value, $message = '', ?string $validation = null): void
    {
        null === $value || static::email($value, $message, $validation);
    }

    /** @param null|class-string<EmailValidation> $validation If none specified, FILTER_VALIDATE_EMAIL is used. */
    public static function allEmail($value, $message = '', ?string $validation = null): void
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::email($entry, $message, $validation);
        }
    }

    /** @param null|class-string<EmailValidation> $validation If none specified, FILTER_VALIDATE_EMAIL is used. */

    public static function allNullOrEmail($value, $message = '', ?string $validation = null): void
    {
        static::isIterable($value);

        foreach ($value as $entry) {
            static::nullOrEmail($entry, $message, $validation);
        }
    }
}
