<?php

namespace App\Http\Controllers;

use App\Models\DiaryEntry;
use Illuminate\Http\Request;

class DiaryController extends Controller
{
    public function create()
    {
        return view('diary.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'mood' => 'required|string',
        ]);

        DiaryEntry::create([
            'user_id' => auth()->id(),
            'mood' => $request->mood,
            'energy_level' => $request->energy_level,
            'notes' => $request->notes,
        ]);

        return redirect()->route('dashboard')->with('success', 'Registro guardado!');
    }
}
