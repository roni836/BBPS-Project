@extends('layouts.app')
@section('content')
    <h2>Payment Status</h2>

    {{-- {{dd($payment)}} --}}
    @if (!empty($payment['data']) && ($payment['data']['status'] ?? '') == 'Success')
        <div class="alert alert-success shadow-sm">
             Payment Successful! <br>
            <strong>Ref ID:</strong> {{ $payment['data']['clientRefId'] ?? '-' }} <br>
            <strong>Txn Date:</strong> {{ $payment['data']['txn_date_time'] ?? '-' }} <br>
            {{-- <strong>Amount:</strong> ₹{{ $payment['data']['amount'] ?? '-' }} <br> --}}
            <strong>Order ID:</strong> {{ $payment['data']['order_id'] ?? '-' }}
        </div>
    @else
        <div class="alert alert-danger shadow-sm">
             Payment Failed <br>
            <strong>Message:</strong> {{ $payment['message'] ?? 'Something went wrong' }}
        </div>
    @endif
@endsection
