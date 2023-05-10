<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\CriteriaLanguage\Keywords;

use Vaened\CriteriaCore\Keyword\FilterOperator;
use Vaened\CriteriaLanguage\DataFormatter;
use Vaened\CriteriaLanguage\Keyword;

final class Equal extends Keyword
{
    private function __construct(
        private readonly string        $pattern,
        private readonly DataFormatter $formatter
    ) {
    }

    public static function anything(): self
    {
        return new self('(?!(<=|>=|[<>=!%]))([^\[\]{},\s]+)[^%]', DataFormatter::natural());
    }

    public static function number(): self
    {
        return new self('\d*\.?\d*', DataFormatter::numbers());
    }

    public function operator(): FilterOperator
    {
        return FilterOperator::Equal;
    }

    public function regex(): string
    {
        return $this->pattern;
    }

    public function format(string $queryString): string|int|float
    {
        return $this->formatter->format($queryString);
    }
}
