<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Sale;
use App\Models\Transactions;

class CartController extends Controller
{
    private function generateInvoiceNumber()
{
    $today = now()->format('dmy'); // hasil: 260524
    $count = \App\Models\Sale::whereDate('created_at', today())->count() + 1;
    $urut = str_pad($count, 4, '0', STR_PAD_LEFT); // hasil: 0001
    return $today . $urut; // hasil akhir: 2605240001
}

    // Tampilkan isi keranjang
    public function index(Request $request)
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function checkoutForm(Request $request)
    {
        $selected = $request->input('items', []);
        $cart = session('cart', []);
        $items = collect($cart)->only($selected)->toArray();

        if (empty($items)) {
            return redirect()->route('cart.index')->with('error', 'Tidak ada item yang dipilih untuk checkout.');
        }

        return view('cart.checkout', [
            'items' => $items
        ]);
    }

    public function deleteSelected(Request $request)
    {
        $selected = explode(',', $request->input('items')[0] ?? '');
        $cart = session('cart', []);

        foreach ($selected as $carId) {
            unset($cart[$carId]);
        }

        session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'Item berhasil dihapus dari keranjang.');
    }


public function checkoutSubmit(Request $request)
{
    $request->validate([
        'name'    => 'required|string|max:255',
        'phone'   => 'required|string|max:20',
        'address' => 'required|string',
        'ket' => 'required|string|in:Bank,Cash,Debit',
        'items'   => 'required|array',
    ]);

    $cart = session()->get('cart', []);
    if (empty($cart)) {
        return back()->withErrors(['empty' => 'Keranjang kosong.']);
    }

    $datePart = now()->format('dmy');
    $countToday = Sale::whereDate('created_at', today())->count();
    $invoice = $datePart . str_pad($countToday + 1, 4, '0', STR_PAD_LEFT);

    $totalAmount = 0;

    foreach ($cart as $item) {
        $car = Car::find($item['car_id']);
        if (!$car || $item['quantity'] > $car->stock) {
            return back()->withErrors(['stock' => "Stok tidak cukup untuk {$item['name']}"]);
        }

        Sale::create([
            'invoice_number' => $invoice,
            'car_id'         => $car->id,
            'quantity'       => $item['quantity'],
            'price_item'     => $car->price,
            'total_price'    => $car->price * $item['quantity'],
            'sold_at'        => now(),
        ]);

        $car->decrement('stock', $item['quantity']);

        $totalAmount += $car->price * $item['quantity'];
    }

    // 🧾 Simpan transaksi utama
    Transactions::create([
        'invoice_number'  => $invoice,
        'customer_name'   => $request->name,
        'phone'           => $request->phone,
        'address'         => $request->address,
        'ket' => $request->ket,
        'total_amount'    => $totalAmount,
        'payment_amount'  => $totalAmount, // jika bayar full
    ]);

    session()->forget('cart');

    return redirect()->route('cart.index')->with('success', "Pesanan berhasil! Invoice: $invoice");
}

    public function add(Request $request)
    {
        $data = $request->validate([
            'car_id'   => 'required|exists:cars,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $car = Car::findOrFail($data['car_id']);
        $cart = session()->get('cart', []);

        if (isset($cart[$car->id])) {
            $newQty = $cart[$car->id]['quantity'] + $data['quantity'];
            if ($newQty > $car->stock) {
                return back()->withErrors(['quantity' => 'Stok tidak cukup.']);
            }
            $cart[$car->id]['quantity'] = $newQty;
        } else {
            $cart[$car->id] = [
                'car_id'   => $car->id,
                'name'     => $car->name,
                'price'    => $car->price,
                'quantity' => $data['quantity'],
                'image'    => $car->image,
                'stock'    => $car->stock,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('cart.index')
                         ->with('success', "{$car->name} ditambahkan ke keranjang.");
    }

    public function remove(Request $request, $car_id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$car_id])) {
            unset($cart[$car_id]);
            session()->put('cart', $cart);
        }
        return back()->with('success', 'Item dihapus dari keranjang.');
    }

    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return back()->withErrors(['empty' => 'Keranjang kosong.']);
        }

        foreach ($cart as $item) {
            $car = Car::find($item['car_id']);

            if (!$car) continue;

            if ($item['quantity'] > $car->stock) {
                return back()->withErrors(['quantity' => "Stok tidak cukup untuk {$car->name}."]);
            }

            $invoice = $this->generateInvoiceNumber();

            Sale::create([
                'invoice_number' => $invoice,
                'car_id'      => $car->id,
                'quantity'    => $item['quantity'],
                'price_items'  => $car->price,
                'total_price' => $car->price * $item['quantity'],
                'sold_at'     => now(),
            ]);

            $car->decrement('stock', $item['quantity']);
        }

        session()->forget('cart');

        return redirect()->route('cart.index')->with('success', 'Checkout berhasil.');
    }

}
