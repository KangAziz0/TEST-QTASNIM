<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Product;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['categories'] = Categories::all();

        return view('pages.transaction', $data);
    }

    public function reportTable(Request $request)
    {

        $categories = Categories::selectRaw('categories.id, categories.name, SUM(transactions.sold) as total_sold')
            ->join('products', 'categories.id', '=', 'products.id_category')
            ->join('transactions', 'products.id', '=', 'transactions.id_product')
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('total_sold', 'desc')->get();

        return DataTables::of($categories)
            ->addIndexColumn()
            ->make(true);
    }

    public function datatable(Request $request)
    {
        if ($request->input('category_filter')) {
            $data = Transaction::where('category', $request->category_filter)->with('products')->orderBy('sold','desc')->get();
        }else if($request->input('range_filter')){
            // $data = Transaction::whereBetween('date_transaction',[$request->start_date,$request->end_date])->where('category',$request->category_filter)->with('products')->get();
            $dateRange = explode(' - ', $request->range_filter);
            $startDate = Carbon::parse($dateRange[0])->startOfDay();
            $endDate = Carbon::parse($dateRange[1])->endOfDay();
            $data = Transaction::whereBetween('created_at',[$startDate,$endDate])->with('products')->get();
        } else {
            $data = Transaction::with('products')->get();
        }
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('product', function ($row) {
                return $row->products ? $row->products->name : 'No Product';
            })
            ->addColumn('stock', function ($row) {
                return $row->products ? $row->products->stock : 'No Product';
            })
            ->addColumn('category', function ($row) {
                return $row->products->category ? $row->products->category->name : 'No Product';
            })

            ->make(true);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function report()
    {
        return view('pages.report');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Ambil data produk berdasarkan product_id
        $product = Product::findOrFail($request->id_product);

        // Cek apakah stok produk cukup
        if ($product->stock < $request->sold) {
            return back()->with('error', 'Stock is not sufficient!');
        }
        // Hitung total harga transaksi
        $product->decrement('stock', $request->sold);
        Transaction::create([
            'date_transaction' => date(now()),
            'id_product' => $request->id_product,
            'sold' => $request->sold,
            'category' => $request->category
        ]);

        return response()->json(['message' => 'Transaction Success']);
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
