<?php

namespace App\Http\Controllers;

use App\Http\Traits\GeneralTrait;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class Land extends Controller
{
    use GeneralTrait;

    public function show()
    {
        try
        {
           $category=Category::selection()->where('status','on')->get();

            return $this->ReturnData('category', $category, '200');
        }
        catch (\Exception $ex)
        {
            return $this->ReturnError($ex->getCode(),$ex->getCode());
        }

    }
}
