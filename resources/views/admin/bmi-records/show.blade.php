@extends('admin.layout')

@section('title', 'BMI Record Details')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('admin.bmi-records.index') }}" class="inline-flex items-center text-sm text-ink-muted hover:text-brand transition-colors mb-2">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Records
            </a>
            <h1 class="font-display text-2xl font-bold text-ink">BMI Record Details</h1>
        </div>
        <div class="flex items-center gap-3">
            <form action="{{ route('admin.bmi-records.destroy', $bmiRecord) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this record?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-50 border border-red-200 text-red-700 font-medium rounded-lg hover:bg-red-100 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Delete Record
                </button>
            </form>
        </div>
    </div>
    
    <!-- Main Info Card -->
    <div class="bg-white rounded-xl border border-line shadow-sm overflow-hidden">
        <div class="grid md:grid-cols-2 gap-0">
            <!-- Left: BMI Display -->
            <div class="p-8 bg-gradient-to-br from-brand-soft to-canvas flex flex-col items-center justify-center">
                <div class="relative w-48 h-48">
                    <svg class="w-full h-full" viewBox="0 0 200 200">
                        <!-- Background circle -->
                        <circle cx="100" cy="100" r="80" fill="none" stroke="#e2e8f0" stroke-width="12"/>
                        <!-- Colored segments -->
                        <circle cx="100" cy="100" r="80" fill="none" stroke="#60a5fa" stroke-width="12" 
                                stroke-dasharray="126 377" transform="rotate(135 100 100)"/>
                        <circle cx="100" cy="100" r="80" fill="none" stroke="#4ade80" stroke-width="12" 
                                stroke-dasharray="126 377" stroke-dashoffset="-126" transform="rotate(135 100 100)"/>
                        <circle cx="100" cy="100" r="80" fill="none" stroke="#fbbf24" stroke-width="12" 
                                stroke-dasharray="126 377" stroke-dashoffset="-252" transform="rotate(135 100 100)"/>
                        <circle cx="100" cy="100" r="80" fill="none" stroke="#f87171" stroke-width="12" 
                                stroke-dasharray="126 377" stroke-dashoffset="-378" transform="rotate(135 100 100)"/>
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-4xl font-display font-bold {{ $bmiRecord->bmi_category === 'Normal' ? 'text-green-600' : ($bmiRecord->bmi_category === 'Underweight' ? 'text-blue-600' : ($bmiRecord->bmi_category === 'Overweight' ? 'text-yellow-600' : 'text-red-600')) }}">
                            {{ $bmiRecord->bmi_value }}
                        </span>
                        <span class="text-sm text-ink-muted mt-1">BMI</span>
                    </div>
                </div>
                @php
                    $categoryColors = [
                        'Underweight' => 'bg-blue-100 text-blue-800',
                        'Normal' => 'bg-green-100 text-green-800',
                        'Overweight' => 'bg-yellow-100 text-yellow-800',
                        'Obese' => 'bg-red-100 text-red-800',
                    ];
                @endphp
                <span class="mt-4 inline-flex px-4 py-2 rounded-full text-sm font-medium {{ $categoryColors[$bmiRecord->bmi_category] ?? 'bg-slate-100 text-slate-800' }}">
                    {{ $bmiRecord->bmi_category }}
                </span>
            </div>
            
            <!-- Right: Details -->
            <div class="p-8 space-y-6">
                <div>
                    <h2 class="font-display text-lg font-semibold text-ink mb-4">Personal Information</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between py-2 border-b border-line">
                            <span class="text-ink-muted">Name</span>
                            <span class="font-medium text-ink">{{ $bmiRecord->name }}</span>
                        </div>
                        @if($bmiRecord->user)
                        <div class="flex justify-between py-2 border-b border-line">
                            <span class="text-ink-muted">User Account</span>
                            <span class="font-medium text-ink">{{ $bmiRecord->user->email }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between py-2 border-b border-line">
                            <span class="text-ink-muted">Weight</span>
                            <span class="font-medium text-ink">{{ $bmiRecord->weight }} kg</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-line">
                            <span class="text-ink-muted">Height</span>
                            <span class="font-medium text-ink">{{ $bmiRecord->height }} cm</span>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h2 class="font-display text-lg font-semibold text-ink mb-4">Record Information</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between py-2 border-b border-line">
                            <span class="text-ink-muted">Created At</span>
                            <span class="font-medium text-ink">{{ $bmiRecord->created_at->format('M d, Y - H:i') }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-line">
                            <span class="text-ink-muted">Last Updated</span>
                            <span class="font-medium text-ink">{{ $bmiRecord->updated_at->format('M d, Y - H:i') }}</span>
                        </div>
                        @if($bmiRecord->notes)
                        <div class="pt-3">
                            <span class="text-ink-muted block mb-2">Notes</span>
                            <p class="text-ink bg-canvas-soft rounded-lg p-3">{{ $bmiRecord->notes }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- BMI Scale Reference -->
    <div class="bg-white rounded-xl border border-line shadow-sm p-6">
        <h2 class="font-display text-lg font-semibold text-ink mb-4">BMI Scale Reference</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="p-4 rounded-xl bg-blue-50 border border-blue-200 {{ $bmiRecord->bmi_category === 'Underweight' ? 'ring-2 ring-blue-500' : '' }}">
                <p class="text-sm font-semibold text-blue-700 mb-1">Underweight</p>
                <p class="text-xs text-blue-600">&lt; 18.5</p>
            </div>
            <div class="p-4 rounded-xl bg-green-50 border border-green-200 {{ $bmiRecord->bmi_category === 'Normal' ? 'ring-2 ring-green-500' : '' }}">
                <p class="text-sm font-semibold text-green-700 mb-1">Normal</p>
                <p class="text-xs text-green-600">18.5 - 24.9</p>
            </div>
            <div class="p-4 rounded-xl bg-yellow-50 border border-yellow-200 {{ $bmiRecord->bmi_category === 'Overweight' ? 'ring-2 ring-yellow-500' : '' }}">
                <p class="text-sm font-semibold text-yellow-700 mb-1">Overweight</p>
                <p class="text-xs text-yellow-600">25 - 29.9</p>
            </div>
            <div class="p-4 rounded-xl bg-red-50 border border-red-200 {{ $bmiRecord->bmi_category === 'Obese' ? 'ring-2 ring-red-500' : '' }}">
                <p class="text-sm font-semibold text-red-700 mb-1">Obese</p>
                <p class="text-xs text-red-600">≥ 30</p>
            </div>
        </div>
    </div>
</div>
@endsection
