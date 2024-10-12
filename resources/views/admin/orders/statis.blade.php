@extends('admin.main')
@section('content')
    <div class="dashboard-container">
        <h1 class="dashboard-title">Thống Kê Tổng Quan</h1>

        <div class="stats-container">
            <div class="stat-box">
                <h3>Sản phẩm đã bán</h3>
                <p>{{ $totalSoldProducts }}</p>
            </div>
            <div class="stat-box">
                <h3>Sản phẩm tồn kho</h3>
                <p>{{ $remainingProducts }}</p>
            </div>
            <div class="stat-box">
                <h3>Số khách mua hàng</h3>
                <p>{{ $totalCustomers }}</p>
            </div>
            <div class="stat-box">
                <h3>Tổng doanh thu</h3>
                <p>{{ number_format($totalRevenue, 0, ',', '.') }} VND</p>
            </div>
        </div>
        <div class="table-container">
            <h2><i>Top 5 sản phẩm bán chạy </i><i class="fa-solid fa-fire" style="color: red"></i></h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên sản phẩm</th>
                        <th>Hình ảnh</th>
                        <th>Số lượng bán</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($leastSellingProducts as $index => $product)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $product->name }}</td>
                            <td><img src="{{ $product->thumb }}" alt="iamge" width="50px"></td>
                            <td>{{ $product->sold_qty }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="table-container">
            <h2><i>Top 5 sản phẩm bán chậm</i></h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên sản phẩm</th>
                        <th>Hình ảnh</th>
                        <th>Số lượng bán </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($topSellingProducts as $index => $product)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $product->name }}</td>
                            <td><img src="{{ $product->thumb }}" alt="iamge" width="50px"></td>
                            <td>{{ $product->total_qty }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
