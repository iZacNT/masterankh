$(document).ready(function () {
    let pjax = $('#pjax-table');
    let id = pjax.data('id');

    if (id) {
        createUrl('/admin/main/check', {id: id}, function (url) {
            $.post(url, function () {
                $.pjax.reload('#pjax-table');
            });
        });
    }
});
