<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\SittingTable;
use Illuminate\Http\Request;

class SittingTableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sitting_tables = SittingTable::query()->with('registrations')->get();
        $registrations = Registration::query()->get();
        return view("backend.sitting-tables.index", compact("sitting_tables", "registrations"));
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
     *
     * @param \Illuminate\Http\Request $request The HTTP request object containing the data to store.
     * @return \Illuminate\Http\Response The redirect response after storing the data.
     */
    public function store(Request $request)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:sitting_tables,name,except,id',
        ]);

        // Create a new SittingTable instance with the validated data
        $sittingTable = SittingTable::create($validatedData);

        // Redirect back to the index
        return redirect()->route('sitting-table.index')->with('success', 'Sitting table created successfully.');
    }

    /**
     * Assigns a sitting table to multiple registrations.
     *
     * @param \Illuminate\Http\Request $request The HTTP request object containing the data to store.
     * @return \Illuminate\Http\Response The redirect response after storing the data.
     */
    public function assignSittingTable(Request $request)
    {
        // Validate the request data
        $request->validate([
            'sitting_table_id' => 'required|exists:sitting_tables,id',
            'registration_ids' => 'required|array',
            'registration_ids.*' => 'exists:registrations,id',
        ]);

        $tableId = $request->sitting_table_id;

        foreach ($request->registration_ids as $registration_id) {
            $registration = Registration::findOrFail($registration_id);

            // Detach any existing table assignments to ensure only one table per registration
            $registration->sittingTable()->detach();

            // Attach the new table
            $registration->sittingTable()->attach($tableId);
        }

        return redirect()->route('sitting-table.index')->with('success', 'Sitting table assigned successfully.');
    }



    /**
     * Display the ballroom index page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ballRoom()
    {
        $sitting_tables = SittingTable::query()->with('registrations')->get();
        return view('backend.ballroom.index', compact('sitting_tables'));
    }



    /**
     * Get the registrations associated with a sitting table.
     *
     * @param \Illuminate\Http\Request $request The HTTP request object.
     * @param int $id The ID of the sitting table.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the registrations.
     */
    public function getRegistrations(Request $request, $id)
    {
        $sittingTable = SittingTable::find($id);

        $registrations = $sittingTable->registrations()->get();

        return response()->json([
            'sittingTable' => $sittingTable,
            'registrations' => $registrations
        ], 200);
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
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $sittingTable = SittingTable::findOrFail($id);
        $sittingTable->name = $request->name;
        $sittingTable->save();

        return redirect()->route('sitting-table.index')->with('success', 'Table updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sittingTable = SittingTable::findOrFail($id);
        $sittingTable->delete();

        return redirect()->route('sitting-table.index')->with('success', 'Table deleted successfully');
    }
}
