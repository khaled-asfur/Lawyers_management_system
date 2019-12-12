$(document).ready(function () {


    
    $("#save").click(function () {
        //	var identity_number = document.getElementById("customer_identiy_number").innerhtml.value();
       var office_name=$("#office_name").val();


        if (office_name.trim() == "" ) {
            show_fail_message("يجب ادخال جميع البيانات المطلوبة");
        } else {
            $.ajax({
                url: "../php/settings_operations.php",
                type: "POST",
                data: {  "office_name": office_name, "operation": "change_user_settings" },
                success: function (data) {
                    var obj = JSON.parse(data);
                    var message = obj.message;
                    if (message == "office name updated") {
                        show_success_message("تم التعديل بنجاح  ");
                       
                    } else {
                        show_fail_message("لم يتم التعديل ");
                    }
                }
            });
        }
    });
    $("#save_password").click(function () {
        //	var identity_number = document.getElementById("customer_identiy_number").innerhtml.value();
        var old_pass = $("#old_password").val();
        var new_pass = $("#new_password").val();
        var confirm_pass = $("#confirm_new_password").val();

        if (confirm_pass.trim() == "" || new_pass.trim() == "" || old_pass.trim() == "") {
            show_password_fail_message("يجب ادخال جميع البيانات المطلوبة");
        } else {
            $.ajax({
                url: "../php/settings_operations.php",
                type: "POST",
                data: {  "old_pass": old_pass, "new_pass": new_pass, "confirm_pass": confirm_pass,  "operation": "change_user_pass" },
                success: function (data) {
                    var obj = JSON.parse(data);
                    var message = obj.message;
                    if (message == "تم تعديل كلمة السر") {
                        show_password_success_message(message);
                    } else {
                        show_password_fail_message(message);
                    }
                }
            });
        }
    });
    var confirm_pass_changed = 0;
    $("#new_password").keyup(function () {
        
            var pass1 = $("#confirm_new_password").val();
            var pass2 = $("#new_password").val();
            if (pass1.trim()!="") {
            if (pass1 === pass2) {
                show_password_success_message("كلمتا السر متطابقتان");
            } else {
                show_password_fail_message("كلمتا السر غير متطابقتان");
            }
        }
    });
    $("#confirm_new_password").keyup(function () {
        var pass1 = $("#confirm_new_password").val();
        var pass2 = $("#new_password").val();
        if(pass2.trim()!=""){
        if (pass1 === pass2) {
            show_password_success_message("كلمتا السر متطابقتان");
        } else {
            show_password_fail_message("كلمتا السر غير متطابقتان");
        }
    }
    });

    /* password success and error dialogs */
    function show_password_success_message(message) {
        $("#password_show_success_msg").html(message);
        $('#password_error_dialog').css('display', 'none');
        $('#password_success_dialog').css('display', 'block');
    }

    function show_password_fail_message(message) {
        $("#password_show_Error").html(message);
        $('#password_success_dialog').css('display', 'none');
        $('#password_error_dialog').css('display', 'block');
    }
    $(".close_pass_success_dialog").click(function () {
        $('#password_success_dialog').css('display', 'none');
    });
    $(".close_pass_fail_dialog").click(function () {
        $('#password_error_dialog').css('display', 'none');
    });

    /*  The other success and fail dialogs*/
    function show_success_message(message) {
        $("#show_success_msg").html(message);
        $('#error_dialog').css('display', 'none');
        $('#success_dialog').css('display', 'block');
    }

    function show_fail_message(message) {
        $("#show_Error").html(message);
        $('#success_dialog').css('display', 'none');
        $('#error_dialog').css('display', 'block');
    }
    $(".close_success_dialog").click(function () {
        $('#success_dialog').css('display', 'none');
    });
    $(".close_fail_dialog").click(function () {
        $('#error_dialog').css('display', 'none');
    });

});