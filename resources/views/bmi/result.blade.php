@extends('layouts.frontend')

@section('title', 'Your BMI Result')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Result Header -->
    <div class="text-center mb-8 animate-fade-in">
        <h1 class="font-display text-4xl sm:text-5xl font-bold text-slate-800 mb-4">
            Your BMI Result
        </h1>
        <p class="text-lg text-slate-600">
            Hello, <span class="font-semibold text-primary-700">{{ $bmiRecord->name }}</span>! Here's your health analysis.
        </p>
    </div>
    
    <!-- Main Result Card -->
    <div class="glass rounded-3xl shadow-2xl p-8 sm:p-12 animate-slide-up mb-8">
        <div class="grid md:grid-cols-2 gap-8 items-center">
            <!-- BMI Gauge -->
            <div class="relative flex items-center justify-center">
                <svg class="w-64 h-64" viewBox="0 0 200 200">
                    <!-- Background circle -->
                    <circle cx="100" cy="100" r="80" fill="none" stroke="#e2e8f0" stroke-width="12"/>
                    <!-- Colored segments -->
                    <circle cx="100" cy="100" r="80" fill="none" stroke="#60a5fa" stroke-width="12" 
                            stroke-dasharray="126 377" stroke-dashoffset="0" transform="rotate(135 100 100)"/>
                    <circle cx="100" cy="100" r="80" fill="none" stroke="#4ade80" stroke-width="12" 
                            stroke-dasharray="126 377" stroke-dashoffset="-126" transform="rotate(135 100 100)"/>
                    <circle cx="100" cy="100" r="80" fill="none" stroke="#fbbf24" stroke-width="12" 
                            stroke-dasharray="126 377" stroke-dashoffset="-252" transform="rotate(135 100 100)"/>
                    <circle cx="100" cy="100" r="80" fill="none" stroke="#f87171" stroke-width="12" 
                            stroke-dasharray="126 377" stroke-dashoffset="-378" transform="rotate(135 100 100)"/>
                    <!-- BMI indicator circle -->
                    <circle cx="100" cy="100" r="60" fill="none" stroke="currentColor" stroke-width="4" 
                            class="text-primary-600 gauge-circle" 
                            style="--gauge-offset: {{ 283 - (283 * ($bmiRecord->bmi_value / 40)) }}; stroke-dasharray: 283;"/>
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span class="text-5xl font-display font-bold {{ $bmiRecord->bmi_category === 'Normal' ? 'text-green-600' : ($bmiRecord->bmi_category === 'Underweight' ? 'text-blue-600' : ($bmiRecord->bmi_category === 'Overweight' ? 'text-yellow-600' : 'text-red-600')) }}">
                        {{ $bmiRecord->bmi_value }}
                    </span>
                    <span class="text-sm text-slate-500 mt-1">BMI</span>
                </div>
            </div>
            
            <!-- Details -->
            <div>
                <div class="space-y-4">
                    <div class="p-4 rounded-xl {{ $bmiRecord->bmi_category === 'Normal' ? 'bg-green-50 border border-green-200' : ($bmiRecord->bmi_category === 'Underweight' ? 'bg-blue-50 border border-blue-200' : ($bmiRecord->bmi_category === 'Overweight' ? 'bg-yellow-50 border border-yellow-200' : 'bg-red-50 border border-red-200')) }}">
                        <div class="flex items-center space-x-3 mb-2">
                            <div class="w-10 h-10 rounded-full {{ $bmiRecord->bmi_category === 'Normal' ? 'bg-green-100' : ($bmiRecord->bmi_category === 'Underweight' ? 'bg-blue-100' : ($bmiRecord->bmi_category === 'Overweight' ? 'bg-yellow-100' : 'bg-red-100')) }} flex items-center justify-center">
                                @if($bmiRecord->bmi_category === 'Normal')
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 {{ $bmiRecord->bmi_category === 'Underweight' ? 'text-blue-600' : ($bmiRecord->bmi_category === 'Overweight' ? 'text-yellow-600' : 'text-red-600') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm {{ $bmiRecord->bmi_category === 'Normal' ? 'text-green-700' : ($bmiRecord->bmi_category === 'Underweight' ? 'text-blue-700' : ($bmiRecord->bmi_category === 'Overweight' ? 'text-yellow-700' : 'text-red-700')) }}">Category</p>
                                <p class="text-xl font-bold {{ $bmiRecord->bmi_category === 'Normal' ? 'text-green-800' : ($bmiRecord->bmi_category === 'Underweight' ? 'text-blue-800' : ($bmiRecord->bmi_category === 'Overweight' ? 'text-yellow-800' : 'text-red-800')) }}">{{ $bmiRecord->bmi_category }}</p>
                            </div>
                        </div>
                        <p class="text-sm {{ $bmiRecord->bmi_category === 'Normal' ? 'text-green-600' : ($bmiRecord->bmi_category === 'Underweight' ? 'text-blue-600' : ($bmiRecord->bmi_category === 'Overweight' ? 'text-yellow-600' : 'text-red-600')) }}">
                            {{ $bmiRecord->bmi_category === 'Underweight' ? 'You may need to gain some weight. Consider consulting a nutritionist.' : 
                               ($bmiRecord->bmi_category === 'Normal' ? 'Great job! You have a healthy weight. Keep maintaining your lifestyle.' : 
                               ($bmiRecord->bmi_category === 'Overweight' ? 'Consider adopting a healthier lifestyle with regular exercise and balanced diet.' : 
                               'It\'s recommended to consult a healthcare professional for personalized advice.')) }}
                        </p>
                    </div>
                    
                    <!-- Measurements -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                            <p class="text-sm text-slate-500 mb-1">Weight</p>
                            <p class="text-2xl font-bold text-slate-800">{{ $bmiRecord->weight }} <span class="text-sm font-normal text-slate-500">kg</span></p>
                        </div>
                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                            <p class="text-sm text-slate-500 mb-1">Height</p>
                            <p class="text-2xl font-bold text-slate-800">{{ $bmiRecord->height }} <span class="text-sm font-normal text-slate-500">cm</span></p>
                        </div>
                    </div>
                    
                    @if($bmiRecord->notes)
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
                        <p class="text-sm text-slate-500 mb-1">Notes</p>
                        <p class="text-slate-700">{{ $bmiRecord->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- BMI Scale Reference -->
        <div class="mt-8 pt-8 border-t border-slate-200">
            <h3 class="font-display font-semibold text-slate-800 mb-4 text-center">BMI Scale Reference</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="text-center p-3 rounded-xl bg-blue-50 border border-blue-200">
                    <p class="text-xs text-blue-600 font-semibold mb-1">Underweight</p>
                    <p class="text-sm text-blue-800">&lt; 18.5</p>
                </div>
                <div class="text-center p-3 rounded-xl bg-green-50 border border-green-200">
                    <p class="text-xs text-green-600 font-semibold mb-1">Normal</p>
                    <p class="text-sm text-green-800">18.5 - 24.9</p>
                </div>
                <div class="text-center p-3 rounded-xl bg-yellow-50 border border-yellow-200">
                    <p class="text-xs text-yellow-600 font-semibold mb-1">Overweight</p>
                    <p class="text-sm text-yellow-800">25 - 29.9</p>
                </div>
                <div class="text-center p-3 rounded-xl bg-red-50 border border-red-200">
                    <p class="text-xs text-red-600 font-semibold mb-1">Obese</p>
                    <p class="text-sm text-red-800">≥ 30</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Action Buttons -->
    <div class="flex flex-col sm:flex-row gap-4 justify-center animate-slide-up" style="animation-delay: 0.2s;">
        <a href="{{ route('bmi.show') }}" class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            Calculate Again
        </a>
        <a href="{{ url('/') }}" class="inline-flex items-center justify-center px-8 py-4 bg-white hover:bg-slate-50 text-slate-700 font-semibold rounded-xl border border-slate-300 shadow hover:shadow-md transition-all duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            Back to Home
        </a>
    </div>
    
    <!-- Health Tips -->
    <div class="mt-12 grid md:grid-cols-3 gap-6 animate-slide-up" style="animation-delay: 0.3s;">
        <div class="glass rounded-2xl p-6">
            <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
            </div>
            <h3 class="font-display font-semibold text-slate-800 mb-2">Stay Active</h3>
            <p class="text-sm text-slate-600">Aim for at least 150 minutes of moderate exercise per week.</p>
        </div>
        
        <div class="glass rounded-2xl p-6">
            <div class="w-10 h-10 bg-accent-100 rounded-xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
            <h3 class="font-display font-semibold text-slate-800 mb-2">Eat Balanced</h3>
            <p class="text-sm text-slate-600">Focus on whole foods, vegetables, and lean proteins.</p>
        </div>
        
        <div class="glass rounded-2xl p-6">
            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center mb-4">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="font-display font-semibold text-slate-800 mb-2">Track Progress</h3>
            <p class="text-sm text-slate-600">Monitor your BMI regularly to maintain a healthy lifestyle.</p>
        </div>
    </div>
</div>
@endsection
