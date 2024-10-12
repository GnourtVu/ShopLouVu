$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
let loading = false; // Biến để theo dõi trạng thái tải
let endOfProducts = false; // Biến để theo dõi xem đã hết sản phẩm chưa

$(window).scroll(function () {
    // Kiểm tra nếu người dùng cuộn gần đến đáy trang
    if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
        if (!loading && !endOfProducts) { // Kiểm tra xem có đang tải không và đã hết sản phẩm chưa
            loading = true; // Đánh dấu rằng đang tải
            loadMore(); // Gọi hàm loadMore
        }
    }
});

function loadMore() {
    const page = $('#page').val(); // Lấy giá trị trang hiện tại
    $('#loadMoreSpinner').show(); // Hiện spinner

    $.ajax({
        type: 'POST',
        dataType: 'Json',
        data: { page },
        url: '/services/load-product',
        success: function (result) {
            $('#loadMoreSpinner').hide(); // Ẩn spinner
            loading = false; // Đánh dấu hoàn tất tải

            if (result.html != '') {
                $('#loadProduct').append(result.html); // Thêm sản phẩm vào danh sách
                $('#page').val(parseInt(page) + 1); // Tăng giá trị page
            } else {
                endOfProducts = true; // Đánh dấu đã hết sản phẩm
                $('#noMoreProducts').show(); // Hiện thông báo "Đã hết sản phẩm"
            }
        },
        error: function () {
            $('#loadMoreSpinner').hide(); // Ẩn spinner khi có lỗi
            loading = false; // Đánh dấu hoàn tất tải
            alert('Có lỗi xảy ra trong quá trình tải sản phẩm.');
        }
    });
}

function copyShippingCode(event) {
    // Lấy phần tử nút đã được nhấn
    const button = event.currentTarget;

    // Tìm phần tử cha và lấy mã giảm giá
    const shippingCode = button.previousElementSibling.querySelector('.shippingCode').textContent;

    // Tạo một textarea tạm thời để thực hiện sao chép
    const tempTextarea = document.createElement('textarea');
    tempTextarea.value = shippingCode;
    document.body.appendChild(tempTextarea);
    tempTextarea.select();
    document.execCommand('copy');
    document.body.removeChild(tempTextarea);

    // Cập nhật nội dung của nút
    button.textContent = '✔ Đã sao chép';

    // Tùy chọn: Đặt lại nội dung của nút sau một khoảng thời gian
    setTimeout(() => {
        button.textContent = 'Sao chép '; // Đặt lại nội dung về 'Sao chép mã' sau 2 giây
    }, 1000);
}
$(document).on('click', '.js-hide-modal1', function (e) {
    e.preventDefault(); // Ngăn chặn hành động mặc định
    $('.js-modal1').removeClass('show-modal1'); // Đóng modal
});
$(document).on('click', '.arrow-slick3', function (e) {
    e.stopPropagation(); // Ngăn chặn sự kiện lan truyền để tránh kích hoạt sự kiện khác
    e.preventDefault(); // Ngăn chặn hành động mặc định (nếu có) để tránh việc thêm vào giỏ hàng
});

// Đảm bảo rằng nút "next" ảnh và các nút khác không bị ảnh hưởng bởi sự kiện đóng modal
$(document).on('click', '.arrow-slick3, .btn-num-product-down, .btn-num-product-up', function (e) {
    e.stopPropagation(); // Ngăn chặn sự kiện lan truyền để tránh đóng modal hoặc kích hoạt các sự kiện không mong muốn
});
$('.your-slider').slick();
$(document).ready(function () {
    $('.your-slider').slick();
});

$(document).on('click', '.js-show-modal1', function (e) {
    e.preventDefault();
    var productId = $(this).data('id');

    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    $.ajax({
        url: '/product/' + productId + '/quickview',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            if (data.error) {
                alert(data.error);
            } else {
                // Cập nhật thông tin sản phẩm
                $('.js-name-detail').text(data.name);
                $('.js-modal1 .mtext-106').text(formatNumber(data.price) + 'đ');
                $('.js-modal1 p').text(data.description);
                $('.js-modal1 h5').text('Chỉ còn ' + formatNumber(data.qty_stock) + ' sản phẩm trong kho.');
                // Cập nhật ảnh trong dots và carousel chính
                let images = [data.thumb, data.image1, data.image2, data.image3];
                $('.slick3-dots li').each(function (index) {
                    $(this).find('img').attr('src', images[index]);
                });
                $('.item-slick3').each(function (index) {
                    $(this).find('.wrap-pic-w img').attr('src', images[index]);
                    $(this).find('.wrap-pic-w a').attr('href', images[index]);
                });

                // Điền thông tin sản phẩm vào input ẩn
                $('input[name="product_id"]').val(data.id);

                // Đặt giá trị mặc định cho số lượng sản phẩm
                $('input[name="num_product"]').val(1);

                // Mở modal
                $('.js-modal1').addClass('show-modal1');
            }
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});
// $(document).ready(function () {
//     $('#colorSelect, #sizeSelect').change(function () {
//         var sizeName = $('#sizeSelect').val();
//         var colorName = $('#colorSelect').val();
//         var productId = $('#productId').val(); // Lấy giá trị product_id từ input hidden

//         if (sizeName && colorName) {
//             $.ajax({
//                 url: '/get-product-quantity',
//                 type: 'GET',
//                 data: {
//                     size_name: sizeName,
//                     color_name: colorName,
//                     product_id: productId
//                 },
//                 success: function (response) {
//                     $('#productQuantity').text(response.qty);
//                 },
//                 error: function () {
//                     $('#productQuantity').text('0');
//                 }
//             });
//         }
//     });
// });


// Hàm xử lý thêm sản phẩm vào giỏ hàng
$(document).on('click', '.add-to-cart', function (e) {
    e.preventDefault();

    var productId = $('input[name="product_id"]').val();
    var size = $('select[name="size"]').val(); // Lấy giá trị kích thước
    var quantity = $('input[name="num_product"]').val(); // Lấy số lượng

    // Kiểm tra nếu không chọn size
    if (size === "") {
        alert('Vui lòng chọn kích thước!');
        return;
    }

    $.ajax({
        url: '/cart/add',
        type: 'POST',
        data: {
            product_id: productId,
            size: size, // Gửi tên kích thước
            quantity: quantity
        },
        success: function (response) {
            // Xử lý sau khi thêm sản phẩm thành công
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
});


$(document).ready(function () {
    // Kiểm tra URL hiện tại và áp dụng trạng thái "active"
    var currentPath = window.location.pathname;
    $('.main-menu li a').each(function () {
        var $this = $(this);
        // Kiểm tra nếu liên kết tương ứng với đường dẫn hiện tại
        if ($this.attr('href') === currentPath) {
            $this.parent().addClass('active-menu');
        } else {
            $this.parent().removeClass('active-menu');
        }
    });

    // Khi người dùng nhấp vào liên kết
    $('.main-menu li a').on('click', function (e) {
        e.preventDefault(); // Ngăn chặn hành động mặc định của liên kết
        $('.main-menu li').removeClass('active-menu');
        $(this).parent().addClass('active-menu');

        // Điều hướng đến liên kết được nhấp
        window.location.href = $(this).attr('href');
    });
});
$(document).ready(function () {
    // Lấy URL hiện tại
    var currentUrl = window.location.href;

    // Duyệt qua tất cả các liên kết
    $('.filter-tope-group a').each(function () {
        var linkUrl = $(this).attr('href');

        // Kiểm tra xem URL hiện tại có chứa URL của liên kết không
        if (currentUrl.indexOf(linkUrl) !== -1) {
            // Thêm lớp "active" vào liên kết hiện tại
            $(this).addClass('how-active1');
        } else {
            // Loại bỏ lớp "active" nếu không khớp
            $(this).removeClass('how-active1');
        }
    });
});
function togglePaymentInfo(selectedInfoId) {
    // Lấy tất cả các phần tử có class 'payment-info'
    const paymentInfoElements = document.querySelectorAll('.payment-info');

    // Ẩn tất cả các phần tử
    paymentInfoElements.forEach(element => {
        element.style.display = 'none';
    });

    // Hiện phần tử được chọn
    const selectedInfo = document.getElementById(selectedInfoId);
    if (selectedInfo) {
        selectedInfo.style.display = 'block';
    }
}

$(document).ready(function () {
    $('#showSizeChart').on('click', function (e) {
        e.preventDefault();

        // Gọi Ajax để lấy bảng kích thước
        $.ajax({
            url: '/size-chart',
            type: 'GET',
            success: function (response) {
                // Gán URL ảnh vào modal và hiển thị modal
                $('#sizeChartImage').attr('src', response.url);
                $('#sizeChartModal').css('display', 'flex');
            },
            error: function () {
                alert('Không thể tải bảng kích thước. Vui lòng thử lại sau.');
            }
        });
    });

    // Đóng modal khi nhấn vào nút close
    $('.close').on('click', function () {
        $('#sizeChartModal').css('display', 'none');
    });
    // Đóng modal khi nhấn ra ngoài modal
    $(window).on('click', function (event) {
        if ($(event.target).is('#sizeChartModal')) {
            $('#sizeChartModal').css('display', 'none');
        }
    });
});
//chart
// $(document).ready(function () {
//     // Dữ liệu giả định cho biểu đồ donut (tổng số đơn hàng)
//     const orderData = {
//         labels: ['Đã giao', 'Đang giao', 'Chờ xác nhận', 'Đã huỷ'],
//         datasets: [{
//             data: [300, 50, 100, 20], // Thêm giá trị cho 'Đã huỷ'
//             backgroundColor: ['#4caf50', '#2196F3', '#ffeb3b', '#f44336'],
//         }]
//     };
//     const orderChartContext = document.getElementById('order-chart').getContext('2d');
//     const orderChart = new Chart(orderChartContext, {
//         type: 'doughnut',
//         data: orderData,
//         options: {
//             responsive: true,
//             maintainAspectRatio: false,
//             plugins: {
//                 legend: {
//                     position: 'top',
//                 },
//                 tooltip: {
//                     callbacks: {
//                         label: function (tooltipItem) {
//                             return tooltipItem.label + ': ' + tooltipItem.raw;
//                         }
//                     }
//                 }
//             }
//         }
//     });
// });

$(document).ready(function () {
    $('#reviewForm').on('submit', function (e) {
        e.preventDefault(); // Ngăn chặn hành động mặc định của form

        $.ajax({
            url: reviewUrl, // Sử dụng biến reviewUrl từ Blade
            type: 'POST',
            data: $(this).serialize(), // Lấy toàn bộ dữ liệu của form
            success: function (response) {
                Swal.fire({
                    title: 'Thành công!',
                    text: response.success,
                    icon: 'success',
                    confirmButtonText: 'Đóng'
                });

                $('#content').val('');
                $('#name').val('');
                $('#email').val('');
                $('#phone').val('');
                $('input[name="rating"]').val('');
            },
            error: function (xhr) {
                var errorMessage = 'Đã có lỗi xảy ra. Vui lòng thử lại.';

                // Kiểm tra mã trạng thái và trả về thông báo tương ứng
                if (xhr.status === 400) {
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        errorMessage = xhr.responseJSON.error; // Lấy thông báo lỗi từ server
                    }
                } else if (xhr.status === 422) {
                    // Lỗi validation
                    // Lấy các thông báo lỗi từ response
                    errorMessage = 'Thông tin không hợp lệ:';
                    $.each(xhr.responseJSON.errors, function (key, value) {
                        errorMessage += '\n' + value[0]; // Thêm từng thông báo lỗi vào chuỗi
                    });
                }

                Swal.fire({
                    title: 'Lỗi!',
                    text: errorMessage,
                    icon: 'error',
                    confirmButtonText: 'Đóng'
                });
            }
        });
    });
});
document.addEventListener('DOMContentLoaded', function () {
    fetchProvinces();

    // Khi người dùng chọn tỉnh
    document.getElementById('province').addEventListener('change', function () {
        fetchDistricts();
        updateProvinceName();  // Cập nhật tên tỉnh
    });

    // Khi người dùng chọn quận/huyện
    document.getElementById('district').addEventListener('change', function () {
        fetchWards();
        updateDistrictName();  // Cập nhật tên quận/huyện
    });

    // Khi người dùng chọn phường/xã
    document.getElementById('ward').addEventListener('change', function () {
        updateWardName();  // Cập nhật tên phường/xã
    });
});

function fetchProvinces() {
    fetch('https://provinces.open-api.vn/api/p/')
        .then(response => response.json())
        .then(data => {
            const provinceSelect = document.getElementById('province');
            data.forEach(province => {
                let option = document.createElement('option');
                option.value = province.code;
                option.text = province.name;
                provinceSelect.add(option);
            });
        })
        .catch(error => console.error('Error fetching provinces:', error));
}

function fetchDistricts() {
    const provinceCode = document.getElementById('province').value;
    if (provinceCode) {
        fetch(`https://provinces.open-api.vn/api/p/${provinceCode}?depth=2`)
            .then(response => response.json())
            .then(data => {
                const districtSelect = document.getElementById('district');
                districtSelect.innerHTML = '<option value="">Chọn Quận/Huyện</option>'; // Reset options
                data.districts.forEach(district => {
                    let option = document.createElement('option');
                    option.value = district.code;
                    option.text = district.name;
                    districtSelect.add(option);
                });
            })
            .catch(error => console.error('Error fetching districts:', error));
    }
}

function fetchWards() {
    const districtCode = document.getElementById('district').value;
    if (districtCode) {
        fetch(`https://provinces.open-api.vn/api/d/${districtCode}?depth=2`)
            .then(response => response.json())
            .then(data => {
                const wardSelect = document.getElementById('ward');
                wardSelect.innerHTML = '<option value="">Chọn Phường/Xã</option>'; // Reset options
                data.wards.forEach(ward => {
                    let option = document.createElement('option');
                    option.value = ward.code;
                    option.text = ward.name;
                    wardSelect.add(option);
                });
            })
            .catch(error => console.error('Error fetching wards:', error));
    }
}

// Cập nhật tên tỉnh
function updateProvinceName() {
    const provinceSelect = document.getElementById('province');
    const selectedProvince = provinceSelect.options[provinceSelect.selectedIndex].text;
    document.getElementById('selected-province').value = selectedProvince;
}

// Cập nhật tên quận/huyện
function updateDistrictName() {
    const districtSelect = document.getElementById('district');
    const selectedDistrict = districtSelect.options[districtSelect.selectedIndex].text;
    document.getElementById('selected-district').value = selectedDistrict;
}

// Cập nhật tên phường/xã
function updateWardName() {
    const wardSelect = document.getElementById('ward');
    const selectedWard = wardSelect.options[wardSelect.selectedIndex].text;
    document.getElementById('selected-ward').value = selectedWard;
}
var modal = document.getElementById("logoutModal");
var logoutBtn = document.getElementById("logoutBtn");
var closeBtn = document.getElementsByClassName("close")[0];
var cancelBtn = document.getElementById("cancelBtn");

// Mở modal khi nhấn nút Đăng xuất
logoutBtn.onclick = function () {
    modal.style.display = "block";
}

// Đóng modal khi nhấn nút đóng (x)
closeBtn.onclick = function () {
    modal.style.display = "none";
}

// Đóng modal khi nhấn nút Hủy
cancelBtn.onclick = function () {
    modal.style.display = "none";
}

// Đóng modal khi nhấn bên ngoài modal
window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
