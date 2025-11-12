<?php

namespace App\Http\Controllers;

use App\Models\SecretSanta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SecretSantaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $secretSantas = Auth::user()->secretSantas()->latest()->get();

        return view('dashboard', compact('secretSantas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        $santa = SecretSanta::findOrfail($id);

        if (Auth::id() !== $santa->user_id()) {
            abort(403);
        }

        $santa->delete();

        return redirect()->route('dashboard')->with('success', 'Secret Santa eliminato con successo!');
    }
}
