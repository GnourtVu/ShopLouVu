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
                $('#page').val(page + 1);
            } else {
                alert('Load product successful');
                $('#button-loadMore').css('display', 'none');
            }
        }
    })
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

// Sự kiện mở modal và tải dữ liệu sản phẩm khi bấm vào nút "Quick View"
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

                // Cập nhật ảnh trong dots và carousel chính
                $('.js-modal1 .slick3-dots li img').attr('src', data.thumb);
                $('.js-modal1 .slick3 .item-slick3 .wrap-pic-w img').attr('src', data.thumb);
                $('.js-modal1 .slick3 .item-slick3 .wrap-pic-w a').attr('href', data.thumb);

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


