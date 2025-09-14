@extends('layouts.app')
@section('content')
    <h2>Bill Details</h2>

    @if(!empty($bill['data']))
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <p><strong>Customer Name:</strong> {{ $bill['data']['customername'] ?? '-' }}</p>
                <p><strong>Bill Number:</strong> {{ $bill['data']['billnumber'] ?? '-' }}</p>
                <p><strong>Bill Date:</strong> {{ $bill['data']['billdate'] ?? '-' }}</p>
                <p><strong>Due Date:</strong> {{ $bill['data']['duedate'] ?? '-' }}</p>
                <p><strong>Due Amount:</strong> ₹{{ $bill['data']['dueamount'] ?? '-' }}</p>
            </div>
        </div>

        <form action="{{ route('pay.bill') }}" method="POST">
            @csrf
            <input type="hidden" name="biller_id" value="{{ $billerId }}">
            <input type="hidden" name="customer_number" value="{{ request('customer_number') }}">
            <input type="hidden" name="amount" value="{{ $bill['data']['dueamount'] ?? 0 }}">
            <input type="hidden" name="clientRefId" value="{{ $bill['data']['ClientRefId'] ?? 0 }}">
            <input type="hidden" name="RequestID" value="{{ $bill['data']['RequestID'] ?? 0 }}">

            <button class="btn btn-primary">Pay Now</button>
        </form>
    @else
        <div class="alert alert-warning">
            No bill details available.
        </div>
    @endif
@endsection
