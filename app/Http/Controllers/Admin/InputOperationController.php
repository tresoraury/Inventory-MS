<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InputOperation;
use Illuminate\Http\Request;

class InputOperationController extends Controller
{
    public function index()
    {
        $inputOperations = InputOperation::with('materiel')->get();
        return view('admin.input_operations.index', compact('inputOperations'));
    }
}
