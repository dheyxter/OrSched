// const { default: Swal } = require("sweetalert2");

$(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /////////////////////////////////////////////////////////////////////////////////
    //THIS PORTION IS FOR TESTING-SCRIPTS-BEFORE-IMPLEMENTING, FOR ALL PAGES
    //


    ////////////////////////////////////////////////////////////////////////////////////////////
    //THIS PORTION IS FOR ADDING-PATIENT PAGE ONLY





    ///////////////////////////////////////////////////////////////////////////////////////////
    //THIS PORTION IS FOR SCHEDULING PAGE ONLY

    //CHANGE TIME
    $('.btnChangeTimeModal').on('click', function () {
        $pat_id = $(this).siblings().val();
        $oldsched = $(this).parent().siblings('.scheduleDisplay').text();
        $('.oldTimeHere').text($oldsched);
        $('#changeTimeModal' + $pat_id).modal('show');
    });

    // EMPLOYEE MODAL
    $('.employeeDetails').on('click', function () {
        $empID = $(this).siblings().val();
        // $oldsched = $(this).parent().siblings('.scheduleDisplay').text();
        // $('.oldTimeHere').text($oldsched);
        console.log($empID);

        $('#employeeDetails' + $empID).modal('show');

    });

    $('.btnConfirmChangeTime').on('click', function () {
        let id = $(this).siblings('input').val()
        console.log($(this).siblings('input').val());
        if ($('#newIn' + $pat_id).val() == '' || $('#newOut' + $pat_id).val() == '') {
            Swal.fire({
                title: 'Invalid entry',
                icon: 'warning',
                showConfirmButton: false,
                timer: 500
            });
        } else if ($('#newIn' + $pat_id).val() < '08:00' || $('#newIn' + $pat_id).val() > '17:00') {
            Swal.fire({
                title: 'Invalid Time-IN',
                icon: 'warning',
                showConfirmButton: false,
                timer: 500
            });
        } else if ($('#newOut' + $pat_id).val() > '17:00' || $('#newOut' + $pat_id).val() < '08:00') {
            Swal.fire({
                title: 'Invalid Time-Out',
                icon: 'warning',
                showConfirmButton: false,
                timer: 500
            });
        } else {
            Swal.fire({
                title: 'Confirmation: ' + $('#newIn' + $pat_id).val() + ' to ' + $('#newOut' + $pat_id).val(),
                text: "Do you want to change this schedule?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Back'
            }).then((result) => {
                if (result.value) {
                    // IF CONFIRMED DO SOMETHING
                    $('.changetimeForm' + id).submit();
                };
            });
        }
    });
    //LOCKING THE DATE FOR THE ADDSCHEDULE FORM/MODAL
    $('#date').val($('#selectdate').val());
    $('#date_emer').val($('#selectdate1').val());

    $('.btnCancel').on('click', function () {
        $pat_id = $(this).siblings('.patId').val();
        $hpercode = $(this).siblings('.hpercode').val();
        console.log($hpercode, $pat_id);
        Swal.fire({
            title: 'Confirm cancellation',
            text: "Do you want to cancel this schedule?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Yes',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Back'
        }).then((result) => {
            if (result.value) {
                // IF CONFIRMED DO SOMETHING
                $.ajax({
                    type: 'get',
                    url: '/cancel_schedule',
                    data: {
                        'id': $pat_id,
                        'patient_id': $hpercode,
                    },
                    // beforeSend: function () {
                    //     Swal.fire({
                    //         title: '<div style="width: 7rem; height: 7rem;" class="spinner-border text-info" role="status"><span class="sr-only">Loading...</span></div>',
                    //         showConfirmButton: false,
                    //     });
                    // },
                    success: function (data) {

                        location.reload();
                        Swal.fire(
                            'Canceled',
                            'success'
                        );
                    }
                });


            }
        });
    });

    $('.btnDefer').on('click', function () {
        $pat_id = $(this).siblings('.patId').val();
        $hpercode = $(this).siblings('.hpercode').val();
        console.log($hpercode);
        
        Swal.fire({
            title: 'Confirm Action',
            text: "Do you want to defer this schedule?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Yes',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Back'
        }).then((result) => {
            if (result.value) {
                // IF CONFIRMED DO SOMETHING
                $.ajax({
                    type: 'get',
                    url: '/defer_schedule',
                    data: {
                        'id': $pat_id,
                        'patient_id': $hpercode,
                    },
                    beforeSend: function () {
                        Swal.fire({
                            title: '<div style="width: 7rem; height: 7rem;" class="spinner-border text-info" role="status"><span class="sr-only">Loading...</span></div>',
                            showConfirmButton: false,
                        });
                    },
                    success: function (data) {

                        location.reload();
                        Swal.fire(
                            'Deferred',
                            'success'
                        );
                    }
                });


            }
        });
    });

    $('.btnDefer1').on('click', function () {
        $pat_id = $(this).siblings('.patId').val();
        $hpercode = $(this).siblings('.hpercode').val();
        console.log($hpercode, $pat_id);
        Swal.fire({
            title: 'Confirm Action',
            text: "Do you want to defer this schedule?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Yes',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Back'
        }).then((result) => {
            if (result.value) {
                // IF CONFIRMED DO SOMETHING
                $.ajax({
                    type: 'get',
                    url: '/defer_schedule',
                    data: {
                        'id': $pat_id,
                        'patient_id': $hpercode,
                    },
                    beforeSend: function () {
                        Swal.fire({
                            title: '<div style="width: 7rem; height: 7rem;" class="spinner-border text-info" role="status"><span class="sr-only">Loading...</span></div>',
                            showConfirmButton: false,
                        });
                    },
                    success: function (data) {

                        location.reload();
                        Swal.fire(
                            'Deferred',
                            'success'
                        );
                    }
                });


            }
        });
    })

    $('.btnUndoDefer').on('click', function () {
        $pat_id = $(this).siblings('.patId').val();
        $hpercode = $(this).siblings('.hpercode').val();
        // console.log($hpercode);
        Swal.fire({
            title: 'Confirm Action',
            text: "Undo defer for this schedule?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Yes',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Back'
        }).then((result) => {
            if (result.value) {
                // IF CONFIRMED DO SOMETHING
                $.ajax({
                    type: 'get',
                    url: '/undo_defer',
                    data: {
                        'id': $pat_id,
                        'patient_id': $hpercode,
                    },
                    beforeSend: function () {
                        Swal.fire({
                            title: '<div style="width: 7rem; height: 7rem;" class="spinner-border text-info" role="status"><span class="sr-only">Loading...</span></div>',
                            showConfirmButton: false,
                        });
                    },
                    success: function (data) {

                        location.reload();
                        Swal.fire(
                            'Undo Defer',
                            'success'
                        );
                    }
                });


            }
        });
    });

    //BUTTON UPDATE FOR REMARKS IS CLICKED
    $('.btnRemarks').on('click', function () {
        // console.log('ID: '+$(this).siblings('.idRemarks').val()+' Remarks: '+$(this).siblings('.textRemarks').val());
        $patient_id = $(this).siblings('.idRemarks').val();
        $patient_name = $(this).siblings('.nameRemarks').val();
        $remarks = $(this).siblings('.textRemarks').val();
        $hpercode = $(this).siblings('.hpercode').val();
        // console.log($hpercode);
        $.ajax({
            type: 'get',
            url: '/remarks',
            data: {
                'patient_id': $patient_id,
                'patient_name': $patient_name,
                'remarks': $remarks,
                'hpercode': $hpercode,
            },
            beforeSend: function () {
                Swal.fire({
                    title: '<div style="width: 7rem; height: 7rem;"  class="spinner-border text-info" role="status"><span class="sr-only">Loading...</span></div>',
                    showConfirmButton: false
                });
            },
            success: function (d) {
                // console.log(d);
                if (d == 'success') {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Remarks Saved!',
                        showConfirmButton: false,
                        timer: 1000
                    });
                } else {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Remarks not saved',
                        showConfirmButton: false,
                        timer: 1000
                    });
                }
            }
        });
    });

    // BUTTON UPDATE FOR ANES
    $('.btnAnes').on('click', function () {
        $patid = $(this).siblings('.idAnes').val();
        $patient_name = $(this).siblings('.patInfo').val();
        $hpercode = $(this).siblings('.hpercode').val();    
        $anes = document.getElementById("anesInput").innerHTML;
        // console.log($anes);
        $.ajax({
            type: 'post',
            url: '/anes',
            data: {
                'patient_id': $patid,
                'patient_name': $patient_name,
                'anes': $anes,
                'hpercode': $hpercode,
            },
            beforeSend: function () {
                Swal.fire({
                    title: '<div style="width: 7rem; height: 7rem;"  class="spinner-border text-info" role="status"><span class="sr-only">Loading...</span></div>',
                    showConfirmButton: false
                });
            },
            success: function (d) {
                if (d == 'success') {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Anesthesiologist Saved!',
                        showConfirmButton: false,
                        timer: 1000
                    });
                } else {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Anesthesiologist not saved',
                        showConfirmButton: false,
                        timer: 1000
                    });
                }
                location.reload();
            }
        });
    });

    $('.btnAnes1').on('click', function () {
        $patid = $(this).siblings('.idAnes').val();
        $patient_name = $(this).siblings('.patInfo').val();
        $hpercode = $(this).siblings('.hpercode').val();    
        // $anes = document.getElementById("anesInput").innerHTML;
        $anes = $("#anes").val();
        console.log($anes);
        $.ajax({
            type: 'post',
            url: '/anesHome',
            data: {
                'patient_id': $patid,
                'patient_name': $patient_name,
                'anes': $anes,
                'hpercode': $hpercode,
            },
            beforeSend: function () {
                Swal.fire({
                    title: '<div style="width: 7rem; height: 7rem;"  class="spinner-border text-info" role="status"><span class="sr-only">Loading...</span></div>',
                    showConfirmButton: false
                });
            },
            success: function (d) {
                if (d == 'success') {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Anesthesiologist Saved!',
                        showConfirmButton: false,
                        timer: 1000
                    });
                } else {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Anesthesiologist not saved',
                        showConfirmButton: false,
                        timer: 1000
                    });
                }
                // location.reload();
            }
        });
    });


    // CHANGE ON ANES
    $('#anes').on('change', function() {
        $anes = $('#anesInput').text($(this).val());
        // console.log($anes);
    });

    // $('#radtype').on('click', function() {
    //    $rad = $('#radtype').val();
    // })

    //WHEN BUTTON ADD IS CLICKED, IT WILL CHECK FOR VALIDATIONS
    function validateForm() {
        var isValid = true;
        
        // Check if all input fields and selects have values
        $('#addscheduleform input, #addscheduleform select, #addscheduleform textarea').each(function() {
            if ($(this).prop('required') && $.trim($(this).val()) === '') {
                isValid = false;
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        // Check if at least one surgeon is selected
        var selectedSurgeons = $('select[name="surgeon[]"]').val();
        if (!selectedSurgeons || selectedSurgeons.length === 0) {
            isValid = false;
            Swal.fire({
                position: 'center',
                icon: 'warning',
                title: 'Please select at least one surgeon',
                showConfirmButton: false,
                timer: 2000
            });
        }

        // Return the result of validation
        return isValid;
    }

    $('.btnAddSchedule').on('click', function (e) {
        e.preventDefault(); // Prevent default form submission

        if (validateForm()) {
            Swal.fire({
                title: 'Confirmation',
                text: "Are you sure about the details on scheduling?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Back'
            }).then((result) => {
                if (result.value) {
                    $('#addscheduleform').submit();
                    Swal.fire(
                        'Confirmed',
                        'Successfully scheduled',
                        'success'
                    );
                }
            });
        } else {
            Swal.fire({
                position: 'center',
                icon: 'warning',
                title: 'Please fill out all required fields',
                showConfirmButton: false,
                timer: 2000
            });
        }
    });


    //WHEN BUTTON ADD IS CLICKED, IT WILL CHECK FOR VALIDATIONS
    function emervalidate() {
        var isValid = true;
    
        // Check if all input fields, selects, and textareas have values
        $('#addscheduleform1 input, #addscheduleform1 select, #addscheduleform1 textarea').each(function() {
            if ($(this).prop('required') && $.trim($(this).val()) === '') {
                isValid = false;
                console.log("Invalid field: ", $(this).attr('name'));
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });
    
        // Check if at least one surgeon is selected
        var selectedSurgeons = $('#surgeon_emer').val();
        if (!selectedSurgeons || selectedSurgeons.length === 0) {
            isValid = false;
            // console.log("No surgeon selected");
            Swal.fire({
                position: 'center',
                icon: 'warning',
                title: 'Please select at least one surgeon',
                showConfirmButton: false,
                timer: 2000
            });
        }
    
        // Return the result of validation
        return isValid;
    }
    
    $('.btnAddSchedule1').on('click', function (e) {
        e.preventDefault(); // Prevent default form submission
    
        if (emervalidate()) {
            Swal.fire({
                title: 'Confirmation',
                text: "Are you sure about the details on scheduling?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Yes',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Back'
            }).then((result) => {
                if (result.value) {
                    $('#addscheduleform1').submit(); // Correct form id
                    Swal.fire(
                        'Confirmed',
                        'Successfully scheduled',
                        'success'
                    );
                }
            });
        } else {
            Swal.fire({
                position: 'center',
                icon: 'warning',
                title: 'Please fill out all required fields',
                showConfirmButton: false,
                timer: 2000
            });
        }
    });
    

    // $('.btnAddSchedule1').on('click', function () {
    //     $show_time = $('#show_time').val();
    //     $show_date = $('#date').val();
    //     console.log($show_date);
    //     if ($show_time >= 0) {

    //         Swal.fire({
    //             title: 'Confirmation',
    //             text: "Are you sure about the details on scheduling?",
    //             icon: 'warning',
    //             showCancelButton: true,
    //             confirmButtonColor: '#3085d6',
    //             confirmButtonText: 'Yes',
    //             cancelButtonColor: '#d33',
    //             cancelButtonText: 'Back'
    //         }).then((result) => {
    //             if (result.value) {
    //                 // IF CONFIRMED
    //                 // CALL THE ADD SCHEDULE FORM TO BE SUBMITTED
    //                 $('#addscheduleform1').submit();
    //                 Swal.fire(
    //                     'Confirmed',
    //                     'Successfully scheduled',
    //                     'success'
    //                 )
    //             }
    //         });
    //     } else {
    //         Swal.fire({
    //             icon: 'error',
    //             title: 'Oops...',
    //             text: 'Something went wrong!',
    //             showConfirmButton: false,
    //             timer: 2000
    //         })
    //     }
    // });


    // BUTTON FOR CHANGE USER ROLE
    // $('.btnChangePriv').on('click', function () {
    //     $role = $('#role').val();
    //     console.log($role);
    //     Swal.fire({
    //         title: 'Confirmation',
    //         text: "Are you sure on changing role of this user?",
    //         icon: 'warning',
    //         showCancelButton: true,
    //         confirmButtonColor: '#3085d6',
    //         confirmButtonText: 'Yes',
    //         cancelButtonColor: '#d33',
    //         cancelButtonText: 'Back'
    //     }).then((result) => {
    //         if (result.value) {
    //             // IF CONFIRMED
    //             // CALL THE ADD SCHEDULE FORM TO BE SUBMITTED
    //             $('#changeprivform').submit();
    //             Swal.fire(
    //                 'Confirmed',
    //                 'Successfully Changed User Role',
    //                 'success'
    //             )
    //         }
    //     });
    // });

    //CHANGE ANNEX BUTTON
    //IT WILL FETCH THE LAST SCHEDULED TIME ACCORDING TO THE ANNEX SELECTED
    $('#room').on('change', function () {
        // console.log($('#room').val());
        // console.log($('#date').val());
        $.ajax({
            type: 'get',
            url: '/change_annex',
            data: {
                'annex': $('#room').val(),
                'date': $('#date').val()
            },
            success: function (data) {
                // console.log(data)
                if (data > '20') {
                    $('#full_time').html('FULL');
                    $('#full_time2').html('');
                    $('#time').prop('disabled', true);
                    $('#btnAddSchedule').prop('disabled', false);
                    $('#time').val('');
                    $('#time_in').val(data);

                } else {
                    $('#time').prop('disabled', false);
                    $('#btnAddSchedule').prop('disabled', false);
                    $('#full_time').html(data + ' Scheduled');
                    $('#show_time').html(data);
                    $('#show_time').val(data);
                    $('#time_in').val(data);
                    $('#time').val(data);
                    $('#full_time2').html('5pm');
                }


            }
        });
    });

    $('#room').trigger('change');





    // CHANGE ROLE
    // FETCH ALL
    $('.btnEditUser').on('click', function() {
        let empid = $(this).siblings('input.empID').val();
        console.log(empid);
    });

    $('#role').on('change', function () {
        console.log($('#role').val());

        $.ajax({
            type: 'get',
            url: '/change',
            data: {
                'role': $('#role').val(),
            },
            success: function (data) {
             Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Success!',
                    text: 'User Role Successfully',
                    showConfirmButton: false,
                    timer: 2000
                })
            }
        });
    });

    $('#role').trigger('change');


    $('.btnAccept').on('click', function () {
        let id = $(this).siblings('input.id').val();
        let name = $(this).siblings('input.name').val();
        let namePat = $(this).siblings('input.namePat').val();
        let nameEmp = $(this).siblings('input.nameEmp').val();
        let patient_id = $(this).siblings('input.patID').val();
        $.ajax({
            type: 'get',
            url: '/accept',
            data: {
                'id': id,
                'name': name,
                'namePat': namePat,
                'nameEmp': nameEmp,
                'patient_id': patient_id,
            },
            beforeSend: function () {
                Swal.fire({
                    position: 'top-end',
                    title: '<div style="width: 7rem; height: 7rem;" class="spinner-border text-info" role="status"><span class="sr-only">Loading...</span></div>',
                    showConfirmButton: false,
                });
            },
            success: function (data) {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Success!',
                    text: 'Patient Accepted Successfully',
                    showConfirmButton: false,
                    timer: 3000
                })
                location.reload();
            }

        })

    });

    $('.btnCancel').on('click', function() {
        console.log("test");
        let id = $(this).siblings('input.id').val();
        let name = $(this).siblings('input.name').val();
        let namePat = $(this).siblings('input.namePat').val();
        let nameEmp = $(this).siblings('input.nameEmp').val();
        let patient_id = $(this).siblings('input.patID').val();
        Swal.fire({
            title: 'Confirmation',
            text: "Are you sure to cancel this schedule?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Yes',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: 'get',
                    url: '/cancel',
                    data: {
                        'id': id,
                        'name': name,
                        'namePat': namePat,
                        'nameEmp': nameEmp,
                        'patient_id': patient_id,
                    },
                    beforeSend: function () {
                        Swal.fire({
                            position: 'top-end',
                            title: '<div style="width: 7rem; height: 7rem;" class="spinner-border text-info" role="status"><span class="sr-only">Loading...</span></div>',
                            showConfirmButton: false,
                        });
                    },
                    success: function (data) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Success!',
                            text: 'Schedule Deleted Successfully',
                            showConfirmButton: false,
                            timer: 3000
                        })
                        // location.reload();
                    }
        
                })
            }
        });
    });

    $('.btnViewLogs').on('click', function () {
        let hpercode = $(this).siblings('input.hpercode').val();
        console.log(hpercode);
        $.ajax({
            type: 'get',
            url: '/histoPat',
            data: {
                'patient_id': hpercode,
            }
        });
    });

    $('.btnSelect').on('click', function () {
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Success!',
            text: 'Patient Accepted Successfully',
            showConfirmButton: false,
            timer: 3000
        })
        location.reload();
    });


    // REPORTS PRINTING FUNCTIONS

    $('.printMe').on('click', function () {
        let dateFrom = $('#dateFrom').val();
        let dateTo = $('#dateTo').val();
        let dept = $('#tscode').val();
        $.ajax({
            type: 'get',
            url: '/print/all',
            data: {
                'dateFrom': dateFrom,
                'dateTo': dateTo,
                'tscode': dept
            },
            success: function (data) {
                let w = 1250;
                let h = 635;
                let left = (screen.width / 2) - (w / 2);
                let top = (screen.height / 2) - (h / 2) - 50;
                // console.log(dateFrom, dateTo);
                if(!data.tscode) {
                    childWin = window.open("/print/all?dateFrom=" + dateFrom + "&dateTo=" + dateTo , "", "height=" + h + ", width=" + w +
                    ", status=no, toolbar=no, menubar=no, location=no, addressbar=no, directories=no, top=" + top + ", left=" +
                    left);
                }
                else {
                    childWin = window.open("/print/all?dateFrom=" + dateFrom + "&dateTo=" + dateTo + "&tscode=" + dept, "", "height=" + h + ", width=" + w +
                    ", status=no, toolbar=no, menubar=no, location=no, addressbar=no, directories=no, top=" + top + ", left=" +
                    left);
                }

            }
        });
    });

    $('.printMe1').on('click', function () {
        let dateFrom = $('#dateFrom').val();
        let dateTo = $('#dateTo').val();
        let dept = $('#tscode').val();
        // console.log(dateFrom, dateTo, dept);
        $.ajax({
            type: 'get',
            url: '/print/r1',
            data: {
                'dateFrom': dateFrom,
                'dateTo': dateTo,
                'tscode': dept
            },
            success: function (data) {
                let w = 1250;
                let h = 635;
                let left = (screen.width / 2) - (w / 2);
                let top = (screen.height / 2) - (h / 2) - 50;

                if(!data.tscode) {
                    childWin = window.open("/print/r1?dateFrom=" + dateFrom + "&dateTo=" + dateTo , "", "height=" + h + ", width=" + w +
                    ", status=no, toolbar=no, menubar=no, location=no, addressbar=no, directories=no, top=" + top + ", left=" +
                    left);
                }
                else {
                    childWin = window.open("/print/r1?dateFrom=" + dateFrom + "&dateTo=" + dateTo + "&tscode=" + dept, "", "height=" + h + ", width=" + w +
                    ", status=no, toolbar=no, menubar=no, location=no, addressbar=no, directories=no, top=" + top + ", left=" +
                    left);
                }
            }
        });
    });

    $('.printMe3').on('click', function () {
        let dateFrom = $('#dateFrom').val();
        let dateTo = $('#dateTo').val();
        let dept = $('#tscode').val();
        $.ajax({
            type: 'get',
            url: '/print/r2',
            data: {
                'dateFrom': dateFrom,
                'dateTo': dateTo,
                'tscode': dept
            },
            success: function (data) {
                let w = 1250;
                let h = 635;
                let left = (screen.width / 2) - (w / 2);
                let top = (screen.height / 2) - (h / 2) - 50;


               if(!data.tscode) {
                    childWin = window.open("/print/r2?dateFrom=" + dateFrom + "&dateTo=" + dateTo , "", "height=" + h + ", width=" + w +
                    ", status=no, toolbar=no, menubar=no, location=no, addressbar=no, directories=no, top=" + top + ", left=" +
                    left);
                }
                else {
                    childWin = window.open("/print/r2?dateFrom=" + dateFrom + "&dateTo=" + dateTo + "&tscode=" + dept, "", "height=" + h + ", width=" + w +
                    ", status=no, toolbar=no, menubar=no, location=no, addressbar=no, directories=no, top=" + top + ", left=" +
                    left);
                }
            }
        });
    });

    $('.printMe4').on('click', function () {
        let dateFrom = $('#dateFrom').val();
        let dateTo = $('#dateTo').val();
        $.ajax({
            type: 'get',
            url: '/print/anesAll',
            data: {
                'dateFrom': dateFrom,
                'dateTo': dateTo
            },
            success: function (data) {
                let w = 1250;
                let h = 635;
                let left = (screen.width / 2) - (w / 2);
                let top = (screen.height / 2) - (h / 2) - 50;
                childWin = window.open("/print/anesAll?dateFrom=" + dateFrom + "&dateTo=" + dateTo, "", "height=" + h + ", width=" + w +
                    ", status=no, toolbar=no, menubar=no, location=no, addressbar=no, directories=no, top=" + top + ", left=" +
                    left);
            }
        });
    });

    $('.printMe5').on('click', function () {
        let dateFrom = $('#dateFrom').val();
        let dateTo = $('#dateTo').val();
        $.ajax({
            type: 'get',
            url: '/print/anesEmer',
            data: {
                'dateFrom': dateFrom,
                'dateTo': dateTo
            },
            success: function (data) {
                let w = 1250;
                let h = 635;
                let left = (screen.width / 2) - (w / 2);
                let top = (screen.height / 2) - (h / 2) - 50;
                childWin = window.open("/print/anesEmer?dateFrom=" + dateFrom + "&dateTo=" + dateTo, "", "height=" + h + ", width=" + w +
                    ", status=no, toolbar=no, menubar=no, location=no, addressbar=no, directories=no, top=" + top + ", left=" +
                    left);
            }
        });
    });

    $('.printMe6').on('click', function () {
        let dateFrom = $('#dateFrom').val();
        let dateTo = $('#dateTo').val();
        $.ajax({
            type: 'get',
            url: '/print/anesElec',
            data: {
                'dateFrom': dateFrom,
                'dateTo': dateTo
            },
            success: function (data) {
                let w = 1250;
                let h = 635;
                let left = (screen.width / 2) - (w / 2);
                let top = (screen.height / 2) - (h / 2) - 50;
                childWin = window.open("/print/anesElec?dateFrom=" + dateFrom + "&dateTo=" + dateTo, "", "height=" + h + ", width=" + w +
                    ", status=no, toolbar=no, menubar=no, location=no, addressbar=no, directories=no, top=" + top + ", left=" +
                    left);
            }
        });
    });
});
