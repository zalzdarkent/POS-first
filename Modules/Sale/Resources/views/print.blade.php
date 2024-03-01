<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sale Details</title>
    <link rel="stylesheet" href="{{ public_path('b3/bootstrap.min.css') }}">
</head>
<style>
</style>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-xs-8 mb-2 mb-md-0">
                        <div style="margin-right: auto; max-width: 70%;">
                                <div><strong>{{ settings()->company_name }}</strong></div>
                                <div style="overflow: hidden; text-overflow: ellipsis;">{{ settings()->company_address }}</div>
                                <div>Phone: {{ settings()->company_phone }}     /   Invoice: <strong>INV/{{ $sale->reference }}</strong></div>
                                <div>Email: {{ settings()->company_email }}     /   Reference: <strong>{{ $sale->reference }}</strong></div>
                            </div>
                        </div>
                        <div class="col-xs-4 mb-2 mb-md-0">
                        <div style="margin-left: auto; max-width: 70%;">
                                <div><strong>Tanggal : {{ \Carbon\Carbon::parse($sale->date)->format('d M, Y') }}</strong></div>
                                <div>Kpd yth : <strong>{{ $customer->customer_name }}</strong></div>
                                <div style="overflow: hidden; text-overflow: ellipsis;">{{ $customer->address }}</div>
                                <div>Email: {{ $customer->customer_email }}</div>
                                <div>Phone: {{ $customer->customer_phone }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive-sm" style="margin-top: 5px; overflow: hidden;">
                    <table class="table table-bordered table-fixed" style="table-layout: fixed;">
                            <thead>
                            <tr>
                                <th class="align-middle" scope="col">Product</th>
                                <th class="align-middle" scope="col">Net Unit Price</th>
                                <th class="align-middle" scope="col">Quantity</th>
                                <th class="align-middle">Discount</th>
                                <th class="align-middle">Tax</th>
                                <th class="align-middle">Sub Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sale->saleDetails as $item)
                            <tr>
                                    <td class="align-middle">
                                        {{ $item->product_name }} <br>
                                        <span class="badge badge-success">
                                                {{ $item->product_code }}
                                            </span>
                                    </td>

                                    <td class="align-middle">{{ format_currency($item->unit_price) }}</td>

                                    <td class="align-middle">
                                        {{ $item->quantity }}
                                    </td>

                                    <td class="align-middle">
                                        {{ format_currency($item->product_discount_amount) }}
                                    </td>

                                    <td class="align-middle">
                                        {{ format_currency($item->product_tax_amount) }}
                                    </td>

                                    <td class="align-middle">
                                        {{ format_currency($item->sub_total) }}
                                    </td>
                            </tr>
                            @endforeach
                            </tbody>
                            <tr>
                                <td colspan="6">Jenis Pembayaran    : Tunai <span style="float: right;">Total : <strong>{{ format_currency($sale->total_amount) }}</strong><br>Ongkos  : <strong>{{ format_currency($sale->shipping_amount) }}</strong><br>Sisa Tagihan : <strong>{{ format_currency($sale->due_amount)}}</strong></span><br>Tanggal Kirim :   {{ \Carbon\Carbon::parse($sale->date)->format('d M, Y') }}</td>
                            </tr>
                            <tr>
                                <td colspan="3">Armada Pengiriman</td>
                                <td colspan="3"><span style="float: right;">Total Yang Harus Dibayar    : {{ format_currency($sale->total_amount - $sale->due_amount) }}</span></td>
                            </tr>

                        </table>
                    </div>
                    <div class="row text-center" style="padding-top: 5px;">
                        <div class="col-xs-3" style="text-align: center;" >Hormat Kami,<br><br><br>({{ auth()->user()->name }})</div>
                        <div class="col-xs-3">Checker<br><br><br>(          )</div>
                        <div class="col-xs-3">Pengirim<br><br><br>(         )</div>
                        <div class="col-xs-3">Penerima Barang<br><br><br>({{ $customer->customer_name }})</div>
                    </div>


                    <div class="row" style="margin-top: 25px;">
                        <div class="col-xs-12">
                            <p style="font-style: italic;text-align: center">{{ settings()->company_name }} &copy; {{ date('Y') }}.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>