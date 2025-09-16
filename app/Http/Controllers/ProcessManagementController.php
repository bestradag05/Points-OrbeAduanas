<?php

namespace App\Http\Controllers;

use App\Models\ProcessManagement;
use App\Services\ProcessManagementService;
use Illuminate\Http\Request;

class ProcessManagementController extends Controller
{
    protected $processManagementService;

    public function __construct(ProcessManagementService $processManagementService)
    {
        $this->processManagementService = $processManagementService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $compact = $this->processManagementService->index();
        return view('process_management.list-process-management', $compact);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ProcessManagement $process)
    {
        

        return view('process_management.detail-process-management', compact('process'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProcessManagement $processManagement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProcessManagement $processManagement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProcessManagement $processManagement)
    {
        //
    }
}
