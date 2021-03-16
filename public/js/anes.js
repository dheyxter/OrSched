$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.btnUp').on('click', function() {
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Success!',
            text: 'Patient Schedule Updated Successfully',
            showConfirmButton: false,
            timer: 3000
        })
        location.reload();

    });

});