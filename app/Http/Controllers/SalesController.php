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

			// $data = array_map('str_getcsv',file(request()->mycsv));
			$data = file(request()->mycsv);
			// dd($data);
			// $header = $data[0];
			// // dd($header);
			// unset($data[0]);

			//chunk 
			$chunks = array_chunk($data, 1000);
			// dd($chunk[0]);
			// convert 1000 record a new csv
            $path = resource_path('temp');
			foreach ($chunks as $key => $chunk) {
				$name = "/tmp{$key}.csv";
				// return $path.$name;
				file_put_contents($path . $name, $chunk);
			}

        $files = glob("$path/*.csv");
        // return $files;
        // dd($files[0]);
        $header = [];
        foreach ($files as $key => $file) 
        {
            $data = array_map('str_getcsv', file($file));
            if ($key == 0) {
                // dd($data);
                $header = $data[0];
                // dd($header);
                unset($data[0]);
            }

            SaleCsvProccess::dispatch($data, $header);
            unlink($file);

        }
        return "stored";
		}
		return 'couldnot upload';
    }
}
