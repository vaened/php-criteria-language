<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\CriteriaLanguage\Keywords;

use Vaened\CriteriaCore\Keyword\FilterOperator;
use Vaened\CriteriaLanguage\Keyword;

final class Contains extends Keyword
{
    public static function anything(): self
    {
        return new self();
    }

    public function operator(): FilterOperator
    {
        return FilterOperator::Contains;
    }

    public function regex(): string
    {
        return '(?!.*![^\[\]{},\s]*$)%[^\[\]{},\s]*%';
    }

    public function format(string $queryString): string
    {
        return preg_replace("/%/", "", $queryString);
    }
}
