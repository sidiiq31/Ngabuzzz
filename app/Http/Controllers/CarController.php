<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{

   public function index()
    {
        $cars = Car::with('category')->paginate(10);
        return view('cars.index', compact('cars'));
    }

    public function create()
    {
        $categories = Category::pluck('name','id');
        return view('cars.create', compact('categories'));
    }

    public function store(Request $req)
    {
        $data = $req->validate([
            'category_id'=>'required|exists:categories,id',
            'name'=>'required',
            'description'=>'nullable',
            'stock'=>'required|integer|min:0',
            'price'=>'required|numeric|min:0',
            'image'=> 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
         if ($req->hasFile('image')) {
            $data['image'] = $req->file('image')->store('cars', 'public');
        }
        Car::create($data);
        return redirect()->route('cars.index')->with('success','Mobil ditambahkan.');
    }

    public function show(Car $car)
    {
        $car->load('category');

        return view('cars.show', compact('car'));
        //
    }

    public function edit(Car $car)
    {
        $categories = Category::pluck('name', 'id');

        return view('cars.edit', compact('car', 'categories'));
        //
    }

    public function update(Request $request, Car $car)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'stock'       => 'required|integer|min:0',
            'price'       => 'required|numeric|min:0',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($car->image) {
                Storage::disk('public')->delete($car->image);
            }
            $data['image'] = $request->file('image')->store('cars', 'public');
        }

        $car->update($data);

        return redirect()->route('cars.index')
                         ->with('success', 'Mobil berhasil diperbarui.');
        //
    }

    public function destroy(Car $car)
    {
        if ($car->image) {
            Storage::disk('public')->delete($car->image);
        }
        $car->delete();

        return redirect()->route('cars.index')
                         ->with('success', 'Mobil berhasil dihapus.');
        //
    }
}
