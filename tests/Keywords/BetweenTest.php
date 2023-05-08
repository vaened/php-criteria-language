<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\CriteriaLanguage\Tests\Keywords;

use DateTimeImmutable;
use Vaened\CriteriaLanguage\Keywords\Between;

final class BetweenTest extends KeywordTestCase
{
    public function test_between_to_anything_valid_satisfactorily(): void
    {
        $this->assertThatKeywordIsCorrect(
            Sentence::create(
                sentence: '{1, 122}',
                expected: ['1', '122']
            ),
            Between::anything()
        );

        $this->assertThatKeywordIsCorrect(
            Sentence::create(
                sentence: '{ad, 1}',
                expected: ['ad', '1']
            ),
            Between::anything()
        );
    }

    public function test_between_to_anything_invalid(): void
    {
        $this->assertThatKeywordIsInvalid('{a, 1', Between::anything());
        $this->assertThatKeywordIsInvalid('a, 1}', Between::anything());
        $this->assertThatKeywordIsInvalid('{a}', Between::anything());
        $this->assertThatKeywordIsInvalid('{a, 1, }', Between::anything());
        $this->assertThatKeywordIsInvalid('{a, 1, 2}', Between::anything());
    }

    public function test_between_to_numbers_valid_satisfactorily(): void
    {
        $this->assertThatKeywordIsCorrect(
            Sentence::create(
                sentence: '{1, 122}',
                expected: [1, 122]
            ),
            Between::numbers()
        );
    }

    public function test_between_to_numbers_invalid(): void
    {
        $this->assertThatKeywordIsInvalid('{a, 1', Between::anything());
        $this->assertThatKeywordIsInvalid('a, 1}', Between::anything());
        $this->assertThatKeywordIsInvalid('{a}', Between::anything());
        $this->assertThatKeywordIsInvalid('{a, 1, }', Between::anything());
        $this->assertThatKeywordIsInvalid('{a, 1, 2}', Between::anything());
    }

    public function test_between_to_dates_valid_satisfactorily(): void
    {
        $this->assertThatKeywordIsCorrect(
            Sentence::create(
                sentence: '{2022, 2023}',
                expected: [new DateTimeImmutable('2022-01-01'), new DateTimeImmutable('2023-12-31T23:59:59.999999')]
            ),
            Between::dates()
        );

        $this->assertThatKeywordIsCorrect(
            Sentence::create(
                sentence: '{202105, 202201}',
                expected: [new DateTimeImmutable('2021-05-01'), new DateTimeImmutable('2022-01-31T23:59:59.999999')]
            ),
            Between::dates()
        );

        $this->assertThatKeywordIsCorrect(
            Sentence::create(
                sentence: '{20210508, 20220808}',
                expected: [new DateTimeImmutable('2021-05-08'), new DateTimeImmutable('2022-08-08T23:59:59.999999')]
            ),
            Between::dates()
        );

        $this->assertThatKeywordIsCorrect(
            Sentence::create(
                sentence: '{2021, 202208}',
                expected: [new DateTimeImmutable('2021-01-01'), new DateTimeImmutable('2022-08-31T23:59:59.999999')]
            ),
            Between::dates()
        );
    }

    public function test_between_to_dates_invalid(): void
    {
        $this->assertThatKeywordIsInvalid('{a, 1', Between::dates());
        $this->assertThatKeywordIsInvalid('a, 1}', Between::dates());
        $this->assertThatKeywordIsInvalid('{22, 22211}', Between::dates());
        $this->assertThatKeywordIsInvalid('{22, 22}', Between::dates());
        $this->assertThatKeywordIsInvalid('{a}', Between::dates());
        $this->assertThatKeywordIsInvalid('{a, 1, }', Between::dates());
        $this->assertThatKeywordIsInvalid('{a, 1, 2}', Between::dates());
    }
}
