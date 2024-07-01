<?php

namespace App\Http\Controllers;

use App\Http\Traits\GeneralTrait;
use App\Models\Makeup;
use App\Models\Studio;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DailyController extends Controller
{
    use GeneralTrait;
    public function updateArriveMakeup($id)
    {
        try {
            $makeup= Makeup::find($id);
            if (!$makeup){
                return $this->ReturnError('404','Not Found');
            }
            $status=$makeup->arrive=='لم يتم الوصول'? 'تم الوصول':'لم يتم الوصول';
            $makeup->update(['arrive'=>$status]);
            return $this->ReturnSuccess('200','Updated Successfully');

        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());

        }


    }

    public function updateArriveStudio($id)
    {
        try {
            $studio= Studio::find($id);
            if (!$studio){
                return $this->ReturnError('404','Not Found');
            }
            $status=$studio->arrive=='لم يتم الوصول'? 'تم الوصول':'لم يتم الوصول';
            $studio->update(['arrive'=>$status]);
            return $this->ReturnSuccess('200','Updated Successfully');

        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());

        }

    }

    public function updateStatusStudio($id)
    {
        try {
            $studio= Studio::find($id);
            if (!$studio){
                return $this->ReturnError('404','Not Found');
            }
            $status=$studio->status=='لم يتم الدفع'? 'تم الدفع':'لم يتم الدفع';
            $studio->update(['status'=>$status]);
            return $this->ReturnSuccess('200','Updated Successfully');

        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());

        }

    }

    public function updateStatusMakeup($id)
    {
        try {
            $makeup= Makeup::find($id);
            if (!$makeup){
                return $this->ReturnError('404','Not Found');
            }
            $status=$makeup->status=='لم يتم الدفع'? 'تم الدفع':'لم يتم الدفع';
            $makeup->update(['status'=>$status]);
            return $this->ReturnSuccess('200','Updated Successfully');

        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());

        }

    }

    public function showMakeup()
    {
        try
        {
            $today = Carbon::now();
            $makeup= Makeup::with('category')->selection()->whereDate('created_at', $today)->paginate(pag);
            return $this->ReturnData('makeup',$makeup,'200');
        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());

        }
    }

    public function showStudio()
    {
        try
        {
            $today = Carbon::now();
            $studio= Studio::with('category')->selection()->whereDate('created_at', $today)->paginate(pag);
            return $this->ReturnData('studio',$studio,'200');
        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());

        }
    }
}
