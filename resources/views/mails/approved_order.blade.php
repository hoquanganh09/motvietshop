<!DOCTYPE html>
<html>

<head>
    <title>Đơn hàng đã được xác nhận</title>
</head>

<body>
    <p>Xin chào {{ $customerName }},</p>
    <p>Đơn hàng của bạn (Mã đơn hàng: #{{ $orderCode }}) đã được xác nhận thành công.</p>
    <p>Cảm ơn bạn đã mua sắm tại {{ config('app.name') }}!</p>
    <p>Chúng tôi sẽ sớm giao hàng cho bạn.</p>
    <br>
    <p>Trân trọng,</p>
    <p>Đội ngũ {{ config('app.name') }}</p>
</body>

</html>
