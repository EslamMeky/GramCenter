<?php

namespace App\Http\Controllers;

use App\Http\Traits\GeneralTrait;
use App\Models\TheJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TheJobController extends Controller
{
    use GeneralTrait;
    public function save(Request $request)
    {
        try
        {
            ///////////// validation ///////////////
            $rules = [
                'name' => 'required|unique:the_jobs',
                'price' => 'required'

            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails())
            {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            ////////////////////  save  ///////////////////
            TheJob::create([
                'name'=> $request->name,
                'price'=> $request->price,
            ]);
            return $this->ReturnSuccess('200','Save Successfully');
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
            $jobs= TheJob::selection()->paginate(pag);
            return $this->ReturnData('jobs',$jobs,'200');
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
            $job= TheJob::find($id);
            if (!$job)
            {
                return $this->ReturnError('404','Not Found');
            }
            $job->Selection()->where('id',$id)->get();
            return $this->ReturnData('job',$job,'200');
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
                'price' => 'required',

            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails())
            {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            /////////////////////  update  ///////////
            $job= TheJob::find($id);
            if (!$job)
            {
                return $this->ReturnError('404','Not Found');
            }
            $job->where('id',$id)->update([
                'name' => $request->name,
                'price' => $request->price,

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
            $job = TheJob::find($id);
            if (!$job) {
                return $this->ReturnError('404', 'Not Found');
            }
            $job->where('id', $id)->delete();
            return $this->ReturnSuccess('200', 'deleted Successfully');

        } catch (\Exception $ex) {
            return $this->ReturnError($ex->getCode(), $ex->getCode());
        }
    }


    public function getJobs()
    {
        try {
            $jobs= TheJob::selection()->get();
            return $this->ReturnData('jobs',$jobs,'200');
        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());
        }
    }
    public function getJobPrice($name)
    {
        try {
//            $job = TheJob::find($name);
//            if (!$job) {
//                return $this->ReturnError('404', 'Not Found');
//            }
            $job=TheJob::selection()->where('name',$name)->get();
            if ($job -> isEmpty())
            {
                return $this->ReturnData('job',$job,'Not Found');

            }
            return $this->ReturnData('job',$job,'200');
        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());
        }
    }

}
