<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\CriteriaLanguage\Tests\Keywords;

use Vaened\CriteriaLanguage\Keywords\Equal;

final class EqualTest extends KeywordTestCase
{
    public function test_equal_to_anything_valid_satisfactorily(): void
    {
        $this->assertThatKeywordIsCorrect(
            Sentence::create(
                sentence: '1ad',
                expected: '1ad'
            ),
            Equal::anything()
        );
    }

    public function test_equal_to_anything_invalid(): void
    {
        $this->assertThatKeywordIsInvalid('!a', Equal::anything());
        $this->assertThatKeywordIsInvalid('>a', Equal::anything());
        $this->assertThatKeywordIsInvalid('>=a', Equal::anything());
    }

    public function test_equal_to_number_valid_satisfactorily(): void
    {
        $this->assertThatKeywordIsCorrect(
            Sentence::create(
                sentence: '123',
                expected: 123
            ),
            Equal::number()
        );
    }

    public function test_equal_to_number_invalid(): void
    {
        $this->assertThatKeywordIsInvalid('!1', Equal::number());
        $this->assertThatKeywordIsInvalid('>a', Equal::number());
        $this->assertThatKeywordIsInvalid('>=a', Equal::number());
    }
}
