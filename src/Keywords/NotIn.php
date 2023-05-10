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

final class NotIn extends Keyword
{
    private function __construct(
        private readonly string        $pattern,
        private readonly DataFormatter $formatter
    ) {
    }

    public static function anything(): self
    {
        return new self(
            '(!\[[^=\]]*(,\s*[^=\]]+)*\])',
            DataFormatter::collection(DataFormatter::natural())
        );
    }

    public static function integers(): self
    {
        return new self(
            '!\[\s*(\d+\s*,\s*)*\d+\s*\]',
            DataFormatter::collection(DataFormatter::numbers())
        );
    }

    public static function numbers(): self
    {
        return new self(
            '!\[\s*(\d+(\.\d+)?\s*,\s*)*(\d+(\.\d+)?\s*)\]',
            DataFormatter::collection(DataFormatter::numbers())
        );
    }

    public function operator(): FilterOperator
    {
        return FilterOperator::NotIn;
    }

    public function regex(): string
    {
        return $this->pattern;
    }

    public function format(string $queryString): array
    {
        $values = str_replace(['![', ']'], '', $queryString);
        return $this->formatter->format(
            map(static fn(string $value) => trim($value), explode(',', $values))
        );
    }
}
