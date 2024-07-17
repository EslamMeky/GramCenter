<?php

namespace App\Http\Controllers;

use App\Http\Traits\GeneralTrait;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DiscountController extends Controller
{
    use GeneralTrait;
    public function save(Request $request)
    {
        try
        {
        ///////////// validation ///////////////
        $rules = [
            'discount' => 'required',
            'price' => 'required',

        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails())
        {
            $code = $this->returnCodeAccordingToInput($validator);
            return $this->returnValidationError($code, $validator);
        }
        ////////////////////  save  ///////////////////
        Discount::create([
            'discount'=> $request->discount,
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
            $discounts= Discount::selection()->paginate(pag);
            return $this->ReturnData('discounts',$discounts,'200');
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
            $discount= Discount::find($id);
            if (!$discount)
            {
                return $this->ReturnError('404','Not Found');
            }
            $discount->Selection()->where('id',$id)->get();
            return $this->ReturnData('discount',$discount,'200');
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
                'discount' => 'required',
                'price' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails())
            {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            /////////////////////  update  ///////////

            $discount= Discount::find($id);
            if (!$discount)
            {
                return $this->ReturnError('404','Not Found');
            }
            $discount->where('id',$id)->update([
                'discount' => $request->discount,
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
            $discount= Discount::find($id);
            if (!$discount)
            {
                return $this->ReturnError('404','Not Found');
            }
            $discount->where('id',$id)->delete();
            return $this->ReturnSuccess('200','deleted Successfully');

        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());
        }
    }

    public function getPriceDiscount($id){
        try
        {
            $discount= Discount::find($id);
            if (!$discount)
            {
                return $this->ReturnError('404','Not Found');
            }
            $discount->Selection()->where('id',$id)->get();
            return $this->ReturnData('discount',$discount,'200');
        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());
        }
    }

    public function getDiscount()
    {
        try {
            $discounts= Discount::selection()->get();
            return $this->ReturnData('discounts',$discounts,'200');
        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());
        }
    }

    public function getPrice(Request $request)
    {
        try {
            // افترض أن المعرّفات يتم إرسالها كمصفوفة في الطلب
            $ids = $request->ids;

            if (!is_array($ids) || empty($ids)) {
                return $this->ReturnError('400', 'No valid IDs provided');
            }

            // جلب التخفيضات بناءً على المعرّفات
            $discounts = Discount::whereIn('id',$ids)->get();

            if ($discounts->isEmpty()) {
                return $this->ReturnError('404', 'No discounts found for the provided IDs');
            }

            // حساب مجموع الأسعار
            $totalPrice = $discounts->sum('price'); // تأكد من أن 'price' هو العمود الصحيح

            return $this->ReturnData('totalPrice', $totalPrice, '200');
        } catch (\Exception $ex) {
            return $this->ReturnError($ex->getCode(), $ex->getMessage());
        }
    }
}
