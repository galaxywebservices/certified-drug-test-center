@extends('layouts.main')

@section('content')
<section class="py-16 md:py-24 bg-slate-50">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-blue-100 text-blue-700 font-bold text-2xl mb-6">
            404
        </div>
        <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4 tracking-tight">
            Page Not Found
        </h1>
        <p class="text-lg text-slate-600 max-w-2xl mx-auto mb-8">
            The page or municipality you requested does not have an active certified collection facility or the URL has changed. Explore our 20,000+ certified partner facilities nationwide.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('locations.index') }}" class="btn-primary w-full sm:w-auto px-8 py-3.5 text-base font-semibold text-white bg-blue-700 hover:bg-blue-800 rounded-xl shadow-md transition">
                Browse Certified Locations by State
            </a>
            <a href="{{ route('home') }}" class="btn-secondary w-full sm:w-auto px-8 py-3.5 text-base font-semibold text-slate-700 bg-white border border-slate-300 hover:bg-slate-100 rounded-xl transition">
                Return to Homepage
            </a>
        </div>
    </div>
</section>
@endsection
