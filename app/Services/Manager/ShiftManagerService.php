<?php

namespace App\Services\Manager;

use App\Contracts\Manager\ShiftManagerServiceInterface;
use App\Helpers\Manager\ManagerHelper;
use App\Validators\RepositoryValidator;
use JsonException;

class ShiftManagerService implements ShiftManagerServiceInterface
{
    public function __construct(private readonly ManagerHelper $helper){}

    /**
     * @param $request
     * @return array|null
     * @throws JsonException
     */
    public function createShift($request): ?array
    {
        $shifts = $this->helper->shiftAlreadyCreated($request);
        if(!$shifts){
            RepositoryValidator::dataAlreadyExist("insertion", "shift dates already entered for this user", 409);
        }
        return ['shift_created' => $this->helper->createShift($shifts, $request->manager_id, $request->user_id)];
    }

    /**
     * @param $request
     * @return array|null
     */
    public function updateShift($request): ?array
    {
        $shift = $this->helper->shiftExistForUser($request->shift_manager_id, $request->user_id);
        if(!$shift){
            RepositoryValidator::dataAlreadyExist("update",
                "Sorry you cannot update this shift because it does not exist for this user", 409);
        }
        return  ['shift_updated' => $this->helper->updateShift($shift, $request->shift_id)];
    }


}
