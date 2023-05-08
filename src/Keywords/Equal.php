<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\CriteriaLanguage\Keywords;

use Vaened\CriteriaCore\Keyword\FilterOperator;
use Vaened\CriteriaLanguage\Keyword;

final class Equal extends Keyword
{
    private function __construct(private readonly string $pattern)
    {
    }

    public static function anything(): self
    {
        return new self('(?!(<=|>=|[<>=!%]))([^\[\]{},\s]+)[^%]');
    }

    public static function number(): self
    {
        return new self('\d*\.?\d*');
    }

    public function operator(): FilterOperator
    {
        return FilterOperator::Equal;
    }

    public function regex(): string
    {
        return $this->pattern;
    }

    public function format(string $queryString): string
    {
        return $queryString;
    }
}
