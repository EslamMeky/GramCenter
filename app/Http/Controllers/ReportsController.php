<?php

namespace App\Http\Controllers;

use App\Http\Traits\GeneralTrait;
use App\Models\Expense;
use App\Models\Loan;
use App\Models\Makeup;
use App\Models\Studio;
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
            $currentYear = $today->year;

            $makeup = Makeup::with(['category', 'discount'])
                ->selection()
                ->orderBy('id','desc')
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->paginate(pag);

            return $this->ReturnData('makeup', $makeup, '200');
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
            $makeup = Makeup::with(['category', 'discount'])
                ->whereBetween('created_at', [$dateStart, $dateEnd])
                ->orderBy('id','desc')
                ->get();

            if ($makeup->isEmpty())
            {
                return $this->ReturnData('makeup', $makeup, 'Not Found');
            }

            return $this->ReturnData('makeup', $makeup, 'Done search');
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
            $currentYear = $today->year;

            $studio = Studio::with(['category', 'discount'])
                ->selection()
                ->orderBy('id','desc')
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->paginate(pag);

            return $this->ReturnData('studio', $studio, '200');
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
            $studio = Studio::with(['category', 'discount'])
                ->whereBetween('created_at', [$dateStart, $dateEnd])
                ->orderBy('id','desc')
                ->get();

            if ($studio->isEmpty())
            {
                return $this->ReturnData('studio', $studio, 'Not Found');
            }

            return $this->ReturnData('studio', $studio, 'Done search');
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
            $currentYear = $today->year;

            $expense = Expense::selection()
                ->orderBy('id','desc')
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
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
            $currentYear = $today->year;

            $loan = Loan::selection()
                ->orderBy('id','desc')
                ->whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
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


}


