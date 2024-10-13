<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            align-self: center;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .text-center {
            text-align: center;
        }

        .text-end {
            text-align: right !important;
        }

        .align-content-center {
            align-content: center;
        }

        .fw-bold {
            font-weight: bold;
        }
    </style>
    <title>Hóa đơn</title>
</head>

<body>
    <div class="invoice-box">
        <h1 class="text-end">{{ config('app.name') }}</h1>
        <h2>Đơn hàng #{{ $order->code }}</h2>
        <hr>
        <div>
            <p>Ngày đặt: {{ $order->created_at->format('d/m/Y') }}</p>
            <p>Người nhận: {{ $order->fullname }}</p>
            <p>Số điện thoại: {{ $order->phone_number }}</p>
            <p>Địa chỉ: {{ $order->address }}</p>
            <p>Ghi chú: {{ $order->note }}</p>
        </div>
        <hr>
        <table>
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá tiền</th>
                    <th>Tổng tiền</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total = 0;
                @endphp
                @foreach ($order->orderDetails as $item)
                    <tr>
                        <td>
                            {{ $item->product->name }}
                            <div>Size: {{ $item->size->name }}</div>
                            <div>Màu sắc: {{ $item->color->label }}</div>
                        </td>
                        <td class="text-center align-content-center">{{ $item->quantity }}</td>
                        <td class="text-center align-content-center">{{ formatMoney($item->price) }}</td>
                        <td class="text-center align-content-center">{{ formatMoney($item->quantity * $item->price) }}
                        </td>
                    </tr>
                    @php
                        $total += $item->quantity * $item->price;
                    @endphp
                @endforeach
                @if ($order->discount)
                    <tr>
                        <td class="text-end" colspan="4">
                            Tổng tiền: {{ formatMoney($total) }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-end" colspan="4">
                            Giảm giá: -{{ formatMoney($order->discount) }}
                        </td>
                    </tr>
                @endif
                <tr>
                    <td class="text-end fw-bold" colspan="4">
                        Thanh toán: {{ formatMoney($order->total) }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
