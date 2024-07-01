<?php

namespace App\Http\Controllers;

use App\Http\Traits\GeneralTrait;
use App\Models\Rent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RentsController extends Controller
{
    use GeneralTrait;

    public function save(Request $request)
    {
        try
        {
            ///////////// validation ///////////////
            $rules = [
                'name'=>'required',
                'category'=>'required',
                'type_insurance'=>'required',
                'insurance'=>'required',
                'status' => 'required',

            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails())
            {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            ////////////////////  save  ///////////////////

            Rent::create([
                'name'=>$request->name,
                'category'=>$request->category,
                'type_insurance'=>$request->type_insurance,
                'insurance'=>$request->insurance,
                'status'=> $request->status,
            ]);
            return $this->ReturnSuccess('200','Save Successfully');
        }
        catch (\Exception $ex)
        {
//            return $this->ReturnError($ex->getCode(),$ex->getCode());
            return $ex;
        }
    }

    public function show()
    {
        try {
            $rents= Rent::selection()->paginate(pag);
            return $this->ReturnData('rents',$rents,'200');
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
            $rent= Rent::find($id);
            if (!$rent)
            {
                return $this->ReturnError('404','Not Found');
            }
            $rent->Selection()->where('id',$id)->get();
            return $this->ReturnData('rent',$rent,'200');
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
                'name'=>'required',
                'category'=>'required',
                'type_insurance'=>'required',
                'insurance'=>'required',
                'status' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails())
            {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            /////////////////////  update  ///////////
            $rent= Rent::find($id);
            if (!$rent)
            {
                return $this->ReturnError('404','Not Found');
            }
            $rent->where('id',$id)->update([
                'name'=>$request ->name,
                'category'=>$request ->category,
                'type_insurance'=>$request ->type_insurance,
                'insurance'=>$request ->insurance,
                'status'=> $request->status,


            ]);
            return $this->ReturnSuccess('200','Updated Successfully');
        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());
        }
    }
    public function updateStatus($id)
    {
        try {
            $rent= Rent::find($id);
            if (!$rent){
                return $this->ReturnError('404','Not Found');
            }
            $status=$rent->status=='لم يتم الاسترجاع'? 'تم الاستراجاع':'لم يتم الاسترجاع';
            $rent->update(['status'=>$status]);
            return $this->ReturnSuccess('200','Updated Successfully');

        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());

        }
    }

    public function delete($id)
    {
        try {
            $rent = Rent::find($id);
            if (!$rent) {
                return $this->ReturnError('404', 'Not Found');
            }
            $rent->where('id', $id)->delete();
            return $this->ReturnSuccess('200', 'deleted Successfully');

        } catch (\Exception $ex) {
            return $this->ReturnError($ex->getCode(), $ex->getCode());
        }
    }
}
