@extends('layouts.main')

@section('content')
<section class="py-16 md:py-24 bg-slate-50">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-amber-100 text-amber-700 font-bold text-2xl mb-6">
            410
        </div>
        <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4 tracking-tight">
            Testing Location Permanently Retired
        </h1>
        <p class="text-lg text-slate-600 max-w-2xl mx-auto mb-8">
            The collection site or address you requested has been permanently decommissioned. However, Certified Drug Test Centers partners with over 20,000 active Quest Diagnostics and Labcorp facilities nationwide.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('locations.index') }}" class="btn-primary w-full sm:w-auto px-8 py-3.5 text-base font-semibold text-white bg-blue-700 hover:bg-blue-800 rounded-xl shadow-md transition">
                Find Nearest Active Center
            </a>
            <a href="{{ route('home') }}" class="btn-secondary w-full sm:w-auto px-8 py-3.5 text-base font-semibold text-slate-700 bg-white border border-slate-300 hover:bg-slate-100 rounded-xl transition">
                Return to Homepage
            </a>
        </div>
    </div>
</section>
@endsection
