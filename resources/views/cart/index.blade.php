@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="mb-4 text-center">🛒 Keranjang Belanja</h1>

    @if($cart->items->isEmpty())
        <div class="alert alert-info text-center">
            Keranjang masih kosong. Yuk belanja dulu!
        </div>
    @else
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart->items as $item)
                    <tr>
                        <td>
                            <img src="{{ $item->product->primaryImage->url ?? '/img/no-image.png' }}" 
                                 alt="{{ $item->product->name }}" width="60" class="me-2 rounded">
                            {{ $item->product->name }}
                        </td>
                        <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-flex">
                                @csrf
                                <input type="number" name="quantity" value="{{ $item->quantity }}" 
                                       min="0" class="form-control form-control-sm me-2" style="width:80px;">
                                <button type="submit" class="btn btn-sm btn-success">Update</button>
                            </form>
                        </td>
                        <td>Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-end mt-3">
            <h4>Total: 
                <span class="text-success fw-bold">
                    Rp {{ number_format($cart->items->sum(fn($i) => $i->quantity * $i->price), 0, ',', '.') }}
                </span>
            </h4>
            <a href="#" class="btn btn-lg btn-primary mt-2">Checkout</a>
        </div>
    @endif
</div>
@endsection
