<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Staff's Login/Logout</title>
    <!-- <link rel="icon" href="<?php echo base_url('assets/img/Ojt-ID_BACK.jpg'); ?>"> -->
	<!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url('node_modules/bootswatch/dist/flatly/bootstrap.css'); ?>"> -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('src/css/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('src/datatables/css/jquery.dataTables.min.css'); ?>">
    <!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url('src/datatables/css/dataTables.bootstrap.min.css'); ?>"> -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/Fonts/font-awesome-4.7.0/css/font-awesome.min.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('src/css/style.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('src/css/service.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('src/sweetalert/dist/sweetalert.css'); ?>">
    <script src="<?php echo base_url('src/sweetalert/dist/sweetalert.min.js'); ?>"></script>
    <!-- <script src="<?php echo base_url('src/sweetalert/dist/sweetalert-dev.min.js'); ?>"></script> -->
    <script src="<?php echo base_url('src/script/js/jquery-3.3.1.min.js'); ?>"></script>
    <script src="<?php echo base_url('src/datatables/css/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?php echo base_url('src/datatables/js/dataTables.bootstrap.min.js'); ?>"></script>
    <script src="<?php echo base_url('src/script/js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo base_url('src/script/jquery/my_js.js'); ?>"></script>
</head>
<body style="background-color: #fff;">
    <div id="myNavbar" class="navbar navbar-default navbar-fixed-top top__wrapper" role="navigation">
        <div class="top_logo">
            <div class="container logo">
                <h1 style="color: #fff; text-align: center;">College of Computer Studies and Information Technology</h1>
            </div>
        </div>
        <div class="container bar">  
            <a href="#" class='navbar-brand text-center'>Staffs Log</a>
            <!-- <div class="navbar-right" id="align" align="right">
                <a href="<?php echo base_url('/pages/attendance/attendance-monitoring'); ?>" class="btn btn__reg"
                style='position: relative; right: 24.7rem;'>BORROWED KEYS</a>
                <a href="<?php echo base_url('/pages/index'); ?>" 
                style="margin-right: 5px; position: relative; top: -33px;" class="btn btn__reg">BORROW KEY</a>
                <a href="<?php echo base_url('/pages/return'); ?>" class="btn btn__login"
                style="position: relative; margin-top: -55px;">RETURN KEY</a>
            </div> -->
        </div>
    </div>
	
    <div class="container-fluid login" style="margin-top: -30px;">
        <div class="container">
            <div class="col-md-6 col-md-offset-3 errors"></div>
            <form method="post">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 parent">
                        <div class="belt">
                            <div class="login_form"> 
                                <div class="form-control email__holder">
                                    <input type="text" name="emp_id" id="emp_id" class="form-control email__input" placeholder="Employee ID">
                                    <!-- <i class="fa fa-envelope"></i> -->
                                </div>
                                <div class="form-control password__holder">
                                    <input type="password" name="password" id="password" class="form-control password__input" placeholder="Password">
                                    <!-- <i class="fa fa-key"></i> -->
                                </div>
                                <select class="form-control" name="dest" id="dest" style="height: 40px;">
                                    <option value=''>Staff's Whereabout</option>
                                    <option value="Faculty Room">Faculty Room</option>
                                    <option value="Dean's Office">Dean's Office</option>
                                    <option value="Other Office">Other Office</option>
                                    <option value="Break Time">Break Time</option>
                                    <option value="Out">Out</option>
                                </select>
                                <div align="center">
                                    <button type="submit" name="save" id="save" class="btn__register login" style="margin-left: 0px !important;"> LOGIN</button>
                                </div>
                                <div class="forgot" align="center">
                                    <!-- <a href="#">Forget password?</a> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </form>
        </div>
        <p class="text-center" id="footer" style="margin-top: 50px;">&COPY; CCSIT&nbsp;-&nbsp;All Rights Reserved 2020</p>
        <p class="text-center" id="footer" style="">Developed By: Dr. Alex C. Bacalla - (Microcontroller) and Benigno E. Ambus Jr. - (Application)</p>
    </div>

    <script>
        $(document).ready(function(){
            $('#save').click(function(event){
                event.preventDefault();
                const set = 'staffs_log';
                const id = $('#emp_id').val();
                const pass = $('#password').val();
                var dest = $('#dest').val();
                var in_out = '', events = '', ref = '';
                if(id != '' && pass != '' && dest != ''){
                    if(dest == 'Out' || dest == 'Break Time')
                    {
                        in_out = '2';
                        events = (dest == 'Out' ? 'Out' : 'Break Time');
                    }
                    else{
                        in_out = '1';
                        events = 'On-Duty';
                    }
                    $.ajax({
                        url: '<?php echo base_url(); ?>user/staffs_log',
                        type: 'POST',
                        data: {
                            id   : id,
                            pass : pass,
                            dest : dest,
                            set  : set,
                            in_out : in_out,
                            events : events
                        },
                        success:function(data){
                            const log_oObj = JSON.parse(data);
                            console.log(log_oObj);
                            if(log_oObj.login == true){
                                swal(
                                    {
                                        title: "Thank You !",
                                        text : log_oObj.msg ,
                                        type : "success",
                                        showCancelButton  : false,
                                        showConfirmButton : true,
                                        confirmButtonColor: "#DD6B55",
                                        confirmButtonText : "OK",
                                        cancelButtonText  : "",
                                        closeOnConfirm    : true,
                                        closeOnCancel     : false 
                                    }
                                );
                                $('#dest').val("");
                                $('#emp_id').val("");
                                $('#password').val("");
                            }
                            else{
                                swal(
                                    {
                                        title: "Sorry!",
                                        text : log_oObj.msg,
                                        type : "info",
                                        showCancelButton  : false,
                                        confirmButtonColor: "#DD6B55",
                                        confirmButtonText : "Ok",
                                        cancelButtonText  : "",
                                        closeOnConfirm    : true,
                                        closeOnCancel     : false 
                                    }
                                );
                            }
                        }
                    });
                }
                else{
                    swal(
                        {
                            title: "Authentication invalid",
                            text : 'All fields are required!',
                            type : "warning",
                            showCancelButton  : false,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText : "OK",
                            cancelButtonText  : "",
                            closeOnConfirm    : true,
                            closeOnCancel     : false 
                        }
                    );
                }
            });
        });
    </script>

</body>
</html>