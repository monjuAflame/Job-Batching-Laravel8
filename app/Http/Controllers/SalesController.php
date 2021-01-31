<?php

namespace App\Http\Controllers;

use App\Jobs\SaleCsvProccess;
use Illuminate\Http\Request;
use App\Models\Sale;
class SalesController extends Controller
{
    public function index()
    {
    	return view('upload');
    }
    public function upload()
    {
    	if (request()->has('mycsv')) {

			$data = file(request()->mycsv);

			//chunk 
			$chunks = array_chunk($data, 1000);

            $header = [];
			foreach ($chunks as $key => $chunk) {
                $data = array_map('str_getcsv', $chunk);
                if ($key == 0) {
                    $header = $data[0];
                    unset($data[0]);
                }
                
                SaleCsvProccess::dispatch($data, $header);
            }
        return "stored";
		}
		return 'couldnot upload';
    }
}
