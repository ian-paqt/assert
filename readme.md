# Assert
Basically [webmozart/assert](https://github.com/webmozarts/assert) but with some improvements

## Installation

To get started, you should add the the repo as a valid repository to your `composer.json`
```
"repositories": [
    {
        "type": "vcs",
        "url": "git@github.com:ian-paqt/assert.git"
    }
]
```

Then you can install the `paqtcom/assert` Composer dependency to your project:
```bash
composer require paqtcom/assert
```

## Usage

See [webmozart/assert](https://github.com/webmozarts/assert) documentation about how to use Assertions.

## Improvements

#### Enums

When comparing Enums the case you try to Assert is also displayed in the Exception message.
So instead of:

```
Expected a value equal to Ians\Assert\Tests\TestEnum. Got: Ians\Assert\Tests\TestEnum
```

It tells us:

```
Expected a value equal to Ians\Assert\Tests\TestEnum::SecondCase. Got: Ians\Assert\Tests\TestEnum::FirstCase
```

#### Custom email validation

Default email assertions use PHP's `filter_var()` with `FILTER_VALIDATE_EMAIL`.


All email assertions have an optional `$validation` argument to supply an alternative validation.
All validations must be an implementation of the interface `Egulias\EmailValidator\Validation`.

The Composer package [egulias/email-validator](https://github.com/egulias/EmailValidator) is used for this.

Laravel uses this same package for email validation, its default email validator is `RFCValidation`, which allows for more formats than  `FILTER_VALIDATE_EMAIL`.


This applies to these methods
- `Assert::email`
- `Assert::nullOrEmail`
- `Assert::allEmail`
- `Assert::allNullOrEmail`


Regular email assertion:

```php
use Egulias\EmailValidator\Validation\RFCValidation;
use PAQT\Assert\Assert;

Assert::email('me@localhost'); // will throw an InvalidArgumentException due to missing top level domain
```

Custom validation email assertion:

```php
use Egulias\EmailValidator\Validation\RFCValidation;
use PAQT\Assert\Assert;

Assert::email('me@localhost', validation: RFCValidation::class); // will not throw an exception
```
