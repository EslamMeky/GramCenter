<?php

namespace App\Http\Controllers;

use App\Http\Traits\GeneralTrait;
use App\Models\Makeup;
use App\Models\Studio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MackupController extends Controller
{
    use GeneralTrait;
    public function save(Request $request)
    {
        try
        {
            ///////////// validation ///////////////
            $rules = [
                 'category_id' => 'required',
                 'name' => 'required',
                 'phone'=> 'required',
                 'address'=> 'required',
                'appropriate'=> 'required',
                'pay'=> 'required',
                'rest'=> 'required',
                'total'=> 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails())
            {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            ////////////////////  save  ///////////////////
            if ($request->rest == 0 ){
                Makeup::create([
                    'category_id' => $request ->category_id,
                    'notes' =>$request->notes,
                    'name' => $request ->name,
                    'phone' => $request ->phone,
                    'address' => $request ->address,
                    'appropriate' => $request ->appropriate,
                    'pay' => $request ->pay,
                    'rest' => $request ->rest,
                    'total' => $request ->total,
                    'reason_discount_id' =>$request->reason_discount_id,
                    'price'=>$request->price,
                    'status' =>' تم الدفع',
                    'arrive' =>$request->arrive,
                    'addService'=>$request->addService,
                    'priceService'=>$request->priceService,
                ]);
                return $this->ReturnSuccess('200','Save Successfully');

            }
            else
            {
                Makeup::create([
                    'category_id' => $request ->category_id,
                    'notes' =>$request->notes,
                    'name' => $request ->name,
                    'phone' => $request ->phone,
                    'address' => $request ->address,
                    'appropriate' => $request ->appropriate,
                    'pay' => $request ->pay,
                    'rest' => $request ->rest,
                    'total' => $request ->total,
                    'reason_discount_id' =>$request->reason_discount_id,
                    'price'=>$request->price,
                    'status' =>'لم يتم الدفع',
                    'arrive' =>$request->arrive,
                    'addService'=>$request->addService,
                    'priceService'=>$request->priceService,
                ]);
                return $this->ReturnSuccess('200','Save Successfully');

            }
        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());
//            return $ex;
        }

    }

    public function show()
    {
        try {
            $makeups= Makeup::with(['category','discount'])->selection()->orderBy('id','desc')->paginate(pag);
            return $this->ReturnData('makeups',$makeups,'200');
        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());
        }
    }

    public function edit($id)
    {
        try
        {
            $makeup= Makeup::find($id);
            if (!$makeup)
            {
                return $this->ReturnError('404','Not Found');
            }
            $makeup=Studio::with(['category','discount'])->Selection()->where('id',$id)->get();
            return $this->ReturnData('makeups',$makeup,'200');
        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());
        }
    }

    public function update(Request $request ,$id)
    {
        try
        {
            //////////////// validation ////////////////////
            $rules = [
                'name' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'appropriate' => 'required',
                'pay' => 'required',
                'rest' => 'required',
                'total' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails())
            {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            /////////////////////  update  ///////////

            $makeups= Makeup::find($id);
            if (!$makeups)
            {
                return $this->ReturnError('404','Not Found');
            }
            if ($request->rest ==0  ){
                $makeups->where('id',$id)->update([
                    'name' => $request ->name,
                    'phone' => $request ->phone,
                    'address' => $request ->address,
                    'appropriate' => $request ->appropriate,
                    'pay' => $request ->pay,
                    'rest' => $request ->rest,
                    'total' => $request ->total,
                    'status' =>'تم الدفع',
                    'enter'=>$request->enter,
                    'exit'=>$request->exit,
                    'arrive' =>$request->arrive,
                ]);
                return $this->ReturnSuccess('200','Updated Successfully');
            }
            else{
                $makeups->where('id',$id)->update([
                    'name' => $request ->name,
                    'phone' => $request ->phone,
                    'address' => $request ->address,
                    'appropriate' => $request ->appropriate,
                    'pay' => $request ->pay,
                    'rest' => $request ->rest,
                    'total' => $request ->total,
                    'status' =>'لم يتم الدفع',
                    'enter'=>$request->enter,
                    'exit'=>$request->exit,
                    'arrive' =>$request->arrive,
                ]);
                return $this->ReturnSuccess('200','Updated Successfully');
            } }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());
        }
    }

    public function delete($id)
    {
        try
        {
            $makeups= Makeup::find($id);
            if (!$makeups)
            {
                return $this->ReturnError('404','Not Found');
            }
            $makeups->where('id',$id)->delete();
            return $this->ReturnSuccess('200','deleted Successfully');

        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());
        }
    }


}
