<?php

namespace App\Helpers\Workers;

use App\Helpers\DailyWorkRound;
use App\Models\ShiftManager;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WorkerShiftHelper
{
    public function __construct(private readonly ShiftManager $shiftManager,){}

    /**
     * @param $request
     * @return Model|Builder|null
     */
    public function workerDailyCheck($request): Model|Builder|null
    {
        $date = $request->date ?? Carbon::now()->format('Y-m-d');
        return $this->shiftManager::with('shift')->where('user_id', $request->user_id)->whereDate('shift_date', $date )->first();
    }


    /**
     * @param $request
     * @return mixed
     */
    private function getWorkerShift($request): mixed
    {
        return $this->shiftManager::with('shift')->where('user_id', $request->user_id);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function dailyShift($request): mixed
    {
        return $this->getWorkerShift($request)->orderBy(DB::RAW("DATE(shift_date)"), 'DESC')->get();
    }

    /**
     * @param $request
     * @return mixed
     */
    public function weeklyShift($request): mixed
    {
        $endDate = $this->sevenDays($request->start_date, $request->end_date, 1);
        return $this->getWorkerShift($request)->whereBetween(DB::RAW("DATE(shift_date)"), [$request->start_date, $endDate])
            ->orderBy('created_at', 'DESC')
            ->get()
            ->groupBy(function ($date) use($request) {
                return Carbon::parse($date->created_at)->format(DailyWorkRound::groupFormat($request->type));
            });
    }


    /**
     * @param $start_date
     * @param $end_date
     * @param int $deter
     * @return string
     */
    public function sevenDays($start_date, $end_date, int $deter = 0): string
    {
        $sevenDays = 60 * 60 * 24 * (6 + $deter);
        return date('Y-m-d', (strtotime($end_date) - ((strtotime($end_date) - strtotime($start_date)) - $sevenDays)));
    }

    /**
     * @param $request
     * @return array|int[]
     */
    public function monthlyShift($request): array
    {
        $scoreArray = $var = [];
        $i = 1;
        $data = $this->getWorkerShift($request)->whereMonth(DB::RAW("DATE(shift_date)"), $request->month)
            ->orderBy(DB::RAW("DATE(shift_date)"), 'DESC')
            ->get()
            ->groupBy(function ($date) use($request) {
                return Carbon::parse($date->created_at)->format(DailyWorkRound::groupFormat($request->type));
            });

        $useKey = array_keys($data->toArray());
        foreach($useKey as $key){
            if(in_array($key, $useKey, true)){
                $var[] = $data[$key];
            }
            $scoreArray['week' . $i] = $var;
            $i++;
        }

        return array_merge(DailyWorkRound::$weekArray, $scoreArray);
    }

    /**
     * @param $request
     * @return array|int[]
     */
    public function yearly($request): array
    {
        $scoreArray = $var = [];
        $data = $this->getWorkerShift($request)->whereYear(DB::RAW("DATE(shift_date)"), $request->year)
            ->orderBy(DB::RAW("DATE(shift_date)"), 'DESC')
            ->get()
            ->groupBy(function ($date) use($request) {
                return Carbon::parse($date->created_at)->format(DailyWorkRound::groupFormat($request->type));
            });

        $useKey = array_keys($data->toArray());
        foreach($useKey as $key){
            if(in_array($key, $useKey, true)){
                $var[] = $data[$key];
            }
            $scoreArray[$key] = $var;
        }

        return array_merge(DailyWorkRound::$monthArray, $scoreArray);
    }

}
