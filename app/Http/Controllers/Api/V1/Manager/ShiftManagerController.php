<?php

namespace App\Http\Controllers\Api\V1\Manager;

use App\Contracts\Manager\ShiftManagerInterface;

class ShiftManagerController
{
    public function __construct(private readonly ShiftManagerInterface $repository){}

    /**
     * @param WorkerRequest $request
     * @return JsonResponse
     */
    public function shiftManager(WorkerRequest $request): JsonResponse
    {
        return response()->json($this->repository->shiftManager($request));
    }


}
