@extends('layouts.app')
@section('content')
    <h2>Select Biller</h2>
    <div class="list-group">
        {{-- {{dd($billers)}} --}}
        @foreach ($billers['data'] ?? [] as $biller)
            <a href="{{ route('biller.info',['billerId' => $biller['biller_id']]) }}" class="list-group-item list-group-item-action">
                {{ $biller['biiler_name'] }}
            </a>
        @endforeach
    </div>
@endsection
