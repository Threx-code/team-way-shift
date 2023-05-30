<?php

namespace App\Repositories\Manager;

use App\Contracts\Manager\ShiftManagerInterface;
use App\Contracts\Manager\ShiftManagerServiceInterface;
use JsonException;

class ShiftManagerRepository implements ShiftManagerInterface
{
    public function __construct(private readonly  ShiftManagerServiceInterface $service){}

    /**
     * @param $request
     * @return array|null
     * @throws JsonException
     */
    public function createShift($request): ?array
    {
        return $this->service->createShift($request);
    }

    /**
     * @param $request
     * @return array|null
     */
    public function updateShift($request): ?array
    {
        return $this->service->updateShift($request);
    }



}
