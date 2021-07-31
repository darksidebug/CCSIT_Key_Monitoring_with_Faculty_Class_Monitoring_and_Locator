
    <div class="container-fluid login" style="margin-top: -30px;">
        <div class="container">
            <div class="col-md-6 col-md-offset-3 errors"></div>
            <form method="post">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 parent">
                        <div class="belt">
                            <div class="login_form"> 
                                <select class="form-control" name="time_duration" id="time_duration" style="height: 40px;">
                                    <option>Class Hour Duration</option>
                                    <?php
                                        $time_allowed = '18:00:00';
                                        if(date('H:i:s') >= date('H:i:s', strtotime($time_allowed)))
                                        {
                                            ?>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                            <?php
                                        }
                                        else{
                                            ?>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                            <?php
                                        }
                                    ?>
                                </select> 
                                <select class="form-control" name="keys" id="keys" style="height: 40px;">
                                    <option>Room Keys</option>
                                    <?php
                                        foreach ($keys as $key => $value) {
                                            ?>
                                                <option value="<?= $value->room_keys; ?>"><?= $value->room_keys; ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                                <div class="form-control email__holder">
                                    <input type="text" name="emp_id" id="emp_id" class="form-control email__input" placeholder="Employee ID">
                                    <!-- <i class="fa fa-envelope"></i> -->
                                </div>
                                <div class="form-control password__holder">
                                    <input type="password" name="password" id="password" class="form-control password__input" placeholder="Password">
                                    <!-- <i class="fa fa-key"></i> -->
                                </div>
                                <div align="center">
                                    <button type="submit" name="login" id="login" class="btn__register login" style="margin-left: 0px !important;"><!---<i class="fa fa-lock"></i>&nbsp;--> BORROW</button>
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
                const borrow = 'users';
                const emp_id = $('#emp_id').val();
                const password = $('#password').val();
                const keys = $('#keys').val();
                const duration = $('#time_duration').val();
                if(emp_id != '' && password != '' && keys != '' && duration != ""){
                    $.ajax({
                        url: '<?php echo base_url("User/borrow"); ?>',
                        type: 'POST',
                        data: {
                            emp_id   : emp_id,
                            password : password,
                            borrow   : borrow,
                            keys     : keys,
                            duration : duration
                        },
                        success:function(data){
                            const log_oObj = JSON.parse(data);
                            console.log(log_oObj);
                            if(log_oObj.borrow == true){
                                swal(
                                    {
                                        title: "Successfull",
                                        text : log_oObj.msg,
                                        type : "success",
                                        showCancelButton  : false,
                                        showConfirmButton : false,
                                        confirmButtonColor: "#DD6B55",
                                        confirmButtonText : "OK",
                                        cancelButtonText  : "",
                                        closeOnConfirm    : true,
                                        closeOnCancel     : false 
                                    }
                                );

                                $('#emp_id').val("");
                                $('#password').val("");
                                $('#keys').val("");
                                $('#time_duration').val("");

                                if(keys == "CCSIT: ICT 1" || keys == "CCSIT: ICT 2" || keys == "CCSIT: ICT 3" || keys == "CCSIT: ICT 4" || 
                                keys == "CCSIT: ICT 5" || keys == "CCSIT: ICT 6" || keys == "CCSIT: ICT 7" || keys == "CCSIT: ICT 8")
                                {
                                    window.location.href = "http://192.168.240.1/arduino/digital/12/1";
                                    setTimeout(() => {
                                        window.location = "<?php echo base_url("pages/index"); ?>";
                                    }, 1000);
                                }
                                else if(keys == "CCSIT: Lab 1" || keys == "CCSIT: Lab 2" || keys == "CCSIT: Lab 3" || keys == "CCSIT: Lab 4" ||
                                keys == "CCSIT: Oracle Lab" || keys == "CCSIT: Faculty Office" || keys == "CCSIT: GIS Lab" || 
                                keys == "CCSIT: AVR Room" || keys == "CCSIT: Dean Office" || keys == "CCSIT: CISCO Lab")
                                {
                                    window.location.href = "http://192.168.240.1/arduino/digital/13/1";
                                    setTimeout(() => {
                                        window.location = "<?php echo base_url("pages/index"); ?>";
                                    }, 1000);
                                }
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