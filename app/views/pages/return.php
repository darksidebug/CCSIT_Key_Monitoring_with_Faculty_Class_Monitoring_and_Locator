
    <div class="container-fluid login" style="margin-top: -30px;">
        <div class="container">
            <div class="col-md-6 col-md-offset-3 errors"></div>
            <form method="post">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 parent">
                        <div class="belt">
                            <div class="login_form"> 
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
                                <select class="form-control" name="dest" id="dest" style="height: 40px;">
                                    <option value=''>Next Whereabout</option>
                                    <option value="Faculty Room">Faculty Room</option>
                                    <option value="Dean's Office">Dean's Office</option>
                                    <option value="GIS Tech Center">GIS Tech Center</option>
                                    <option value="Next Class">Next Class</option>
                                    <option value="On-Meeting">On-Meeting</option>
                                    <option value="Other Office">Other Office</option>
                                    <option value="Out">Out</option>
                                </select>
                                <div align="center">
                                    <button type="submit" name="return" id="return" class="btn__register login" style="margin-left: 0px !important;"><!---<i class="fa fa-lock"></i>&nbsp;--> RETURN</button>
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
            $('#return').click(function(event){
                event.preventDefault();
                const returned = 'keys';
                const emp_id = $('#emp_id').val();
                const password = $('#password').val();
                const keys = $('#keys').val();
                var dest = $('#dest').val();
                var in_out = '', events = '';
                console.log(emp_id.length);
                if(emp_id.length >= 4 && emp_id != '' && password != '' && keys != '')
                {
                        in_out = '2';
                        events = '';
                        ajax(in_out, events, returned, emp_id, dest, keys, password);
                }
                else if(emp_id.length <= 3 && emp_id != '' && password != '' && keys != '' && dest != ''){
                    if(dest == 'Out')
                    {
                        in_out = '2';
                        events = '';
                    }
                    else{
                        in_out = '1';
                        events = dest;
                    }
                    ajax(in_out, events, returned, emp_id, dest, keys, password);
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

            function ajax(in_out, events, returned, emp_id, dest, keys, password){
                $.ajax({
                    url: '<?php echo base_url("User/return"); ?>',
                    type: 'POST',
                    data: {
                        emp_id   : emp_id,
                        password : password,
                        returned : returned,
                        keys     : keys,
                        in_out   : in_out,
                        dest     : dest,
                        events   : events
                    },
                    success:function(data){
                        const log_oObj = JSON.parse(data);
                        console.log(log_oObj);
                        if(log_oObj.return == true){
                            swal(
                                {
                                    title: "Thank You !",
                                    text : log_oObj.msg ,
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
        });
    </script>

</body>
</html>