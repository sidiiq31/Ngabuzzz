<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function index()
    {
        $roles = DB::table('roles')->pluck('name');
        $menus = Menu::all()->groupBy('role');

        return view('roles.index', compact('roles', 'menus'));
    }

    public function edit($role)
    {
        $menus = Menu::all();
        $selected = DB::table('menu_role')->where('role', $role)->pluck('menu_id')->toArray();

        return view('roles.edit', compact('role', 'menus', 'selected'));
    }

    public function update(Request $request, $role)
    {
        DB::table('menu_role')->where('role', $role)->delete();
        foreach ($request->menu_ids as $menuId) {
            DB::table('menu_role')->insert([
                'role' => $role,
                'menu_id' => $menuId,
            ]);
        }

        return redirect()->route('roles.index')->with('success', 'Menu role berhasil diperbarui.');
    }

    public function create()
    {
        return view('roles.create'); // buat view-nya nanti
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
        ]);

        // Simpan role ke tabel roles (atau source lain)
        // Sesuaikan dengan struktur penyimpananmu
        \DB::table('roles')->insert([
            'name' => $request->name,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('roles.index')->with('success', 'Role berhasil ditambahkan.');
    }
}
