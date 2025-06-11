<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    protected $message, $status;

    public function get()
    {
        $data = Contact::with(['sector', 'transactions'])->get();
        return response()->json($data);
    }

    public function row(Contact $contact)
    {
        return response()->json($contact->load(['sector', 'transactions']));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('contact/page', [
            "title" => "Kontak Sales",
            "contacts" => Contact::with(['sector'])->get()
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
            "company_name" => ['required', 'string'],
            "email" => ['required', 'string', 'email', Rule::unique(Contact::class)],
            "phone" => ['required', 'numeric', 'max_digits:20', Rule::unique(Contact::class)],
            "sector_id" => ['required', 'string'],
            "address" => ['required', 'string']
        ]);
        $contact = Contact::create($validation);
        $this->message = $contact ? "Berhasil membuat data kontak!" : "Gagal membuat data kontak!";
        $this->status = $contact ? 201 : 205;
        return response()->json([
            "message" => $this->message
        ], $this->status);
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        $validation = $request->validate([
            "name" => ['sometimes', 'string'],
            "company_name" => ['sometimes', 'string'],
            "email" => ['sometimes', 'string', 'email', Rule::unique(Contact::class)->ignore($contact->id)],
            "phone" => ['sometimes', 'numeric', 'max_digits:20', Rule::unique(Contact::class)->ignore($contact->id)],
            "sector_id" => ['sometimes', 'string'],
            "address" => ['sometimes', 'string']
        ]);
        $is_updated = $contact->updateOrFail($validation);
        $this->message = $is_updated ? "Berhasil mengubah data kontak!" : "Gagal mengubah data kontak!";
        $this->status = $is_updated ? 201 : 205;
        return response()->json([
            "message" => $this->message
        ], $this->status);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        DB::beginTransaction();
        try {
            if ($contact->transactions()->exists()) {
                new Exception("Gagal menghapus data kontak!");
            }
            $contact->delete();
            DB::commit();
            return response()->json([
                "message" => "Berhasil menghapus kontak!"
            ]);
        } catch (Exception $ex) {
            DB::rollBack();
            return response()->json([
                "message" => $ex->getMessage()
            ]);
        }
    }
}
