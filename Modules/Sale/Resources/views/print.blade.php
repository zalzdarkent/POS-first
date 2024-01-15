<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Faktur Penjualan</title>
    <link rel="stylesheet" href="{{ public_path('b3/bootstrap.min.css') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 80%;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            /* Add your logo styling here */
            max-width: 100px; /* Adjust as needed */
            margin-bottom: 10px;
        }

        .info-section {
            border-bottom: 1px solid #ddd;
            margin-bottom: 20px;
            padding-bottom: 20px;
        }

        .info-section h4 {
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }

        .info-section div {
            margin-bottom: 8px;
        }

        .table-section {
            margin-top: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .total-section {
            float: right;
        }

        .footer {
            margin-top: 25px;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        {{-- <img class="logo" src="{{ public_path('images/logo-dark.png') }}" alt="Logo"> --}}
        <h4>Faktur Penjualan</h4>
        <p><strong>Reference:</strong> {{ $sale->reference }}</p>
    </div>

    <div class="info-section">
        <div class="row">
            <div class="col-xs-4">
                <h4>Info Perusahaan:</h4>
                <div><strong>{{ settings()->company_name }}</strong></div>
                <div>{{ settings()->company_address }}</div>
                <div>Email: {{ settings()->company_email }}</div>
                <div>Phone: {{ settings()->company_phone }}</div>
            </div>

            <div class="col-xs-4">
                <h4>Info Pelanggan:</h4>
                <div><strong>{{ $customer->customer_name }}</strong></div>
                <div>{{ $customer->address }}</div>
                <div>Email: {{ $customer->customer_email }}</div>
                <div>Phone: {{ $customer->customer_phone }}</div>
            </div>

            <div class="col-xs-4">
                <h4>Info Faktur:</h4>
                <div>Invoice: <strong>INV/{{ $sale->reference }}</strong></div>
                <div>Date: {{ \Carbon\Carbon::parse($sale->date)->format('d M, Y') }}</div>
                <div>Status: <strong>{{ $sale->status }}</strong></div>
                <div>Payment Status: <strong>{{ $sale->payment_status }}</strong></div>
            </div>
        </div>
    </div>

    <div class="table-section">
        <table>
            <thead>
            <tr>
                <th>Product</th>
                <th>Unit Price</th>
                <th>Quantity</th>
                <th>Discount</th>
                <th>Tax</th>
                <th>Sub Total</th>
            </tr>
            </thead>
            <tbody>
            @foreach($sale->saleDetails as $item)
                <tr>
                    <td>
                        {{ $item->product_name }} <br>
                        <span class="badge badge-success">{{ $item->product_code }}</span>
                    </td>

                    <td>{{ format_currency($item->unit_price) }}</td>

                    <td>{{ $item->quantity }}</td>

                    <td>{{ format_currency($item->product_discount_amount) }}</td>

                    <td>{{ format_currency($item->product_tax_amount) }}</td>

                    <td>{{ format_currency($item->sub_total) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="total-section">
            <table>
                <tbody>
                <tr>
                    <td><strong>Discount ({{ $sale->discount_percentage }}%)</strong></td>
                    <td>{{ format_currency($sale->discount_amount) }}</td>
                </tr>
                <tr>
                    <td><strong>Tax ({{ $sale->tax_percentage }}%)</strong></td>
                    <td>{{ format_currency($sale->tax_amount) }}</td>
                </tr>
                <tr>
                    <td><strong>Shipping</strong></td>
                    <td>{{ format_currency($sale->shipping_amount) }}</td>
                </tr>
                <tr>
                    <td><strong>Grand Total</strong></td>
                    <td><strong>{{ format_currency($sale->total_amount) }}</strong></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="footer">
        <p style="font-style: italic;">{{ settings()->company_name }} &copy; {{ date('Y') }}.</p>
    </div>
</div>
</body>
</html>
