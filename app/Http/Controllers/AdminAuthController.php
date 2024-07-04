<?php

namespace App\Http\Controllers;

use App\Http\Traits\GeneralTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminAuthController extends Controller
{
    use GeneralTrait;
    public function save(Request $request)
    {
        try
        {
            ///////////// validation ///////////////
            $rules = [
                'name' => 'required',
                'email' => 'required|unique:users',
                'phone' => 'required',
                'password'=>'required',
                'com_password'=>'required',
                'type'=>'required'

            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails())
            {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            ////////////////////  save  ///////////////////
            if ($request->password == $request->com_password){
                User::create([
                    'name'=> $request->name,
                    'email'=> $request->email,
                    'phone'=> $request->phone,
                    'password'=>bcrypt($request->password),
                    'type'=>$request->type,

                ]);
                return $this->ReturnSuccess('200','Save Successfully');
            }
            else{
                return $this->ReturnError('000',"Don't match password");
            }

        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());
        }
    }

    public function show()
    {
        try {
            $users= User::selection()->paginate(pag);
            return $this->ReturnData('users',$users,'200');
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
            $user= User::find($id);
            if (!$user)
            {
                return $this->ReturnError('404','Not Found');
            }
            $user->Selection()->where('id',$id)->get();
            return $this->ReturnData('user',$user,'200');
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
                'email' => 'required',
                'phone' => 'required',
//                'password'=>'required',
                'type'=>'required'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails())
            {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            /////////////////////  update  ///////////

            $users= User::find($id);
            if (!$users)
            {
                return $this->ReturnError('404','Not Found');
            }
            $users->where('id',$id)->update([
                    'name'=> $request->name,
                    'email'=> $request->email,
                    'phone'=> $request->phone,
//                    'password'=>bcrypt($request->password),
                    'type'=>$request->type,

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
            $users= User::find($id);
            if (!$users)
            {
                return $this->ReturnError('404','Not Found');
            }
            $users->where('id',$id)->delete();
            return $this->ReturnSuccess('200','deleted Successfully');

        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());
        }
    }


    public function login(Request $request)
    {
        try
        {
            $rules = [
                'email' => 'required',
                'password' => 'required',

            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            ///////  login  ////
            $incremental=$request->only(['email','password']);
            $token=Auth::guard('user-api')->attempt($incremental);
            if (!$token)
            {
                return $this->ReturnError('E001','information is not correct');
            }
            $user=Auth::guard('user-api')->user();
            $user->api_token=$token;
            return $this->ReturnData('user',$user,'login successfully');

        }
        catch (\Exception $ex){
            return $this->ReturnError($ex->getCode(),$ex->getCode());
        }
    }

    public function forgetPassword(Request $request)
    {
        try
        {
            $email=$request->email;
            $user=User::where('email',$email)->first();
            if (!$user){
                return $this->ReturnError('E001','Not found This user');
            }
            $user->where('email',$email)->update([
               'password'=>bcrypt($request->password),
            ]);
            return $this->ReturnSuccess('200','updated successfully');


        }
        catch (\Exception $ex){
            return $this->ReturnError($ex->getCode(),$ex->getCode());
        }
    }
}
