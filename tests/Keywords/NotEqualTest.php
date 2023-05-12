<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\CriteriaLanguage\Tests\Keywords;

use Vaened\CriteriaLanguage\Keywords\NotEqual;

final class NotEqualTest extends KeywordTestCase
{
    public function test_not_NotEqual_to_anything_valid_satisfactorily(): void
    {
        $this->assertThatKeywordIsCorrect(
            Sentence::create(
                sentence: '!1ad',
                expected: '1ad'
            ),
            NotEqual::anything()
        );
    }

    public function test_not_NotEqual_to_anything_invalid(): void
    {
        $this->assertThatKeywordIsInvalid('a', NotEqual::anything());
        $this->assertThatKeywordIsInvalid('>a', NotEqual::anything());
        $this->assertThatKeywordIsInvalid('>=a', NotEqual::anything());
    }

    public function test_not_NotEqual_to_number_valid_satisfactorily(): void
    {
        $this->assertThatKeywordIsCorrect(
            Sentence::create(
                sentence: '!123',
                expected: 123
            ),
            NotEqual::number()
        );
        $this->assertThatKeywordIsCorrect(
            Sentence::create(
                sentence: '!123.2',
                expected: 123.2
            ),
            NotEqual::number()
        );
    }

    public function test_not_NotEqual_to_number_invalid(): void
    {
        $this->assertThatKeywordIsInvalid('1', NotEqual::number());
        $this->assertThatKeywordIsInvalid('>a', NotEqual::number());
        $this->assertThatKeywordIsInvalid('>=a', NotEqual::number());
    }
}
