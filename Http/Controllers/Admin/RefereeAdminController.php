<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Referee;
use Illuminate\Http\Request; // Use specific Request classes later

class RefereeAdminController extends Controller
{
    /**
     * Display a listing of the referees.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $referees = Referee::orderBy('name')->paginate(15);
        // View: resources/views/admin/referees/index.blade.php
        return view('admin.referees.index', compact('referees'));
    }

    /**
     * Show the form for creating a new referee.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
         // View: resources/views/admin/referees/create.blade.php
        return view('admin.referees.create');
    }

    /**
     * Store a newly created referee in storage.
     *
     * @param  \Illuminate\Http\Request  $request // Replace with StoreRefereeRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request) // Replace with StoreRefereeRequest
    {
        // Validation in StoreRefereeRequest
        Referee::create($request->all()); // Ensure 'fillable' is set

        return redirect()->route('admin.referees.index')->with('status', 'Referee added successfully.');
    }

    /**
     * Display the specified referee.
     *
     * @param  \App\Models\Referee  $referee
     * @return \Illuminate\View\View
     */
    public function show(Referee $referee)
    {
        // Optional: View: resources/views/admin/referees/show.blade.php
        return view('admin.referees.show', compact('referee'));
    }

    /**
     * Show the form for editing the specified referee.
     *
     * @param  \App\Models\Referee  $referee
     * @return \Illuminate\View\View
     */
    public function edit(Referee $referee)
    {
         // View: resources/views/admin/referees/edit.blade.php
        return view('admin.referees.edit', compact('referee'));
    }

    /**
     * Update the specified referee in storage.
     *
     * @param  \Illuminate\Http\Request  $request // Replace with UpdateRefereeRequest
     * @param  \App\Models\Referee  $referee
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Referee $referee) // Replace with UpdateRefereeRequest
    {
        // Validation in UpdateRefereeRequest
        $referee->update($request->all()); // Ensure 'fillable' is set

        return redirect()->route('admin.referees.index')->with('status', 'Referee updated successfully.');
    }

    /**
     * Remove the specified referee from storage.
     *
     * @param  \App\Models\Referee  $referee
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Referee $referee)
    {
        // Add authorization check here
        $referee->delete(); // Use soft delete if enabled

        return redirect()->route('admin.referees.index')->with('status', 'Referee deleted successfully.');
    }
}