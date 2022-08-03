<?php

namespace App\Http\Controllers;

use App\Models\HistoryStock;
use App\Models\Order;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        if (isset($request['start_date']) && isset($request['end_date'])) {
            $orders = Order::where('status', 'done')
                ->whereDate('created_at', '>=', $request['start_date'])
                ->whereDate('created_at', '<=', $request['end_date'])
                ->get();
        } else {
            $orders = Order::where('status', 'done')->get();
        }

        $completeOrders = Order::where('status', 'done')->get();
        $pendingOrders = Order::where('status', '<>', 'done')->get();
        $totalPending = 0;
        $totalComplete = 0;
        foreach ($pendingOrders as $pendingOrder) {
            $totalPending += ($pendingOrder->amount() + $pendingOrder->totalShippingPrice());
        }
        foreach ($completeOrders as $completeOrder) {
            $totalComplete += ($completeOrder->amount() + $completeOrder->totalShippingPrice());
        }

        return view('admin.report.index', compact('orders', 'totalComplete', 'totalPending'));
    }

    public function reports(){
        if (isset($request['start_date']) && isset($request['end_date'])) {
            $orders = Order::where('status', 'done')
                ->whereDate('created_at', '>=', $request['start_date'])
                ->whereDate('created_at', '<=', $request['end_date'])
                ->get();
        } else {
            $orders = Order::where('status', 'done')->get();
        }

        $completeOrders = Order::where('status', 'done')->get();
        $modal = 0;
        $omset = 0;
        $untungRugi = 0;
        foreach($completeOrders as $order){
            $modal += $order->modal();
            $omset += $order->amount();
        }
        $untungRugi = ($omset-$modal)*(100-0.25)/100;
        return view('admin.report.reports',compact('modal','omset','untungRugi','orders'));
    }

    public function stocksHistory(){
        $historyStocks = HistoryStock::with('productDetail.product')->get();

        return view('admin.report.stock', compact('historyStocks'));
    }

}
