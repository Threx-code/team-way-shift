<?php

namespace App\Helpers\Manager;

use App\Helpers\Helper;
use App\Models\ShiftManager;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use JsonException;

class ManagerHelper
{
    public function __construct( private readonly ShiftManager $shiftManager, private readonly Helper $helper){}

    /**
     * @param $request
     * @return array
     * @throws JsonException
     */
    public function shiftAlreadyCreated($request): array
    {
        $shifts = is_array($request->shift_date) ? $request->shift_date : $this->helper::convertToArray($request->shift_date);
        $shiftAlreadyExist = $this->shiftManager::where('user_id', $request->user_id)->whereIn(DB::raw("DATE(shift_date)"), $shifts)->get();
        $shiftAlreadyExist = array_column($shiftAlreadyExist->toArray(), 'shift_date');
        return array_diff(array_values(array_unique($shifts)), $shiftAlreadyExist);
    }

    /**
     * @param $dates
     * @param $mangerId
     * @param $userId
     * @return bool
     */
    public function createShift($dates, $mangerId, $userId)
    {
        $inserts = [];
        $response = false;
       foreach($dates as $key => $date)
       {
           $inserts[$key]['user_id'] = $userId;
           $inserts[$key]['manager_id'] = $mangerId;
           $inserts[$key]['shift_date'] = $date;
           $inserts[$key]['created_at'] = Carbon::now();
           $inserts[$key]['updated_at'] = Carbon::now();
       }

        if($this->shiftManager->insert($inserts)){
            $response = true;
        }
        return $response;
    }

    /**
     * @param $shiftManagerId
     * @param $userId
     * @return mixed
     */
    public function shiftExistForUser($shiftManagerId, $userId): mixed
    {
        return $this->shiftManager::where(['user_id' => $userId, 'id' => $shiftManagerId])->first();
    }

    /**
     * @param $shift
     * @param $shiftId
     * @return bool
     */
    public function updateShift($shift, $shiftId): bool
    {
        $shift->shift_id = $shiftId;
        $shift->save();
        return true;
    }

}
