<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Stocks;
use Session;


class PrintController extends Controller
{
      
      public function indexx()
    {
    	return view('admin.stocks.printstock');
    	  
    }


      public function prnpriview()
      {
            $stock = Stocks::all();
            return view('printstock')->with('printstock', $stock);
      }
}
