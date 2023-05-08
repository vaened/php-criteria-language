<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\CriteriaLanguage\Dates;

use DateTimeImmutable;

use function preg_replace;
use function sprintf;

final class Month extends Dateable
{
    public function __construct(string $yearString)
    {
        parent::__construct(
            new DateTimeImmutable(
                sprintf('%s-01', preg_replace('/^(\d{4})(\d{2})$/', '$1-$2', $yearString))
            )
        );
    }

    public function end(): DateTimeImmutable
    {
        return $this->endOfMonthDatetime();
    }
}
