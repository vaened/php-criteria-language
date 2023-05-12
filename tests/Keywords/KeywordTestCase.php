<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\CriteriaLanguage\Tests\Keywords;

use Vaened\CriteriaLanguage\Keyword;
use Vaened\CriteriaLanguage\Tests\TestCase;

use function gettype;

abstract class KeywordTestCase extends TestCase
{
    public function assertThatKeywordIsCorrect(Sentence $sentence, Keyword $keyword): void
    {
        $expected  = $sentence->expected();
        $formatted = $keyword->format($sentence->sentence());

        $this->assertTrue($keyword->canApplyFor($sentence->sentence()));
        $this->assertEquals(gettype($expected), gettype($formatted));
        $this->assertEquals($expected, $formatted);
    }

    public function assertThatKeywordIsInvalid(string $target, Keyword $keyword): void
    {
        $this->assertFalse($keyword->canApplyFor($target));
    }
}
