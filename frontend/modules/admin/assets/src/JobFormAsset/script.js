$(document).ready(function () {
    let pjax = $('#pjax-alert');
    let id = pjax.data('id');

    if (id) {
        createUrl('/admin/main/check', {id: id}, function (url) {
            $.post(url, function () {
                $.pjax.reload('#pjax-alert');
            });
        });
    }
});
