<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\CriteriaLanguage;

use Vaened\CriteriaCore\Directives\Filter;
use Vaened\CriteriaCore\Statement;
use Vaened\CriteriaLanguage\Keywords\Between;
use Vaened\CriteriaLanguage\Keywords\Contains;
use Vaened\CriteriaLanguage\Keywords\EndsWith;
use Vaened\CriteriaLanguage\Keywords\Equal;
use Vaened\CriteriaLanguage\Keywords\In;
use Vaened\CriteriaLanguage\Keywords\NotBetween;
use Vaened\CriteriaLanguage\Keywords\NotEqual;
use Vaened\CriteriaLanguage\Keywords\NotIn;
use Vaened\CriteriaLanguage\Keywords\StartsWith;
use Vaened\Support\Types\ArrayList;

use function sprintf;
use function str_replace;

class Specification
{
    private readonly array $keywords;

    private ?string $alias = null;

    public function __construct(private readonly string $field, Keyword ...$keywords)
    {
        $this->keywords = $keywords;
    }

    public static function date(string $field): static
    {
        return new static(
            $field,
            Between::dates(),
            Equal::anything(),
            NotBetween::dates(),
            NotEqual::anything(),
        );
    }

    public static function text(string $field): static
    {
        return new static(
            $field,
            Equal::anything(),
            NotEqual::anything(),
            StartsWith::anything(),
            EndsWith::anything(),
            Contains::anything()
        );
    }

    public static function char(string $field): static
    {
        return new static(
            $field,
            Equal::anything(),
            NotEqual::anything(),
            In::anything(),
            NotIn::anything()
        );
    }

    public static function number(string $field): static
    {
        return new static(
            $field,
            Equal::number(),
            NotEqual::number(),
            In::numbers(),
            NotIn::numbers()
        );
    }

    public function named(string $alias): static
    {
        $this->alias = $alias;
        return $this;
    }

    public function createFilterFor(string $queryString): ?Filter
    {
        $value   = $this->extractValueFrom($queryString);
        $keyword = $this->keywordOf($value);

        if (null === $keyword) {
            return null;
        }

        return Statement::that($this->field, $keyword->operator(), $keyword->format($value));
    }

    private function extractValueFrom(string $queryString): string
    {
        return str_replace(sprintf('[%s]=', $this->target()), '', $queryString);
    }

    private function keywordOf(string $value): ?Keyword
    {
        return ArrayList::from($this->keywords)->find($this->satisfiedBy($value));
    }

    private function satisfiedBy(string $value): callable
    {
        return static fn(Keyword $keyword) => $keyword->canApplyFor($value);
    }

    private function target(): string
    {
        return $this->alias ?? $this->field;
    }
}
