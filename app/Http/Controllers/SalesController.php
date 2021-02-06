<?php

namespace App\Http\Controllers;

use App\Jobs\SaleCsvProccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Bus\Batch;
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
            $batch = Bus::batch([])->dispatch();
			foreach ($chunks as $key => $chunk) {
                $data = array_map('str_getcsv', $chunk);
                if ($key == 0) {
                    $header = $data[0];
                    unset($data[0]);
                }
                $batch->add(new SaleCsvProccess($data, $header));
            }
        return $batch;
		}
		return 'couldnot upload';
    }
    public function batch()
    {
        $batchId= request('id');
        return Bus::findBatch($batchId);
    }
}
