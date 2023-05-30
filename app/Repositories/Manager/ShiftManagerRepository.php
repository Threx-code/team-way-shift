<?php

namespace App\Repositories\Manager;

use App\Contracts\Manager\ShiftManagerInterface;
use App\Contracts\Manager\ShiftManagerServiceInterface;

class ShiftManagerRepository implements ShiftManagerInterface
{
    public function __construct(private readonly  ShiftManagerServiceInterface $service){}

    /**
     * @param $request
     * @return bool[]|string[]|null
     */
    public function shiftManager($request): ?array
    {
        return $this->service->shiftManager($request);
    }

}
