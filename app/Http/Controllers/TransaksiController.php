<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
//    public function index(Request $request)
//     {
//         $query = Transactions::query();

//         if ($request->filled('from')) {
//             $query->whereDate('created_at', '>=', $request->from);
//         }

//         if ($request->filled('to')) {
//             $query->whereDate('created_at', '<=', $request->to);
//         }

//         $transaksis = $query->latest()->paginate(10);

//         return view('transaksi.index', compact('transaksis'));
//     }

    public function index(Request $request)
    {
        // Ambil inputan dari request
        $start = $request->input('start_date');
        $end   = $request->input('end_date');

        // Jika tidak diisi, gunakan tanggal hari ini
        if (!$start || !$end) {
            $start = $end = now()->toDateString();
        }

        $transaksis = \App\Models\Transactions::whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<=', $end)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('transaksi.index', compact('transaksis'));
    }

    public function print($invoice)
    {
        $transaksi = \App\Models\Transactions::where('invoice_number', $invoice)->firstOrFail();
        $sales = \App\Models\Sale::where('invoice_number', $invoice)->with('car')->get();

        return view('transaksi.print', compact('transaksi', 'sales'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
