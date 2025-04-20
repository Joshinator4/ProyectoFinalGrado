@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Admin Panel') }}</div>

                <div class="card-body">

                    <div class="list-group">
                        <a href="{{ route('products.index') }}" class="list-group-item btn-primary mb-1" style="color: white">Manage Products</a>

                    </div>
                    <div class="list-group">
                        <a href="{{ route('users.index') }}" class="list-group-item btn-warning">Manage Users</a>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
