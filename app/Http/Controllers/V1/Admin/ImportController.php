<?php 
namespace App\Http\Controllers\V1\Admin;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\V1\Import\UploadRequest;
use App\Imports\DatabaseImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
  public function store(UploadRequest $request) 
  {
    $request["file"]->storeAs('', 'database.xlsx');
    Excel::import(new DatabaseImport, 'database.xlsx');
    return response()->json(['status'=>'success','message'=>'Database imported']);
  }
}


