@extends('admin.main')
@section('content')
    <div class="row " style="margin-top: 20px;">
        <div class="col-lg-3 col-6 ">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3 style="font-size: 25px">{{ $countOd }}</h3>
                    <p>Đơn hàng mới</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="/admin/orderToDay" class="small-box-footer">Xem chi tiết<i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box" style="background-color: rgb(78, 218, 71)">
                <div class="inner">
                    <h3 style="font-size: 25px">{{ number_format($salesDay, 0, '.', ',') }}đ</h3>

                    <p>Hôm nay</p>
                </div>
                <div class="icon">
                    <i class="fa-solid fa-money-check-dollar"></i>
                </div>
                <a href="/admin/orderToDay" class="small-box-footer">Xem chi tiết<i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box" style="background-color: rgb(162, 88, 231)">
                <div class="inner">
                    <h3 style="font-size: 25px">{{ number_format($salesWeek, 0, '.', ',') }}đ</h3>

                    <p>Hôm qua</p>
                </div>
                <div class="icon">
                    <i class="fa-solid fa-money-check-dollar"></i>
                </div>
                <a href="/admin/orderYesterday" class="small-box-footer">Xem chi tiết <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box" style="background-color: rgb(240, 223, 36)">
                <div class="inner">
                    <h3 style="font-size: 25px">{{ number_format($salesMonth, 0, '.', ',') }}đ</h3>

                    <p>Tổng doanh thu</p>
                </div>
                <div class="icon">
                    <i class="fa-solid fa-money-check-dollar"></i>
                </div>
                <a href="/admin/order" class="small-box-footer">Xem chi tiết<i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fa-solid fa-certificate"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Đánh giá</span>
                    <span class="info-box-number">
                        {{ $countRv }}
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fa-solid fa-shirt"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Sản phẩm đã bán</span>
                    <span class="info-box-number">{{ $totalProduct }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix hidden-md-up"></div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Đơn hàng </span>
                    <span class="info-box-number">{{ $countTotal }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Khách hàng</span>
                    <span class="info-box-number">{{ $countCt }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>

    <div>
        <label for="select-month">Chọn tháng:</label>
        <select id="select-month">
            <option value="">--Tháng--</option>
            <option value="01">Tháng 1</option>
            <option value="02">Tháng 2</option>
            <option value="03">Tháng 3</option>
            <option value="04">Tháng 4</option>
            <option value="05">Tháng 5</option>
            <option value="06">Tháng 6</option>
            <option value="07">Tháng 7</option>
            <option value="08">Tháng 8</option>
            <option value="09">Tháng 9</option>
            <option value="10">Tháng 10</option>
            <option value="11">Tháng 11</option>
            <option value="12">Tháng 12</option>
        </select>
        <button id="view-month">Xem doanh thu</button>
        <div id="order-info" style="margin-left: 20px;"></div>
    </div>
    <div>
        <h3 style="color: rgb(228, 12, 12)">$<i><b> Doanh thu theo tuần</b></i></h3>
        <label for="start-date">Chọn ngày : </label>
        <input type="text" id="start-date" placeholder="YYYY-MM-DD" autocomplete="off">
        <button id="view-revenue">Xem doanh thu</button>
    </div>
    <div class="chart-container">
        <div class="bar-chart-container">
            <canvas id="barChart"></canvas>
        </div>
        <div class="pie-chart-container">
            <canvas id="pieChart"></canvas>
        </div>
    </div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const allMessages = @json($messages); // Lưu trữ tất cả tin nhắn vào biến JavaScript

        document.getElementById('seeAllMessages').addEventListener('click', function(event) {
            event.preventDefault(); // Ngăn chặn hành vi mặc định của link

            // Lấy dropdown menu
            const dropdown = document.getElementById('messageDropdown');
            dropdown.innerHTML = ''; // Xóa nội dung hiện tại

            // Thêm tất cả các tin nhắn vào dropdown
            allMessages.forEach(mes => {
                const messageItem = `
                <a href="#" class="dropdown-item">
                    <div class="media">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                ${mes.email}
                                <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">${mes.content}</p>
                        </div>
                    </div>
                </a>`;
                dropdown.innerHTML += messageItem; // Thêm tin nhắn vào dropdown
            });

            // Thêm lại nút "See All Messages" để không bị mất
            dropdown.innerHTML += '<div class="dropdown-divider"></div>';
            dropdown.innerHTML +=
                '<a href="#" class="dropdown-item dropdown-footer">See Less</a>'; // Có thể thêm tùy chọn để thu gọn lại nếu cần
        });
    });
</script>
