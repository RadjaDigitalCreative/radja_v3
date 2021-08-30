<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Order;
use App\Model\OrderDetail;
use App\Model\User;
use App\Model\Payment;
use App\Model\Product;
use App\Model\Kas;
use App\Model\Credit;
use App\Exports\OrdersExport;
use Illuminate\Support\Facades\Validator;
use DB;
use PDF;
use Alert;

class CreditController extends Controller
{

    protected $folder   = 'admin.kas.saldo';
    protected $rdr   = 'admin/kas';
    public function index()
    {

    }

    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        $total = str_replace( ".", "", $request->total);
        $image = $request->file('image');
        $new_name = rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $new_name);
        $input_data = array(
            'name'               =>         $request->name,
            'table_number'               =>         $request->table_number,
            'total'               =>            $total,
            'payment_id'               =>         23,
            'created_by'               =>         $request->created_by,
            'note'               =>         $request->note,
            'keperluan'               =>         $request->keperluan,
            'lokasi'               =>         $request->lokasi,
            'id_team'               =>         auth()->user()->id_team,
            'image'               =>        $new_name
        );
        Credit::create($input_data);
        return redirect($this->rdr)->with('success', 'Data Berhasil di tambahkan');
    }

    
    public function show(Credit $credit)
    {
        //
    }

    
    public function edit(Credit $credit)
    {
        //
    }

    
    public function update(Request $request, Credit $credit)
    {
        //
    }

    public function destroy(Credit $credit)
    {
        //
    }
}
