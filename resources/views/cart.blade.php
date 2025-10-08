@extends('layouts.app')

@section('title', 'My Cart - ShoeCommerce')

@section('content')
<div class="container my-5">
    <!-- React mount point -->
    <div id="cart-app"></div>
</div>
@endsection

@viteReactRefresh
@vite('resources/js/app.jsx')
