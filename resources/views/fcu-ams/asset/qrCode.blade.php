@extends('layouts.layout')

@section('content')
<div class="container">
    <h1>Asset QR Code</h1>
    <div>
        {{ $qrCode }}
    </div>
</div>
@endsection