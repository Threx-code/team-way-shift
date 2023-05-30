<?php

namespace App\Repositories\Workers;

use App\Contracts\Workers\WorkerShiftInterface;


class WorkerShiftRepository implements WorkerShiftInterface
{
    public function __construct(private readonly  WorkerShiftInterface $service){
    }

    /**
     * @param $request
     * @return bool[]|null
     */
    public function workerClockIn($request): ?array
    {
        return $this->service->workerClockIn($request);
    }


    /**
     * @param $request
     * @return bool[]|null
     */
    public function workerClockOut($request): ?array
    {
        return $this->service->workerClockOut($request);
    }

    /**
     * @param $request
     * @return array|int[]|mixed|null
     */
    public function listOfAllShiftForAWorker($request): mixed
    {
        return $this->service->listOfAllShiftForAWorker($request);
    }

    /**
     * @param $request
     * @return bool[]|string[]|null
     */
    public function shiftManager($request): ?array
    {
        return $this->service->shiftManager($request);
    }

    /**
     * @param $request
     * @return bool[]|string[]|null
     */
    public function dailyRoster($request): ?array
    {
        return $this->service->dailyRoster($request);
    }
}
