@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col">
                {{-- notif berhasil --}}
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="card">
                    <div class="card-header text-primary d-flex justify-content-between align-items-center">
                        Dashboard | Data Products
                        <a href="{{ route('products.create') }}" class="btn btn-primary float-right">Add Item</a>
                    </div>
                    {{-- table --}}
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            {{-- cek data --}}
                            @if ($products->isEmpty() == false)
                                {{-- looping data --}}
                                @foreach ($products as $item)
                                    <tr>
                                        {{-- <th class="align-middle">{{ $loop->iteration }}</th> --}}
                                        <th class="align-middle">{{ $products->firstItem() + $loop->index }}</th>
                                        <td class="align-middle">
                                            <img src="{{ asset('assets/images/' . $item->image) }}"
                                                alt="{{ $item->image }}" height="50">
                                        </td>
                                        <td class="align-middle">{{ $item->name }}</td>
                                        <td class="align-middle">$. {{ $item->price }}</td>
                                        <td class="align-middle">
                                            <form action="{{ route('products.destroy', $item->id) }}" method="POST">
                                                <a href="{{ route('products.show', $item->id) }}"
                                                    class="btn text-primary">Detail</a>
                                                <a href="{{ route('products.edit', $item->id) }}"
                                                    class="btn text-warning">Edit</a>

                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn text-danger"
                                                    onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>

                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">Data produk kosong</td>
                                </tr>
                            @endif
                        </table>
                        {{-- untuk pagination --}}
                        {{ $products->links() }}
                    </div>
                    {{-- end tables --}}
                </div>
            </div>
        </div>
    </div>
@endsection
