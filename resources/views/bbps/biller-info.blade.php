@extends('layouts.app')
@section('content')
    <h2>Biller Info</h2>

    <p><strong>Biller ID:</strong> {{ $billerId }}</p>
    <p><strong>Bill Fetch Required:</strong> {{ $info['is_bill_fetch'] ? 'Yes' : 'No' }}</p>

    @if (!empty($info['data']))
        <form action="{{ route('fetch.bill') }}" method="POST" class="mt-4">
            @csrf
            <input type="hidden" name="biller_id" value="{{ $billerId }}">

            @foreach ($info['data'] as $field)
                <div class="mb-3">
                    <label>{{ $field['field_name'] }}</label>
                    <input type="text" name="fields_info[{{ $field['field_name'] }}]" class="form-control"
                        minlength="{{ $field['field_min_length'] }}" maxlength="{{ $field['field_max_length'] }}" required>
                </div>
            @endforeach

            <button class="btn btn-success">Fetch Bill</button>
        </form>
    @else
        <div class="alert alert-warning">
            No customer input fields returned for this biller.
        </div>
    @endif
@endsection
