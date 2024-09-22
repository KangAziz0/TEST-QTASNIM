<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('Category')->get();
        return response()->json($products);
    }

    public function datatable()
    {
        $products = Product::with('Category')->get();
        return DataTables::of($products)
            ->addIndexColumn()
            ->addColumn('category', function($row){
                return $row->category ? $row->category->name : 'No Category'; // Menampilkan nama kategori
            })
            ->addColumn('action', function ($row) {
                return '<button data-id="' . $row->id . '" class="btn btn-info edit">Edit</button>      <button data-id="' . $row->id . '" class="btn btn-danger delete">Delete</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        Product::insert([
            'name' => $request->name,
            'stock' => $request->stock,
            'price' => $request->price,
            'id_category' => $request->category
        ]);
        return response()->json(['message' => 'Product Created']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with('Category')->findOrFail($id);
        return response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        Product::where('id', $id)->update($request->all());
        return response()->json(['message' => 'Product Updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::where('id', $id)->delete();
        return response()->json(['message' => 'Product Deleted']);
    }

    public function getProductsByCategory($categoryId)
    {
        $products = Product::where('id_category', $categoryId)->pluck('name', 'id');
        return response()->json($products);
    }
}
