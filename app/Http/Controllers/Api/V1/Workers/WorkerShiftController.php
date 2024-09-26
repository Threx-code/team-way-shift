<?php

namespace App\Http\Controllers\Api\V1\Workers;

use App\Contracts\Workers\WorkerShiftInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Workers\DailyRosterRequest;
use App\Http\Requests\Workers\WorkerClockAllShiftRequest;
use App\Transformers\DailyRosterTransformer;
use Illuminate\Http\JsonResponse;

class WorkerShiftController extends Controller
{
    public function __construct(private readonly WorkerShiftInterface $repository){}

    /**
     * @param DailyRosterRequest $request
     * @return JsonResponse
     */
    public function dailyRoster(DailyRosterRequest $request): JsonResponse
    {
        return response()->json(DailyRosterTransformer::transform($this->repository->dailyRoster($request)));
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
