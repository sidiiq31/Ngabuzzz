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
        if ($req->hasFile('images') && !is_array($req->file('images'))) {
            $req->merge([
                'images' => [$req->file('images')]
            ]);
        }

        $data = $req->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required',
            'description' => 'nullable',
            'stock'       => 'required|integer|min:0',
            'price'       => 'required|numeric|min:0',
            'images'      => 'required|array|min:1|max:2',
            'images.*'    => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $imagePaths = [];
        foreach ($req->file('images') as $image) {
            $imagePaths[] = $image->store('cars', 'public');
        }

        $data['images'] = json_encode($imagePaths);

        Car::create($data);

        return redirect()->route('cars.index')->with('success', 'Mobil ditambahkan.');
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
        if ($request->hasFile('images') && !is_array($request->file('images'))) {
            $request->merge([
                'images' => [$request->file('images')]
            ]);
        }

        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'stock'       => 'required|integer|min:0',
            'price'       => 'required|numeric|min:0',
            'images'      => 'nullable|array|min:1|max:2',
            'images.*'    => 'image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($request->hasFile('images')) {
            if ($car->images) {
                foreach (json_decode($car->images) as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }

            $newImages = [];
            foreach ($request->file('images') as $image) {
                $newImages[] = $image->store('cars', 'public');
            }

            $data['images'] = json_encode($newImages);
        } else {
            $data['images'] = $car->images;
        }

        $car->update($data);

        return redirect()->route('cars.index')->with('success', 'Mobil berhasil diperbarui.');
    }

    public function destroy(Car $car)
    {
        if ($car->images) {
            foreach (json_decode($car->images) as $img) {
                Storage::disk('public')->delete($img);
            }
        }

        $car->delete();

        return redirect()->route('cars.index')->with('success', 'Mobil berhasil dihapus.');
        //
    }
}
