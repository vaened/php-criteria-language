<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\CriteriaLanguage\Keywords;

use Vaened\CriteriaCore\Keyword\FilterOperator;
use Vaened\CriteriaLanguage\DataFormatter;
use Vaened\CriteriaLanguage\Keyword;

use function explode;
use function Lambdish\Phunctional\map;
use function str_replace;
use function trim;

final class Between extends Keyword
{
    private function __construct(
        private readonly string        $pattern,
        private readonly DataFormatter $formatter
    ) {
    }

    public static function anything(): self
    {
        return new self(
            '(\{[^,]+,[^,]+\})',
            DataFormatter::collection(DataFormatter::natural())
        );
    }

    public static function dates(): self
    {
        return new self(
            '\{(\d{4}|\d{6}|\d{8})(,\s*(\d{4}|\d{6}|\d{8}))*\}',
            DataFormatter::dates()
        );
    }

    public static function numbers(): self
    {
        return new self(
            '\{(\d+)(,\s*(\d+))*\}',
            DataFormatter::collection(DataFormatter::numbers())
        );
    }

    public function operator(): FilterOperator
    {
        return FilterOperator::Between;
    }

    public function regex(): string
    {
        return $this->pattern;
    }

    public function format(string $queryString): array
    {
        $content = str_replace(['{', '}'], '', $queryString);

        return $this->formatter->format(
            map(static fn(string $value) => trim($value), explode(',', $content))
        );
    }
}
