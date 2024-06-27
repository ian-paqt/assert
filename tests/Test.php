<?php

declare(strict_types=1);

namespace Ians\Assert\Tests;

use BackedEnum;
use Ians\Assert\Assert;
use PHPUnit\Framework\TestCase;
use Webmozart\Assert\InvalidArgumentException;

class Test extends TestCase
{

    /**
     * @test
     * @dataProvider backedEnumProvider
     */
    public function it_shows_the_compared_cases_for_backed_enums(
        string $methodName,
        string $expectedMessage,
        BackedEnum $value,
        BackedEnum $expectation
    ): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($expectedMessage);
        Assert::$methodName($value, $expectation);
    }

    public static function backedEnumProvider(): array
    {
        return [
            'Equals' => [
                'methodName'      => 'eq',
                'expectedMessage' => 'Expected a value equal to Ians\Assert\Tests\TestBackedEnum::SecondCase. '
                    . 'Got: Ians\Assert\Tests\TestBackedEnum::FirstCase',
                'value'           => TestBackedEnum::FirstCase,
                'expectation'     => TestBackedEnum::SecondCase,
            ],
            'Not equals' => [
                'methodName'      => 'notEq',
                'expectedMessage' => 'Expected a different value than Ians\Assert\Tests\TestBackedEnum::FirstCase.',
                'value'           => TestBackedEnum::FirstCase,
                'expectation'     => TestBackedEnum::FirstCase,
            ]
        ];
    }

    /**
     * @test
     * @dataProvider enumProvider
     */
    public function it_shows_the_compared_cases_for_enums(
        string $methodName,
        string $expectedMessage,
        TestEnum $value,
        TestEnum $expectation
    ): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($expectedMessage);
        Assert::$methodName($value, $expectation);
    }

    public static function enumProvider(): array
    {
        return [
            'Equals' => [
                'methodName'      => 'eq',
                'expectedMessage' => 'Expected a value equal to Ians\Assert\Tests\TestEnum::SecondCase. '
                    . 'Got: Ians\Assert\Tests\TestEnum::FirstCase',
                'value'           => TestEnum::FirstCase,
                'expectation'     => TestEnum::SecondCase,
            ],
            'Not equals' => [
                'methodName'      => 'notEq',
                'expectedMessage' => 'Expected a different value than Ians\Assert\Tests\TestEnum::FirstCase.',
                'value'           => TestEnum::FirstCase,
                'expectation'     => TestEnum::FirstCase,
            ]
        ];
    }
}
