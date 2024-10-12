// Khởi tạo biểu đồ cột
// Đảm bảo rằng đoạn mã này chạy sau khi DOM đã được tải
document.getElementById('view-month').addEventListener('click', function () {
    var selectedMonth = document.getElementById('select-month').value;
    console.log('Tháng được chọn:', selectedMonth);  // Log để kiểm tra

    if (selectedMonth) {
        fetch(`/orders-revenue/${selectedMonth}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json(); // Đảm bảo rằng phản hồi được parse thành JSON
            })
            .then(data => {
                console.log('Dữ liệu trả về:', data);  // Kiểm tra dữ liệu trả về từ API
                var revenueInfo = '';

                if (data.totalRevenue > 0) {
                    // Sử dụng toLocaleString() để định dạng số tiền
                    var formattedRevenue = data.totalRevenue.toLocaleString('vi-VN');
                    revenueInfo = `<h3>Tổng doanh thu tháng ${selectedMonth}: ${formattedRevenue} VND</h3>`;
                } else {
                    revenueInfo = '<p>Không có doanh thu trong tháng này.</p>';
                }

                document.getElementById('order-info').innerHTML = revenueInfo;
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                document.getElementById('order-info').innerHTML = '<p>Đã xảy ra lỗi khi tải dữ liệu. Vui lòng thử lại.</p>';
            });
    } else {
        document.getElementById('order-info').innerText = 'Vui lòng chọn tháng.';
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const ctxBar = document.getElementById('barChart').getContext('2d');

    const barChart = new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: [], // Sẽ được cập nhật từ API
            datasets: [{
                label: 'Doanh thu',
                data: [], // Sẽ được cập nhật từ API
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Xử lý sự kiện khi nhấn nút "Xem doanh thu"
    document.getElementById('view-revenue').addEventListener('click', function () {
        const startDate = document.getElementById('start-date').value; // Lấy ngày từ input

        // Gọi API để cập nhật dữ liệu cho biểu đồ cột
        fetch(`/admin/getChartCol?start_date=${startDate}`) // Gửi ngày bắt đầu tới API
            .then(response => response.json())
            .then(data => {
                // Cập nhật nhãn và dữ liệu cho biểu đồ
                barChart.data.labels = data.labels; // Cập nhật nhãn từ API
                barChart.data.datasets[0].data = data.sales; // Cập nhật dữ liệu doanh số từ API
                barChart.update(); // Cập nhật lại biểu đồ
            })
            .catch(error => console.error('Lỗi khi tải dữ liệu doanh số:', error));
    });
});


// Biểu đồ tròn (nếu cần thiết)
fetch('/admin/getChartRod') // Thay đổi đường dẫn nếu cần
    .then(response => response.json())
    .then(data => {
        const ctxPie = document.getElementById('pieChart').getContext('2d');
        const pieChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: data.labels, // Nhãn từ API
                datasets: [{
                    label: 'Tổng đơn hàng',
                    data: data.data, // Dữ liệu từ API
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(255, 99, 132, 0.6)',
                        // Thêm màu thứ tư nếu 
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(255, 99, 132, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });
    })
    .catch(error => console.error('Lỗi khi tải dữ liệu đơn hàng:', error));

