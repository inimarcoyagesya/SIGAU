<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::all()->map(function ($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'description' => $p->description,
                'price' => 'Rp ' . number_format($p->price, 0, ',', '.'),
                'duration' => $p->duration,
                'status' => $p->status
            ];
        });
        return view('admin.packages.index', compact('packages'));
    }

    public function index2()
    {
        $packages = Package::where('status', 'aktif')->get()->map(function ($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'description' => $p->description,
                'price' => 'Rp ' . number_format($p->price, 0, ',', '.'),
                'duration' => $p->duration,
            ];
        });
        return view('packages.index2', compact('packages'));
    }

    public function create()
    {
        return view('admin.packages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);
        
        Package::create($validated);
        
        return redirect()->route('admin.packages.index')
            ->with('success', 'Paket berhasil dibuat!');
    }

    public function edit(Package $package)
{
    return view('admin.packages.edit', compact('package'));
}

    public function update(Request $request, Package $package)
    {
        $package->price = number_format($package->price, 0, ',', '.');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);
        
        $package->update($validated);
        
        return redirect()->route('admin.packages.index')
            ->with('success', 'Paket berhasil diperbarui!');
    }

    public function destroy(Package $package)
    {
        $package->delete();
    return response()->json(['success' => true]);
    }

    public function toggleStatus(Package $package)
    {
        $package->status = $package->status === 'Aktif' ? 'Nonaktif' : 'Aktif';
        $package->save();
        return response()->json(['success' => true]);
    }
}