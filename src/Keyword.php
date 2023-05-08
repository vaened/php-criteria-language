<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\CriteriaLanguage;

use Vaened\CriteriaCore\Keyword\FilterOperator;

use function preg_match;
use function sprintf;
use function trim;

abstract class Keyword
{
    abstract public function regex(): string;

    abstract public function operator(): FilterOperator;

    abstract public function format(string $queryString): mixed;

    public function canApplyFor(string $value): bool
    {
        return preg_match(
                sprintf('/^%s$/', $this->regex()),
                trim($value)
            ) > 0;
    }
}
