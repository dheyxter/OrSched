$(function(){
    // $('#btnTrig').trigger('click');


//THIS POTION IS FOR TESTING ONLY
    $('.btnComplete').on('click', function(){
        let id = $(this).siblings('input.id').val();
        let hpercode = $(this).siblings('input.hpercode').val();
        console.log(hpercode);
        Swal.fire({
            title: 'Operation Completed?',
            // text: "Do you want to save the status?",
            icon: 'info',
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
                   url: '/status',
                   data: {
                       'id' : id,
                       'hpercode' : hpercode,
                   },
                   beforeSend: function(){
                        Swal.fire({
                            title: '<div style="width: 7rem; height: 7rem;" class="spinner-border text-info" role="status"><span class="sr-only">Loading...</span></div>',
                            showConfirmButton : false,
                        });
                   },
                   success: function(data){
                        Swal.fire({
                            title: 'SAVED!',
                            showConfirmButton : false,
                            timer: 1000,
                            icon: 'success'
                        });
                        location.reload();
                   }
               });
            };
        });
    });


//END OF TEST-PORTION





//THIS PORTION IS FOR COMPLETED SCRIPTS
    
});