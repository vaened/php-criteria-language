<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\CriteriaLanguage\Tests\Keywords;

use Vaened\CriteriaLanguage\Keywords\In;

final class InTest extends KeywordTestCase
{
    public function test_in_to_anything_valid_satisfactorily(): void
    {
        $this->assertThatKeywordIsCorrect(
            Sentence::create(
                sentence: '[1, 2, A1, B]',
                expected: ['1', '2', 'A1', 'B']
            ),
            In::anything()
        );

        $this->assertThatKeywordIsCorrect(
            Sentence::create(
                sentence: '[1]',
                expected: ['1']
            ),
            In::anything()
        );
    }

    public function test_in_to_anything_invalid(): void
    {
        $this->assertThatKeywordIsInvalid('[a, 1', In::anything());
        $this->assertThatKeywordIsInvalid('a, 1]', In::anything());
    }

    public function test_in_integers_valid_satisfactorily(): void
    {
        $this->assertThatKeywordIsCorrect(
            Sentence::create(
                sentence: '[1, 2, 4]',
                expected: [1, 2, 4]
            ),
            In::integers()
        );
    }

    public function test_in_integers_invalid(): void
    {
        $this->assertThatKeywordIsInvalid('[a, 1', In::integers());
        $this->assertThatKeywordIsInvalid('a, 1]', In::integers());
        $this->assertThatKeywordIsInvalid('[a]', In::integers());
        $this->assertThatKeywordIsInvalid('[1.8]', In::integers());
    }

    public function test_in_numbers_valid_satisfactorily(): void
    {
        $this->assertThatKeywordIsCorrect(
            Sentence::create(
                sentence: '[1, 2, 9.8]',
                expected: [1, 2, 9.8]
            ),
            In::numbers()
        );
    }

    public function test_in_numbers_invalid(): void
    {
        $this->assertThatKeywordIsInvalid('[a, 1', In::numbers());
        $this->assertThatKeywordIsInvalid('a, 1]', In::numbers());
        $this->assertThatKeywordIsInvalid('[a]', In::numbers());
    }
}
