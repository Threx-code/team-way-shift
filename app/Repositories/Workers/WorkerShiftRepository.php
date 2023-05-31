<?php

namespace App\Repositories\Workers;

use App\Contracts\Workers\WorkerShiftInterface;
use App\Contracts\Workers\WorkShiftServiceInterface;


class WorkerShiftRepository implements WorkerShiftInterface
{
    public function __construct(private readonly  WorkShiftServiceInterface $service){
    }

    /**
     * @param $request
     * @return mixed
     */
    public function dailyRoster($request): mixed
    {
        return $this->service->dailyRoster($request);
    }

    /**
     * @param $request
     * @return array|int[]|mixed|null
     */
    public function listOfAllShiftForAWorker($request): mixed
    {
        return $this->service->listOfAllShiftForAWorker($request);
    }



}
