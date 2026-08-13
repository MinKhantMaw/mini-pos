<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        @font-face {
            font-family: "Noto Sans Myanmar";
            src: url("file://{{ storage_path('fonts/NotoSansMyanmar-Regular.ttf') }}") format("truetype");
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: "Noto Sans Myanmar";
            src: url("file://{{ storage_path('fonts/NotoSansMyanmar-Bold.ttf') }}") format("truetype");
            font-weight: bold;
            font-style: normal;
        }

        * {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: "DejaVu Sans", Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .myanmar {
            font-family: "Noto Sans Myanmar", "DejaVu Sans", Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px
        }

        th,
        td {
            border-bottom: 1px solid #ddd;
            padding: 8px;
            text-align: left
        }

        .right {
            text-align: right
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header-info h2 {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .header-info p {
            font-size: 11px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="header">
        <div>
            <img src="{{ public_path('images/logo.jpg') }}" style="height:60px;" alt="Logo" />
        </div>
        <div style="text-align:right" class="header-info">
            <h2>ငွေတောင်း {{ $sale->invoice_number }}</h2>
            <p>{{ $sale->customer_name }} · {{ $sale->sale_date->format('d M Y') }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Price</th>
                <th class="right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sale->items as $item)
                <tr>
                    <td class="myanmar">{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->selling_price, 2) }}</td>
                    <td class="right">{{ number_format($item->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="right" style="margin-top:20px">
        <p>SubTotal: {{ number_format($sale->subtotal, 2) }}</p>
        <p>Discount: {{ number_format($sale->discount, 2) }}</p>
        <p>Delivery Fee: {{ number_format($sale->delivery_fee, 2) }}</p>
        <p style="margin-top:10px"><strong>Total: {{ number_format($sale->total_amount, 2) }}</strong></p>
    </div>
</body>

</html>
