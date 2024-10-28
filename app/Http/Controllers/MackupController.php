<?php

namespace App\Http\Controllers;

use App\Http\Traits\GeneralTrait;
use App\Models\Makeup;
use App\Models\Studio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class MackupController extends Controller
{
    use GeneralTrait;
//    public function save(Request $request)
//    {
//        try
//        {
//            ///////////// validation ///////////////
//            $rules = [
//                 'category_id' => 'required',
//                 'name' => 'required',
//                 'phone'=> 'required',
//                 'address'=> 'required',
//                'appropriate'=> 'required',
//                'pay'=> 'required',
//                'rest'=> 'required',
//                'total'=> 'required',
//            ];
//            $validator = Validator::make($request->all(), $rules);
//            if ($validator->fails())
//            {
//                $code = $this->returnCodeAccordingToInput($validator);
//                return $this->returnValidationError($code, $validator);
//            }
//            ////////////////////  save  ///////////////////
//            if ($request->rest == 0 ){
//                Makeup::create([
//                    'category_id' => $request ->category_id,
//                    'notes' =>$request->notes,
//                    'name' => $request ->name,
//                    'phone' => $request ->phone,
//                    'address' => $request ->address,
//                    'appropriate' => $request ->appropriate,
//                    'pay' => $request ->pay,
//                    'rest' => $request ->rest,
//                    'total' => $request ->total,
//                    'reason_discount_id' =>$request->reason_discount_id,
//                    'price'=>$request->price,
//                    'status' =>' تم الدفع',
//                    'arrive' =>$request->arrive,
//                    'addService'=>$request->addService,
//                    'priceService'=>$request->priceService,
//                ]);
//
//                return $this->ReturnSuccess('200','Save Successfully');
//            }
//            else
//            {
//                Makeup::create([
//                    'category_id' => $request ->category_id,
//                    'notes' =>$request->notes,
//                    'name' => $request ->name,
//                    'phone' => $request ->phone,
//                    'address' => $request ->address,
//                    'appropriate' => $request ->appropriate,
//                    'pay' => $request ->pay,
//                    'rest' => $request ->rest,
//                    'total' => $request ->total,
//                    'reason_discount_id' =>$request->reason_discount_id,
//                    'price'=>$request->price,
//                    'status' =>'لم يتم الدفع',
//                    'arrive' =>$request->arrive,
//                    'addService'=>$request->addService,
//                    'priceService'=>$request->priceService,
//                ]);
//                return $this->ReturnSuccess('200','Save Successfully');
//
//            }
//        }
//        catch (\Exception $ex)
//        {
////            return $this->ReturnError($ex->getCode(),$ex->getCode());
//            return $ex;
//        }
//
//    }


//    public function save(Request $request)
//    {
//        try {
//            // Validate incoming request
//            $rules = [
//                'category_id' => 'required',
//                'name' => 'required',
//                'phone'=> 'required',
//                'address'=> 'required',
//                'appropriate'=> 'required',
//                'pay'=> 'required',
//                'rest'=> 'required',
//                'total'=> 'required',
//                'notes' => 'required|array',  // Ensure notes is an array
//                'notes.*.key' => 'required|string',
//                'notes.*.value' => 'required|string',
//            ];
//
//            $validator = Validator::make($request->all(), $rules);
//            if ($validator->fails()) {
//                $code = $this->returnCodeAccordingToInput($validator);
//                return $this->returnValidationError($code, $validator);
//            }
//
//            // Save data
//            Makeup::create([
//                'category_id' => $request->category_id,
//                'notes' => json_encode($request->notes), // Make sure notes are encoded as JSON
//                'name' => $request->name,
//                'phone' => $request->phone,
//                'address' => $request->address,
//                'appropriate' => $request->appropriate,
//                'pay' => $request->pay,
//                'rest' => $request->rest,
//                'total' => $request->total,
//                'reason_discount_id' => $request->reason_discount_id,
//                'price' => $request->price,
//                'status' => $request->rest == 0 ? 'تم الدفع' : 'لم يتم الدفع',
//                'arrive' => $request->arrive,
//                'addService' => $request->addService,
//                'priceService' => $request->priceService,
//            ]);
//
//            return $this->ReturnSuccess('200', 'Save Successfully');
//        } catch (\Exception $ex) {
//            return $this->ReturnError($ex->getCode(), $ex->getMessage());
//        }
//    }

    public function save(Request $request)
    {
        try {
            // Validate incoming request
            $rules = [
                'category_id' => 'required',
                'name' => 'required',
                'phone'=> 'required',
                'address'=> 'required',
                'appropriate'=> 'required',
                'pay'=> 'required',
                'rest'=> 'required',
                'total'=> 'required',
                'notes' => 'nullable|array',  // Ensure notes is an array
                'notes.*.key' => 'nullable|string', // Ensure each note key is a string
                'notes.*.value' => 'nullable|integer', // Ensure each note value is a string
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            // Save data
            Makeup::create([
                'category_id' => $request->category_id,
                'notes' => json_encode($request->notes), // Store notes as JSON
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'appropriate' => $request->appropriate,
                'pay' => $request->pay,
                'rest' => $request->rest,
                'total' => $request->total,
                'reason_discount_id' => $request->reason_discount_id,
                'price' => $request->price,
                'status' => $request->rest == 0 ? 'تم الدفع' : 'لم يتم الدفع',
                'arrive' => $request->arrive,
                'addService' => $request->addService,
                'priceService' => $request->priceService,
                'dateService'=>$request->dateService,
                'typeHair'=>$request->typeHair,
                'priceHair'=>$request->priceHair,
                'dateHair'=>$request->dateHair,
                'DateOfTheFirstInstallment'=>now(),
            ]);

            return $this->ReturnSuccess('200', 'Save Successfully');
        } catch (\Exception $ex) {
            return $this->ReturnError($ex->getCode(), $ex->getMessage());
        }
    }

//    public function show()
//    {
//        try {
//            $makeups= Makeup::with(['category','discount'])->selection()->orderBy('id','desc')->paginate(pag);
//            foreach ($makeups as $makeup) {
//                $makeup->notes = json_decode($makeup->notes, true); // تحويل notes إلى مصفوفة
//            }
//            return $this->ReturnData('makeups',$makeups,'200');
//        }
//        catch (\Exception $ex)
//        {
//            return $this->ReturnError($ex->getCode(),$ex->getCode());
//        }
//    }


    public function show(Request $request)
    {
        try
        {
            $search = $request->search;

            $makeups = Makeup::with(['category','discount'])
                ->where('name','LIKE',"%$search%")
                ->orderBy('id', 'desc')
                ->paginate(pag);
//                ->orWhere('lname','LIKE',"%$search%")->get();
            if ($makeups -> isEmpty())
            {
                return $this->ReturnData('makeup',$makeups,'Not Found');

            }
            foreach ($makeups as $makeup) {
                $makeup->notes = json_decode($makeup->notes, true); // تحويل notes إلى مصفوفة
            }
            return$this->ReturnData('makeups',$makeups,'done search');

        }
        catch (\Exception $ex){
            return $this->ReturnError($ex->getCode(),$ex->getCode());
        }
    }

//    public function edit($id)
//    {
//        try
//        {
//            $makeup= Makeup::find($id);
//            if (!$makeup)
//            {
//                return $this->ReturnError('404','Not Found');
//            }
//            $makeup=Makeup::with(['category','discount'])->Selection()->where('id',$id)->get();
//            return $this->ReturnData('makeups',$makeup,'200');
//        }
//        catch (\Exception $ex)
//        {
//            return $this->ReturnError($ex->getCode(),$ex->getCode());
//        }
//    }

    public function edit($id)
    {
        try {
            $makeup = Makeup::with(['category','discount'])->Selection()->find($id);
            if (!$makeup) {
                return $this->ReturnError('404', 'Not Found');
            }

            // Decode the notes JSON back to an array
            $makeup->notes = json_decode($makeup->notes, true);


            return $this->ReturnData('makeups', $makeup, '200');
        } catch (\Exception $ex) {
            return $this->ReturnError($ex->getCode(), $ex->getMessage());
        }
    }

//    public function update(Request $request ,$id)
//    {
//        try
//        {
//            //////////////// validation ////////////////////
//            $rules = [
//                'name' => 'required',
//                'phone' => 'required',
//                'address' => 'required',
//                'appropriate' => 'required',
//                'pay' => 'required',
//                'rest' => 'required',
//                'total' => 'required',
//            ];
//            $validator = Validator::make($request->all(), $rules);
//            if ($validator->fails())
//            {
//                $code = $this->returnCodeAccordingToInput($validator);
//                return $this->returnValidationError($code, $validator);
//            }
//
//            /////////////////////  update  ///////////
//
//            $makeups= Makeup::find($id);
//            if (!$makeups)
//            {
//                return $this->ReturnError('404','Not Found');
//            }
//            if ($request->rest ==0  ){
//                $makeups->where('id',$id)->update([
//                    'name' => $request ->name,
//                    'phone' => $request ->phone,
//                    'address' => $request ->address,
//                    'appropriate' => $request ->appropriate,
//                    'pay' => $request ->pay,
//                    'rest' => $request ->rest,
//                    'total' => $request ->total,
//                    'status' =>'تم الدفع',
//                    'enter'=>$request->enter,
//                    'exit'=>$request->exit,
//                    'arrive' =>$request->arrive,
//                ]);
//                return $this->ReturnSuccess('200','Updated Successfully');
//            }
//            else{
//                $makeups->where('id',$id)->update([
//                    'name' => $request ->name,
//                    'phone' => $request ->phone,
//                    'address' => $request ->address,
//                    'appropriate' => $request ->appropriate,
//                    'pay' => $request ->pay,
//                    'rest' => $request ->rest,
//                    'total' => $request ->total,
//                    'status' =>'لم يتم الدفع',
//                    'enter'=>$request->enter,
//                    'exit'=>$request->exit,
//                    'arrive' =>$request->arrive,
//                ]);
//                return $this->ReturnSuccess('200','Updated Successfully');
//            } }
//        catch (\Exception $ex)
//        {
//            return $this->ReturnError($ex->getCode(),$ex->getCode());
//        }
//    }

    public function update(Request $request, $id)
    {
        try
        {
            //////////////// validation ////////////////////
            $rules = [
                'category_id' => 'required',
                'name' => 'required',
                'phone'=> 'required',
                'address'=> 'required',
                'appropriate'=> 'required',
                'pay'=> 'required',
                'rest'=> 'required',
                'total'=> 'required',
                'notes' => 'nullable|array',  // Ensure notes is an array
                'notes.*.key' => 'nullable|string', // Ensure each note key is a string
                'notes.*.value' => 'nullable|integer',
                // Ensure each note value is a string
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails())
            {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            /////////////////////  update  ///////////
            $makeup = Makeup::find($id);
            if (!$makeup)
            {
                return $this->ReturnError('404', 'Not Found');
            }

            // تحديث البيانات
            $makeup->update([
                'category_id' => $request->category_id,
                'notes' => json_encode($request->notes), // Store notes as JSON
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'appropriate' => $request->appropriate,
                'pay' => $request->pay,
                'rest' => $request->rest,
                'total' => $request->total,
                'reason_discount_id' => $request->reason_discount_id,
                'price' => $request->price,
                'status' => $request->rest == 0 ? 'تم الدفع' : 'لم يتم الدفع',
                'arrive' => $request->arrive,
                'addService' => $request->addService,
                'priceService' => $request->priceService,
                'dateService'=>$request->dateService,
                'typeHair'=>$request->typeHair,
                'priceHair'=>$request->priceHair,
                'dateHair'=>$request->dateHair,
                'DateOfTheFirstInstallment'=>now(),

            ]);

            return $this->ReturnSuccess('200', 'Updated Successfully');
        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(), $ex->getMessage());
        }
    }

    public function delete($id)
    {
        try
        {
            $makeups= Makeup::find($id);
            if (!$makeups)
            {
                return $this->ReturnError('404','Not Found');
            }
            $makeups->where('id',$id)->delete();
            return $this->ReturnSuccess('200','deleted Successfully');

        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());
        }
    }

    public function updateInstallment(Request $request,$id)
    {
        try
        {
            $makeups= Makeup::find($id);
            if (!$makeups)
            {
                return $this->ReturnError('404','Not Found');
            }
            if ($request->has('secondInstallment') && $makeups->secondInstallment==null)
            {
                $makeups->update([
                   'secondInstallment'=>$request->secondInstallment,
                   'DateOfTheSecondInstallment'=>now(),
                    'pay'=>$request->pay,
                    'rest'=>$request->rest,
                    'total'=>$request->total,
                    'status' => $request->rest == 0 ? 'تم الدفع' : 'لم يتم الدفع',

                ]);
                return $this->ReturnSuccess('200','updated secondInstallment Successfully');

            }
            elseif ($request->has('thirdInstallment')&& $makeups->secondInstallment!=null)
            {
                $makeups->update([
                    'thirdInstallment'=>$request->thirdInstallment,
                    'DateOfTheThirdInstallment'=>now(),
                    'pay'=>$request->pay,
                    'rest'=>$request->rest,
                    'total'=>$request->total,
                    'status' => $request->rest == 0 ? 'تم الدفع' : 'لم يتم الدفع',

                ]);
                return $this->ReturnSuccess('200','updated third Installment Successfully');
            }

        }
        catch (\Exception $ex){
            return $this->ReturnError($ex->getCode(),$ex->getMessage());
        //return $ex;
        }

    }

}
