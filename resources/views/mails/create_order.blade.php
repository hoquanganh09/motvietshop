<!DOCTYPE html>
<html>

<head>
    <title>Đơn hàng đã được đặt</title>
</head>

<body>
    <p>Xin chào {{ $customerName }},</p>
    <p>Chúng tôi đã tiếp nhận đơn hàng của bạn (Mã đơn hàng: #{{ $orderCode }}), chúng tôi sẽ xử lý sớm nhất trong thời gian có thể.</p>
    <p>Cảm ơn bạn đã mua sắm tại {{ config('app.name') }}!</p>
    <br>
    <p>Trân trọng,</p>
    <p>Đội ngũ {{ config('app.name') }}</p>
</body>

</html>
