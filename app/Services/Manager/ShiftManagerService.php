<?php

namespace App\Services\Manager;

use App\Contracts\Manager\ShiftManagerServiceInterface;
use App\Helpers\Helper;
use App\Validators\RepositoryValidator;
use Carbon\Carbon;

class ShiftManagerService implements ShiftManagerServiceInterface
{
    public function __construct(private readonly Helper $helper){}


    /**
     * @param $request
     * @param array $shifts
     * @return bool[]|string[]|null
     */
    public function shiftManager($request, array $shifts = []): ?array
    {
        $shifts = $this->helper->shiftAlreadyCreated($request);
        if(!$shifts){
            $shifts = $this->helper->shiftManager($request);
        }
        return $shifts;

    }
}
