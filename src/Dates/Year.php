<?php
/**
 * @author enea dhack <enea.so@live.com>
 */

declare(strict_types=1);

namespace Vaened\CriteriaLanguage\Dates;

use DateTimeImmutable;

use function sprintf;

final class Year extends Dateable
{
    public function __construct(string $yearString)
    {
        parent::__construct(
            new DateTimeImmutable(
                sprintf('%s-01-01', $yearString)
            )
        );
    }

    public function end(): DateTimeImmutable
    {
        return $this->endOfYearDatetime();
    }
}
