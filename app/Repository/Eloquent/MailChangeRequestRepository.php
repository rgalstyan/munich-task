<?php

declare(strict_types=1);

namespace App\Repository\Eloquent;

use App\Models\MailChangeRequest;
use App\Repository\MailChangeRequestRepositoryInterface;

final class MailChangeRequestRepository extends BaseRepository implements MailChangeRequestRepositoryInterface
{
    public function __construct(
        MailChangeRequest $model
    ) {
        parent::__construct($model);
    }
}
