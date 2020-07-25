var base_jsurl = "https://www.techprodevcenter.co.in/ulsa/";
var url = $(location).attr('href');
var parts = url.split("/");
var dashPart = parts[4].replace(/#/, "");
var last_part = parts[parts.length - 1];

$(document).ready(function() {
    "use strict";
    $(".demo-preloader").css("display", "none");

    // ______________ PAGE LOADING
    $(window).on("load", function(e) {
        $("#global-loader").fadeOut("slow");
    })

    // ______________ BACK TO TOP BUTTON

    $(window).on("scroll", function(e) {
        if ($(this).scrollTop() > 300) {
            $('#back-to-top').fadeIn('slow');
        } else {
            $('#back-to-top').fadeOut('slow');
        }
    });

    $("#back-to-top").on("click", function(e) {
        $("html, body").animate({
            scrollTop: 0
        }, 600);
        return false;
    });

    $(".readonly").keydown(function(e) {
        e.preventDefault();
    });

    ////Prevent Number////
    $(".preventNumber").on('input', function(event) {
        this.value = this.value.replace(/[^a-z\s]/gi, '');
    });
    ////Prevent Letters////
    $(".preventAlpha").on('input', function(event) {
        this.value = this.value.replace(/[^0-9]/gi, '');
    });


    ///Phone formating///
    $(".phone").on('keyup ', function() {
        var number = $(this).val()
        number = number.replace(/(\d\d\d)(\d\d\d)(\d\d\d\d)/, "$1-$2-$3");
        $(this).val(number)
    });


    ////******************////
    //// USER LOGIN CHECK ////
    $("#email_address").on('blur', function() {
        var email_address = $("#email_address").val();
        $.ajax({
            url: base_jsurl + 'auth/check_user_id',
            type: 'POST',
            data: { email_address: email_address },
            success: function(data) {
                if (data == 0) {
                    $(".errLoginUser").text("Invalid Email");
                    $(".errLoginUser").css("display", "block");
                    return false;
                } else {
                    $(".errLoginUser").css("display", "none");
                    return true;
                }
            }
        })
    })


    ////***************////
    // LOGIN FORM//
    $("#login").on('submit', function(e) {
        e.preventDefault();

        var email_address = $("#email_address").val();
        var password = $("#userPassword").val();
        $(".errLoginUser").css("display", "none");
        $(".errLoginPass").css("display", "none");
        $.ajax({
            url: base_jsurl + 'auth/check_user_id',
            type: 'POST',
            data: { email_address: email_address },
            success: function(data) {
                if (data == 0) {
                    $(".errLoginUser").text("Invalid Email");
                    $(".errLoginUser").css("display", "block");
                    return false;
                } else {
                    $(".errLoginUser").css("display", "none");
                    $.ajax({
                        url: base_jsurl + 'auth/check_email_login',
                        type: 'POST',
                        data: { email_address: email_address, password: password },
                        success: function(data) {
                            if (data == 1) {
                                $(".errLoginUser").css("display", "none");
                                $(".errLoginPass").css("display", "none");
                                window.location.replace(base_jsurl + "dashboard")

                            } else {
                                $(".errLoginPass").text("Invalid Password");
                                $(".errLoginPass").css("display", "block");
                                return false;
                            }
                        }
                    })
                }
            }
        })
    })

    ////****************////
    //// RESET PASSWORD ////
    $("#resetPasswordForm").on('submit', function(e) {
        e.preventDefault();
        $(".errResetEmail").css("display", "none");
        $.ajax({
            url: base_jsurl + 'auth/reset_pass_link',
            type: 'POST',
            data: $("#resetPasswordForm").serialize(),
            success: function(data) {
                if (data == 1) {
                    swal({
                        title: "A link to recover your password has been sent to your email.",
                        type: "success",
                        confirmButtonText: "OK"
                    }, function() {
                        window.location.href = base_jsurl + "auth";
                    });
                } else if (data == 0) {
                    $(".errResetEmail").text("Email invalid");
                    $(".errResetEmail").css("display", "block");
                    return false;
                }
            }
        })
    })

    $("#passwordForm").on('submit', function(e) {
        e.preventDefault();
        if ($("#password").val() != $("#confPassword").val()) {
            $(".errResetPassword").text("Password do not match");
            $(".errResetPassword").css("display", "block");
        } else {
            $(".errResetPassword").css("display", "none");
            var abc = $(this).find("button[type=submit]").attr("attrb");
            // var id = $("input[type=submit]").attr("attrb")
            $.ajax({
                url: base_jsurl + 'auth/reset_pass',
                type: 'POST',
                data: $("#passwordForm").serialize(),
                success: function(data) {
                    if (data == 1) {
                        if (abc == "web") {
                            //
                            swal({
                                title: "Password was successfully changed.",
                                type: "success",
                                confirmButtonText: "OK"
                            }, function() {
                                window.location.href = base_jsurl + "auth";
                            });
                        } else {
                            swal({
                                title: "Password was successfully changed.",
                                type: "success",
                                confirmButtonText: "OK"
                            }, function() {
                                window.location.href = base_jsurl + "auth/pass_change_msg";
                            });
                        }

                    }
                }
            })
        }
    })

    ////***************////
    // Users Table//
    $('#users_table').DataTable({
        "processing": true,
        "serverSide": true,
        "searching": true,
        "bInfo": false,
        "order": [],
        "ajax": {
            "url": base_jsurl + 'users/fetchUsers',
            "type": "POST",
        },
        "columnDefs": [{
            "targets": [0, 6],

            "orderable": false
        }]
    });


    // Delete User//
    $(document).on("click", '.deleteuser', function() {
        var id = $(this).attr("id");
        swal({
                title: "Alert",
                text: "Are you sure want to delete this patient?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            },
            function(inputValue) {
                if (inputValue === true) {
                    $.ajax({
                        url: base_jsurl + 'users/deleteUser',
                        type: 'POST',
                        data: { id: id },
                        success: function(data) {
                            if (data == true) {
                                window.location.replace(base_jsurl + "users")
                            }
                        }
                    })
                }
            });
    })

    //Users Satus Chane Toggle button//
    $('body').on('change', '#userstatus', function() {
        var id = $(this).attr("data-user_toggle");
        if ($(this).prop("checked") == true) {
            var prop = $(this).prop("checked")
        } else {
            var prop = $(this).prop("checked")
        }
        $.ajax({
            url: base_jsurl + 'users/change_user_status',
            type: 'POST',
            data: { prop: prop, id: id },
            success: function(data) {}
        })

    });

    ////Add Patients///
    $('#add_user').submit(function(e) {
        e.preventDefault();
        var phone = $('#phone').val();
        if (phone.length !== 12) {
            $(".errMobile").text("Mobile no must be 10 digit");
            $(".errMobile").css("display", "block");

        } else {
            var formName = $(this);
            $(".errEmail").css("display", "none");
            $.ajax({
                url: base_jsurl + 'users/checkEmail',
                type: 'post',
                datatype: 'json',
                // data: $(this).serialize(),
                data: { email: $("#email").val() },
                success: function(data) {
                    if (data == 1) {
                        $(".errEmail").text("Email already exist");
                        $(".errEmail").css("display", "block");
                        // window.location.replace(base_jsurl + "users")
                    } else if (data == 0) {
                        $(".errEmail").css("display", "none");
                        $(".errMobile").css("display", "none");
                        $.ajax({
                            url: base_jsurl + 'users/checkMobile',
                            type: 'post',
                            datatype: 'json',
                            // data: $(this).serialize(),
                            data: { phone: $("#phone").val() },
                            success: function(data) {
                                // alert(data);
                                if (data == 1) {
                                    $(".errMobile").text("Mobile  already exist");
                                    $(".errMobile").css("display", "block");
                                } else {
                                    $.ajax({
                                        // url: base_jsurl + 'users/insertUser',
                                        // url: base_jsurl + 'subadmin/insertUser',
                                        url: base_jsurl + 'users/insertUser',
                                        type: 'post',
                                        datatype: 'json',
                                        // data: $(this).serialize(),
                                        data: formName.serialize(),
                                        success: function(data) {
                                            if (data == true) {
                                                // window.location.replace(base_jsurl + "subadmin")
                                                swal("Created!", "Patient Created Successfully.", "success")
                                                setTimeout(function() {
                                                    window.location.reload();
                                                }, 2000);
                                            }
                                        }
                                    });

                                }
                            }

                        });
                    }
                }

            });
        }
    });





    ///Update Patients Profile///
    $('#users_update').submit(function(e) {
        e.preventDefault();
        var phone = $('#phone').val();
        if (phone.length !== 12) {
            $(".mobileErr").text("Mobile no must be 10 digit");
            $(".mobileErr").css("display", "block");

        } else {
            var form = $('#users_update')[0];
            var formData = new FormData(form);
            $.ajax({
                url: base_jsurl + 'users/updateUser',
                type: 'post',
                datatype: 'json',
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    if (data == true) {

                        swal("Updated!", "Patient Profile Updated Successfully.", "success")
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);

                    }
                }
            });
        }
    });



    var switchStatus = 1;
    $("#push_notification").on('change', function() {
        if ($(this).is(':checked')) {
            return $(this).is(':checked');
            // alert(switchStatus); // To verify
            // return 1;
        } else {
            return $(this).is(':checked');
            // alert(switchStatus); // To verify
            // return 0;
        }
    });


    ////***************////
    // Dentistry_table Table//
    $('#dentistry_table').DataTable({
        "processing": true,
        "serverSide": true,
        "searching": true,
        "bInfo": false,
        "order": [],
        "ajax": {
            "url": base_jsurl + 'dentistry/fetchDentistry',
            "type": "POST",
        },
        "columnDefs": [{
            "targets": [4],

            "orderable": false
        }]

    });

    // Delete Dentistry//
    $(document).on("click", '.delete_dentistry', function() {
        var id = $(this).attr("id");
        swal({
                title: "Alert",
                text: "Are you sure want to delete this dentistry?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            },
            function(inputValue) {
                if (inputValue === true) {
                    $.ajax({
                        url: base_jsurl + 'dentistry/deleteDentistry',
                        type: 'POST',
                        data: { id: id },
                        success: function(data) {
                            if (data == true) {

                                swal("Deleted!", "Dentistry Deleted Successfully.", "success")
                                setTimeout(function() {
                                    // window.location.reload();
                                    window.location.replace(base_jsurl + "dentistry")

                                }, 2000);
                            }
                        }
                    })
                }
            });
    });


    ///Add dentistry///
    $('#add_Dentistry').submit(function(e) {
        e.preventDefault();
        var messageLength = CKEDITOR.instances['description'].getData().replace(/<[^>]*>/gi, '').length;
        if (!messageLength) {
            $(".dentistry_descrption_err").text("Please fill the Dentistry Description ");
            $(".dentistry_descrption_err").css("display", "block");
        } else {
            var Ck_editor_value = CKEDITOR.instances['description'].getData();
            var form = $('#add_Dentistry')[0];
            var formData = new FormData(form);
            formData.append('Ck_editor_value', Ck_editor_value);
            $.ajax({
                url: base_jsurl + 'dentistry/addDentistry',
                type: 'post',
                datatype: 'json',
                // data: $(this).serialize(),
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    if (data == true) {
                        // window.location.replace(base_jsurl + "dentistry")
                        swal("Created!", "Dentistry Created Successfully.", "success")
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);

                    }
                }
            });
        }
    });


    ////***************////
    //Edit Dentistry popup//
    $(document).on('click', '.edit_dentistry', function() {
        var id = $(this).attr("id");
        $.ajax({
            url: base_jsurl + 'dentistry/editDentistry',
            method: "POST",
            data: { id: id },
            dataType: "json",
            success: function(data) {
                $('#editModal').modal('show');
                $('#id').val(id);
                $('#clinic_id_dentistry').val(data.clinic_id);
                $('#clinic_latitude').val(data.latitude);
                $('#clinic_longitude').val(data.longitude);
                $('#General_dentistry').val(data.General_dentistry_name);
                CKEDITOR.instances['description_dentistry'].setData(data.description);

            }
        })
    });

    ///Update Dentistry///
    $('#edit_Dentistry').submit(function(e) {
        e.preventDefault();
        var messageLength = CKEDITOR.instances['description_dentistry'].getData().replace(/<[^>]*>/gi, '').length;
        if (!messageLength) {
            $(".dentistry_descrption_error").text("Please fill the Dentistry Description ");
            $(".dentistry_descrption_error").css("display", "block");
        } else {
            var Ck_editor_value = CKEDITOR.instances['description_dentistry'].getData();
            var form = $('#edit_Dentistry')[0];
            var formData = new FormData(form);
            formData.append('Ck_editor_value', Ck_editor_value);
            $.ajax({
                url: base_jsurl + 'dentistry/updateDentistry',
                type: 'post',
                datatype: 'json',
                // data: new FormData(this),
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    if (data == true) {
                        swal("Updated!", "Dentistry Updated Successfully.", "success")
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);
                    }
                }
            });
        }
    });


    ////Add Braces///
    $('#add_braces').submit(function(e) {
        e.preventDefault();
        var form = $('#add_braces')[0];
        var formData = new FormData(form);
        $.ajax({
            url: base_jsurl + 'braces/add_braces',
            type: 'post',
            datatype: 'json',
            // data: $(this).serialize(),
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
                if (data == true) {
                    // window.location.replace(base_jsurl + "braces")
                    swal("Created!", "Braces Created Successfully.", "success")
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                }
            }
        });
    });


    ////***************////
    //Edit Braces popup//
    $(document).on('click', '.edit_brace', function() {
        var id = $(this).attr("id");
        $.ajax({
            url: base_jsurl + 'braces/edit_braces',
            method: "POST",
            data: { id: id },
            dataType: "json",
            success: function(data) {
                $('#editModal').modal('show');
                $('#id').val(id);
                // $('#image_dentistry').val(data.image);
                $('#braces_name').val(data.Braces_post_op);
                $('#bclinic_id').val(data.clinic_id);

                $('#youlink').val(data.link);


            }
        })
    });
    ///Update Braces///
    $('#edit_braces').submit(function(e) {
        e.preventDefault();
        var form = $('#edit_braces')[0];
        var formData = new FormData(form);
        $.ajax({
            url: base_jsurl + 'braces/update_braces',
            type: 'post',
            datatype: 'json',
            // data: new FormData(this),
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
                if (data == true) {
                    // window.location.replace(base_jsurl + "braces")
                    swal("Updated!", "Braces Updated Successfully.", "success")
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                }
            }
        });
    });


    ////Delete Braces////
    $(document).on("click", '.delete_braces', function() {
        var id = $(this).attr("id");
        swal({
                title: "Alert",
                text: "Are you sure want to delete this Braces-Post OP ?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            },
            function(inputValue) {
                if (inputValue === true) {
                    $.ajax({
                        url: base_jsurl + 'braces/delete_braces',
                        type: 'POST',
                        data: { id: id },
                        success: function(data) {
                            if (data == true) {
                                window.location.replace(base_jsurl + "braces")
                            }
                        }
                    })
                }
            });
    });

    ////***************////
    // Doctor_table //
    $('#doctors_table').DataTable({
        "processing": true,
        "serverSide": true,
        "searching": true,
        "bInfo": false,
        "order": [],
        "ajax": {
            "url": base_jsurl + 'doctors/fetchDoctors',
            "type": "POST",
        },
        "columnDefs": [{
            "targets": [6],

            "orderable": false
        }]

    });


    ////Add Doctor////
    $('#add_Doctor').submit(function(e) {
        e.preventDefault();
        var phone = $('#phone').val();
        var messageLength = CKEDITOR.instances['description'].getData().replace(/<[^>]*>/gi, '').length;
        if (phone.length !== 12) {
            $(".errDoctor_phone").text("Mobile no must be 10 digit");
            $(".errDoctor_phone").css("display", "block");
        } else if (!messageLength) {
            $(".description_error").text("Please fill the doctor description   ");
            $(".description_error").css("display", "block");

        } else {
            var Ck_editor_value = CKEDITOR.instances['description'].getData();
            var form = $('#add_Doctor')[0];
            var formData = new FormData(form);
            formData.append('Ck_editor_value', Ck_editor_value);
            $(".errDoctor_phone").css("display", "none");
            $.ajax({
                url: base_jsurl + 'doctors/checkMobile',
                type: 'post',
                datatype: 'json',
                data: { phone: $("#phone").val() },
                success: function(data) {
                    // alert(data);
                    if (data == 1) {
                        $(".errDoctor_phone").text("Mobile  already exist");
                        $(".errDoctor_phone").css("display", "block");

                    } else {
                        $(".errDoctor_phone").css("display", "none");
                        $.ajax({
                            url: base_jsurl + 'doctors/addDoctor',
                            type: 'post',
                            datatype: 'json',
                            data: formData,
                            processData: false,
                            contentType: false,
                            cache: false,
                            success: function(data) {
                                if (data == true) {
                                    // window.location.replace(base_jsurl + "doctors")
                                    swal("Created!", "Doctor Created Successfully.", "success")
                                    setTimeout(function() {
                                        window.location.reload();
                                    }, 2000);
                                }
                            }
                        });
                    }
                }
            });
        }
    });


    ////***************////
    //Edit Doctor popup//
    $(document).on('click', '.edit_doctor', function() {
        var id = $(this).attr("id");
        $.ajax({
            url: base_jsurl + 'doctors/editDoctor',
            method: "POST",
            data: { id: id },
            dataType: "json",
            success: function(data) {
                $('#editDoctor').modal('show');
                $('#id').val(id);
                $('#Lname').val(data.LName);
                $('#Fname').val(data.FName);
                $('#doctor_phone').val(data.phone);
                $('#cclinic_id').val(data.clinic_id);
                CKEDITOR.instances['doctor_description'].setData(data.doctor_description);

            }
        })
    });

    ///Update Doctor///
    $('#edit_Doctor').submit(function(e) {
        e.preventDefault();
        var phone = $('#doctor_phone').val();
        var messageLength = CKEDITOR.instances['doctor_description'].getData().replace(/<[^>]*>/gi, '').length;
        if (phone.length !== 12) {
            $(".errDoctor_phones").text("Mobile no must be 10 digit");
            $(".errDoctor_phones").css("display", "block");

        } else if (!messageLength) {
            $(".description_err").text("Please fill the doctor description  ");
            $(".description_err").css("display", "block");

        } else {
            var Ck_editor_value = CKEDITOR.instances['doctor_description'].getData();
            var form = $('#edit_Doctor')[0];
            var formData = new FormData(form);
            formData.append('Ck_editor_value', Ck_editor_value);

            $.ajax({
                url: base_jsurl + 'doctors/updateDoctor',
                type: 'post',
                // data: new FormData(this),
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data == true) {
                        // window.location.replace(base_jsurl + "doctors")
                        swal("Updated!", "Doctor Updated Successfully.", "success")
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);
                    }
                }
            });
        }
    });

    // Delete Doctors//
    $(document).on("click", '.delete_doctor', function() {
        var id = $(this).attr("id");
        swal({
                title: "Alert",
                text: "Are you sure want to delete this doctor?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            },
            function(inputValue) {
                if (inputValue === true) {
                    $.ajax({
                        url: base_jsurl + 'doctors/deleteDoctor',
                        type: 'POST',
                        data: { id: id },
                        success: function(data) {
                            if (data == true) {
                                window.location.replace(base_jsurl + "doctors")
                            }
                        }
                    })
                }
            });
    })


    //Doctor Satus Chane Toggle button//
    $('body').on('change', '#doctorstatus', function() {
        var id = $(this).attr("data-user_toggle");
        if ($(this).prop("checked") == true) {
            var prop = $(this).prop("checked")
        } else {
            var prop = $(this).prop("checked")
        }
        $.ajax({
            url: base_jsurl + 'doctors/change_dctor_status',
            type: 'POST',
            data: { prop: prop, id: id },
            success: function(data) {}
        })

    });





    // Members Table//
    $('#members_table').DataTable({
        "processing": true,
        "serverSide": true,
        "searching": true,
        "bInfo": false,
        "order": [],
        "ajax": {
            "url": base_jsurl + 'users/fetch_member',
            "type": "POST",
            'data': { "id": $("#members_table").attr("data-id") }
        },
        "columnDefs": [{
            "targets": [3],

            "orderable": false
        }]
    });

    ////***************////
    // Add Member   //
    $('#add_member').submit(function(e) {
        e.preventDefault();
        var phone = $('#phone_number').val();
        if (phone.length !== 12) {
            $(".mobileError").text("Mobile no must be 10 digit");
            $(".mobileError").css("display", "block");
        } else {

            $(".mobileError").css("display", "none");
            var form = $('#add_member')[0];
            var formData = new FormData(form);
            $.ajax({
                url: base_jsurl + 'users/checkmobile_member',
                type: 'post',
                datatype: 'json',
                data: { phone_number: $("#phone_number").val() },
                success: function(data) {
                    if (data == 1) {
                        $(".mobileError").text("Mobile  already exist");
                        $(".mobileError").css("display", "block");

                    } else {
                        $(".mobileError").css("display", "none");
                        $.ajax({
                            url: base_jsurl + 'users/insertMember',
                            type: 'post',
                            datatype: 'json',
                            data: formData,
                            processData: false,
                            contentType: false,
                            cache: false,
                            success: function(data) {
                                if (data == true) {
                                    swal("Added!", "Family member Added Successfully.", "success")
                                    setTimeout(function() {
                                        window.location.reload();
                                    }, 2000);
                                }
                            }
                        });
                    }
                }
            });
        }

    });


    // Delete Member//
    $(document).on("click", '.delete_member', function() {
        var id = $(this).attr("id");
        swal({
                title: "Alert",
                text: "Are you sure want to delete this member?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            },
            function(inputValue) {
                if (inputValue === true) {
                    $.ajax({
                        url: base_jsurl + 'users/deleteMember',
                        type: 'POST',
                        data: { id: id },
                        success: function(data) {
                            if (data == true) {
                                swal("Deleted!", "Family member Deleted Success.", "success")
                                setTimeout(function() {
                                    window.location.reload();
                                }, 2000);
                            }
                        }
                    })
                }
            });
    })


    ////***************////
    //Edit Member popup//
    $(document).on('click', '.edit_member', function() {
        var id = $(this).attr("id");
        $.ajax({
            url: base_jsurl + 'users/editMember',
            method: "POST",
            data: { id: id },
            dataType: "json",
            success: function(data) {
                $('#edit_modals').modal('show');
                $('#member_id').val(id);
                // $('#image_dentistry').val(data.image);
                $('#names').val(data.Firstname);
                $('#member_Lastname').val(data.Lastname);
                $('#member_phone_number').val(data.phone_number);
            }
        })
    });

    /// update member///
    $('#edit_member').submit(function(e) {
        e.preventDefault();
        var phone = $('#member_phone_number').val();
        if (phone.length !== 12) {
            $(".mobileErrors").text("Mobile no must be 10 digit");
            $(".mobileErrors").css("display", "block");
        } else {
            $.ajax({
                url: base_jsurl + 'users/updateMember',
                type: 'post',
                datatype: 'json',
                data: $(this).serialize(),
                success: function(data) {
                    if (data == true) {
                        swal("Updated!", "Family member Updated Successfully.", "success")
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);
                    }
                }
            });
        }
    });

    // Braces_table //
    $('#braces_table').DataTable({
        "processing": true,
        "serverSide": true,
        "searching": true,
        "bInfo": false,
        "order": [],
        "ajax": {
            "url": base_jsurl + 'braces/fetchBraces',
            "type": "POST",
        },
        "columnDefs": [{
            "targets": [3],

            "orderable": false
        }]

    });

    ///SubAdmin table////
    $('#subadmin_table').DataTable({
        "processing": true,
        "serverSide": true,
        "searching": true,
        "bInfo": false,
        "order": [],
        "ajax": {
            "url": base_jsurl + 'subadmin/fetchSubadmin',
            "type": "POST",
        },
        "columnDefs": [{
            "targets": [5],

            "orderable": false
        }]

    });

    ///Add Subadmin///
    $('#add_subadmin').submit(function(e) {
        e.preventDefault();
        var phone = $('#phone').val();
        if (phone.length !== 12) {
            $(".errMobilesubadmin").text("Mobile no must be 10 digit");
            $(".errMobilesubadmin").css("display", "block");
        } else {
            var formName = $(this);
            $(".errEmailsubadmin").css("display", "none");
            $.ajax({
                url: base_jsurl + 'users/checkEmail',
                type: 'post',
                datatype: 'json',
                // data: $(this).serialize(),
                data: { email: $("#email").val() },
                success: function(data) {
                    if (data == 1) {
                        $(".errEmailsubadmin").text("Email already exist");
                        $(".errEmailsubadmin").css("display", "block");
                    } else if (data == 0) {
                        $(".errEmailsubadmin").css("display", "none");
                        $(".errMobilesubadmin").css("display", "none");
                        $.ajax({
                            url: base_jsurl + 'users/checkMobile',
                            type: 'post',
                            datatype: 'json',
                            // data: $(this).serialize(),
                            data: { phone: $("#phone").val() },
                            success: function(data) {
                                if (data == 1) {
                                    $(".errMobilesubadmin").text("Mobile  already exist");
                                    $(".errMobilesubadmin").css("display", "block");
                                } else {
                                    $.ajax({
                                        url: base_jsurl + 'subadmin/insertUser',
                                        type: 'post',
                                        datatype: 'json',
                                        data: formName.serialize(),
                                        success: function(data) {
                                            if (data == true) {
                                                swal("Created!", "User Created Successfully.", "success")
                                                setTimeout(function() {
                                                    window.location.reload();
                                                }, 2000);
                                            }
                                        }
                                    });
                                }
                            }
                        });
                    }
                }
            });
        }
    });




    // Delete subadmin//
    $(document).on("click", '.deletesubadmin', function() {
        var id = $(this).attr("id");
        swal({
                title: "Alert",
                text: "Are you sure want to delete this user?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            },
            function(inputValue) {
                if (inputValue === true) {
                    $.ajax({
                        url: base_jsurl + 'subadmin/deleteSubadmin',
                        type: 'POST',
                        data: { id: id },
                        success: function(data) {
                            if (data == true) {
                                window.location.replace(base_jsurl + "subadmin")
                            }
                        }
                    })
                }
            });
    })

    ////***************////
    //Edit SubAdmin popup//
    $(document).on('click', '.editsubadmin', function() {
        var id = $(this).attr("id");
        $.ajax({
            url: base_jsurl + 'subadmin/editSubadmin',
            method: "POST",
            data: { id: id },
            dataType: "json",
            success: function(data) {
                $('#edit_subadmin').modal('show');
                $('#id').val(id);
                $('#sname').val(data.name);
                $('#semail').val(data.email);
                $('#sphone').val(data.phone);
                $('#slastname').val(data.lastname);
                $('#sdesired_clinic').val(data.desired_clinic);

            }
        })
    });

    ///Update suadmin///
    $('#update_subadmin').submit(function(e) {
        e.preventDefault();
        var phone = $('#sphone').val();
        if (phone.length !== 12) {
            $(".errMobilesadmin").text("Mobile no must be 10 digit");
            $(".errMobilesadmin").css("display", "block");
        } else {
            $.ajax({
                url: base_jsurl + 'subadmin/updateSubadmin',
                type: 'post',
                datatype: 'json',
                data: $(this).serialize(),
                success: function(data) {
                    if (data == true) {
                        // window.location.replace(base_jsurl + "subadmin")
                        swal("Updated!", "User Updated Successfully.", "success")
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);
                    }
                }
            });
        }
    });

    // clinic_table //
    $('#clinic_table').DataTable({
        "processing": true,
        "serverSide": true,
        "searching": true,
        "bInfo": false,
        "order": [],
        "ajax": {
            "url": base_jsurl + 'clinic/fetchClinic',
            "type": "POST",
        },
        "columnDefs": [{
            "targets": [7, 8],
            "orderable": false
        }]

    });


    // Delete Office//
    $(document).on("click", '.delete_clinic', function() {
        var id = $(this).attr("id");
        swal({
                title: "Alert",
                text: "Are you sure want to delete this clinic?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            },
            function(inputValue) {
                if (inputValue === true) {
                    $.ajax({
                        url: base_jsurl + 'clinic/deleteClinic',
                        type: 'POST',
                        data: { id: id },
                        success: function(data) {
                            if (data == true) {
                                window.location.replace(base_jsurl + "clinic")
                            }
                        }
                    })
                }
            });
    })


    ////***************////
    //Edit Office popup//
    $(document).on('click', '.edit_clinic', function() {
        var id = $(this).attr("id");
        $.ajax({
            url: base_jsurl + 'clinic/editClinic',
            method: "POST",
            data: { id: id },
            dataType: "json",
            success: function(data) {
                $('#editModal').modal('show');
                $('#id').val(id);
                $('#cdesired_clinic').val(data.desired_clinic);
                $('#cclinic_email').val(data.clinic_email);
                $('#cclinic_phoneno').val(data.clinic_phoneno);
                $('#cclinic_address').val(data.clinic_address);
                $('#clinic_latitude').val(data.latitude);
                $('#clinic_longitude').val(data.longitude);


                CKEDITOR.instances['cworking_hours'].setData(data.working_hours);


            }
        })
    });

    ///UPdate Office///
    $('#edit_clinic').submit(function(e) {
        e.preventDefault();
        var phone = $('#cclinic_phoneno').val();
        var messageLength = CKEDITOR.instances['cworking_hours'].getData().replace(/<[^>]*>/gi, '').length;
        if (phone.length !== 12) {
            $(".errClinic_phones").text("Mobile no must be 10 digit");
            $(".errClinic_phones").css("display", "block");
        } else if (!messageLength) {
            $(".workinghours_err").text("Please fill the Office Working Hours   ");
            $(".workinghours_err").css("display", "block");
        } else {
            var Ck_editor_value = CKEDITOR.instances['cworking_hours'].getData();
            var form = $('#edit_clinic')[0];
            var formData = new FormData(form);
            formData.append('Ck_editor_value', Ck_editor_value);

            $.ajax({
                url: base_jsurl + 'clinic/updateClinic',
                type: 'post',
                // data: new FormData(this),
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data == true) {
                        // window.location.replace(base_jsurl + "clinic")
                        swal("Updated!", "Clinic Updated Successfully.", "success")
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);

                    }
                }
            });
        }
    });

    //add Office///
    $('#add_clinic').submit(function(e) {
        e.preventDefault();
        var phone = $('#clinic_phoneno').val();
        var messageLength = CKEDITOR.instances['working_hours'].getData().replace(/<[^>]*>/gi, '').length;
        if (phone.length !== 12) {
            $(".errClinic_phone").text("Mobile no must be 10 digit");
            $(".errClinic_phone").css("display", "block");
        } else if (!messageLength) {
            $(".workinghours_error").text("Please fill the Office Working Hours   ");
            $(".workinghours_error").css("display", "block");

        } else {
            var Ck_editor_value = CKEDITOR.instances['working_hours'].getData();
            var form = $('#add_clinic')[0];
            var formData = new FormData(form);
            formData.append('Ck_editor_value', Ck_editor_value);

            $(".errClinic_email").css("display", "none");
            $.ajax({
                url: base_jsurl + 'clinic/checkEmail',
                type: 'post',
                datatype: 'json',
                data: $(this).serialize(),
                data: { clinic_email: $("#clinic_email").val() },
                success: function(data) {
                    if (data == 1) {
                        $(".errClinic_email").text("Email already exist");
                        $(".errClinic_email").css("display", "block");
                        // window.location.replace(base_jsurl + "users")
                    } else if (data == 0) {
                        $(".errClinic_email").css("display", "none");
                        $(".errClinic_phone").css("display", "none");
                        $.ajax({
                            url: base_jsurl + 'clinic/checkMobile',
                            type: 'post',
                            datatype: 'json',
                            data: $(this).serialize(),
                            data: { clinic_phoneno: $("#clinic_phoneno").val() },
                            success: function(data) {
                                // alert(data);
                                if (data == 1) {
                                    $(".errClinic_phone").text("Mobile  already exist");
                                    $(".errClinic_phone").css("display", "block");
                                } else {
                                    $.ajax({
                                        url: base_jsurl + 'clinic/addClinic',
                                        type: 'post',
                                        datatype: 'json',
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        cache: false,
                                        success: function(data) {
                                            if (data == true) {
                                                // window.location.replace(base_jsurl + "clinic")
                                                swal("Created!", "Clinic Created Successfully.", "success")
                                                setTimeout(function() {
                                                    window.location.reload();
                                                }, 2000);
                                            }
                                        }
                                    });
                                }
                            }
                        });
                    }
                }
            });
        }
    });


    ///check password validation////
    $("#oldpassword").on('blur', function() {
        var oldpassword = $("#oldpassword").val();
        $.ajax({
            url: base_jsurl + 'dashboard/checkPassword',
            type: 'POST',
            data: { oldpassword: oldpassword },
            success: function(data) {
                if (data == 0) {
                    $(".errPaasword").text("Invalid Password");
                    $(".errPaasword").css("display", "block");
                    return false;
                } else {
                    $(".errPaasword").css("display", "none");
                    return true;
                }
            }
        })
    })


    ////Password changes///
    $('#password_change').submit(function(e) {
        e.preventDefault();
        var oldpassword = $("#oldpassword").val();
        var password = $("#password").val();
        var cnfpassword = $("#cnfpassword").val();
        var form = $('#password_change')[0];
        var formData = new FormData(form);

        if (password != cnfpassword) {
            $(".errCnfPass").text(" Password do not match");
            $(".errCnfPass").css("display", "block");
        } else {

            $(".errPaasword").css("display", "none");
            // $(".errLoginPass").css("display", "none");
            $.ajax({
                url: base_jsurl + 'dashboard/checkPassword',
                type: 'POST',
                data: { oldpassword: oldpassword },
                success: function(data) {
                    if (data == 0) {
                        $(".errPaasword").text("Invalid Password");
                        $(".errPaasword").css("display", "block");
                        return false;
                    } else {
                        $(".errPaasword").css("display", "none");
                        $.ajax({
                            url: base_jsurl + 'dashboard/updatePassword',
                            type: 'post',
                            datatype: 'json',
                            data: formData,
                            processData: false,
                            contentType: false,
                            cache: false,
                            success: function(data) {
                                if (data == true) {

                                    swal("Changes!", "Password Changes successfully.", "success")
                                    setTimeout(function() {
                                        window.location.reload();
                                    }, 2000);

                                }
                            }
                        });
                    }
                }
            });
        }
    });

    ////Update Admin profile////
    $('#admin_update').submit(function(e) {
        e.preventDefault();
        var phone = $('#phone').val();
        if (phone.length !== 12) {
            $(".erradmin_mobile").text("Mobile no must be 10 digit");
            $(".erradmin_mobile").css("display", "block");

        } else {
            var form = $('#admin_update')[0];
            var formData = new FormData(form);
            $.ajax({
                url: base_jsurl + 'dashboard/updateAdmin',
                type: 'post',
                datatype: 'json',
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    if (data == true) {

                        // swal("Created!", "Service type Created Successfully.", "success")
                        swal("Updated!", "Your Profile Updated Successfully.", "success")
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);

                    }
                }
            });
        }
    });


    ///Offers Table/////
    $('#offers_table').DataTable({
        "processing": true,
        "serverSide": true,
        "searching": true,
        "bInfo": false,
        "order": [],
        "ajax": {
            "url": base_jsurl + 'offers/fetchOffers',
            "type": "POST",
        },
        "columnDefs": [{
            "targets": [7, 8],

            "orderable": false
        }]

    });


    ///Add Offers///
    $('#add_offers').submit(function(e) {
        e.preventDefault();
        var messageLength = CKEDITOR.instances['description'].getData().replace(/<[^>]*>/gi, '').length;
        if (!messageLength) {
            $(".offer_descrption_err").text("Please fill the Offer Description ");
            $(".offer_descrption_err").css("display", "block");
        } else {
            var Ck_editor_value = CKEDITOR.instances['description'].getData();
            var form = $('#add_offers')[0];
            var formData = new FormData(form);
            formData.append('Ck_editor_value', Ck_editor_value);
            $.ajax({
                url: base_jsurl + 'offers/addOffer',
                type: 'post',
                datatype: 'json',
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    if (data == true) {
                        // window.location.replace(base_jsurl + "offers")
                        swal("Created!", "Offer Created Successfully.", "success")
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);
                    }
                }
            });
        }
    });

    ////******refresh data after close popup/////*** */
    // $('#offerModal').on('click', function() {
    //     $('.form-control').val('');
    // });



    ////***************////
    //Edit offers popup//
    $(document).on('click', '.edit_offers', function() {
        var id = $(this).attr("id");
        $.ajax({
            url: base_jsurl + 'offers/editOffer',
            method: "POST",
            data: { id: id },
            dataType: "json",
            success: function(data) {
                $('#editModal').modal('show');
                $('#id').val(id);
                $('#offer_name').val(data.name);
                $('#offer_clinic_id').val(data.clinic_id);
                $('#offer_starting_date').val(data.starting_date);
                $('#offer_expiry_date').val(data.expiry_date);
                $('#offer_promo_code').val(data.promo_code);
                CKEDITOR.instances['offer_description'].setData(data.description);
            }
        })
    });

    ////***************////
    //Update offers popup//
    $('#edit_offers').submit(function(e) {
        e.preventDefault();
        var messageLength = CKEDITOR.instances['offer_description'].getData().replace(/<[^>]*>/gi, '').length;
        if (!messageLength) {
            $(".offer_descrption_error").text("Please fill the Offer Description ");
            $(".offer_descrption_error").css("display", "block");
        } else {
            var Ck_editor_value = CKEDITOR.instances['offer_description'].getData();
            var form = $('#edit_offers')[0];
            var formData = new FormData(form);
            formData.append('Ck_editor_value', Ck_editor_value);

            $.ajax({
                url: base_jsurl + 'offers/updateOffer',
                type: 'post',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data == true) {
                        // window.location.replace(base_jsurl + "offers")
                        swal("Updated!", "Offer Updated Successfully.", "success")
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);
                    }
                }
            });
        }
    });


    // Delete Offers//
    $(document).on("click", '.delete_offers', function() {
        var id = $(this).attr("id");
        swal({
                title: "Alert",
                text: "Are you sure want to delete this offer?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            },
            function(inputValue) {
                if (inputValue === true) {
                    $.ajax({
                        url: base_jsurl + 'offers/deleteOffer',
                        type: 'POST',
                        data: { id: id },
                        success: function(data) {
                            if (data == true) {
                                window.location.replace(base_jsurl + "offers")
                            }
                        }
                    })
                }
            });
    })

    // Appointment_table //
    $('#appointment_table').DataTable({
        "processing": true,
        "serverSide": true,
        "searching": true,
        "bInfo": false,
        "order": [],
        "ajax": {
            "url": base_jsurl + 'appointment/fetchAppointment',
            "type": "POST",
            'data': { "id": $("#appointment_table").attr("data-id") }
        },
        "columnDefs": [{
            "targets": [0, 7, 8],

            "orderable": false
        }]

    });
    $('#appointment_table_pend').DataTable({
        "processing": true,
        "serverSide": true,
        "searching": true,
        "bInfo": false,
        "order": [],
        "ajax": {
            "url": base_jsurl + 'appointment/fetchAppointmentPend',
            "type": "POST",
            'data': { "id": $("#appointment_table_pend").attr("data-id") }
        },
        "columnDefs": [{
            "targets": [0, 7, 8],
            "orderable": false
        }]

    });
    $('#appointment_table_dec').DataTable({
        "processing": true,
        "serverSide": true,
        "searching": true,
        "bInfo": false,
        "order": [],
        "ajax": {
            "url": base_jsurl + 'appointment/fetchAppointmentDec',
            "type": "POST",
            'data': { "id": $("#appointment_table_dec").attr("data-id") }
        },
        "columnDefs": [{
            "targets": [0, 7, 8],
            "orderable": false
        }]

    });

    // Cancel Appointmnet Button//
    $(document).on("click", '.cancel_apppoinment', function() {
        var id = $(this).attr("id");
        swal({
                title: "Alert",
                text: "Are you sure want to cancel this Appointment?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            },
            function(inputValue) {
                if (inputValue === true) {
                    $.ajax({
                        url: base_jsurl + 'appointment/cancelAppointment',
                        type: 'POST',
                        data: { id: id },
                        success: function(data) {
                            if (data == true) {
                                window.location.reload();

                            }
                        }
                    })
                }
            });
    })


    // Appointment_Dashboard //
    $('#appointment_dashboard').DataTable({
        "processing": true,
        "serverSide": true,
        "searching": true,
        "bInfo": false,
        "order": [],
        "ajax": {
            "url": base_jsurl + 'dashboard/fetchAppointment',
            "type": "POST",
            'data': { "id": $("#appointment_dashboard").attr("data-id") }
        },
        "columnDefs": [{
            "targets": [0, 8, 9],

            "orderable": false
        }]
    });

    $('#appointment_dashboard_pend').DataTable({
        "processing": true,
        "serverSide": true,
        "searching": true,
        "bInfo": false,
        "order": [],
        "ajax": {
            "url": base_jsurl + 'dashboard/fetchAppointmentPend',
            "type": "POST",
            'data': { "id": $("#appointment_dashboard_pend").attr("data-id") }
        },
        "columnDefs": [{
            "targets": [0, 8, 9],

            "orderable": false
        }]
    });

    $('#appointment_dashboard_cancel').DataTable({
        "processing": true,
        "serverSide": true,
        "searching": true,
        "bInfo": false,
        "order": [],
        "ajax": {
            "url": base_jsurl + 'dashboard/fetchAppointmentDec',
            "type": "POST",
            'data': { "id": $("#appointment_dashboard_cancel").attr("data-id") }
        },
        "columnDefs": [{
            "targets": [0, 8, 9],

            "orderable": false
        }]
    });

    // Service type//
    $('#service_type').DataTable({
        "processing": true,
        "serverSide": true,
        "searching": true,
        "bInfo": false,
        "order": [],
        "ajax": {
            "url": base_jsurl + 'clinic/Fetchservice_type',
            "type": "POST",
            'data': { "id": $("#service_type").attr("data-id") }
        },
        "columnDefs": [{
            "targets": [2],

            "orderable": false
        }]
    });


    ///Add Service Type///
    $('#add_servicetype').submit(function(e) {
        e.preventDefault();
        var form = $('#add_servicetype')[0];
        var formData = new FormData(form);
        $.ajax({
            url: base_jsurl + 'clinic/insertservices',
            type: 'post',
            datatype: 'json',
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
                if (data == true) {

                    swal("Created!", "Service type Created Successfully.", "success")
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);

                }
            }
        });
    });

    ////***************////
    //Edit Service popup//
    $(document).on('click', '.edit_service', function() {
        var id = $(this).attr("id");
        $.ajax({
            url: base_jsurl + 'clinic/editService',
            method: "POST",
            data: { id: id },
            dataType: "json",
            success: function(data) {
                $('#editModal').modal('show');
                $('#aid').val(id);
                $('#aservice_type').val(data.service_type);
                $('#aservice_description').val(data.service_description);
            }
        })
    });

    $('#edit_serviceaptype').submit(function(e) {
        e.preventDefault();
        var form = $('#edit_serviceaptype')[0];
        var formData = new FormData(form);

        $.ajax({
            url: base_jsurl + 'clinic/updateService',
            type: 'post',
            datatype: 'json',
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
                if (data == true) {

                    swal("Updated!", "Service type Updated Successfully.", "success")
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);

                }
            }
        });
    });

    // Delete Service Type//
    $(document).on("click", '.delete_service', function() {
        var id = $(this).attr("id");
        swal({
                title: "Alert",
                text: "Are you sure want to delete this Service Type?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            },
            function(inputValue) {
                if (inputValue === true) {
                    $.ajax({
                        url: base_jsurl + 'clinic/deleteService',
                        type: 'POST',
                        data: { id: id },
                        success: function(data) {
                            if (data == true) {
                                // swal("Deleted!", "Service type Deleted Successfully.", "success")
                                // setTimeout(function() {
                                window.location.reload();
                                // }, 2000);
                            }
                        }
                    })
                }
            });
    })

    ///family member hover///
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });


    ///Appoinment date & time///
    $(function() {
        $("#date").datepicker({
            dateFormat: 'dd-mm-yy'
        });
        $("#time").timepicker({
            timeFormat: 'H:mm:ss '
        });

        $("#times").timepicker({
            timeFormat: 'H:mm:ss '
        });
    });

    $('#status_filter').submit(function(e) {
        e.preventDefault();
        var form = $('#status_filter')[0];
        var formData = new FormData(form);

        $.ajax({
            url: base_jsurl + 'dashboard/filter',
            type: 'post',
            datatype: 'json',
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
                if (data == true) {

                    swal("Filtered!", "Dashboard status changes.", "success")
                    setTimeout(function() {
                        window.location.reload();

                    }, 2000);

                }
            }
        });
    });


    ///status filter datepicker validation///
    $(function() {
        $("#date_one").datepicker({
            dateFormat: 'dd-mm-yy',
            onSelect: function(dateText, inst) {
                $(".date_two").css("display", "none");
                var date1 = $("#date_two").val().split('-');
                date1 = date1[1] + '/' + date1[0] + '/' + date1[2];

                var date2 = dateText.split('-');
                date2 = date2[1] + '/' + date2[0] + '/' + date2[2];
                if ($("#date_two").val() != "" && date1 <= date2) {
                    $(this).val(inst.lastVal);
                    $(".date_one").text(" Start date must be before than the End date");
                    $(".date_one").css("display", "block");
                } else {
                    $(".date_one").css("display", "none");
                }
            }
        });
        $("#date_two").datepicker({
            dateFormat: 'dd-mm-yy',

            onSelect: function(dateText, inst) {
                $(".date_one").css("display", "none");
                var date1 = $("#date_one").val().split('-');
                date1 = date1[1] + '/' + date1[0] + '/' + date1[2];

                var date2 = dateText.split('-');
                date2 = date2[1] + '/' + date2[0] + '/' + date2[2];

                if ($("#date_one").val() != "" && date1 >= date2) {
                    $(this).val(inst.lastVal);
                    $(".date_two").text(" End date must be after than the start date");
                    $(".date_two").css("display", "block");
                } else {
                    $(".date_two").css("display", "none");
                }
            }
        });

    });


    ///Offers DatePicker & Validations////
    $(function() {
        $("#starting_date").datepicker({
            dateFormat: 'dd-mm-yy',
            onSelect: function(dateText, inst) {
                $(".errEndTime").css("display", "none");
                var date1 = $("#expiry_date").val().split('-');
                date1 = date1[1] + '/' + date1[0] + '/' + date1[2];

                var date2 = dateText.split('-');
                date2 = date2[1] + '/' + date2[0] + '/' + date2[2];
                if ($("#expiry_date").val() != "" && date1 <= date2) {
                    $(this).val(inst.lastVal);
                    $(".errStartTime").text(" Starting date must be before than the Expiry date");
                    $(".errStartTime").css("display", "block");
                } else {
                    $(".errStartTime").css("display", "none");
                }
            }
        });
        $("#expiry_date").datepicker({
            dateFormat: 'dd-mm-yy',

            onSelect: function(dateText, inst) {
                $(".errStartTime").css("display", "none");
                var date1 = $("#starting_date").val().split('-');
                date1 = date1[1] + '/' + date1[0] + '/' + date1[2];

                var date2 = dateText.split('-');
                date2 = date2[1] + '/' + date2[0] + '/' + date2[2];

                if ($("#starting_date").val() != "" && date1 >= date2) {
                    $(this).val(inst.lastVal);
                    $(".errEndTime").text(" Expiry date must be after than the starting date");
                    $(".errEndTime").css("display", "block");
                } else {
                    $(".errEndTime").css("display", "none");
                }
            }
        });

    });

    $(function() {
        $("#offer_starting_date").datepicker({
            dateFormat: 'dd-mm-yy',
            onSelect: function(dateText, inst) {
                $(".errEndTimeO").css("display", "none");
                var date1 = $("#offer_expiry_date").val().split('-');
                date1 = date1[1] + '/' + date1[0] + '/' + date1[2];

                var date2 = dateText.split('-');
                date2 = date2[1] + '/' + date2[0] + '/' + date2[2];

                if ($("#offer_expiry_date").val() != "" && date1 <= date2) {
                    $(this).val(inst.lastVal);
                    $(".errStartTimeO").text("Starting date must be before than the Expiry date");
                    $(".errStartTimeO").css("display", "block");
                } else {
                    $(".errStartTimeO").css("display", "none");
                }
            }
        });
        $("#offer_expiry_date").datepicker({
            dateFormat: 'dd-mm-yy',

            onSelect: function(dateText, inst) {
                $(".errStartTimeO").css("display", "none");
                var date1 = $("#offer_starting_date").val().split('-');
                date1 = date1[1] + '/' + date1[0] + '/' + date1[2];

                var date2 = dateText.split('-');
                date2 = date2[1] + '/' + date2[0] + '/' + date2[2];

                if ($("#offer_starting_date").val() != "" && date1 >= date2) {
                    $(this).val(inst.lastVal);
                    $(".errEndTimeO").text(" Expiry date must be after than the starting date");
                    $(".errEndTimeO").css("display", "block");
                } else {
                    $(".errEndTimeO").css("display", "none");
                }
            }
        });

    });


    ////Appointment Fix////
    $('#apfix').submit(function(e) {
        e.preventDefault();
        var form = $('#apfix')[0];
        var formData = new FormData(form);
        $(".demo-preloader").css("display", "block");
        $("input").prop('disabled', true);


        $.ajax({
            url: base_jsurl + 'appointment/fixAppointment',
            type: 'post',
            datatype: 'json',
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
                console.log(data);
                if (data == true) {
                    $(".demo-preloader").css("display", "none");
                    $("input").prop('disabled', false);
                    swal("Updated!", "Appointment Fixed Updated Successfully.", "success")
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);

                } else if (data == false) {
                    $(".demo-preloader").css("display", "none");
                    $("input").prop('disabled', false);
                    alert('doctor alreday booked on this time ');
                }
            }
        });
    });


    /////Appointment Cancel////
    $('#apcancel').submit(function(e) {
        e.preventDefault();
        var form = $('#apcancel')[0];
        var formData = new FormData(form);

        $.ajax({
            url: base_jsurl + 'appointment/cancelAppointment',
            type: 'post',
            datatype: 'json',
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
                if (data == true) {

                    swal("Cancel!", "Appointment Cancel Successfully.", "success")
                    setTimeout(function() {
                        window.location.reload();

                    }, 2000);

                }
            }
        });
    });

    ///Chat table////
    $('#chatuser_table').DataTable({
        "processing": true,
        "serverSide": true,
        "searching": true,
        "bInfo": false,
        "order": [],
        "ajax": {
            "url": base_jsurl + 'chat/fetchUser',
            "type": "POST",
        },
        "columnDefs": [{
            "targets": [5],

            "orderable": false
        }]

    });

    ///chat message form///
    $('#msg_form').submit(function(e) {
        e.preventDefault();
        var form = $('#msg_form')[0];
        var formData = new FormData(form);

        $.ajax({
            url: base_jsurl + 'chat/send_msg',
            type: 'post',
            datatype: 'json',
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
                if (data == true) {
                    window.location.reload();

                }
            }
        });
    });



    var locpath = window.location.pathname.split("/");
    //console.log(locpath);
    if (locpath[2] === "subadmin") {
        $(".list li").removeClass("active");
        $(".usermenu").addClass("active");
        $(".usermenu").addClass("open");
        $(".usermenu ul").css("display", "block");
        $(".usermenu li").addClass("active");
    } else if (locpath[2] === "clinic") {
        $(".list li").removeClass("active");
        $(".clinicmenu").addClass("active");
        $(".clinicmenu").addClass("open");
        $(".clinicmenu ul").css("display", "block");
        $(".clinicmenu li").addClass("active");
    } else if (locpath[2] === "doctors") {
        $(".list li").removeClass("active");
        $(".docmenu").addClass("active");
        $(".docmenu").addClass("open");
        $(".docmenu ul").css("display", "block");
        $(".docmenu li").addClass("active");
    } else if (locpath[2] === "users") {
        $(".list li").removeClass("active");
        $(".patmenu").addClass("active");
        $(".patmenu").addClass("open");
        $(".patmenu ul").css("display", "block");
        $(".patmenu li").addClass("active");
    } else if (locpath[2] === "dentistry") {
        $(".list li").removeClass("active");
        $(".dentmenu").addClass("active");
        $(".dentmenu").addClass("open");
        $(".dentmenu ul").css("display", "block");
        $(".dentmenu li").addClass("active");
    } else if (locpath[2] === "braces") {
        $(".list li").removeClass("active");
        $(".bracesmenu").addClass("active");
        $(".bracesmenu").addClass("open");
        $(".bracesmenu ul").css("display", "block");
        $(".bracesmenu li").addClass("active");
    } else if (locpath[2] === "offers") {
        $(".list li").removeClass("active");
        $(".spoffermenu").addClass("active");
        $(".spoffermenu").addClass("open");
        $(".spoffermenu ul").css("display", "block");
        $(".spoffermenu li").addClass("active");
    } else if (locpath[2] === "appointment") {
        $(".list li").removeClass("active");
        $(".apptmenu").addClass("active");
        $(".apptmenu").addClass("open");
        // $(".apptmenu ul").css("display", "block");
        // $(".apptmenu li").addClass("active");
    }


    /////multiple select clinic///
    $('#dotor_clinic_id').multiselect({
        nonSelectedText: 'Select Office',
        enableFiltering: true,
        enableCaseInsensitiveFiltering: true,
        buttonWidth: '400px'
    });

    $('#doct_clinic_id').multiselect({
        nonSelectedText: 'Select Office',
        enableFiltering: true,
        enableCaseInsensitiveFiltering: true,
        buttonWidth: '400px'
    });

    $('#dotor').multiselect({
        nonSelectedText: 'Select Doctor',
        enableFiltering: true,
        enableCaseInsensitiveFiltering: true,
        buttonWidth: '400px'
    });


    $('#dotors').multiselect({
        nonSelectedText: 'Select Doctor',
        enableFiltering: true,
        enableCaseInsensitiveFiltering: true,
        buttonWidth: '400px'
    });

    $('#adddoctor').click(function() {
        $.ajax({
            url: base_jsurl + 'doctors/add_doctor',
            type: 'post',
            datatype: 'json',
            success: function(data) {
                if (data == true) {
                    swal("Added", "All Doctors Added Successfully", "success")
                    setTimeout(function() {
                        window.location.reload();

                    }, 2000);

                } else {
                    swal('Added', 'All Doctors are Already Added', 'warning');
                    setTimeout(function() {
                        window.location.reload();

                    }, 2000);
                }
            }
        });
    });

    ////Patient add from old Database///
    $('#export').click(function() {
        $.ajax({
            url: base_jsurl + 'users/export',
            type: 'post',
            datatype: 'json',
            success: function(data) {
                if (data == true) {
                    // swal("Added", "All Patient Added Successfully", "success")
                    // setTimeout(function() {
                    window.location.reload();

                }


            }
        });
    });


    $('#emergency_table').DataTable({
        "processing": true,
        "serverSide": true,
        "searching": true,
        "bInfo": false,
        "order": [],
        "ajax": {
            "url": base_jsurl + 'emergency/fetchEmergency',
            "type": "POST",
            'data': { "id": $("#emergency_table").attr("data-id") }
        },
        "columnDefs": [{
            "targets": [0, 7, 8],


            "orderable": false
        }]

    });
    $('#emergency_table_pend').DataTable({
        "processing": true,
        "serverSide": true,
        "searching": true,
        "bInfo": false,
        "order": [],
        "ajax": {
            "url": base_jsurl + 'emergency/fetchEmergencyPend',
            "type": "POST",
            'data': { "id": $("#emergency_table_pend").attr("data-id") }
        },
        "columnDefs": [{
            "targets": [0, 7, 8],

            "orderable": false
        }]

    });
    $('#emergency_table_dec').DataTable({
        "processing": true,
        "serverSide": true,
        "searching": true,
        "bInfo": false,
        "order": [],
        "ajax": {
            "url": base_jsurl + 'emergency/fetchEmergencyDec',
            "type": "POST",
            'data': { "id": $("#emergency_table_dec").attr("data-id") }
        },
        "columnDefs": [{
            "targets": [0, 7, 8],
            "orderable": false
        }]

    });




    ////Emergency Fix////
    $('#emergencyfix').submit(function(e) {
        e.preventDefault();
        var form = $('#emergencyfix')[0];
        var formData = new FormData(form);
        $(".demo-preloader").css("display", "block");
        $("input").prop('disabled', true);


        $.ajax({
            url: base_jsurl + 'emergency/fixEmergency',
            type: 'post',
            datatype: 'json',
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
                console.log(data);
                if (data == true) {
                    $(".demo-preloader").css("display", "none");
                    $("input").prop('disabled', false);
                    swal("Updated!", "Emergency Fixed Updated Successfully.", "success")
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);

                } else if (data == false) {
                    $(".demo-preloader").css("display", "none");
                    $("input").prop('disabled', false);
                    alert('doctor alreday booked on this time ');
                }
            }
        });
    });


    /////Emergency Cancel////
    $('#emergencycancel').submit(function(e) {
        e.preventDefault();
        var form = $('#emergencycancel')[0];
        var formData = new FormData(form);

        $.ajax({
            url: base_jsurl + 'emergency/cancelEmergency',
            type: 'post',
            datatype: 'json',
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
                if (data == true) {

                    swal("Cancel!", "Emergency Cancel Successfully.", "success")
                    setTimeout(function() {
                        window.location.reload();

                    }, 2000);

                }
            }
        });
    });


    // Cancel Emergency Button //
    $(document).on("click", '.cancel_emergency', function() {
        var id = $(this).attr("id");
        swal({
                title: "Alert",
                text: "Are you sure want to cancel this Emergency Appointment?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            },
            function(inputValue) {
                if (inputValue === true) {
                    $.ajax({
                        // url: base_jsurl + 'appointment/cancelAppointment',
                        url: base_jsurl + 'emergency/cancelEmergency',
                        type: 'POST',
                        data: { id: id },
                        success: function(data) {
                            if (data == true) {
                                window.location.reload();

                            }
                        }
                    })
                }
            });
    })



    //Edit Dentistry popup//
    $(document).on('click', '.notification', function() {
        var id = $(this).attr("id");
        // alert(id);

        $('#notification').modal('show');

        $('#id').val(id);

        if ($(".notification").attr("atr") == "pushoff") {
            $("#notificationState").text("This Patient set the Notifications Off");
        } else {
            $("#notificationState").text("");
        }


    });


    $('#notoification_form').submit(function(e) {
        e.preventDefault();
        var form = $('#notoification_form')[0];
        var formData = new FormData(form);
        $(".demo-preloader").css("display", "block");
        $("input").prop('disabled', true);

        $.ajax({
            url: base_jsurl + 'appointment/sendnotification',
            type: 'post',
            datatype: 'json',
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {
                if (data == true) {

                    swal("Success!", "Notification send Successfully.", "success")
                    setTimeout(function() {
                        window.location.reload();

                    }, 2000);

                }
            }
        });
    });








});