$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
function loadMore() {
    const page = $('#page').val();
    $.ajax({
        type: 'POST',
        dataType: 'Json',
        data: { page },
        url: '/services/load-product',
        success: function (result) {
            if (result.html != '') {
                $('#loadProduct').append(result.html);
                $('#page').val(parseInt(page) + 1); // Tăng giá trị page
            } else {
                // Hiện thông báo và ẩn nút Load More
                alert('Đã hiện hết sản phẩm.');
                $('#button-loadMore').css('display', 'none'); // Ẩn nút Load More
            }
        },
        error: function () {
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


