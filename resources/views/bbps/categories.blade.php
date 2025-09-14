@extends('layouts.app')
@section('content')
    <h2>Select Category</h2>
    <div class="row">
        @foreach ($categories['data'] ?? [] as $cat)
            <div class="col-md-3 mb-3">
                <a href="{{ route('billers', ['category_name' => $cat['category']]) }}" 
                   class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5>{{ $cat['category'] }}</h5>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
@endsection
