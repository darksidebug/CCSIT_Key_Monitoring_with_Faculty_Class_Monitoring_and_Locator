
    <div class="container-fluid login" style="margin-top: -30px;">
        <div class="container">
            <div class="col-md-6 col-md-offset-3 errors"></div>
            <form method="post">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 parent">
                        <div class="belt">
                            <div class="login_form"> 
                                <select class="form-control" name="faculty" id="faculty" style="height: 40px;">
                                    <option value=''>Select Faculty Name</option>
                                    <?php
                                        foreach ($faculty as $key => $value) {
                                            ?>
                                                <option value="<?= $value->borrower_name; ?>"><?= $value->borrower_name; ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                                <select class="form-control" name="dest" id="dest" style="height: 40px;">
                                    <option value=''>Faculty Whereabout</option>
                                    <option value="Faculty Room">Faculty Room</option>
                                    <option value="Dean's Office">Dean's Office</option>
                                    <option value="GIS Tech Center">GIS Tech Center</option>
                                    <option value="On-Leave">On-Leave</option>
                                    <option value="On-Meeting">On-Meeting</option>
                                    <option value="On-Travel">On-Travel</option>
                                    <option value="Other Office">Other Office</option>
                                    <option value="Out">Out</option>
                                </select>
                                <div align="center">
                                    <button type="submit" name="save" id="save" class="btn__register login" style="margin-left: 0px !important;"> SAVE</button>
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
                const set = 'locator';
                const faculty = $('#faculty').val();
                var dest = $('#dest').val();
                var ref = '', in_out = '', events = '', room = '';
                if(faculty != '' && dest != ''){
                    if(dest == 'Out')
                    {
                        ref = '1';
                        in_out = '2';
                        events = 'Out';
                        room = '';
                    }
                    else if(dest == 'On-Travel')
                    {
                        ref = '1';
                        in_out = '2';
                        events = 'On-Travel';
                        room = '';
                    }
                    else if(dest == 'On-Leave')
                    {
                        ref = '1';
                        in_out = '2';
                        events = 'On-Leave';
                        room = '';
                    }
                    else{
                        ref ='1';
                        in_out = '1';
                        events = dest;
                        room = dest;
                    }
                    $.ajax({
                        url: '<?php echo base_url(); ?>user/set_locator',
                        type: 'POST',
                        data: {
                            faculty  : faculty,
                            dest     : dest,
                            set      : set,
                            ref      : ref,
                            in_out   : in_out,
                            events   : events,
                            room     : room
                        },
                        success:function(data){
                            const log_oObj = JSON.parse(data);
                            console.log(log_oObj);
                            if(log_oObj.save == true){
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
                                $('#faculty').val("");
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