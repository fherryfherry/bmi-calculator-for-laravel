@extends('layouts.frontend')

@section('title', 'BMI Calculator')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-20">
    <!-- Hero Section -->
    <div class="text-center mb-12 animate-fade-in">
        <h1 class="font-display text-4xl sm:text-5xl font-bold text-slate-800 mb-4">
            Calculate Your <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-accent-500">BMI</span>
        </h1>
        <p class="text-lg text-slate-600 max-w-2xl mx-auto">
            Discover your Body Mass Index instantly with our free calculator. Get personalized health insights based on your measurements.
        </p>
    </div>
    
    <!-- Calculator Card -->
    <div class="glass rounded-3xl shadow-2xl p-8 sm:p-12 animate-slide-up">
        <form action="{{ route('bmi.calculate') }}" method="POST" id="bmiForm">
            @csrf
            
            <div class="grid md:grid-cols-2 gap-8">
                <!-- Name Input -->
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">
                        Your Name <span class="text-accent-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}"
                        placeholder="Enter your full name"
                        class="input-focus w-full px-4 py-3 rounded-xl border border-slate-200 bg-white/80 text-slate-800 placeholder-slate-400 transition-all hover:border-primary-300"
                        required
                    >
                    @error('name')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Weight Input -->
                <div>
                    <label for="weight" class="block text-sm font-semibold text-slate-700 mb-2">
                        Weight (kg) <span class="text-accent-500">*</span>
                    </label>
                    <div class="relative">
                        <input 
                            type="number" 
                            id="weight" 
                            name="weight" 
                            value="{{ old('weight') }}"
                            placeholder="70"
                            min="20"
                            max="300"
                            step="0.1"
                            class="input-focus w-full px-4 py-3 rounded-xl border border-slate-200 bg-white/80 text-slate-800 placeholder-slate-400 transition-all hover:border-primary-300"
                            required
                        >
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm">kg</span>
                    </div>
                    <input 
                        type="range" 
                        id="weightSlider" 
                        min="20" 
                        max="300" 
                        step="0.5"
                        value="{{ old('weight', 70) }}"
                        class="w-full mt-3 accent-primary-600"
                    >
                    @error('weight')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Height Input -->
                <div>
                    <label for="height" class="block text-sm font-semibold text-slate-700 mb-2">
                        Height (cm) <span class="text-accent-500">*</span>
                    </label>
                    <div class="relative">
                        <input 
                            type="number" 
                            id="height" 
                            name="height" 
                            value="{{ old('height') }}"
                            placeholder="175"
                            min="50"
                            max="250"
                            step="1"
                            class="input-focus w-full px-4 py-3 rounded-xl border border-slate-200 bg-white/80 text-slate-800 placeholder-slate-400 transition-all hover:border-primary-300"
                            required
                        >
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm">cm</span>
                    </div>
                    <input 
                        type="range" 
                        id="heightSlider" 
                        min="50" 
                        max="250" 
                        step="1"
                        value="{{ old('height', 175) }}"
                        class="w-full mt-3 accent-primary-600"
                    >
                    @error('height')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Notes Input -->
                <div class="md:col-span-2">
                    <label for="notes" class="block text-sm font-semibold text-slate-700 mb-2">
                        Notes <span class="text-slate-400 font-normal">(optional)</span>
                    </label>
                    <textarea 
                        id="notes" 
                        name="notes" 
                        rows="3"
                        placeholder="Any additional notes (e.g., fitness goals, health conditions)"
                        class="input-focus w-full px-4 py-3 rounded-xl border border-slate-200 bg-white/80 text-slate-800 placeholder-slate-400 transition-all hover:border-primary-300 resize-none"
                    >{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Live BMI Preview -->
            <div class="mt-8 p-6 bg-gradient-to-r from-primary-50 to-accent-50 rounded-2xl border border-primary-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-600 mb-1">Your Estimated BMI</p>
                        <p class="text-3xl font-display font-bold text-primary-700" id="liveBmi">22.86</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-slate-600 mb-1">Category</p>
                        <p class="text-lg font-semibold text-primary-600" id="liveCategory">Normal</p>
                    </div>
                </div>
                <!-- BMI Scale -->
                <div class="mt-4">
                    <div class="relative h-4 bg-gradient-to-r from-blue-400 via-green-400 via-yellow-400 to-red-500 rounded-full">
                        <div class="absolute top-1/2 -translate-y-1/2 w-1 h-6 bg-slate-800 rounded-full transition-all duration-300" id="bmiMarker" style="left: 45%;"></div>
                    </div>
                    <div class="flex justify-between mt-2 text-xs text-slate-500">
                        <span>Underweight</span>
                        <span>Normal</span>
                        <span>Overweight</span>
                        <span>Obese</span>
                    </div>
                </div>
            </div>
            
            <!-- Submit Button -->
            <div class="mt-8">
                <button 
                    type="submit" 
                    class="w-full py-4 px-6 bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center space-x-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 36v-3m-3 3h3"></path>
                    </svg>
                    <span>Calculate My BMI</span>
                </button>
            </div>
        </form>
    </div>
    
    <!-- Info Cards -->
    <div class="grid sm:grid-cols-3 gap-6 mt-12">
        <div class="glass rounded-2xl p-6 text-center hover:shadow-lg transition-shadow">
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="font-display font-semibold text-slate-800 mb-2">What is BMI?</h3>
            <p class="text-sm text-slate-600">Body Mass Index is a measure of body fat based on height and weight.</p>
        </div>
        
        <div class="glass rounded-2xl p-6 text-center hover:shadow-lg transition-shadow">
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="font-display font-semibold text-slate-800 mb-2">Free & Instant</h3>
            <p class="text-sm text-slate-600">Get your BMI calculation instantly with no registration required.</p>
        </div>
        
        <div class="glass rounded-2xl p-6 text-center hover:shadow-lg transition-shadow">
            <div class="w-12 h-12 bg-accent-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
            <h3 class="font-display font-semibold text-slate-800 mb-2">Private & Secure</h3>
            <p class="text-sm text-slate-600">Your data is stored securely and never shared with third parties.</p>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const weightInput = document.getElementById('weight');
    const heightInput = document.getElementById('height');
    const weightSlider = document.getElementById('weightSlider');
    const heightSlider = document.getElementById('heightSlider');
    const liveBmi = document.getElementById('liveBmi');
    const liveCategory = document.getElementById('liveCategory');
    const bmiMarker = document.getElementById('bmiMarker');
    
    function calculateBmi(weight, height) {
        if (!weight || !height || height <= 0) return null;
        const heightInMeters = height / 100;
        return (weight / (heightInMeters * heightInMeters)).toFixed(2);
    }
    
    function getCategory(bmi) {
        if (bmi < 18.5) return { name: 'Underweight', color: 'text-blue-600', position: 20 };
        if (bmi < 25) return { name: 'Normal', color: 'text-green-600', position: 45 };
        if (bmi < 30) return { name: 'Overweight', color: 'text-yellow-600', position: 70 };
        return { name: 'Obese', color: 'text-red-600', position: 90 };
    }
    
    function updateDisplay() {
        const weight = parseFloat(weightInput.value) || 70;
        const height = parseFloat(heightInput.value) || 175;
        const bmi = calculateBmi(weight, height);
        
        if (bmi) {
            const category = getCategory(bmi);
            liveBmi.textContent = bmi;
            liveCategory.textContent = category.name;
            liveCategory.className = `text-lg font-semibold ${category.color}`;
            bmiMarker.style.left = category.position + '%';
        }
    }
    
    // Sync inputs with sliders
    weightInput.addEventListener('input', function() {
        weightSlider.value = this.value;
        updateDisplay();
    });
    
    heightInput.addEventListener('input', function() {
        heightSlider.value = this.value;
        updateDisplay();
    });
    
    weightSlider.addEventListener('input', function() {
        weightInput.value = this.value;
        updateDisplay();
    });
    
    heightSlider.addEventListener('input', function() {
        heightInput.value = this.value;
        updateDisplay();
    });
    
    // Initial display
    updateDisplay();
});
</script>
@endpush
