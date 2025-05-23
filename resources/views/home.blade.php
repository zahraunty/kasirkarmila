@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">Pilih Barang</div>
                    <div class="card-body">
                        <form action="{{ route('cart.store') }}" method="post">
                            @csrf
                            <input type="hidden" name="item_id" id="itemId">
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="item_name" id="itemName"
                                        placeholder="Pilih barang..." readonly required>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-secondary" data-toggle="modal"
                                            data-target="#pilihBarang">Pilih</button>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="pilihBarang">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Pilih Barang</h5>
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table table-striped">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Nama Barang</th>
                                                        <th>Kategori</th>
                                                        <th>Foto</th>
                                                        <th>Harga</th>
                                                        <th>Stok</th>
                                                        <th>Opsi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($items as $item)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $item->name }}</td>
                                                            <td>{{ $item->category->name }}</td>
                                                            <td><img src="{{ asset($item->image) }}" width="50px" height="50px">
                                                            </td>
                                                            <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                                            <td>{{ $item->stock }}</td>
                                                            <td>
                                                                <button type="button" class="btn btn-sm btn-primary"
                                                                    data-dismiss="modal" onclick="
                                                                                        $('#itemId').val('{{ $item->id }}');
                                                                                        $('#itemName').val('{{ $item->name }}');
                                                                                        $('#itemQty').attr('max', '{{ $item->stock }}');
                                                                                    ">
                                                                    Pilih
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <input type="number" min="1" value="1" class="form-control" name="quantity" id="itemQty"
                                        placeholder="Jumlah..." required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">Unit</span>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary float-right">Tambah</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8 mb-4">
                <div class="card">
                    <div class="card-header">Pembayaran</div>
                    <div class="card-body">
                        <form action="{{ route('transaction.store') }}" method="post">
                            @csrf
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Total Harga</label>
                                <div class="input-group col-sm-10">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="number" class="form-control" name="total"
                                        value="{{ $itemCarts->sum(fn($item) => $item->price * $item->cart->quantity) }}"
                                        readonly required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Jumlah Bayar</label>
                                <div class="input-group col-sm-10">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="number" class="form-control" name="pay_total"
                                        min="{{ $itemCarts->sum(fn($item) => $item->price * $item->cart->quantity) }}"
                                        required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Tanggal</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" value="{{ date('d F Y') }}" disabled>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary float-right">Bayar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Foto</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($itemCarts as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->category->name }}</td>
                        <td><img src="{{ asset($item->image) }}" width="50px" height="50px"></td>
                        <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td>{{ $item->cart->quantity }}</td>
                        <td>Rp {{ number_format($item->price * $item->cart->quantity, 0, ',', '.') }}</td>
                        <td>
                            <button class="btn btn-sm btn-primary" data-toggle="modal"
                                data-target="#ubahJumlah{{ $loop->iteration }}">Ubah</button>
                            <form action="{{ route('cart.destroy', $item->cart) }}" method="post" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    <div class="modal fade" id="ubahJumlah{{ $loop->iteration }}">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Ubah Jumlah {{ $item->name }}</h5>
                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('cart.update', $item->cart) }}" method="post">
                                        @csrf
                                        @method('PATCH')
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="number" min="1" name="quantity" value="{{ $item->cart->quantity }}"
                                                    class="form-control" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Unit</span>
                                                    <button type="submit" class="btn btn-primary">Ubah</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection