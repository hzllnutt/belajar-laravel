<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Struk Pembayaran #{{$order->order_code}}</title>
    <style>
        body {
            width: 58mm;
            font-family: 'Courier New', Courier, monospace;
            font-size: 11px;
            color: #000;
            margin: 0;
            padding: 5px;
        }
        .text-center {
            text-align: center;
        }
        .text-end {
            text-align: right;
        }
        .line {
            border-top: 1px dashed #000;
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            padding: 2px 0;
        }
    </style>
</head>
<body>
    <div class="text-center">
        <strong>Toko Kopi</strong>
        Jl karet
    </div>
    <div class="line"></div>
    <div class="">Tgl : {{ $order->created_at->format('d/m/Y H:i' )}}</div>
    <div class="">Code : {{ $order->order_code }}</div>
    <div class="">Metode : {{ strtoupper($order->status === 1 ? 'CASH' : 'MIDTRANS' ) }}</div>
    <div class="line"></div>
    <table>
        @foreach ($order->orderDetails as $detail)
        <tr>
            <td colspan="2">
                <strong>{{ $detail->product->name }}</strong>
            </td>
        </tr>
        <tr>
            <td>{{ $detail->order_qty}} X Rp{{ number_format($detail->order_price, 2, ',', '.')}}</td>
            <td class="text-end">Rp{{ number_format($detail->order_subtotal, 2, ',', '.')}} </td>
        </tr>
        @endforeach
    </table>
    <div class="line"></div>
    <div class="text-end">Kembali : Rp{{ number_format($order->order_change), 2, ',', '.'}} </div>
    <div class="text-end">Total : Rp{{ number_format($order->orderDetails->sum('order_subtotal'), 2, ',', '.')}} </div>
    <div class="line"></div>
    <div class="text-center">
        -- Terima Kasih -- <br>
        Selamat Menikmati!
    </div>
    <script>
        window.onload = function(){
            widow.print();
        }
    </script>
</body>
</html>
