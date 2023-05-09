<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\CriteriaLanguage;

use Vaened\CriteriaLanguage\Dates\DateFormatter;

use function Lambdish\Phunctional\apply;
use function Lambdish\Phunctional\map;
use function preg_match;

final class DataFormatter
{
    private readonly mixed $formatter;

    public function __construct(callable $formatter)
    {
        $this->formatter = $formatter;
    }

    public static function collection(self $formatter): self
    {
        return new self(
            static fn(array $values) => map(
                static fn(mixed $value) => $formatter->format($value),
                $values
            )
        );
    }

    public static function dates(): self
    {
        return new self(
            static fn(array $dates) => [
                DateFormatter::createFrom($dates[0])->start(),
                DateFormatter::createFrom($dates[1])->end(),
            ]
        );
    }

    public static function numbers(): self
    {
        return new self(
            static fn(mixed $value) => preg_match('/^\d+$/', $value) ? (int)$value : (float)$value
        );
    }

    public static function integer(): self
    {
        return new self(static fn(mixed $value) => (int)$value);
    }

    public static function natural(): self
    {
        return new self(static fn(mixed $value) => $value);
    }

    public function format(mixed $value): mixed
    {
        return apply($this->formatter, [$value]);
    }
}
