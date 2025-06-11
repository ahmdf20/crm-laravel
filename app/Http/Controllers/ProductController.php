<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;
use App\Http\Requests\Product\StoreRequest as ProductStore;
use Exception;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    protected $message, $status;
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('product/page', [
            "title" => "List Produk",
            "products" => Product::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('product/create', [
            "title" => "Tambah Produk Baru",
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            "name" => ['required', 'string'],
            "price" => ['required', 'numeric'],
            "description" => ['nullable', 'string']
        ]);
        $product = Product::create($validation);
        $this->message = $product ? "Berhasil membuat data produk!" : "Gagal membuat data produk!";
        $this->status = $product ? 201 : 205;
        return response()->json([
            "message" => $this->message
        ], $this->status);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): Response
    {
        return Inertia::render('product/edit', [
            "title" => "Edit Produk $product->name",
            "product" => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validation = $request->validate([
            "name" => ['sometimes', 'string'],
            "price" => ['sometimes', 'numeric'],
            "description" => ['nullable', 'string']
        ]);
        $is_updated = $product->updateOrFail($validation);
        $this->message = $is_updated ? "Berhasil mengubah data produk!" : "Gagal mengubah data produk!";
        $this->status = $is_updated ? 201 : 205;
        return response()->json([
            "message" => $this->message
        ], $this->status);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        DB::beginTransaction();
        try {
            if ($product->transactions()->exists()) {
                new Exception("Gagal menghapus data produk!");
            }
            $product->delete();
            DB::commit();
            return response()->json([
                "message" => "Berhasil menghapus data produk!"
            ], 201);
        } catch (Exception $ex) {
            return response()->json([
                "message" => $ex->getMessage()
            ], 205);
        }
    }
}
