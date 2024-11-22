<?php

namespace App\Http\Controllers;

use App\Http\Traits\GeneralTrait;
use App\Models\Expense;
use App\Models\Loan;
use App\Models\Makeup;
use App\Models\Studio;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReportsController extends Controller
{
    use GeneralTrait;

    public function makeupReports()
    {
        try
        {
            $today = Carbon::now();
            $currentMonth = $today->month;
//            $currentYear = $today->year;

            $makeups = Makeup::with(['category', 'discount'])
                ->selection()
                ->orderBy('id','desc')
                ->whereMonth('created_at', $currentMonth)
//                ->whereYear('created_at', $currentYear)
                ->paginate(pag);

            foreach ($makeups as $makeup) {
                $makeup->notes = json_decode($makeup->notes, true); // تحويل notes إلى مصفوفة
            }

            return $this->ReturnData('makeup', $makeups, '200');
        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());

        }
    }

    public function makeupSearchReports(Request $request)
    {
        try
        {
//
            // التحقق من أن المصفوفة تحتوي على تاريخين
//            if (!isset($request->dates[0]) || !isset($request->dates[1])) {
//                throw new \Exception('تاريخ البدء أو الانتهاء مفقود.');
//            }
//
//            $dateStart = $request->dates[0];
//            $dateEnd = $request->dates[1];
//
//            // تأكد من تنسيق التواريخ بشكل صحيح
//            $makeup = Makeup::with(['category', 'discount'])
//                ->whereBetween('created_at', [$dateStart . ' 00:00:00', $dateEnd . ' 23:59:59'])
//                ->get();
//
//            if ($makeup->isEmpty())
//            {
//                return $this->ReturnData('makeup', $makeup, 'Not Found');
//            }
//
//            return $this->ReturnData('makeup', $makeup, 'Done search');


            $dateStart = $request->dateStart;
            $dateEnd = $request->dateEnd;

            // تأكد من تنسيق التواريخ بشكل صحيح
            $makeups = Makeup::with(['category', 'discount'])
                ->whereBetween('created_at', [$dateStart, $dateEnd])
                ->orderBy('id','desc')
                ->get();

            if ($makeups->isEmpty())
            {
                return $this->ReturnData('makeup', $makeups, 'Not Found');
            }
            foreach ($makeups as $makeup) {
                $makeup->notes = json_decode($makeup->notes, true); // تحويل notes إلى مصفوفة
            }

            return $this->ReturnData('makeup', $makeups, 'Done search');
        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());

        }
    }

    public function studioReports()
    {
        try
        {
            $today = Carbon::now();
            $currentMonth = $today->month;
//            $currentYear = $today->year;

            $sudios = Studio::with(['category', 'discount'])
                ->selection()
                ->orderBy('id','desc')
                ->whereMonth('created_at', $currentMonth)
//                ->whereYear('created_at', $currentYear)
                ->paginate(pag);

            foreach ($sudios as $sudio) {
                $sudio->notes = json_decode($sudio->notes, true); // تحويل notes إلى مصفوفة
            }
            return $this->ReturnData('studio', $sudios, '200');
        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());

        }
    }

    public function studioSearchReports(Request $request)
    {
        try
        {
//
            $dateStart = $request->dateStart;
            $dateEnd = $request->dateEnd;


            // تأكد من تنسيق التواريخ بشكل صحيح
            $sudios = Studio::with(['category', 'discount'])
                ->whereBetween('created_at', [$dateStart, $dateEnd])
                ->orderBy('id','desc')
                ->get();

            if ($sudios->isEmpty())
            {
                return $this->ReturnData('studio', $sudios, 'Not Found');
            }
            foreach ($sudios as $sudio) {
                $sudio->notes = json_decode($sudio->notes, true); // تحويل notes إلى مصفوفة
            }
            return $this->ReturnData('studio', $sudios, 'Done search');
        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());

        }
    }

    public function ExpenseReports()
    {
        try
        {
            $today = Carbon::now();
            $currentMonth = $today->month;
//            $currentYear = $today->year;

            $expense = Expense::selection()
                ->orderBy('id','desc')
                ->whereMonth('created_at', $currentMonth)
//                ->whereYear('created_at', $currentYear)
                ->paginate(pag);

            return $this->ReturnData('expense', $expense, '200');
        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());

        }
    }
    public function SearchExpenseReports(Request $request)
    {
        try
        {
            $dateStart = $request->dateStart;
            $dateEnd = $request->dateEnd;


            $expense = Expense::whereBetween('created_at', [$dateStart, $dateEnd])
                ->orderBy('id','desc')
                ->get();

            if ($expense->isEmpty())
            {
                return $this->ReturnData('expense', $expense, 'Not Found');
            }

            return $this->ReturnData('expense', $expense, 'Done search');
        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());

        }
    }

    public function LoansReports()
    {
        try
        {
            $today = Carbon::now();
            $currentMonth = $today->month;
//            $currentYear = $today->year;

            $loan = Loan::selection()
                ->orderBy('id','desc')
                ->whereMonth('created_at', $currentMonth)
//                ->whereYear('created_at', $currentYear)
                ->paginate(pag);

            return $this->ReturnData('loan', $loan, '200');
        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());

        }
    }

    public function SearchLoansReports(Request $request)
    {
        try
        {
            $dateStart = $request->dateStart;
            $dateEnd = $request->dateEnd;

            $loan = Loan::whereBetween('created_at', [$dateStart , $dateEnd ])
                ->orderBy('id','desc')
                ->get();

            if ($loan->isEmpty())
            {
                return $this->ReturnData('loan', $loan, 'Not Found');
            }

            return $this->ReturnData('loan', $loan, 'Done search');
        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());
            //return $ex;
        }
    }



    public function worksReports()
    {
        try
        {
            $today = Carbon::now();
            $currentMonth = $today->month;
//            $currentYear = $today->year;

            $works = Work::with(['employee'])->selection()
                ->orderBy('id','desc')
                ->whereMonth('created_at', $currentMonth)
//                ->whereYear('created_at', $currentYear)
                ->paginate(pag);

            return $this->ReturnData('works', $works, '200');
        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());

        }
    }

    public function SearchWorksReports(Request $request)
    {
        try
        {
            $dateStart = $request->dateStart;
            $dateEnd = $request->dateEnd;
            $search = $request->search;

            $works = Work::with(['employee'])
                ->whereBetween('created_at', [$dateStart, $dateEnd])
                ->when($search, function ($query) use ($search) {
                    $query->whereHas('employee', function ($q) use ($search) {
                        $q->where('employee_name', 'like', '%' . $search . '%'); // استبدل 'employee_field_name' بالحقل الذي تريد البحث فيه في جدول employee
                    });
                })
                ->orderBy('id', 'desc')
                ->get();
            $totalSum=$works->sum('total');

            if ($works->isEmpty())
            {
                return $this->ReturnData('works', $works, 'Not Found');
            }

            $data=[
                'Works'=>$works,
                'TotalSum'=>$totalSum,
            ];
            return $this->ReturnData('data', $data, 'Done search');
        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());
            //return $ex;
        }
    }

    public function showDailyTotal()
    {
        try
        {

                $today = Carbon::now()->toDateString(); // تاريخ اليوم بصيغة 'Y-m-d'

    // جلب السجلات التي يكون تاريخها مطابقًا اليوم لأي من الأعمدة المحددة
                $makeups = Makeup::where(function ($query) use ($today) {
                    $query->whereDate('DateOfTheFirstInstallment', $today)
                        ->orWhereDate('DateOfTheSecondInstallment', $today)
                        ->orWhereDate('DateOfTheThirdInstallment', $today);
                })->get();

    // حساب مجموع الأقساط المطابقة
                foreach ($makeups as $makeup) {
                    $makeup->notes = json_decode($makeup->notes, true); // تحويل notes إلى مصفوفة
                }
                $totalPriceMakeup = $makeups->sum(function ($makeup) use ($today) {
                    $total = 0;
                    if ($makeup->DateOfTheFirstInstallment == $today) {
                        $total += $makeup->pay;
                    }
                    if ($makeup->DateOfTheSecondInstallment == $today) {
                        $total += $makeup->secondInstallment;
                    }
                    if ($makeup->DateOfTheThirdInstallment == $today) {
                        $total += $makeup->thirdInstallment;
                    }
                    return $total;
                });


            /////////////////////////////    studio ///////
            $sudios = Studio::where(function ($query) use ($today) {
                $query->whereDate('DateOfTheFirstInstallment', $today)
                    ->orWhereDate('DateOfTheSecondInstallment', $today)
                    ->orWhereDate('DateOfTheThirdInstallment', $today);
            })->get();

// حساب مجموع الأقساط المطابقة
            foreach ($sudios as $sudio) {
                $sudio->notes = json_decode($sudio->notes, true); // تحويل notes إلى مصفوفة
            }
            $totalPriceStudio = $sudios->sum(function ($sudio) use ($today) {
                $total = 0;
                if ($sudio->DateOfTheFirstInstallment == $today) {
                    $total += $sudio->pay;
                }
                if ($sudio->DateOfTheSecondInstallment == $today) {
                    $total += $sudio->secondInstallment;
                }
                if ($sudio->DateOfTheThirdInstallment == $today) {
                    $total += $sudio->thirdInstallment;
                }
                return $total;
            });

///////////////////////////////  expenses  /////////////////
            $expenses = Expense::whereDate('updated_at', $today)->get();
            $totalPriceExpenses = $expenses->sum('price');

            $loans = Loan::whereDate('updated_at', $today)->get();
            $totalPriceLoans = $loans->sum('price');

            $works = Work::with(['employee'])->whereDate('updated_at', $today)->get();
            $totalPriceWorks = $works->sum('total');

            //////// total daily //////
            $totalDaily=($totalPriceMakeup + $totalPriceStudio + $totalPriceWorks - $totalPriceExpenses - $totalPriceLoans);
            $data=[
              'makeups'=>$makeups,
              'totalInstallmentsSum'=>$totalPriceMakeup,

              'studio'=>$sudios,
              'totalPriceStudio'=>$totalPriceStudio,

              'works'=>$works,
              '$totalPriceWorks'=>$totalPriceWorks,

              'expenses' =>$expenses,
              'totalPriceExpenses' =>$totalPriceExpenses,

              'loans' =>$loans,
              'totalPriceLoans' =>$totalPriceLoans,


              'totalDaily' =>$totalDaily

            ];
            return $this->ReturnData('data', $data, '200');
        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());

        }
    }



    public function SearchLoanReports(Request $request)
    {
        try
        {
            $dateStart = $request->dateStart;
            $dateEnd = $request->dateEnd;
            $search = $request->search;

            $loan = Loan::whereBetween('created_at', [$dateStart, $dateEnd])
                ->where('employee_name', 'like', '%' . $search . '%')
                ->orderBy('id', 'desc')
                ->get();
            $totalSum=$loan->sum('price');

            if ($loan->isEmpty())
            {
                return $this->ReturnData('loan', $loan, 'Not Found');
            }

            $data=[
                'Loan'=>$loan,
                'TotalSum'=>$totalSum,
            ];
            return $this->ReturnData('data', $data, 'Done search');
        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getMessage());
            //return $ex;
        }
    }

    public function searchDateDailyTotal(Request $request)
    {
        try
        {

//            $today = Carbon::now()->toDateString(); // تاريخ اليوم بصيغة 'Y-m-d'
            $today = $request->search;

            // جلب السجلات التي يكون تاريخها مطابقًا اليوم لأي من الأعمدة المحددة
            $makeups = Makeup::where(function ($query) use ($today) {
                $query->whereDate('DateOfTheFirstInstallment', $today)
                    ->orWhereDate('DateOfTheSecondInstallment', $today)
                    ->orWhereDate('DateOfTheThirdInstallment', $today);
            })->get();

            // حساب مجموع الأقساط المطابقة
            foreach ($makeups as $makeup) {
                $makeup->notes = json_decode($makeup->notes, true); // تحويل notes إلى مصفوفة
            }
            $totalPriceMakeup = $makeups->sum(function ($makeup) use ($today) {
                $total = 0;
                if ($makeup->DateOfTheFirstInstallment == $today) {
                    $total += $makeup->pay;
                }
                if ($makeup->DateOfTheSecondInstallment == $today) {
                    $total += $makeup->secondInstallment;
                }
                if ($makeup->DateOfTheThirdInstallment == $today) {
                    $total += $makeup->thirdInstallment;
                }
                return $total;
            });


            /////////////////////////////    studio ///////
            $sudios = Studio::where(function ($query) use ($today) {
                $query->whereDate('DateOfTheFirstInstallment', $today)
                    ->orWhereDate('DateOfTheSecondInstallment', $today)
                    ->orWhereDate('DateOfTheThirdInstallment', $today);
            })->get();

// حساب مجموع الأقساط المطابقة
            foreach ($sudios as $sudio) {
                $sudio->notes = json_decode($sudio->notes, true); // تحويل notes إلى مصفوفة
            }
            $totalPriceStudio = $sudios->sum(function ($sudio) use ($today) {
                $total = 0;
                if ($sudio->DateOfTheFirstInstallment == $today) {
                    $total += $sudio->pay;
                }
                if ($sudio->DateOfTheSecondInstallment == $today) {
                    $total += $sudio->secondInstallment;
                }
                if ($sudio->DateOfTheThirdInstallment == $today) {
                    $total += $sudio->thirdInstallment;
                }
                return $total;
            });

///////////////////////////////  expenses  /////////////////
            $expenses = Expense::whereDate('updated_at', $today)->get();
            $totalPriceExpenses = $expenses->sum('price');

            $loans = Loan::whereDate('updated_at', $today)->get();
            $totalPriceLoans = $loans->sum('price');

            $works = Work::with(['employee'])->whereDate('updated_at', $today)->get();
            $totalPriceWorks = $works->sum('total');

            //////// total daily //////
            $totalDaily=($totalPriceMakeup + $totalPriceStudio + $totalPriceWorks - $totalPriceExpenses - $totalPriceLoans);
            $data=[
                'makeups'=>$makeups,
                'totalInstallmentsSum'=>$totalPriceMakeup,

                'studio'=>$sudios,
                'totalPriceStudio'=>$totalPriceStudio,

                'works'=>$works,
                '$totalPriceWorks'=>$totalPriceWorks,

                'expenses' =>$expenses,
                'totalPriceExpenses' =>$totalPriceExpenses,

                'loans' =>$loans,
                'totalPriceLoans' =>$totalPriceLoans,


                'totalDaily' =>$totalDaily

            ];
            return $this->ReturnData('data', $data, '200');
        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());

        }

    }


}


