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