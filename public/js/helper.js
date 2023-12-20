$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

function SuccessAlert(title, msg) {
    return Swal.fire(title, msg, 'success');
}

function ErrorAlert(title, msg) {
    Swal.fire(title, msg, 'error');
}

async function AjaxPost(url, param = {}, onSuccess = function () {
}, onAccepted = function () {

}) {
    try {
        let response = await $.post(url, param);
        if (response['status'] === 200) {
            onSuccess();
        } else {
            onAccepted();
        }
    } catch (e) {
        let error_message = JSON.parse(e.responseText);
        console.log(error_message);
        ErrorAlert('Error', error_message.message);
    }
}

function blockLoading(state) {
    if (state) {
        $('#overlay-loading').css('display', 'flex')
    } else {
        $('#overlay-loading').css('display', 'none')
    }
}
// var myToastEl = document.getElementById('liveToast');
// var myToast = new bootstrap.Toast(myToastEl, {
//     autohide: true,
//     animation: true,
//     delay: 1000
// });
// myToast.show();
