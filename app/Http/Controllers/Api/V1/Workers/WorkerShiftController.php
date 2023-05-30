<?php

namespace App\Http\Controllers\Api\V1\Workers;

use App\Contracts\Workers\WorkerShiftInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Manager\WorkerRequest;
use App\Http\Requests\Workers\DailyRosterRequest;
use App\Http\Requests\Workers\WorkerClockAllShiftRequest;
use App\Http\Requests\Workers\WorkerClockInRequest;
use App\Http\Requests\Workers\WorkerClockOutRequest;
use Illuminate\Http\JsonResponse;

class WorkerShiftController extends Controller
{
    public function __construct(private readonly WorkerShiftInterface $repository){}

    /**
     * @param WorkerRequest $request
     * @return JsonResponse
     */
    public function shiftManager(WorkerRequest $request): JsonResponse
    {
            return response()->json($this->repository->shiftManager($request));
    }

    /**
     * @param DailyRosterRequest $request
     * @return JsonResponse
     */
    public function dailyRoster(DailyRosterRequest $request): JsonResponse
    {
        return response()->json($this->repository->dailyRoster($request));
    }

    /**
     * @param WorkerClockInRequest $request
     * @return JsonResponse
     */
    public function workerClockIn(WorkerClockInRequest $request): JsonResponse
    {
        return response()->json($this->repository->workerClockIn($request));
    }


    /**
     * @param WorkerClockOutRequest $request
     * @return JsonResponse
     */
    public function workerClockOut(WorkerClockOutRequest $request): JsonResponse
    {
        return response()->json($this->repository->workerClockOut($request));
    }

    /**
     * @param WorkerClockAllShiftRequest $request
     * @return JsonResponse
     */
    public function listOfAllShiftForAWorker(WorkerClockAllShiftRequest $request): JsonResponse
    {
        return response()->json($this->repository->listOfAllShiftForAWorker($request));
    }


}
