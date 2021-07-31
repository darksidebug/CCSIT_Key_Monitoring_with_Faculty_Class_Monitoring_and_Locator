
    <div class="container-fluid login" style='margin-top: -50px;'>
        <div class="container">
            <div class="col-md-6 col-md-offset-3 errors"></div>
            <form method="post">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 parent">
                        <div class="belt">
                            <div class="login_form"> 
                                <select class="form-control" name="dept" id="dept" style="height: 40px;">
                                    <option>Select College/Department</option>
                                    <option value="CCSIT">CCSIT</option>
                                    <option value="Other">Other</option>
                                </select>
                                <div class="form-control email__holder">
                                    <input type="text" name="emp_id" id="emp_id" class="form-control email__input" placeholder="Employee ID">
                                    <!-- <i class="fa fa-envelope"></i> -->
                                </div>
                                <div class="form-control email__holder">
                                    <input type="text" name="emp_name" id="emp_name" class="form-control email__input" placeholder="Employee Name">
                                    <!-- <i class="fa fa-envelope"></i> -->
                                </div>
                                <div class="form-control password__holder">
                                    <input type="password" name="password" id="password" class="form-control password__input" placeholder="Password">
                                    <!-- <i class="fa fa-key"></i> -->
                                </div>
                                <div class="form-control password__holder">
                                    <input type="password" name="cfm_password" id="cfm_password" class="form-control password__input" placeholder="Confirm Password">
                                    <!-- <i class="fa fa-key"></i> -->
                                </div>
                                <div align="center">
                                    <button type="submit" name="login" id="login" class="btn__register login" style="margin-left: 0px !important;"><!---<i class="fa fa-lock"></i>&nbsp;--> SAVE</button>
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
            $('#login').click(function(event){
                event.preventDefault();
                const register = 'register';
                const emp_id = $('#emp_id').val();
                const password = $('#password').val();
                const emp_name = $('#emp_name').val();
                const cfm_password = $('#cfm_password').val();
                const dept_allowed = $('#dept').val();
                var dept = '';
                if(emp_id != '' && password != '' && emp_name != '' && cfm_password != "" && dept_allowed !== ''){
                    if(password == cfm_password)
                    {
                        if(emp_id.length <= 3)
                        {
                            dept = dept_allowed;
                        }
                        else
                        {
                            dept = '';
                        }
                        $.ajax({
                            url: '<?php echo base_url("User/register"); ?>',
                            type: 'POST',
                            data: {
                                emp_id   : emp_id,
                                password : password,
                                register : register,
                                emp_name : emp_name,
                                dept     : dept
                            },
                            success:function(data){
                                const log_oObj = JSON.parse(data);
                                console.log(log_oObj);
                                if(log_oObj.register == true){
                                    swal(
                                        {
                                            title: "Successfull",
                                            text : log_oObj.msg,
                                            type : "success",
                                            showCancelButton  : false,
                                            confirmButtonColor: "#DD6B55",
                                            confirmButtonText : "OK",
                                            cancelButtonText  : "",
                                            closeOnConfirm    : true,
                                            closeOnCancel     : false 
                                        }
                                    );

                                    $('#emp_id').val("");
                                    $('#password').val("");
                                    $('#emp_name').val("");
                                    $('#cfm_password').val("");
                                    $('#dept').val("");
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
                            title: "Invalid !",
                            text : 'Password did not match.',
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