<?php

namespace App\Http\Controllers;

use App\Models\DiaryEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener los registros del diario del usuario actual, ordenados por fecha (más reciente primero)
        $entries = Auth::user()->diaryEntries()->orderBy('created_at', 'desc')->get();

        return view('diary.index', [
            'entries' => $entries,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('diary.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'mood' => 'required|string',
            'energy_level' => 'required|integer|between:1,10',
            'notes' => 'nullable|string',
        ]);

        DiaryEntry::create([
            'user_id' => Auth::id(),
            'mood' => $request->mood,
            'energy_level' => $request->energy_level,
            'notes' => $request->notes,
        ]);

        return redirect()->route('dashboard')->with('success', 'Registro guardado!');
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
