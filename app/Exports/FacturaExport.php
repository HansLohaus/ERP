<?php

namespace App\Exports;

use App\Factura;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class FacturaExport implements FromView
{
	use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */


    public function view(): View
    {
    	$facturas=Factura::orderBy('id', 'asc')->get();
        return view('factura.export',[
        	'facturas'=>$facturas
        ]);
    }
}
