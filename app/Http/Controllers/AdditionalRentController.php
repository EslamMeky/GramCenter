<?php

namespace App\Http\Controllers;

use App\Http\Traits\GeneralTrait;
use App\Models\AdditionalRent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdditionalRentController extends Controller
{
    use GeneralTrait;
    public function save(Request $request)
    {
        try
        {
            ///////////// validation ///////////////
            $rules = [
                'name' => 'required',

            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails())
            {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            ////////////////////  save  ///////////////////
            AdditionalRent::create([
                'name'=> $request->name,
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
            $rents= AdditionalRent::selection()->orderBy('id','desc')->paginate(pag);
            return $this->ReturnData('rents',$rents,'200');
        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());
        }
    }

    public function showWithoutPag()
    {
        try {
            $rents= AdditionalRent::selection()->orderBy('id','desc')->get();
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
            $rents= AdditionalRent::find($id);
            if (!$rents)
            {
                return $this->ReturnError('404','Not Found');
            }
            $rents->Selection()->where('id',$id)->get();
            return $this->ReturnData('rents',$rents,'200');
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
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails())
            {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            /////////////////////  update  ///////////

            $rents= AdditionalRent::find($id);
            if (!$rents)
            {
                return $this->ReturnError('404','Not Found');
            }
            $rents->where('id',$id)->update([
                'name' => $request->name,
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
            $rents= AdditionalRent::find($id);
            if (!$rents)
            {
                return $this->ReturnError('404','Not Found');
            }

            $rents->delete();
            return $this->ReturnSuccess('200','deleted Successfully');

        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());
        }
    }

}
