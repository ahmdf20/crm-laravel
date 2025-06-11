<?php

namespace App\Http\Controllers;

use App\Models\Column;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ColumnController extends Controller
{
    protected $message, $status;

    public function get()
    {
        $data = Column::with('transactions')->get();
        return response()->json($data);
    }

    public function row(Column $column)
    {
        return response()->json($column->load('transactions'));
    }

    public function count()
    {
        $data = Column::with('transactions')->get();
        $newData = [];
        foreach ($data as $key => $column) {
            array_push($newData, (object)["key" => $key, "id" => $column->id, "name" => $column->name, "total_transaction" => $column->transactions()->count()]);
        }
        return response()->json($newData);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        $validation = $request->validate([
            "name" => ['required', 'string', 'lowercase']
        ]);
        $column = Column::create($validation);
        $this->message = $column ? "Berhasil menambahkan data kolom list!" : "Gagal menambahkan data kolom list!";
        $this->status = $column ? 201 : 205;
        return response()->json([
            "message" => $this->message
        ], $this->status);
    }

    /**
     * Display the specified resource.
     */
    public function show(Column $column)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Column $column)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Column $column)
    {
        $validation = $request->validate([
            "name" => ['sometimes', 'string', 'lowercase']
        ]);
        $is_updated = $column->updateOrFail($validation);
        $this->message = $is_updated ? "Berhasil mengubah data kolom list!" : "Gagal mengubah data kolom list!";
        $this->status = $is_updated ? 201 : 205;
        return response()->json([
            "message" => $this->message
        ], $this->status);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Column $column)
    {
        DB::beginTransaction();
        try {
            if ($column->transactions()->exists()) {
                new Exception("Gagal menghapus data kolom!");
            }
            $column->delete();
            DB::commit();
            return response()->json([
                "message" => "Berhasil menghapus data kolom!"
            ]);
        } catch (Exception $ex) {
            DB::rollBack();
            return response()->json([
                "message" => $ex->getMessage()
            ]);
        }
    }
}
