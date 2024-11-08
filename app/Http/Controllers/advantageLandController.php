<?php

namespace App\Http\Controllers;

use App\Http\Traits\GeneralTrait;
use App\Models\advantageLand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class advantageLandController extends Controller
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
                $pathFile = uploadImage('advantageLand', $request->photo);
                advantageLand::create([
                    'name' => $request->name,
                    'desc' => $request->desc,
                    'photo' => $pathFile,
                ]);

                return $this->ReturnSuccess('200','Save Successfully');
            }
            else
            {
                advantageLand::create([
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
            $advantage= advantageLand::selection()->orderBy('id','desc')->paginate(pag);
            return $this->ReturnData('advantage',$advantage,'200');
        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());
        }
    }
    public function showWithoutPag()
    {
        try {
            $advantage= advantageLand::selection()->orderBy('id','desc')->get();
            return $this->ReturnData('advantage',$advantage,'200');
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
            $advantage= advantageLand::find($id);
            if (!$advantage)
            {
                return $this->ReturnError('404','Not Found');
            }
            $advantage->Selection()->where('id',$id)->get();
            return $this->ReturnData('advantage',$advantage,'200');
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

            $advantage= advantageLand::find($id);
            if (!$advantage)
            {
                return $this->ReturnError('404','Not Found');
            }


            if ($request->hasFile('photo'))
            {
                // استخراج المسار النسبي للصورة من URL
                $photoPath = parse_url($advantage->photo, PHP_URL_PATH);
                $photoPath = ltrim($photoPath, '/'); // إزالة الشرطة المائلة في بداية المسار إذا كانت موجودة
                $oldImagePath = public_path($photoPath);

                // التحقق من وجود الصورة القديمة
                if ($advantage->photo && file_exists($oldImagePath))
                {
                    // إرسال رسالة إذا تم العثور على الصورة
                    // return $this->ReturnSuccess('200', 'تم العثور على الصورة القديمة في المسار: ' . $oldImagePath);

                    // حذف الصورة القديمة
                    unlink($oldImagePath);
                }

                // تحميل الصورة الجديدة
                $pathFile = uploadImage('importantLand', $request->photo);
                $advantage->update([
                    'photo' => $pathFile,
                ]);
            }
            $advantage->where('id',$id)->update([
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

    public function delete($id)
    {
        try
        {
            $advantage= advantageLand::find($id);
            if (!$advantage)
            {
                return $this->ReturnError('404','Not Found');
            }
            if ($advantage->photo != null){
                $image=Str::after($advantage->photo,'assets/');
                $image=base_path('public/assets/'.$image);
                unlink($image);
                $advantage->delete();
            }
            else
                $advantage->delete();
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
