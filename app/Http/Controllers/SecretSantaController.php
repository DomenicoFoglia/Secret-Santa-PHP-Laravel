<?php

namespace App\Http\Controllers;

use App\Models\Draw;
use App\Mail\GiftAssigned;
use App\Models\SecretSanta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

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

    //Manda email - QUESTA È L'UNICA FUNZIONE MODIFICATA
    public function sendEmails($id)
    {
        $secretSanta = SecretSanta::findOrFail($id);

        if ($secretSanta->user_id !== Auth::id()) {
            abort(403);
        }

        $draws = $secretSanta->draws()->with(['giver', 'receiver'])->get();

        if ($draws->isEmpty()) {
            return redirect()->back()->with('error', 'Nessun sorteggio trovato.');
        }

        // Invia le email con delay crescente
        $delay = 0;
        foreach ($draws as $draw) {
            $giver = $draw->giver;
            $receiver = $draw->receiver;

            $data = [
                'receiver_name' => $giver->name,
                'assigned_to' => $receiver->name,
            ];

            Mail::mailer('smtp')
                ->to($giver->email)
                ->later(now()->addSeconds($delay), new \App\Mail\GiftAssigned($data));

            $delay += 10; // 3 secondi di delay tra una email e l'altra
        }


        return redirect()->back()->with('success', 'Email inviate correttamente!');
    }
}
