<?php

declare(strict_types=1);

namespace PAQT\Assert\Tests;

use Egulias\EmailValidator\Validation\RFCValidation;
use PAQT\Assert\Assert;
use PHPUnit\Framework\TestCase;
use Webmozart\Assert\InvalidArgumentException;

class EmailTest extends TestCase
{
    /** @test */
    public function email_accepts_local_name_of_64_chars(): void
    {
        $this->expectNotToPerformAssertions();

        $email = str_repeat('x', 64) . '@test.com';

        Assert::email($email);
    }

    /** @test */
    public function email_with_rfc_validation_accepts_local_name_of_64_chars(): void
    {
        $this->expectNotToPerformAssertions();

        $email = str_repeat('x', 64) . '@test.com';

        Assert::email($email, validation: RFCValidation::class);
    }

    /** @test */
    public function email_fails_on_local_name_exceeding_64_chars(): void
    {
        $email = str_repeat('x', 65) . '@test.com';
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            sprintf('Expected a value to be a valid e-mail address. Got: "%s"', $email)
        );

        Assert::email($email);
    }

    /** @test */
    public function email_with_rfc_validation_accepts_local_name_of_any_length(): void
    {
        $this->expectNotToPerformAssertions();

        $email = str_repeat('x', 999) . '@domain.com';

        Assert::email($email, validation: RFCValidation::class);
    }

    /** @test */
    public function email_accepts_domain_label_of_64_chars(): void
    {
        $this->expectNotToPerformAssertions();

        $domain = str_repeat('x', 63) . '.domain.com'; // dot is included in domain label count
        $email = 'me@' . $domain;

        Assert::email($email);
    }

    /** @test */
    public function email_with_rfc_validation_accepts_domain_label_of_64_chars(): void
    {
        $this->expectNotToPerformAssertions();

        $domain = str_repeat('x', 63) . '.domain.com';
        $email = 'me@' . $domain;

        Assert::email($email, validation: RFCValidation::class);
    }

    /** @test */
    public function email_fails_on_domain_label_exceeding_64_chars(): void
    {
        $domain = str_repeat('x', 64) . '.domain.com';
        $email = 'me@' . $domain;

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            sprintf('Expected a value to be a valid e-mail address. Got: "%s"', $email)
        );

        Assert::email($email);
    }

    /** @test */
    public function email_with_rfc_validation_fails_on_domain_label_exceeding_64_chars(): void
    {
        $domain = str_repeat('x', 65) . '.domain.com';

        $email = 'me@' . $domain;

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            sprintf('Expected a value to be a valid e-mail address. Got: "%s"', $email)
        );

        Assert::email($email, validation: RFCValidation::class);
    }

    /** @test */
    public function email_fails_on_domain_exceeding_255_chars(): void
    {
        $label = str_repeat('x', 62);
        $domain = str_repeat($label . '.', 4) . '.com';
        $this->assertEquals(256, strlen($domain));

        $email = 'me@' . $domain;

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            sprintf('Expected a value to be a valid e-mail address. Got: "%s"', $email)
        );

        Assert::email($email);
    }

    /** @test */
    public function email_with_rfc_validation_fails_on_domain_exceeding_255_chars(): void
    {
        $label = str_repeat('x', 62);
        $domain = str_repeat($label . '.', 4) . '.com';

        $this->assertEquals(256, strlen($domain));

        $email = 'me@' . $domain;

        $this->expectExceptionMessage(
            sprintf('Expected a value to be a valid e-mail address. Got: "%s"', $email)
        );

        Assert::email($email, validation: RFCValidation::class);
    }

    /** @test */
    public function email_fails_on_email_without_top_level_domain(): void
    {
        $emailWithoutTopLevelDomain = 'me@localhost';
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            sprintf('Expected a value to be a valid e-mail address. Got: "%s"', $emailWithoutTopLevelDomain)
        );

        Assert::email($emailWithoutTopLevelDomain);
    }

    /** @test */
    public function email_with_rfc_validation_accepts_email_without_top_level_domain(): void
    {
        $this->expectNotToPerformAssertions();
        $emailWithoutTopLevelDomain = 'to@localhost';
        Assert::email($emailWithoutTopLevelDomain, validation: RFCValidation::class);
    }

    /** @test */
    public function email_fails_on_non_string(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected a value to be a valid e-mail address. Got: null');

        Assert::email(null);
    }

    /** @test */
    public function email_with_custom_validation_fails_on_non_string(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected a value to be a valid e-mail address. Got: null');

        Assert::email(null, validation: RFCValidation::class);
    }

    /** @test */
    public function null_or_email_fails_on_failing_default_validation()
    {
        $validEmail = 'me@domain.com';
        $invalidEmail = 'me@localhost';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            sprintf('Expected a value to be a valid e-mail address. Got: "%s"', $invalidEmail)
        );

        Assert::nullOrEmail(null);
        Assert::nullOrEmail($validEmail);
        Assert::nullOrEmail($invalidEmail);
    }

    /** @test */
    public function all_email_fails_on_first_failing_default_validation()
    {
        $validEmail = 'me@domain.com';
        $tooLongDomainLabel = str_repeat('x', 62);
        $domain = str_repeat($tooLongDomainLabel . '.', 4) . '.com';
        $this->assertEquals(256, strlen($domain));

        $invalidEmail = 'me@' . $domain;

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            sprintf('Expected a value to be a valid e-mail address. Got: "%s"', $invalidEmail)
        );

        Assert::allEmail([$validEmail, $invalidEmail], validation: RFCValidation::class);
    }

    /** @test */
    public function all_email_with_custom_validation_fails_on_first_failing_provided_validation()
    {
        $validEmails = ['me@domain.com', 'me@localhost'];

        $tooLongDomainLabel = str_repeat('x', 62);
        $domain = str_repeat($tooLongDomainLabel . '.', 4) . '.com';
        $this->assertEquals(256, strlen($domain));

        $invalidEmail = 'me@' . $domain;

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            sprintf('Expected a value to be a valid e-mail address. Got: "%s"', $invalidEmail)
        );

        Assert::allEmail([...$validEmails, $invalidEmail], validation: RFCValidation::class);
    }

    /** @test */
    public function all_null_or_email_fails_on_first_failing_default_validation()
    {
        $validValues = [null, 'me@domain.com'];
        $invalidEmail = 'me@localhost';

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            sprintf('Expected a value to be a valid e-mail address. Got: "%s"', $invalidEmail)
        );

        Assert::allNullOrEmail([...$validValues, $invalidEmail]);
    }

    /** @test */
    public function all_null_or_email_with_custom_validation_fails_on_first_failing_provided_validation()
    {
        $validValues = [null, 'me@domain.com', 'me@localhost'];

        $tooLongDomainLabel = str_repeat('x', 62);
        $domain = str_repeat($tooLongDomainLabel . '.', 4) . '.com';
        $this->assertEquals(256, strlen($domain));

        $invalidEmail = 'me@' . $domain;

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            sprintf('Expected a value to be a valid e-mail address. Got: "%s"', $invalidEmail)
        );

        Assert::allNullOrEmail([...$validValues, $invalidEmail], validation: RFCValidation::class);
    }
}
