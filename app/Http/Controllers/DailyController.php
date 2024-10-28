<?php

namespace App\Http\Controllers;

use App\Http\Traits\GeneralTrait;
use App\Models\Makeup;
use App\Models\Studio;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DailyController extends Controller
{
    use GeneralTrait;

//    public function updateStatusStudio($id)
//    {
//        try {
//            $studio= Studio::find($id);
//            if (!$studio){
//                return $this->ReturnError('404','Not Found');
//            }
//            $status=$studio->status=='لم يتم الدفع'? 'تم الدفع':'لم يتم الدفع';
//            $studio->update(['status'=>$status]);
//            return $this->ReturnSuccess('200','Updated Successfully');
//
//        }
//        catch (\Exception $ex)
//        {
//            return $this->ReturnError($ex->getCode(),$ex->getCode());
//
//        }
//
//    }
//
//    public function updateStatusMakeup($id)
//    {
//        try {
//            $makeup= Makeup::find($id);
//            if (!$makeup){
//                return $this->ReturnError('404','Not Found');
//            }
//            $status=$makeup->status=='لم يتم الدفع'? 'تم الدفع':'لم يتم الدفع';
//            $makeup->update(['status'=>$status]);
//            return $this->ReturnSuccess('200','Updated Successfully');
//
//        }
//        catch (\Exception $ex)
//        {
//            return $this->ReturnError($ex->getCode(),$ex->getCode());
//
//        }
//
//    }

    public function showHair(){
        try
        {
            $today = Carbon::now()->toDateString(); // Format the date to 'Y-m-d'
//            $tomorrow = Carbon::now()->addDay()->toDateString();
            $hairs= Makeup::with(['category','discount'])->selection()->orderBy('id','desc')->whereDate('dateHair', $today)->paginate(pag);
            foreach ($hairs as $hair) {
                $hair->notes = json_decode($hair->notes, true); // تحويل notes إلى مصفوفة
            }

            return $this->ReturnData('hairs',$hairs,'200');

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
            $today = Carbon::now()->toDateString(); // Format the date to 'Y-m-d'
//            $tomorrow = Carbon::now()->addDay()->toDateString();

            $makeups= Makeup::with(['category','discount'])->selection()->orderBy('id','desc')->whereDate('appropriate', $today)->paginate(pag);
            foreach ($makeups as $makeup) {
                $makeup->notes = json_decode($makeup->notes, true); // تحويل notes إلى مصفوفة
            }
            $services= Makeup::with(['category','discount'])->selection()->orderBy('id','desc')->whereDate('dateService', $today)->paginate(pag);
            foreach ($services as $service) {
                $service->notes = json_decode($service->notes, true); // تحويل notes إلى مصفوفة
            }
            $data=[
                'makeups'=>$makeups,
                'services'=>$services
            ];
            return $this->ReturnData('data',$data,'200');
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
            $today = Carbon::now()->toDateString(); // Format the date to 'Y-m-d'
//            $tomorrow = Carbon::now()->addDay()->toDateString();
            $studio = Studio::with(['category', 'discount'])
                ->selection()
                ->orderBy('id','desc')
                ->whereDate('appropriate',$today)
                ->paginate(pag);

            return $this->ReturnData('studio', $studio, '200');
        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());

        }
    }
}
