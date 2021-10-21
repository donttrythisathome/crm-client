<?php

declare(strict_types=1);

namespace Donttrythisathome\CRMClient\Contracts;

interface CRMDriver
{
    /**
     * @param array $data
     * @return bool
     */
    public function send(array $data): bool;
}