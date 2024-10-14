@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-primary d-flex justify-content-between align-items-center">
                        {{ __('Dashboard') }} | Tambah Data
                        <a href="{{ route('products.index') }}" class="btn btn-outline-primary">List Data</a>
                    </div>
                    {{-- form --}}
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Product</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name=" name" placeholder="Enter product name" value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <div class="mb-3">
                                    <label for="price" class="form-label">Price</label>
                                    <input type="number" class="form-control @error('price') is-invalid @enderror"
                                        name="price" placeholder="Enter price of product" value="{{ old('price') }}">
                                    @error('price')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">Gambar Image</label>
                                    <input class="form-control @error('image') is-invalid @enderror" type="file"
                                        name="image" value="{{ old('image') }}">
                                    @error('image')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                    {{-- end form --}}
                </div>
            </div>
        </div>
    </div>
@endsection
