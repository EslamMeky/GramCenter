<?php

namespace App\Http\Controllers;

use App\Http\Traits\GeneralTrait;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeControler extends Controller
{
    use GeneralTrait;
    public function save(Request $request)
    {
        try
        {
            ///////////// validation ///////////////
            $rules = [
                'employee_name' => 'required',
                'phone' => 'required',
                'salary' => 'required',
                'num'=>'required'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails())
            {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            ////////////////////  save  ///////////////////
            Employee::create([
                'employee_name'=> $request->employee_name,
                'phone'=> $request->phone,
                'salary'=> $request->salary,
                'num'=>$request->num,
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
           $employees= Employee::selection()->orderBy('id','desc')->paginate(pag);
            return $this->ReturnData('employee',$employees,'200');
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
            $employee= Employee::find($id);
            if (!$employee)
            {
              return $this->ReturnError('404','Not Found');
            }
            $employee->Selection()->where('id',$id)->get();
            return $this->ReturnData('employee',$employee,'200');
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
                'phone' => 'required',
                'salary' => 'required',
                'num'=>'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails())
            {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            /////////////////////  update  ///////////
            $employee= Employee::find($id);
            if (!$employee)
            {
                return $this->ReturnError('404','Not Found');
            }
           $employee->where('id',$id)->update([
                'employee_name' => $request->employee_name,
                'phone' => $request->phone,
                'salary' => $request->salary,
               'num'=>$request->num,

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
            $employee= Employee::find($id);
            if (!$employee)
            {
                return $this->ReturnError('404','Not Found');
            }
           $employee->where('id',$id)->delete();
            return $this->ReturnSuccess('200','deleted Successfully');

        }
        catch (\Exception $ex)
        {
         return $this->ReturnError($ex->getCode(),$ex->getCode());
        }
    }

    public function getEmployee()
    {
        try {
            $employees= Employee::selection()->orderBy('id','desc')->get();
            return $this->ReturnData('employee',$employees,'200');
        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());
        }
    }
}
