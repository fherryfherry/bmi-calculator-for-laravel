<?php

namespace App\Http\Controllers;

use App\Http\Requests\BmiCalculationRequest;
use App\Models\BmiRecord;
use Illuminate\Http\Request;

class BmiCalculatorController extends Controller
{
    /**
     * Show the BMI calculator form.
     */
    public function show()
    {
        return view('bmi.calculator');
    }

    /**
     * Calculate BMI and save the record.
     */
    public function calculate(BmiCalculationRequest $request)
    {
        $validated = $request->validated();
        
        $weight = $validated['weight'];
        $height = $validated['height'];
        $bmiValue = BmiRecord::calculateBmi($weight, $height);
        $category = BmiRecord::getCategory($bmiValue);

        $bmiRecord = BmiRecord::create([
            'name' => $validated['name'],
            'weight' => $weight,
            'height' => $height,
            'bmi_value' => $bmiValue,
            'bmi_category' => $category,
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('bmi.result', $bmiRecord);
    }

    /**
     * Show the BMI result.
     */
    public function result(BmiRecord $bmiRecord)
    {
        return view('bmi.result', compact('bmiRecord'));
    }
}
