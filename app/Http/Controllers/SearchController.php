<?php

namespace App\Http\Controllers;

use App\Models\Search;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $searchs = Search::when($search, function ($query, $search) {
            return $query->where('keyword', 'like', "%{$search}%")
                         ->orWhere('kategori_filter', 'like', "%{$search}%")
                         ->orWhere('radius', 'like', "%{$search}%");
        })->paginate(10);

        $i = ($searchs->currentPage() - 1) * $searchs->perPage() + 1;

        return view('searchs.index', compact('searchs', 'i'));
    }

    public function create()
    {
        return view('searchs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'keyword' => 'required|string',
            'kategori_filter' => 'required|string',
            'radius' => 'required|integer',
        ]);

        try {
            $search = new Search([
                'keyword'  => $request->keyword,
                'kategori_filter' => $request->kategori_filter,
                'radius' => $request->radius,
            ]);

            $search->save();
            return redirect()->route('searchs.index')
                ->with('success', 'Search '.$search->keyword.' has been added successfully!');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function edit(Search $search)
    {
        return view('searchs.edit', compact('search'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'keyword' => 'required|string',
            'kategori_filter' => 'required|string',
            'radius' => 'nullable|integer',
        ]);

        try {
            $search = Search::findOrFail($id);
            $search->keyword = $request->keyword;
            $search->kategori_filter = $request->kategori_filter;
            $search->radius = $request->radius;
            $search->save();

            return redirect()->route('searchs.index')
                ->with('success', 'Search '.$search->keyword.' has been updated successfully!');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function destroy(Search $search)
    {
        $search->delete();
        return redirect()->route('searchs.index')
            ->with('success', 'Search '.$search->keyword.' has been deleted successfully!');
    }
}
