<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\CriteriaLanguage\Tests\Keywords;

final class Sentence
{
    public function __construct(
        private readonly string $sentence,
        private readonly mixed  $expected
    ) {
    }

    public static function create(string $sentence, mixed $expected): self
    {
        return new self($sentence, $expected);
    }

    public function sentence(): string
    {
        return $this->sentence;
    }

    public function expected(): mixed
    {
        return $this->expected;
    }
}
