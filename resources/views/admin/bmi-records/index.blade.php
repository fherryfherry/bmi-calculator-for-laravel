@extends('admin.layout')

@section('title', 'BMI Records')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="font-display text-2xl font-bold text-ink">BMI Records</h1>
            <p class="text-ink-muted mt-1">Track and manage all BMI calculations</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('bmi.show') }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-white border border-line text-ink font-medium rounded-lg hover:bg-canvas-soft transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
                Open Calculator
            </a>
        </div>
    </div>
    
    <!-- Filters -->
    <div class="bg-white rounded-xl border border-line shadow-sm p-4">
        <form action="{{ route('admin.bmi-records.index') }}" method="GET" class="grid sm:grid-cols-2 lg:grid-cols-5 gap-4">
            <div class="lg:col-span-2">
                <label class="block text-sm font-medium text-ink-muted mb-1">Search by Name</label>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ request('search') }}"
                    placeholder="Enter name..."
                    class="w-full px-3 py-2 border border-line rounded-lg focus:outline-none focus:ring-2 focus:ring-brand focus:border-transparent"
                >
            </div>
            <div>
                <label class="block text-sm font-medium text-ink-muted mb-1">Category</label>
                <select name="category" class="w-full px-3 py-2 border border-line rounded-lg focus:outline-none focus:ring-2 focus:ring-brand focus:border-transparent">
                    <option value="">All Categories</option>
                    <option value="Underweight" {{ request('category') === 'Underweight' ? 'selected' : '' }}>Underweight</option>
                    <option value="Normal" {{ request('category') === 'Normal' ? 'selected' : '' }}>Normal</option>
                    <option value="Overweight" {{ request('category') === 'Overweight' ? 'selected' : '' }}>Overweight</option>
                    <option value="Obese" {{ request('category') === 'Obese' ? 'selected' : '' }}>Obese</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-ink-muted mb-1">Date From</label>
                <input 
                    type="date" 
                    name="date_from" 
                    value="{{ request('date_from') }}"
                    class="w-full px-3 py-2 border border-line rounded-lg focus:outline-none focus:ring-2 focus:ring-brand focus:border-transparent"
                >
            </div>
            <div>
                <label class="block text-sm font-medium text-ink-muted mb-1">Date To</label>
                <input 
                    type="date" 
                    name="date_to" 
                    value="{{ request('date_to') }}"
                    class="w-full px-3 py-2 border border-line rounded-lg focus:outline-none focus:ring-2 focus:ring-brand focus:border-transparent"
                >
            </div>
            <div class="lg:col-span-5 flex items-end gap-3">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-brand text-white font-medium rounded-lg hover:bg-brand-deep transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Filter
                </button>
                <a href="{{ route('admin.bmi-records.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-line text-ink font-medium rounded-lg hover:bg-canvas-soft transition-colors">
                    Reset
                </a>
                <span class="text-sm text-ink-muted ml-auto">
                    Total: <strong class="text-ink">{{ $bmiRecords->total() }}</strong> records
                </span>
            </div>
        </form>
    </div>
    
    <!-- Table -->
    <div class="bg-white rounded-xl border border-line shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-canvas border-b border-line">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-ink-muted uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-ink-muted uppercase tracking-wider">Weight</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-ink-muted uppercase tracking-wider">Height</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-ink-muted uppercase tracking-wider">BMI Value</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-ink-muted uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-ink-muted uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-ink-muted uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-line">
                    @forelse($bmiRecords as $record)
                    <tr class="hover:bg-canvas-soft transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-brand-soft to-brand flex items-center justify-center text-brand-deep font-semibold">
                                    {{ substr($record->name, 0, 1) }}
                                </div>
                                <div class="ml-3">
                                    <p class="font-medium text-ink">{{ $record->name }}</p>
                                    @if($record->user)
                                        <p class="text-sm text-ink-muted">{{ $record->user->email }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-ink">{{ $record->weight }} kg</td>
                        <td class="px-6 py-4 text-ink">{{ $record->height }} cm</td>
                        <td class="px-6 py-4">
                            <span class="text-lg font-bold {{ $record->bmi_category === 'Normal' ? 'text-green-600' : ($record->bmi_category === 'Underweight' ? 'text-blue-600' : ($record->bmi_category === 'Overweight' ? 'text-yellow-600' : 'text-red-600')) }}">
                                {{ $record->bmi_value }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $categoryColors = [
                                    'Underweight' => 'bg-blue-100 text-blue-800',
                                    'Normal' => 'bg-green-100 text-green-800',
                                    'Overweight' => 'bg-yellow-100 text-yellow-800',
                                    'Obese' => 'bg-red-100 text-red-800',
                                ];
                            @endphp
                            <span class="inline-flex px-3 py-1 rounded-full text-sm font-medium {{ $categoryColors[$record->bmi_category] ?? 'bg-slate-100 text-slate-800' }}">
                                {{ $record->bmi_category }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-ink-muted">
                            {{ $record->created_at->format('M d, Y') }}
                            <p class="text-xs">{{ $record->created_at->format('H:i') }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.bmi-records.show', $record) }}" class="text-brand hover:text-brand-deep transition-colors" title="View Details">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                <form action="{{ route('admin.bmi-records.destroy', $record) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 transition-colors" title="Delete">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-canvas rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-ink-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <p class="text-ink-muted">No BMI records found</p>
                                <a href="{{ route('bmi.show') }}" class="mt-3 text-brand hover:text-brand-deep font-medium">Be the first to calculate</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($bmiRecords->hasPages())
        <div class="px-6 py-4 border-t border-line bg-canvas-soft">
            {{ $bmiRecords->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
