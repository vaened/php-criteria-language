<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\CriteriaLanguage\Tests\Keywords;

use Vaened\CriteriaLanguage\Keyword;
use Vaened\CriteriaLanguage\Tests\TestCase;

abstract class KeywordTestCase extends TestCase
{
    public function assertThatKeywordIsCorrect(Sentence $sentence, Keyword $keyword): void
    {
        $this->assertTrue($keyword->canApplyFor($sentence->sentence()));
        $this->assertEquals($sentence->expected(), $keyword->format($sentence->sentence()));
    }

    public function assertThatKeywordIsInvalid(string $target, Keyword $keyword): void
    {
        $this->assertFalse($keyword->canApplyFor($target));
    }
}
