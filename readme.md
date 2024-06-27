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

Then you can install the `ians/assert` Composer dependency to your project:
```bash
composer require ians/assert
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

