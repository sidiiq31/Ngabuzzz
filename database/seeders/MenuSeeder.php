<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    public function run()
    {
        $menus = [
            ['name' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'bi-house-door-fill'],
            ['name' => 'Mobil', 'route' => 'cars.index', 'icon' => 'bi-list-ul'],
            ['name' => 'Kategori', 'route' => 'categories.index', 'icon' => 'bi-tags-fill'],
            ['name' => 'Penjualan', 'route' => 'sales.index', 'icon' => 'bi-currency-dollar'],
            ['name' => 'Manajemen User', 'route' => 'users.index', 'icon' => 'bi-people-fill'],
            ['name' => 'Transaksi', 'route' => 'transaksi.index', 'icon' => 'bi-receipt-cutoff'],
        ];

        foreach ($menus as $menu) {
            $m = Menu::create($menu);
            // default hanya superadmin bisa semua
            DB::table('menu_role')->insert([
                ['menu_id' => $m->id, 'role' => 'superadmin']
            ]);
        }
    }
}
