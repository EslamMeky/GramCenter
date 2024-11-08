<?php

namespace App\Http\Controllers;

use App\Http\Traits\GeneralTrait;
use App\Models\MainLand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MainLandController extends Controller
{
    use GeneralTrait;
    public function save(Request $request)
    {
        try
        {
            ///////////// validation ///////////////
            $rules = [
                'name' => 'required',
                'desc' => 'required',
                'photo' => 'required',
                'buttonName'=>'required',
                'buttonLink'=>'required',
                'status'=>'required',

            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails())
            {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            ////////////////////  save  ///////////////////
            if ($request->hasFile('photo')) {
                $pathFile = uploadImage('mainLand', $request->photo);
                MainLand::create([
                    'name' => $request->name,
                    'desc' => $request->desc,
                    'photo' => $pathFile,
                    'buttonName' => $request->buttonName,
                    'buttonLink' => $request->buttonLink,
                    'status' => $request->status,

                ]);

            return $this->ReturnSuccess('200','Save Successfully');
            }
            else
            {
                MainLand::create([
                    'name' => $request->name,
                    'desc' => $request->desc,
                    'buttonName' => $request->buttonName,
                    'buttonLink' => $request->buttonLink,
                    'status' => $request->status,

                ]);
                return $this->ReturnSuccess('200','Save Successfully');
            }
        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getMessage());
//            return $ex;
        }

    }

    public function show()
    {
        try {
            $main= MainLand::selection()->orderBy('id','desc')->paginate(pag);
            return $this->ReturnData('main',$main,'200');
        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());
        }
    }
    public function showWithoutPag()
    {
        try {
            $main= MainLand::selection()->orderBy('id','desc')->get();
            return $this->ReturnData('main',$main,'200');
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
            $main= MainLand::find($id);
            if (!$main)
            {
                return $this->ReturnError('404','Not Found');
            }
            $main->Selection()->where('id',$id)->get();
            return $this->ReturnData('main',$main,'200');
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
                'desc' => 'required',
                'photo'=>'required',
                'buttonName' => 'required',
                'buttonLink'=>'required',
                'status'=>'required',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails())
            {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            /////////////////////  update  ///////////

            $main= MainLand::find($id);
            if (!$main)
            {
                return $this->ReturnError('404','Not Found');
            }


            if ($request->hasFile('photo'))
            {
                // استخراج المسار النسبي للصورة من URL
                $photoPath = parse_url($main->photo, PHP_URL_PATH);
                $photoPath = ltrim($photoPath, '/'); // إزالة الشرطة المائلة في بداية المسار إذا كانت موجودة
                $oldImagePath = public_path($photoPath);

                // التحقق من وجود الصورة القديمة
                if ($main->photo && file_exists($oldImagePath))
                {
                    // إرسال رسالة إذا تم العثور على الصورة
                    // return $this->ReturnSuccess('200', 'تم العثور على الصورة القديمة في المسار: ' . $oldImagePath);

                    // حذف الصورة القديمة
                    unlink($oldImagePath);
                }

                // تحميل الصورة الجديدة
                $pathFile = uploadImage('mainLand', $request->photo);
                $main->update([
                    'photo' => $pathFile,
                ]);
            }
            $main->where('id',$id)->update([
                'name' => $request->name,
                'desc' => $request->desc,
                'buttonName' =>$request->buttonName,
                'status'=>$request->status,
                'buttonLink'=>$request->buttonLink,

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
            $main= MainLand::find($id);
            if (!$main){
                return $this->ReturnError('404','Not Found');
            }
            $status=$main->status=='off'? 'on':'off';
            $main->update(['status'=>$status]);
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
            $main= MainLand::find($id);
            if (!$main)
            {
                return $this->ReturnError('404','Not Found');
            }
            if ($main->photo != null){
                $image=Str::after($main->photo,'assets/');
                $image=base_path('public/assets/'.$image);
                unlink($image);
                $main->delete();
            }
            else
                $main->delete();
            return $this->ReturnSuccess('200','deleted Successfully');

        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());
        }
    }

    function uploadImage($folder,$image)
    {
        $image->store('/',$folder);
        $filename=$image->hashName();
        $path='images/'.$folder.'/'.$filename;
        return $path;
    }
}
