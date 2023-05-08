<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\CriteriaLanguage;

use Vaened\CriteriaCore\Directives\Filter;
use Vaened\CriteriaCore\Statements;
use Vaened\Support\Types\ArrayList;

use function explode;

final class SentenceParser
{
    private const DIVIDER = '&';

    private readonly array $specifications;

    public function __construct(Specification ...$specifications)
    {
        $this->specifications = $specifications;
    }

    public function parse(string $sentences): Statements
    {
        return Statements::of(
            ArrayList::from($this->divide($sentences))
                ->flatMap($this->convertToFilters($this->specifications))
                ->filter($this->matched())
                ->items()
        );
    }

    private function convertToFilters(array $specifications): callable
    {
        return fn(string $value) => ArrayList::from($specifications)
            ->map($this->createFilterFor($value));
    }

    private function createFilterFor(string $value): callable
    {
        return static fn(Specification $specification) => $specification->createFilterFor($value);
    }

    private function matched(): callable
    {
        return static fn(?Filter $filter) => null !== $filter;
    }

    private function divide(string $queryString): array
    {
        return explode(self::DIVIDER, $queryString);
    }
}
