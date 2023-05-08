<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\CriteriaLanguage\Keywords;

use Vaened\CriteriaCore\Keyword\FilterOperator;
use Vaened\CriteriaLanguage\BetweenDatesParser;
use Vaened\CriteriaLanguage\Dates\DateFormatter;
use Vaened\CriteriaLanguage\Keyword;

use function explode;
use function Lambdish\Phunctional\apply;
use function Lambdish\Phunctional\map;
use function str_replace;
use function trim;

final class NotBetween extends Keyword
{
    private readonly mixed $parser;

    private function __construct(
        private readonly string $pattern,
        callable                $parser
    ) {
        $this->parser = $parser;
    }

    public static function anything(): self
    {
        return new self('(!\{[^,]+,[^,]+\})', static fn(array $dates) => $dates);
    }

    public static function dates(): self
    {
        return new self('!\{(\d{4}|\d{6}|\d{8})(,\s*(\d{4}|\d{6}|\d{8}))*\}', static fn(array $dates) => [
            DateFormatter::createFrom($dates[0])->start(),
            DateFormatter::createFrom($dates[1])->end(),
        ]);
    }

    public static function numbers(): self
    {
        return new self('!\{(\d+)(,\s*(\d+))*\}', static fn(array $dates) => [
            (int)$dates[0],
            (int)$dates[1],
        ]);
    }

    public function operator(): FilterOperator
    {
        return FilterOperator::NotBetween;
    }

    public function regex(): string
    {
        return $this->pattern;
    }

    public function format(string $queryString): array
    {
        $content = str_replace(['!{', '}'], '', $queryString);
        $values  = map(static fn(string $value) => trim($value), explode(',', $content));

        return apply($this->parser, [$values]);
    }
}
