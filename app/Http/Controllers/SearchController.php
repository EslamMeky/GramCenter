<?php

namespace App\Http\Controllers;

use App\Http\Traits\GeneralTrait;
use App\Models\Category;
use App\Models\Discount;
use App\Models\Employee;
use App\Models\Expense;
use App\Models\Loan;
use App\Models\Makeup;
use App\Models\Rent;
use App\Models\Studio;
use App\Models\SubCategory;
use App\Models\TheJob;
use App\Models\User;
use App\Models\Work;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    use GeneralTrait;

    public function SearchExpense(Request $request)
    {
        try
        {
            $search = $request->search;

            $expense=Expense::where('side','LIKE',"%$search%")->get();
//                ->orWhere('lname','LIKE',"%$search%")->get();
            if ($expense -> isEmpty())
            {
                return $this->ReturnData('expense',$expense,'Not Found');

            }
            return$this->ReturnData('expense',$expense,'done search');

        }
        catch (\Exception $ex){
            return $this->ReturnError($ex->getCode(),$ex->getCode());
        }
    }

    public function SearchLoans(Request $request)
    {
        try
        {
            $search = $request->search;

            $loan=Loan::where('employee_name','LIKE',"%$search%")->get();
//                ->orWhere('lname','LIKE',"%$search%")->get();
            if ($loan -> isEmpty())
            {
                return $this->ReturnData('loan',$loan,'Not Found');

            }
            return$this->ReturnData('loan',$loan,'done search');

        }
        catch (\Exception $ex){
            return $this->ReturnError($ex->getCode(),$ex->getCode());
        }
    }

    public function SearchAdmin(Request $request)
    {
        try
        {
            $search = $request->search;

            $admin=User::where('name','LIKE',"%$search%")
            ->orWhere('email','LIKE',"%$search%")->get();
            if ($admin -> isEmpty())
            {
                return $this->ReturnData('admin',$admin,'Not Found');

            }
            return$this->ReturnData('admin',$admin,'done search');

        }
        catch (\Exception $ex){
            return $this->ReturnError($ex->getCode(),$ex->getCode());
        }
    }


    public function SearchEmployee(Request $request)
    {
        try
        {
            $search = $request->search;

            $employee=Employee::where('employee_name','LIKE',"%$search%")->get();
//                ->orWhere('lname','LIKE',"%$search%")->get();
            if ($employee -> isEmpty())
            {
                return $this->ReturnData('employee',$employee,'Not Found');

            }
            return$this->ReturnData('employee',$employee,'done search');

        }
        catch (\Exception $ex){
            return $this->ReturnError($ex->getCode(),$ex->getCode());
        }
    }

    public function SearchJob(Request $request)
    {
        try
        {
            $search = $request->search;

            $job=TheJob::where('name','LIKE',"%$search%")->get();
//                ->orWhere('lname','LIKE',"%$search%")->get();
            if ($job -> isEmpty())
            {
                return $this->ReturnData('job',$job,'Not Found');

            }
            return$this->ReturnData('job',$job,'done search');

        }
        catch (\Exception $ex){
            return $this->ReturnError($ex->getCode(),$ex->getCode());
        }
    }

    public function SearchDiscount(Request $request)
    {
        try
        {
            $search = $request->search;

            $discount=Discount::where('discount','LIKE',"%$search%")->get();
//                ->orWhere('lname','LIKE',"%$search%")->get();
            if ($discount -> isEmpty())
            {
                return $this->ReturnData('discount',$discount,'Not Found');

            }
            return$this->ReturnData('discount',$discount,'done search');

        }
        catch (\Exception $ex){
            return $this->ReturnError($ex->getCode(),$ex->getCode());
        }
    }


    public function SearchCategory(Request $request)
    {
        try
        {
            $search = $request->search;

            $category=Category::where('name','LIKE',"%$search%")->get();
//                ->orWhere('lname','LIKE',"%$search%")->get();
            if ($category -> isEmpty())
            {
                return $this->ReturnData('category',$category,'Not Found');

            }
            return$this->ReturnData('category',$category,'done search');

        }
        catch (\Exception $ex){
            return $this->ReturnError($ex->getCode(),$ex->getCode());
        }
    }

    public function SearchSubCategory(Request $request)
    {
        try
        {
            $search = $request->search;

            $subCategory = SubCategory::with('category')->whereHas('category', function ($query) use ($search) {
                $query->where('name', 'LIKE', "%$search%"); // Search by category name
            })->get();

            if ($subCategory -> isEmpty())
            {
                return $this->ReturnData('subCategory',$subCategory,'Not Found');

            }
            return$this->ReturnData('subCategory',$subCategory,'done search');

        }
        catch (\Exception $ex){
            return $this->ReturnError($ex->getCode(),$ex->getCode());
        }
    }

    public function SearchStudio(Request $request)
    {
        try
        {
            $search = $request->search;

            $studio = Studio::with(['category','discount'])->where('name','LIKE',"%$search%")->get();
//                ->orWhere('lname','LIKE',"%$search%")->get();
            if ($studio -> isEmpty())
            {
                return $this->ReturnData('studio',$studio,'Not Found');

            }
            return$this->ReturnData('studio',$studio,'done search');

        }
        catch (\Exception $ex){
            return $this->ReturnError($ex->getCode(),$ex->getCode());
        }
    }

    public function SearchMakeup(Request $request)
    {
        try
        {
            $search = $request->search;

            $makeup = Makeup::with(['category','discount'])->where('name','LIKE',"%$search%")->get();
//                ->orWhere('lname','LIKE',"%$search%")->get();
            if ($makeup -> isEmpty())
            {
                return $this->ReturnData('makeup',$makeup,'Not Found');

            }
            return$this->ReturnData('makeup',$makeup,'done search');

        }
        catch (\Exception $ex){
            return $this->ReturnError($ex->getCode(),$ex->getCode());
        }
    }

    public function SearchRents(Request $request)
    {
        try
        {
            $search = $request->search;

            $rent = Rent::where('name','LIKE',"%$search%")->get();
//                ->orWhere('lname','LIKE',"%$search%")->get();
            if ($rent -> isEmpty())
            {
                return $this->ReturnData('rent',$rent,'Not Found');

            }
            return$this->ReturnData('rent',$rent,'done search');

        }
        catch (\Exception $ex){
            return $this->ReturnError($ex->getCode(),$ex->getCode());
        }
    }


    public function SearchWorks(Request $request)
    {
        try
        {
            $search = $request->search;

            $work = Work::with(['employee','job'])->whereHas('employee', function ($query) use ($search) {
                $query->where('employee_name', 'LIKE', "%$search%"); // Search by category name
            })->get();

            if ($work -> isEmpty())
            {
                return $this->ReturnData('work',$work,'Not Found');

            }
            return$this->ReturnData('work',$work,'done search');

        }
        catch (\Exception $ex){
            return $this->ReturnError($ex->getCode(),$ex->getCode());
        }
    }


}
