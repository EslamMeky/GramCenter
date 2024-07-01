<?php

namespace App\Http\Controllers;

use App\Http\Traits\GeneralTrait;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoansController extends Controller
{
    use GeneralTrait;
    public function save(Request $request)
    {
        try
        {
            ///////////// validation ///////////////
            $rules = [
                'employee_name' => 'required',
                'reason' => 'required',
                'price' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails())
            {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            ////////////////////  save  ///////////////////
            Loan::create([
                'employee_name'=> $request->employee_name,
                'reason'=>$request->reason,
                'price'=> $request->price,
            ]);
            return $this->ReturnSuccess('200','Save Successfully');
        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());
        }
    }

    public function show()
    {
        try {
            $loan= Loan::selection()->paginate(pag);
            return $this->ReturnData('loan',$loan,'200');
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
            $loan= Loan::find($id);
            if (!$loan)
            {
                return $this->ReturnError('404','Not Found');
            }
            $loan->Selection()->where('id',$id)->get();
            return $this->ReturnData('loan',$loan,'200');
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
                'employee_name' => 'required',
                'reason'=>'required',
                'price' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails())
            {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            /////////////////////  update  ///////////

            $loan= Loan::find($id);
            if (!$loan)
            {
                return $this->ReturnError('404','Not Found');
            }
            $loan->where('id',$id)->update([
                'employee_name'=> $request->employee_name,
                'reason'=>$request->reason,
                'price'=> $request->price,
            ]);
            return $this->ReturnSuccess('200','Updated Successfully');
        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());
        }
    }

    public function delete($id)
    {
        try
        {
            $loan= Loan::find($id);
            if (!$loan)
            {
                return $this->ReturnError('404','Not Found');
            }
            $loan->where('id',$id)->delete();
            return $this->ReturnSuccess('200','deleted Successfully');

        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());
        }
    }
}
