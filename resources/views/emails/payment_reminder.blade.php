<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Thanh toán Đơn Hàng Mốt Việt</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8f9fa; margin: 0; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
        <div style="text-align: center; margin-bottom: 30px;">
            <h1 style="color: #000; font-size: 24px;">Giỏ đồ của bạn đang chờ bạn!</h1>
        </div>
        
        <p>Chào bạn,</p>
        <p>Chúng tôi nhận thấy bạn vừa tạo đơn hàng mã <strong>#{{ $order->id }}</strong> tại Mốt Việt, tuy nhiên có vẻ như quá trình thanh toán đã bị gián đoạn.</p>
        <p>Để đảm bảo mua được món đồ yêu thích trước khi hết size, bạn vui lòng nhấn vào nút dưới đây để tiếp tục quá trình thanh toán qua Cổng PayOS (Chuyển khoản QR):</p>
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="https://qr.sepay.vn/img?bank=MBBank&acc=0987654321&template=compact&amount={{ $order->total }}&des=THANH TOAN DON {{ $order->id }}" style="background-color: #000; color: #fff; text-decoration: none; padding: 12px 24px; border-radius: 4px; font-weight: bold; display: inline-block;">Thanh toán ngay ({{ number_format($order->total) }} đ)</a>
        </div>
        
        <p>Trân trọng,<br>Đội ngũ Mốt Việt</p>
    </div>
</body>
</html>
