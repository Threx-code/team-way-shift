<?php

namespace App\Services\Workers;

use App\Contracts\Workers\WorkShiftServiceInterface;
use App\Helpers\Workers\WorkerShiftHelper;
use App\Validators\RepositoryValidator;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use function PHPUnit\Framework\matches;

class WorkerShiftService implements WorkShiftServiceInterface
{
    public function __construct(private readonly WorkerShiftHelper $helper){}

    /**
     * @param $request
     * @return Builder|Model|null
     */
    public function dailyRoster($request): Model|Builder|null
    {
        return $this->helper->workerDailyCheck($request);
    }

    public function listOfAllShiftForAWorker($request)
    {
        return match($request->type){
            'daily','' => $this->helper->dailyShift($request),
            'weekly' => $this->helper->weeklyShift($request),
            'monthly' => $this->helper->monthlyShift($request),
            'yearly' => $this->helper->yearly($request),
        };
    }
}
