@extends('layouts.app')

@section('content')
  <div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold mb-8">Hello World - Phase 2 Test</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-border">
        <h2 class="text-xl font-bold text-dark mb-3">Enhanced Card Design</h2>
        <p class="text-dark-light">This card uses the new Phase 2 styling with enhanced shadows and borders.</p>
      </div>
      
      <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-border transform hover:scale-105 hover:-translate-y-2 transition-all duration-500">
        <h2 class="text-xl font-bold text-dark mb-3">Hover Effects</h2>
        <p class="text-dark-light">Hover over this card to see the enhanced animation effects.</p>
      </div>
      
      <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-border">
        <span class="inline-block px-3 py-1.5 text-xs font-semibold bg-blue-100 text-blue-800 border-blue-200 rounded-full mb-3 border backdrop-blur-sm">
          Technology
        </span>
        <h2 class="text-xl font-bold text-dark mb-3">Enhanced Categories</h2>
        <p class="text-dark-light">New category styling with borders and enhanced colors.</p>
      </div>
    </div>
  </div>
@endsection
