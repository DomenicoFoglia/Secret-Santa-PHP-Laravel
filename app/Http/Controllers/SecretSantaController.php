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
    public function create()
    {
        return view('secret-santas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'participants' => 'required|array|min:1',
        //     'participants.*.name' => 'required|string|max:255',
        //     'participants.*.email' => 'required|email|unique:participants,email',
        // ]);

        // $secretSanta = SecretSanta::create([
        //     'name' => $request->name,
        //     'user_id' => Auth::id(),
        // ]);

        // foreach ($request->participants as $p) {
        //     $secretSanta->participants()->create([
        //         'name' => $p['name'],
        //         'email' => $p['email'],
        //     ]);
        // }

        // return redirect()->route('dashboard')->with('message', 'Secret Santa creato con successo!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $secretSanta = SecretSanta::findOrFail($id);

        if ($secretSanta->user_id !== Auth::id()) {
            abort(403);
        }

        $participants = $secretSanta->participants;

        $draws = $secretSanta->draws()->with(['giver', 'receiver'])->get();

        return view('secret-santas.show', compact('secretSanta', 'participants', 'draws'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $secretSanta = SecretSanta::findOrFail($id);

        if ($secretSanta->user_id !== Auth::id()) {
            abort(403);
        }

        $participants = $secretSanta->participants;

        return view('secret-santas.edit', [
            'secretSanta' => $secretSanta,
            'participants' => $participants,
        ]);
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
        $santa = SecretSanta::findOrFail($id);

        if (Auth::id() !== $santa->user_id) {
            abort(403);
        }

        $santa->delete();

        return redirect()->route('dashboard')->with('success', 'Secret Santa eliminato con successo!');
    }

    //Sorteggio
    public function draw(string $id)
    {
        $secretSanta = SecretSanta::findOrFail($id);

        if ($secretSanta->user_id !== Auth::id()) {
            abort(403);
        }

        try {
            $message = $secretSanta->performDraw();

            session()->flash('success', $message);
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }

        return redirect()->route('secret-santas.show', $secretSanta->id);
    }
}
