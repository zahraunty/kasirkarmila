<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Nota Pemesanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            color: #000;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        h1 {
            text-align: center;
        }
    </style>
</head>

<body>
    <h1>Nota Pemesanan</h1>
    <p><strong>Nama Barang:</strong> {{ $order->item->name }}</p>
    <p><strong>Jumlah:</strong> {{ $order->quantity }}</p>
    <p><strong>Total Harga:</strong> Rp {{ number_format($order->final_price, 0, ',', '.') }}</p>
    <p><strong>Tanggal:</strong> {{ $order->created_at->format('d-m-Y H:i') }}</p>
</body>

</html>