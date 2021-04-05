<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use sasco\LibreDTE\Sii\Dte;

class DTEController extends Controller
{
    public function import(Request $request){
    	$file=$request->file("file");
    	$file_content=file_get_contents($file->getRealPath());
    	dd($file_content);

    	// $dte= new Dte();
    }
}
