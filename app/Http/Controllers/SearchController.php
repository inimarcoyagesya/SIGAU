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
                         ->orWhere('radius', 'like', "%{$search}%")
                         ->orWhere('search_id', 'like', "%{$search}%");
        })->paginate(10);

        // Hitung nomor urut
        $i = ($searchs->currentPage() - 1) * $searchs->perPage() + 1;

        return view('searchs.index', compact('searchs', 'i'));
    }

    public function create()
    {
        return view('Searchs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'keyword' => 'required|string',
            'kategori_filter' => 'required|string',
            'radius' => 'required|string',
            'search_id' => 'required|string'
        ]);

        try {
            $search = new Search([
                'keyword'  => $request->keyword,
                'kategori_filter' => $request->kategori_filter,
                'radius' => $request->radius,
                'search_id' => $request->search_id,

            ]);

            $search->save();
            return redirect()->route('searchs.index')
            ->with('success', 'search '.$search->keyword.' has been added successfully!');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
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
    public function edit(Search $Search)
    {
        return view('Searchs.edit', compact('Search'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'keyword' => 'required|string',
            'kategori_filter' => 'required|string'.$id,
            'radius' => 'nullable|string',
            'search_id' => 'required|string',
        ]);

        try {
            $Search = Search::find($id);
            // dd($Search->first());
            $Search->keyword = $request->keyword;
            $Search->kategori_filter = $request->kategori_filter;
            $Search->search_id = $request->search_id;
            $Search->save();
            return redirect()->route('Searchs.index')
            ->with('success', 'Search '.$Search->name.' has been updated successfully!');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Search $Search)
    {
        if ($Search) {
            $Search->delete();
            return redirect()->route('Searchs.index')
            ->with('success', 'Search '.$Search->name.' has been deleted successfully!');
        } else {
            return back()->with('error', 'Search not found!');
        }
    }
}
