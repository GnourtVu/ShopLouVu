 <style>
     body {
         font-family: 'DejaVu Sans', sans-serif;
         /* Sử dụng font hỗ trợ tiếng Việt */
     }
 </style>

 <div style="flex: 1; padding: 20px; border: 1px solid #eee; border-radius: 8px;">
     <h2>Hóa đơn bán hàng</h2>
     <p><strong>Mã đơn hàng:</strong> {{ $order->id }}</p>
     <p><strong>Khách hàng:</strong> {{ $customer->name }}</p>
     <p><strong>SDT:</strong> {{ $customer->phone }}</p>
     <p><strong>Ngày đặt hàng:</strong> {{ $order->created_at->format('d-m-Y') }}</p>

     <!-- Product Table -->
     <table class="table"
         style="width: 100%; line-height: inherit; text-align: left; margin-top: 20px; border-collapse: collapse;">
         <thead>
             <tr style="background: #eee; border-bottom: 1px solid #ddd;">
                 <th style="padding: 8px;">Tên sản phẩm</th>
                 <th style="padding: 8px; text-align: right;">Giá</th>
                 <th style="padding: 8px; text-align: center;">Số lượng</th>
                 <th style="padding: 8px; text-align: right;">Tổng</th>
             </tr>
         </thead>
         <tbody>
             @foreach ($orderDetail as $key => $orderdt)
                 @php
                     $price = $orderdt->product->price;
                     $priceEnd = $price * $orderdt->qty;
                 @endphp
                 <tr style="border-bottom: 1px solid #ddd;">
                     <td style="padding: 8px;">{{ $orderdt->product->name }}</td>
                     <td style="padding: 8px; text-align: right;">{{ number_format($price, 0, '', ',') }} đ</td>
                     <td style="padding: 8px; text-align: center;">x{{ $orderdt->qty }}</td>
                     <td style="padding: 8px; text-align: right;">{{ number_format($priceEnd, 0, '.', ',') }} đ
                     </td>
                 </tr>
             @endforeach
             <tr>
                 <td colspan="3" style="text-align: right; padding: 8px;"><strong>Giảm giá:</strong></td>
                 <td style="padding: 8px; text-align: right; color: red;">
                     -{{ number_format($order->discount, 0, '.', ',') }} đ</td>
             </tr>
             <tr>
                 <td colspan="3" style="text-align: right; padding: 8px;"><strong>Tổng cộng:</strong></td>
                 <td style="padding: 8px; text-align: right;">{{ number_format($order->total, 0, '.', ',') }} đ
                 </td>
             </tr>
         </tbody>
     </table>
 </div>
