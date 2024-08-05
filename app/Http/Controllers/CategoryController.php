<?php

namespace App\Http\Controllers;

use App\Http\Traits\GeneralTrait;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
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
                'price'=>'required',
                'type'=>'required',
                'status'=>'required',

            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails())
            {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            ////////////////////  save  ///////////////////
            $pathFile=uploadImage('category',$request->photo);
//            $file_ex=$request->photo->getClientOriginalExtension();
//            $fileName= time().'.'.$file_ex;
//            $path='images/categories';
//            $request->photo->move($path,$fileName);
            Category::create([
                'name'=> $request->name,
                'desc'=> $request->desc,
                'photo'=> $pathFile,
                'price'=>$request->price,
                'type'=>$request->type,
                'status'=>$request->status,
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
            $categories= Category::selection()->orderBy('id','desc')->paginate(pag);
            return $this->ReturnData('categories',$categories,'200');
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
            $category= Category::find($id);
            if (!$category)
            {
                return $this->ReturnError('404','Not Found');
            }
            $category->Selection()->where('id',$id)->get();
            return $this->ReturnData('category',$category,'200');
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
                'type' => 'required',
                'price'=>'required',
                'status'=>'required',
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails())
            {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            /////////////////////  update  ///////////

            $category= Category::find($id);
            if (!$category)
            {
                return $this->ReturnError('404','Not Found');
            }
            $category->where('id',$id)->update([
                'name' => $request->name,
                'desc' => $request->desc,
                'type' =>$request->type,
                'status'=>$request->status,
                'price'=>$request->price,

            ]);

            if ($request->hasFile('photo'))
            {
                $pathFile=uploadImage('category',$request->photo);
//                $file_ex=$request->photo->getClientOriginalExtension();
//                $fileName= time().'.'.$file_ex;
//                $path='images/categories';
//                $request->photo->move($path,$fileName);
                $category->where('id',$id)->update([
                    'photo' => $pathFile,
                    ]);
            }
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
            $category= Category::find($id);
            if (!$category){
                return $this->ReturnError('404','Not Found');
            }
            $status=$category->status=='off'? 'on':'off';
            $category->update(['status'=>$status]);
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
            $category= Category::find($id);
            if (!$category)
            {
                return $this->ReturnError('404','Not Found');
            }
            if ($category->photo != null){
                $image=Str::after($category->photo,'assets/');
                $image=base_path('public/assets/'.$image);
                unlink($image);
                $category->delete();
            }
            else
                $category->delete();
            return $this->ReturnSuccess('200','deleted Successfully');

        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());
        }
    }

    public function showMakeup(){
        try {
            $makeup= Category::selection()->orderBy('id','desc')->where('type','ميكاب')->get();
            return $this->ReturnData('makeup',$makeup,'200');
        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());
        }
    }

    public function showStudio(){
        try {
            $makeup= Category::selection()->orderBy('id','desc')->where('type','استوديو')->get();
            return $this->ReturnData('makeup',$makeup,'200');
        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());
        }
    }
    public function showCategory()
    {
        try {
            $categories= Category::selection()->orderBy('id','desc')->get();
            return $this->ReturnData('categories',$categories,'200');
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
