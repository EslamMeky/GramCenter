<?php

namespace App\Http\Controllers;

use App\Http\Traits\GeneralTrait;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
    use GeneralTrait;
    public function save(Request $request)
    {
        try
        {
            ///////////// validation ///////////////
            $rules = [
                'category_id' => 'required',
                'item' => 'required',
                'price' => 'required',

            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails())
            {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            ////////////////////  save  ///////////////////
            SubCategory::create([
                'category_id'=> $request->category_id,
                'item'=> $request->item,
                'price'=> $request->price,
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
            $subCategory= SubCategory::with('category')->selection()->paginate(pag);
            return $this->ReturnData('subCategory',$subCategory,'200');
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
            $subCategory= SubCategory::find($id);
            if (!$subCategory)
            {
                return $this->ReturnError('404','Not Found');
            }
            $subCategory->Selection()->where('id',$id)->get();
            return $this->ReturnData('subCategory',$subCategory,'200');
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
                'category_id' => 'required',
                'item'=>'required',
                'price' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails())
            {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            /////////////////////  update  ///////////

            $subCategory= SubCategory::find($id);
            if (!$subCategory)
            {
                return $this->ReturnError('404','Not Found');
            }
            $subCategory->where('id',$id)->update([
                'category_id' => $request->category_id,
                'item'=>$request->item,
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
        try
        {
            $subCategory= SubCategory::find($id);
            if (!$subCategory)
            {
                return $this->ReturnError('404','Not Found');
            }
            $subCategory->where('id',$id)->delete();
            return $this->ReturnSuccess('200','deleted Successfully');

        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());
        }
    }

    public function getCategory($id)
    {
        try
        {
         $category=SubCategory::with(['category'=>function($q){
             $q->select('id','name','desc','type','price');
         }])->where('category_id',$id)->get();
         return $this->ReturnData('category',$category,'200');
        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());
        }
    }
}
