<?php

namespace App\Http\Controllers;

use App\Http\Traits\GeneralTrait;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TestController extends Controller
{
   use GeneralTrait;
    public function add(Request $request)
    {
        try
        {
            $rules = [
                'name'=>'required',
                'email'=>'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            /// add

            Test::create([
                'name'=>$request->name,
                'email'=>$request->email,
            ]);
            return $this->ReturnSuccess('S000', __('messages.added'));


        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getMessage());
        }
    }

    public function show()
    {
        try {

            $test=Test::selection()->paginate(5);
            return $this->ReturnData('test',$test,'S00');
        }
        catch (\Exception $ex){
            return $this->ReturnError($ex->getCode(),$ex->getMessage());
        }
    }

    public function edit($id){
        try {
            $test=Test::find($id);
            if (!$test){
                return  $this->ReturnError('E00',__('messages.not found this category'));
            }
            $test->where('id',$id)->get();
            return $this->ReturnData('test',$test,'S00');
        }
        catch (\Exception $ex){
            return $this->ReturnError($ex->getCode(),$ex->getMessage());
        }
    }



    public function update(Request $request ,$id)
    {
        try
        {
            $rules = [
                'name'=>'required',
                'email'=>'required',


            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            /// update
            $test=Test::find($id);
            if (!$test){
                return $this->ReturnError('E00',__('messages.not found this category'));
            }

            Test::where('id',$id)->update([
                'name'=>$request->name,
                'email'=>$request->email,
            ]);

            return $this->ReturnSuccess('S000', __('messages.update'));


        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getMessage());
        }

    }


    public function delete($id){
        try {
            $test=Test::find($id);
            if (!$test){
                return  $this->ReturnError('E00',__('messages.not found this category'));
            }
            $test->delete();
            return $this->ReturnSuccess('S00',__('messages.delete'));
        }
        catch (\Exception $ex){
            return $this->ReturnError($ex->getCode(),$ex->getMessage());
        }
    }


}
