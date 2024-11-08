<?php

namespace App\Http\Controllers;

use App\Http\Traits\GeneralTrait;
use App\Models\importantLand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ImportantLandController extends Controller
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
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails())
            {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            ////////////////////  save  ///////////////////
            if ($request->hasFile('photo')) {
                $pathFile = uploadImage('importantLand', $request->photo);
                importantLand::create([
                    'name' => $request->name,
                    'desc' => $request->desc,
                    'photo' => $pathFile,
                ]);

                return $this->ReturnSuccess('200','Save Successfully');
            }
            else
            {
                importantLand::create([
                    'name' => $request->name,
                    'desc' => $request->desc,
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
            $important= importantLand::selection()->orderBy('id','desc')->paginate(pag);
            return $this->ReturnData('important',$important,'200');
        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());
        }
    }
    public function showWithoutPag()
    {
        try {
            $important= importantLand::selection()->orderBy('id','desc')->get();
            return $this->ReturnData('important',$important,'200');
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
            $important= importantLand::find($id);
            if (!$important)
            {
                return $this->ReturnError('404','Not Found');
            }
            $important->Selection()->where('id',$id)->get();
            return $this->ReturnData('important',$important,'200');
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
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails())
            {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            /////////////////////  update  ///////////

            $important= importantLand::find($id);
            if (!$important)
            {
                return $this->ReturnError('404','Not Found');
            }


            if ($request->hasFile('photo'))
            {
                // استخراج المسار النسبي للصورة من URL
                $photoPath = parse_url($important->photo, PHP_URL_PATH);
                $photoPath = ltrim($photoPath, '/'); // إزالة الشرطة المائلة في بداية المسار إذا كانت موجودة
                $oldImagePath = public_path($photoPath);

                // التحقق من وجود الصورة القديمة
                if ($important->photo && file_exists($oldImagePath))
                {
                    // إرسال رسالة إذا تم العثور على الصورة
                    // return $this->ReturnSuccess('200', 'تم العثور على الصورة القديمة في المسار: ' . $oldImagePath);

                    // حذف الصورة القديمة
                    unlink($oldImagePath);
                }

                // تحميل الصورة الجديدة
                $pathFile = uploadImage('importantLand', $request->photo);
                $important->update([
                    'photo' => $pathFile,
                ]);
            }
            $important->where('id',$id)->update([
                'name' => $request->name,
                'desc' => $request->desc,
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
            $important= importantLand::find($id);
            if (!$important){
                return $this->ReturnError('404','Not Found');
            }
            $status=$important->status=='off'? 'on':'off';
            $important->update(['status'=>$status]);
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
            $important= importantLand::find($id);
            if (!$important)
            {
                return $this->ReturnError('404','Not Found');
            }
            if ($important->photo != null){
                $image=Str::after($important->photo,'assets/');
                $image=base_path('public/assets/'.$image);
                unlink($image);
                $important->delete();
            }
            else
                $important->delete();
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
