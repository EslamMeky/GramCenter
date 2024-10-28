<?php

namespace App\Http\Controllers;

use App\Http\Traits\GeneralTrait;
use App\Models\Studio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudioController extends Controller
{
    use GeneralTrait;

    public function save(Request $request)
    {
        try {
            ///////////// validation ///////////////
            $rules = [
                'category_id' => 'required',
                'name' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'appropriate' => 'required',
                'pay' => 'required',
                'rest' => 'required',
                'total' => 'required',
                'receivedDate' => 'required',
                'notes' => 'nullable|array',  // Ensure notes is an array
                'notes.*.key' => 'nullable|string', // Ensure each note key is a string
                'notes.*.value' => 'nullable|integer',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            ////////////////////  save  ///////////////////
            Studio::create([
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
                'dateService' => $request->dateService,
                'DateOfTheFirstInstallment' => now(),
                'receivedDate' => $request->receivedDate,
            ]);
            return $this->ReturnSuccess('200', 'Save Successfully');
        } catch (\Exception $ex) {
            return $this->ReturnError($ex->getCode(), $ex->getCode());
//            return $ex;
        }

    }

    public function show(Request $request)
    {
        try {
            $search = $request->search;
            $studios = Studio::with(['category', 'discount'])
                ->where('name', 'LIKE', "%$search%")
                ->orderBy('id', 'desc')
                ->paginate(pag);
            if ($studios->isEmpty()) {
                return $this->ReturnData('studios', $studios, 'Not Found');

            }
            foreach ($studios as $studio) {
                $studio->notes = json_decode($studio->notes, true); // تحويل notes إلى مصفوفة
            }
            return $this->ReturnData('studios', $studios, 'done search');

        } catch (\Exception $ex) {
            return $this->ReturnError($ex->getCode(), $ex->getCode());
        }
    }

    public function edit($id)
    {
        try {
            $studio = Studio::with(['category', 'discount'])->find($id);

            if (!$studio) {
                return $this->ReturnError('404', 'Not Found');
            }

            // تحويل notes إلى مصفوفة
            $studio->notes = json_decode($studio->notes, true);

            return $this->ReturnData('studio', $studio, '200');
        } catch (\Exception $ex) {
            return $this->ReturnError($ex->getCode(), $ex->getMessage());
        }
    }


    public function update(Request $request, $id)
    {
        try {
            //////////////// validation ////////////////////
            $rules = [
//                'category_id' => 'required',
                'name' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'appropriate' => 'required',
                'pay' => 'required',
                'rest' => 'required',
                'total' => 'required',
                'receivedDate' => 'required',
                'notes' => 'nullable|array',  // Ensure notes is an array
                'notes.*.key' => 'nullable|string', // Ensure each note key is a string
                'notes.*.value' => 'nullable|integer',

            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            /////////////////////  update  ///////////

            $studio = Studio::find($id);
            if (!$studio) {
                return $this->ReturnError('404', 'Not Found');
            }

            $studio->where('id', $id)->update([
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
                'dateService' => $request->dateService,
                'DateOfTheFirstInstallment' => now(),
                'receivedDate' => $request->receivedDate,
            ]);
            return $this->ReturnSuccess('200', 'Updated Successfully');

        } catch (\Exception $ex) {
//            return $this->ReturnError($ex->getCode(), $ex->getCode());
            return $ex;
        }
    }

    public function delete($id)
    {
        try {
            $studio = Studio::find($id);
            if (!$studio) {
                return $this->ReturnError('404', 'Not Found');
            }
            $studio->where('id', $id)->delete();
            return $this->ReturnSuccess('200', 'deleted Successfully');

        } catch (\Exception $ex) {
            return $this->ReturnError($ex->getCode(), $ex->getCode());
        }
    }


    public function updateInstallment(Request $request, $id)
    {
        try {
            $studios = Studio::find($id);
            if (!$studios) {
                return $this->ReturnError('404', 'Not Found');
            }
            if ($request->has('secondInstallment') && $studios->secondInstallment == null) {
                $studios->update([
                    'secondInstallment' => $request->secondInstallment,
                    'DateOfTheSecondInstallment' => now(),
                    'pay' => $request->pay,
                    'rest' => $request->rest,
                    'total' => $request->total,
                    'status' => $request->rest == 0 ? 'تم الدفع' : 'لم يتم الدفع',

                ]);
                return $this->ReturnSuccess('200', 'updated secondInstallment Successfully');

            } elseif ($request->has('thirdInstallment') && $studios->secondInstallment != null) {
                $studios->update([
                    'thirdInstallment' => $request->thirdInstallment,
                    'DateOfTheThirdInstallment' => now(),
                    'pay' => $request->pay,
                    'rest' => $request->rest,
                    'total' => $request->total,
                    'status' => $request->rest == 0 ? 'تم الدفع' : 'لم يتم الدفع',

                ]);
                return $this->ReturnSuccess('200', 'updated third Installment Successfully');
            }

        } catch (\Exception $ex) {
            return $this->ReturnError($ex->getCode(), $ex->getMessage());
            //return $ex;
        }

    }
}
