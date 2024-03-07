<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Yajra\DataTables\Facades\DataTables;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Setup/ProductCategory');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function fetch()
    {
        $data = ProductCategory::latest()->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return '
                <div class="flex items-center gap-4">
                <button type="button" data-id="' . $row->id . '" class="edit flex items-center justify-center p-1 w-10 h-10 bg-gray-800 text-white font-normal text-sm leading-tight rounded-sm shadow-sm hover:bg-gray-700 hover:shadow-lg focus:bg-gray-700 focus:shadow-md focus:outline-none focus:ring-0 active:bg-gray-800 active:shadow-md transition duration-150 ease-in-out">
                <span class="material-symbols-outlined">
                edit
                </span>
                </button>
               
                <button type="button" data-id="' . $row->id . '" class="delete flex items-center justify-center p-1 w-10 h-10 bg-red-600 text-white font-normal text-sm leading-tight rounded-sm shadow-sm hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-md focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-md transition duration-150 ease-in-out">
                <span class="material-symbols-outlined">
                delete
                </span>
                </button>
                </div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'title' => ['required', Rule::unique('product_categories')],
            ]
        );

        $input = $request->all();
        $input['title'] = ucwords($input['title']);

        ProductCategory::create($input);

        return redirect()->back();
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
    public function edit(Request $request)
    {
        $data = ProductCategory::find($request->id);

        return response()->json([
            'row' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductCategory $productCategory)
    {
        $request->validate(
            [
                'title' => ['required', Rule::unique('product_categories')->ignore($productCategory)],
            ]
        );

        $input = $request->all();
        $input['title'] = ucwords($input['title']);

        $productCategory->fill($input)->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $data = ProductCategory::find($request->id);

        $data->delete();
    }
}
