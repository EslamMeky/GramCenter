<?php

namespace App\Http\Controllers;

use App\Http\Traits\GeneralTrait;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WorksController extends Controller
{
    use GeneralTrait;
    public function save(Request $request)
    {
        try
        {
            ///////////// validation ///////////////
            $rules = [
                'employee_name_id' => 'required',
                'job_id' => 'required',

            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails())
            {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            ////////////////////  save  ///////////////////
            Work::create([
                'employee_name_id'=> $request->employee_name_id,
                'job_id'=> $request->job_id,

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
            $works= Work::with(['employee','job'])->selection()->paginate(pag);
            return $this->ReturnData('works',$works,'200');
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
            $work= Work::find($id);
            if (!$work)
            {
                return $this->ReturnError('404','Not Found');
            }
            $work= Work::with(['employee','job'])->Selection()->where('id',$id)->get();
            return $this->ReturnData('work',$work,'200');
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
                'employee_name_id' => 'required',
                'job_id' => 'required',

            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails())
            {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            /////////////////////  update  ///////////
            $work= Work::find($id);
            if (!$work)
            {
                return $this->ReturnError('404','Not Found');
            }
            $work->where('id',$id)->update([
                'employee_name_id' => $request->employee_name_id,
                'job_id' => $request->job_id,


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
        try {
            $work = Work::find($id);
            if (!$work) {
                return $this->ReturnError('404', 'Not Found');
            }
            $work->where('id', $id)->delete();
            return $this->ReturnSuccess('200', 'deleted Successfully');

        } catch (\Exception $ex) {
            return $this->ReturnError($ex->getCode(), $ex->getCode());
        }
    }

}
