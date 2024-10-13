<!DOCTYPE html>
<html>

<head>
    <title>Đơn hàng đang được vận chuyển</title>
</head>

<body>
    <p>Xin chào {{ $customerName }},</p>
    <p>Đơn hàng của bạn (Mã đơn hàng: #{{ $orderCode }}) đang trong quá trình vận chuyển.</p>
    <p>Vui lòng hãy để ý điện thoại để có thể tiếp nhận đơn hàng một cách nhanh chóng nhất.</p>
    <p>Cảm ơn bạn đã mua sắm tại {{ config('app.name') }}!</p>
    <br>
    <p>Trân trọng,</p>
    <p>Đội ngũ {{ config('app.name') }}</p>
</body>

</html>
