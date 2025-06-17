<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Sale;

class SaleController extends Controller
{
        private function generateInvoiceNumber(): string
    {
        $today = Carbon::today()->format('dmY'); // contoh: 26052025
        $countToday = \App\Models\Sale::whereDate('created_at', Carbon::today())->count() + 1;
        $urutan = str_pad($countToday, 4, '0', STR_PAD_LEFT);
        return $today . '-' . $urutan; // hasil: 26052025-0001
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $sales = Sale::with('car')->paginate(10);

        // return view('sales.index', compact('sales'));
        $cars = \App\Models\Car::where('stock', '>', 0)
                ->orderBy('name')
                ->get();

        return view('sales.index', compact('cars'));
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cars = Car::where('stock', '>', 0)->pluck('name', 'id');

        return view('sales.create', compact('cars'));
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $req)
    {
        $data = $req->validate([
            'car_id'=>'required|exists:cars,id',
            'quantity'=>'required|integer|min:1',
        ]);

        $car = Car::findOrFail($data['car_id']);
        if($car->stock < $data['quantity']){
            return back()->withErrors('Stok tidak cukup.');
        }

        $invoice = $this->generateInvoiceNumber();
        
        $sale = Sale::create([
            'invoice_number' => $invoice,
            'car_id'     => $car->id,
            'quantity'   => $data['quantity'],
            'price_item' => $car->price,
            'total_price'=> $car->price * $data['quantity'],
            'sold_at'    => now(),
        ]);

        // Kurangi stok
        $car->decrement('stock', $data['quantity']);

        return redirect()->route('sales.index')->with('success','Penjualan berhasil.');
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
    public function edit(Sale $sale)
    {
        $cars = Car::pluck('name', 'id');

        return view('sales.edit', compact('sale', 'cars'));
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        $data = $request->validate([
            'car_id'   => 'required|exists:cars,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // restore stok lama sebelum update
        $oldQty = $sale->quantity;
        $sale->car->increment('stock', $oldQty);

        $car = Car::findOrFail($data['car_id']);
        if ($car->stock < $data['quantity']) {
            return back()->withErrors(['quantity' => 'Stok tidak cukup'])->withInput();
        }

        // update sale
        $sale->update([
            'car_id'      => $data['car_id'],
            'quantity'    => $data['quantity'],
            'total_price' => $car->price * $data['quantity'],
        ]);

        // kurangi stok baru
        $car->decrement('stock', $data['quantity']);

        return redirect()
            ->route('sales.index')
            ->with('success', 'Penjualan berhasil diperbarui.');
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        $sale->car->increment('stock', $sale->quantity);

        $sale->delete();

        return redirect()
            ->route('sales.index')
            ->with('success', 'Penjualan berhasil dihapus.');
        //
    }

}
