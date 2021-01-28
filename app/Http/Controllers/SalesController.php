<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
class SalesController extends Controller
{
    public function index()
    {
    	return view('upload');
    }
    public function store()
    {
    	if (request()->has('mycsv')) {
			$data = array_map('str_getcsv',file(request()->mycsv));
			// dd($data);
			$header = $data[0];
			// dd($header);
			unset($data[0]);

			foreach ($data as $value) {
				// dd($value);
				$salesData = array_combine($header, $value);
				// dd($salesData);
				Sale::create($salesData);
			}
			return 'Done';
		}
		return 'couldnot upload';
    }
}
