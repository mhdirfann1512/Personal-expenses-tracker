<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function update(Request $request)
    {
        $note = \App\Models\Note::updateOrCreate(
            ['user_id' => auth()->id()],
            ['content' => $request->content]
        );
        return back()->with('success', 'Nota berjaya disimpan!');
    }
}
