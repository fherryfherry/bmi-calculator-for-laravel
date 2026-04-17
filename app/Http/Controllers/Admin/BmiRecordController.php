<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BmiRecord;
use Illuminate\Http\Request;

class BmiRecordController extends Controller
{
    /**
     * Display a listing of BMI records.
     */
    public function index(Request $request)
    {
        $query = BmiRecord::with('user')->latest();

        // Filter by category
        if ($request->filled('category')) {
            $query->where('bmi_category', $request->category);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $bmiRecords = $query->paginate(15);

        return view('admin.bmi-records.index', compact('bmiRecords'));
    }

    /**
     * Display the specified BMI record.
     */
    public function show(BmiRecord $bmiRecord)
    {
        return view('admin.bmi-records.show', compact('bmiRecord'));
    }

    /**
     * Remove the specified BMI record.
     */
    public function destroy(BmiRecord $bmiRecord)
    {
        $bmiRecord->delete();

        return redirect()->route('admin.bmi-records.index')
            ->with('success', 'BMI record deleted successfully.');
    }
}
