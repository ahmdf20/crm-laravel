<?php

namespace App\Http\Controllers;

use App\Models\Sector;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SectorController extends Controller
{
    protected $status, $message;

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('sector/page', [
            "title" => "List Sektor",
            "sectors" => Sector::with(['contacts', 'transactions'])->get()
        ]);
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
            "name" => ['required', 'string'],
        ]);
        $sector = Sector::create($validation);
        $this->message = $sector ? "Berhasil membuat data sektor!" : "Gagal membuat data sektor";
        $this->status = $sector ? 201 : 205;
        return response()->json([
            "message" => $this->message
        ], $this->status);
    }

    /**
     * Display the specified resource.
     */
    public function show(Sector $sector)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sector $sector)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sector $sector)
    {
        $validation = $request->validate([
            "name" => ['required', 'string']
        ]);
        $is_updated = $sector->updateOrFail($validation);
        $this->message = $is_updated ? "Berhasil mengubah data sektor!" : "Gagal mengubah data sektor!";
        $this->status = $is_updated ? 201 : 205;
        return response()->json([
            "message" => $this->message
        ], $this->status);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sector $sector)
    {
        //
    }
}
