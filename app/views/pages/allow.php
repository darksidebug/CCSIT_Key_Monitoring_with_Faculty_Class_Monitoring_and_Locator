
    <div class="container-fluid login" style="margin-top: -30px; margin-bottom: 30px;">
        <div class="container">
            <div class="col-md-6 col-md-offset-3 errors"></div>
            <form method="post" id="form_data">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 parent">
                        <div class="belt">
                            <div class="login_form"> 
                                <select class="form-control" name="overdue" id="overdue" style="height: 40px;">
                                    <option>Overdue Keys</option>
                                    <?php
                                        foreach($return_allow as $value)
                                        {
                                            ?>
                                                <option value="<?= $value->Room_Key ?>"><?= $value->Room_Key ?></option>
                                            <?php
                                        }
                                    ?>
                                </select> 
                                <div class="form-control email__holder">
                                    <input type="text" name="emp_name" id="emp_name" class="form-control email__input" placeholder="Employee Name">
                                    <!-- <i class="fa fa-envelope"></i> -->
                                </div>
                                <div class="form-control email__holder">
                                    <input type="text" name="emp_id" id="emp_id" class="form-control email__input" placeholder="Authorized ID">
                                    <!-- <i class="fa fa-envelope"></i> -->
                                </div>
                                <div class="form-control password__holder">
                                    <input type="password" name="password" id="password" class="form-control password__input" placeholder="Authorized Password">
                                    <!-- <i class="fa fa-key"></i> -->
                                </div>
                                <div align="center">
                                    <button type="submit" name="login" id="login" class="btn__register login" style="margin-left: 0px !important;"><!---<i class="fa fa-lock"></i>&nbsp;--> RETURN AND ALLOW</button>
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
        $(document).on('change', '#overdue', function(){
            var key = $('#overdue').val();
            var remarks = "overdue";
            var status = "borrowed";
            if(key != "")
            {
                $.ajax({
                    url: '<?php echo base_url("User/getBorrowOverdue"); ?>',
                    type: 'POST',
                    data: { 
                        key : key,
                        remarks : remarks,
                        status : status
                    },
                    success:function(data){
                        const log_oObj = JSON.parse(data);
                        if(log_oObj.data_set == true)
                        {
                            $("#emp_name").val(log_oObj.name);
                        }
                    }
                })
            }
        })

        $(document).ready(function(){
            $('#login').click(function(event){
                event.preventDefault();
                const emp_name = $('#emp_name').val();
                var key = $('#overdue').val();
                var status = 'borrowed';
                var id = $('#emp_id').val();
                var pass = $('#password').val();
                if(emp_name != '' && key != '' && id != '' & pass != ''){
                    $.ajax({
                        url: '<?php echo base_url("User/allowBorrower"); ?>',
                        type: 'POST',
                        data: {
                            emp_name : emp_name,
                            key : key,
                            status : status,
                            id : id,
                            pass : pass
                        },
                        success:function(data){
                            const log_oObj = JSON.parse(data);
                            console.log(log_oObj);
                            if(log_oObj.return == true){
                                swal(
                                    {
                                        title: "Successfull",
                                        text : log_oObj.message,
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

                                setTimeout(() => {
                                    window.location = "<?php echo base_url("pages/return_allow/allow"); ?>";
                                }, 1000);
                            }
                            else{
                                swal(
                                    {
                                        title: "Sorry!",
                                        text : log_oObj.message,
                                        type : "info",
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