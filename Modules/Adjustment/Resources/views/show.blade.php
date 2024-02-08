@extends('layouts.app')

@section('title', 'Detail Penyesuaian')

@push('page_css')
    @livewireStyles
@endpush

@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route('adjustments.index') }}">Penyesuaian</a></li>
        <li class="breadcrumb-item active">Detail</li>
    </ol>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th colspan="2">
                                        Tanggal
                                    </th>
                                    <th colspan="2">
                                        Nomor Referensi
                                    </th>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        {{ $adjustment->date }}
                                    </td>
                                    <td colspan="2">
                                        {{ $adjustment->reference }}
                                    </td>
                                </tr>

                                <tr>
                                    <th>Nama Produk</th>
                                    <th>Kode Produk</th>
                                    <th>Kuantitas</th>
                                    <th>Tipe Produk</th>
                                </tr>

                                @foreach($adjustment->adjustedProducts as $adjustedProduct)
                                    <tr>
                                        <td>{{ $adjustedProduct->product->product_name }}</td>
                                        <td>{{ $adjustedProduct->product->product_code }}</td>
                                        <td>{{ $adjustedProduct->quantity }}</td>
                                        <td>
                                            @if($adjustedProduct->type == 'add')
                                                (+) Penambahan
                                            @else
                                                (-) Pengurangan
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <th colspan="4">Catatan</th>
                                </tr>

                                <tr>
                                    <td colspan="4">
                                        {{$adjustment->note}}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
