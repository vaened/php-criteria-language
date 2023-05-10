<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\CriteriaLanguage\Tests\Keywords;

use Vaened\CriteriaLanguage\Keywords\NotIn;

final class NotInTest extends KeywordTestCase
{
    public function test_not_in_to_anything_valid_satisfactorily(): void
    {
        $this->assertThatKeywordIsCorrect(
            Sentence::create(
                sentence: '![1, 2, A1, B]',
                expected: ['1', '2', 'A1', 'B']
            ),
            NotIn::anything()
        );

        $this->assertThatKeywordIsCorrect(
            Sentence::create(
                sentence: '![1]',
                expected: ['1']
            ),
            NotIn::anything()
        );
    }

    public function test_not_in_to_anything_invalid(): void
    {
        $this->assertThatKeywordIsInvalid('[a, 1]', NotIn::anything());
        $this->assertThatKeywordIsInvalid('[a, 1', NotIn::anything());
        $this->assertThatKeywordIsInvalid('a, 1]', NotIn::anything());
    }

    public function test_not_in_integers_valid_satisfactorily(): void
    {
        $this->assertThatKeywordIsCorrect(
            Sentence::create(
                sentence: '![1, 2, 4]',
                expected: [1, 2, 4]
            ),
            NotIn::integers()
        );
    }

    public function test_not_in_integers_invalid(): void
    {
        $this->assertThatKeywordIsInvalid('[1, 1]', NotIn::integers());
        $this->assertThatKeywordIsInvalid('[a, 1', NotIn::integers());
        $this->assertThatKeywordIsInvalid('a, 1]', NotIn::integers());
        $this->assertThatKeywordIsInvalid('[a]', NotIn::integers());
        $this->assertThatKeywordIsInvalid('[1.8]', NotIn::integers());
    }

    public function test_not_in_numbers_valid_satisfactorily(): void
    {
        $this->assertThatKeywordIsCorrect(
            Sentence::create(
                sentence: '![1, 2, 9.8]',
                expected: [1, 2, 9.8]
            ),
            NotIn::numbers()
        );
    }

    public function test_not_in_numbers_invalid(): void
    {
        $this->assertThatKeywordIsInvalid('[1, 2.2]', NotIn::numbers());
        $this->assertThatKeywordIsInvalid('[a, 1', NotIn::numbers());
        $this->assertThatKeywordIsInvalid('a, 1]', NotIn::numbers());
        $this->assertThatKeywordIsInvalid('[a]', NotIn::numbers());
    }
}
