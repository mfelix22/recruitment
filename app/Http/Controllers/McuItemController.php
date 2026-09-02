<?php

namespace App\Http\Controllers;

use App\Models\McuItem;
use App\Models\McuPackage;
use Illuminate\Http\Request;

class McuItemController extends Controller
{
    public function index()
    {
        $items    = McuItem::orderBy('sort_order')->orderBy('id')->get();
        $packages = McuPackage::orderBy('code')->get();

        return view('hrd.mcu.paket.index', compact('items', 'packages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => ['required', 'string', 'max:255'],
            'packages'    => ['nullable', 'array'],
            'packages.*'  => ['exists:mcu_packages,id'],
        ]);

        $item = McuItem::create([
            'description' => $validated['description'],
            'sort_order'  => McuItem::max('sort_order') + 1,
        ]);

        $item->packages()->sync($validated['packages'] ?? []);

        return back()->with('success', 'Item MCU berhasil ditambahkan.');
    }

    public function update(Request $request, McuItem $mcuItem)
    {
        $validated = $request->validate([
            'description' => ['required', 'string', 'max:255'],
            'packages'    => ['nullable', 'array'],
            'packages.*'  => ['exists:mcu_packages,id'],
        ]);

        $mcuItem->update(['description' => $validated['description']]);
        $mcuItem->packages()->sync($validated['packages'] ?? []);

        return back()->with('success', 'Item MCU berhasil diperbarui.');
    }

    public function destroy(McuItem $mcuItem)
    {
        $mcuItem->delete();

        return back()->with('success', 'Item MCU berhasil dihapus.');
    }
}
