<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Categories;
use Illuminate\Support\Facades\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $data['categories'] = Categories::all();
        return view('pages.categories');
    }

    public function datatable()
    {

        $data = Categories::all();
        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '<button data-id="' . $row->id . '" class="btn btn-info edit">Edit</button>';
                $btn .= '<button data-id="' . $row->id . '" class="btn btn-danger ms-2 delete">Delete</button>';
                return $btn;
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
    public function store(CategoryRequest $request)
    {
        Categories::create($request->all());
        return response()->json(['message' => 'Category Created']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Categories::findOrFail($id);
        return response()->json($category);
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
    public function update(CategoryRequest $request, string $id)
    {
        Categories::where('id', $id)->update($request->all());
        return response()->json(['message' => 'Category Updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Categories::where('id', $id)->delete();
        return response()->json(['message' => 'Category Deleted']);
    }
}
