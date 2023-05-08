<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\CriteriaLanguage\Keywords;

use Vaened\CriteriaCore\Keyword\FilterOperator;
use Vaened\CriteriaLanguage\Keyword;

use function explode;
use function Lambdish\Phunctional\map;
use function str_replace;
use function trim;

final class In extends Keyword
{
    private function __construct(private readonly string $pattern)
    {
    }

    public static function anything(): self
    {
        return new self('(\[[^=\]]*(,\s*[^=\]]+)*\])');
    }

    public static function integers(): self
    {
        return new self('\[\s*(\d+\s*,\s*)*\d+\s*\]');
    }

    public static function numbers(): self
    {
        return new self('\[\s*(\d+(\.\d+)?\s*,\s*)*(\d+(\.\d+)?\s*)\]');
    }

    public function operator(): FilterOperator
    {
        return FilterOperator::In;
    }

    public function regex(): string
    {
        return $this->pattern;
    }

    public function format(string $queryString): array
    {
        $values = str_replace(['[', ']'], '', $queryString);
        return map(static fn(string $value) => trim($value), explode(',', $values));
    }
}
