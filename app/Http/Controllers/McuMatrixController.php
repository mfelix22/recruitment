<?php

namespace App\Http\Controllers;

use App\Models\McuMatrix;
use App\Models\McuPackage;
use Illuminate\Http\Request;

class McuMatrixController extends Controller
{
    public function index(Request $request)
    {
        $query = McuMatrix::with('package')->orderBy('code');

        if ($request->filled('cari')) {
            $q = $request->cari;
            $query->where(function ($sq) use ($q) {
                $sq->where('code', 'like', "%$q%")
                    ->orWhere('department', 'like', "%$q%")
                    ->orWhere('employee_position', 'like', "%$q%");
            });
        }

        $matrices = $query->paginate(20)->withQueryString();
        $packages = McuPackage::orderBy('code')->get();

        return view('hrd.mcu.matrix.index', compact('matrices', 'packages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code'              => ['required', 'string', 'max:50', 'unique:mcu_matrices,code'],
            'company'           => ['nullable', 'string', 'max:100'],
            'department'        => ['nullable', 'string', 'max:100'],
            'sub_section'       => ['nullable', 'string', 'max:100'],
            'employee_position' => ['required', 'string', 'max:150'],
            'mcu_package_id'    => ['required', 'exists:mcu_packages,id'],
        ]);

        McuMatrix::create($validated);

        return back()->with('success', 'Matrix MCU berhasil ditambahkan.');
    }

    public function update(Request $request, McuMatrix $mcuMatrix)
    {
        $validated = $request->validate([
            'code'              => ['required', 'string', 'max:50', 'unique:mcu_matrices,code,' . $mcuMatrix->id],
            'company'           => ['nullable', 'string', 'max:100'],
            'department'        => ['nullable', 'string', 'max:100'],
            'sub_section'       => ['nullable', 'string', 'max:100'],
            'employee_position' => ['required', 'string', 'max:150'],
            'mcu_package_id'    => ['required', 'exists:mcu_packages,id'],
        ]);

        $mcuMatrix->update($validated);

        return back()->with('success', 'Matrix MCU berhasil diperbarui.');
    }

    public function destroy(McuMatrix $mcuMatrix)
    {
        $mcuMatrix->delete();

        return back()->with('success', 'Matrix MCU berhasil dihapus.');
    }
}
