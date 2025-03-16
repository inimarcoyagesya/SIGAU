<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $categories = Category::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%");
        })->paginate(10);

        // Hitung nomor urut
        $i = ($categories->currentPage() - 1) * $categories->perPage() + 1;

        return view('categories.index', compact('categories', 'i'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:categories',
        ]);

        try {
            $category = new Category([
                'name' => $request->name,
            ]);

            $category->save();
            return redirect()->route('categories.index')
                ->with('success', 'Category '.$category->name.' has been added successfully!');
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
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|unique:categories,name,'.$id,
        ]);

        try {
            $category = Category::find($id);
            if (!$category) {
                return back()->with('error', 'Category not found!');
            }

            $category->name = $request->name;
            $category->save();

            return redirect()->route('categories.index')
                ->with('success', 'Category '.$category->name.' has been updated successfully!');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category) {
            $categoryName = $category->name;
            $category->delete();
            return redirect()->route('categories.index')
                ->with('success', 'Category '.$categoryName.' has been deleted successfully!');
        } else {
            return back()->with('error', 'Category not found!');
        }
    }
}