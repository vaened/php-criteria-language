<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\CriteriaLanguage\Keywords;

use Vaened\CriteriaCore\Keyword\FilterOperator;
use Vaened\CriteriaLanguage\Keyword;

use function preg_replace;

final class EndsWith extends Keyword
{
    public static function anything(): self
    {
        return new self();
    }

    public function operator(): FilterOperator
    {
        return FilterOperator::EndsWith;
    }

    public function regex(): string
    {
        return '(%[^%\[\]{},\s]*)';
    }

    public function format(string $queryString): string
    {
        return preg_replace("/%/", "", $queryString);
    }
}
