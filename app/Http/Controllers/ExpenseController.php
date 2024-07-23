<?php

namespace App\Http\Controllers;

use App\Http\Traits\GeneralTrait;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{
    use GeneralTrait;
    public function save(Request $request)
    {
        try
        {
            ///////////// validation ///////////////
            $rules = [
                'side' => 'required',
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
            Expense::create([
                'side'=> $request->side,
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
            $expense= Expense::selection()->orderBy('id','desc')->paginate(pag);
            return $this->ReturnData('expense',$expense,'200');
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
            $expense= Expense::find($id);
            if (!$expense)
            {
                return $this->ReturnError('404','Not Found');
            }
            $expense->Selection()->where('id',$id)->get();
            return $this->ReturnData('expense',$expense,'200');
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
                'side' => 'required',
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

            $expense= Expense::find($id);
            if (!$expense)
            {
                return $this->ReturnError('404','Not Found');
            }
            $expense->where('id',$id)->update([
                'side'=> $request->side,
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
            $expense= Expense::find($id);
            if (!$expense)
            {
                return $this->ReturnError('404','Not Found');
            }
            $expense->where('id',$id)->delete();
            return $this->ReturnSuccess('200','deleted Successfully');

        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());
        }
    }
}
