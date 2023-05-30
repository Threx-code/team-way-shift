<?php

namespace App\Http\Controllers\Api\V1\Manager;

use App\Contracts\Manager\ShiftManagerInterface;
use App\Http\Requests\Manager\UpdateShiftRequest;
use App\Http\Requests\Manager\WorkerRequest;
use Illuminate\Http\JsonResponse;

class ShiftManagerController
{
    public function __construct(private readonly ShiftManagerInterface $repository){}

    /**
     * @param WorkerRequest $request
     * @return JsonResponse
     */
    public function createShift(WorkerRequest $request): JsonResponse
    {
        return response()->json($this->repository->createShift($request));
    }

    public function updateShift(UpdateShiftRequest $request): JsonResponse
    {
        return response()->json($this->repository->updateShift($request));
    }





}
