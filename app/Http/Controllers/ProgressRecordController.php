<?php

namespace App\Http\Controllers;

use App\Models\ProgressRecord;
use Illuminate\Http\Request;

class ProgressRecordController extends Controller
{
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
        $validated = $request->validate([
            'client_id' => 'required',
            'coaching_session_id' => 'required',
            'weight' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'date' => 'required',
        ]);

        $record = new ProgressRecord();

        $record->client_id = $validated['client_id'];
        $record->coaching_session_id = $validated['coaching_session_id'];
        $record->weight = $validated['weight'];
        $record->start_time = $validated['start_time'];
        $record->end_time = $validated['end_time'];
        $record->date = date('Y-m-d', strtotime($validated['date']));

        $record->save();

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(ProgressRecord $progressRecord)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProgressRecord $progressRecord)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProgressRecord $progressRecord)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProgressRecord $progressRecord)
    {
        //
    }
}
