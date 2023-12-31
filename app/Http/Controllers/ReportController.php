<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['index']);
        $this->middleware('auth:api')->only(['get_reports']);
    }

    public function index () {
        return view('report.index');
    }
    public function get_reports(Request $request)
    {
        if(!$request['dari']) $request['dari'] = date('Y-m-d');
        if(!$request['sampai']) $request['sampai'] = date('Y-m-d');
        $report = DB::table('order_details')
            ->join('products', 'products.id', '=', 'order_details.id_produk')
            ->select(DB::raw('
            nama_barang,
            count(*) as jumlah_dibeli, 
            nama_barang,
            harga,
            SUM(total) as pendapatan, 
            SUM(jumlah) as total_qty'))
            ->whereRaw("date(order_details.created_at) >= '$request->dari'")
            ->whereRaw("date(order_details.created_at) <= '$request->sampai'")
            ->groupBy('id_produk', 'nama_barang', 'harga')->get();

        return response()->json([
            'data' => $report
        ]);
    }
}
