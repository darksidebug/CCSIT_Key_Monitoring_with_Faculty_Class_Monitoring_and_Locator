<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv='refresh' content='25'>
    <title>Locator Chart</title>
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

<div style="width: 100%; background-color: #fff; height: 100%;">
    <div class="container-fluid" style="margin-top: 0px;">
    <!-- <h2 id='head' style="text-align: center; letter-spacing: 0.07rem; font-family: Lucida Bright; color: rgba(0, 0, 255, 0.7);">SOUTHERN LEYTE STATE UNIVERSITY MAIN-CAMPUS</h2> -->
    <h4 style="font-size: 20px; text-align: center; letter-spacing: 0.15rem; color: #000; padding-top: 10px;">College of Computer Studies and Information Technology</h4>
    <h5 href="#" class='text-center' style='padding-bottom: 0px; padding-top: 0px; letter-spacing: 0.15rem; text-transform: uppercase; color: #000;'>Faculty  and  Staff  &nbsp;<span style='color: red;'>E</span>-Locator   Board</h5>
        <div class="row">
            <div class="col-md-12">
                <table id="tbl-attendance" class="table table-hover table-striped table-condensed table-bordered" >
                    <thead style='color: #fff; background-color: rgba(0, 0, 255, 0.6);'>
                        <tr>
                            <td style='font-size: 15px; letter-spacing: 0.05rem;'>EMPLOYEE NAME</td>
                            <td class='text-center' style='font-size: 15px;'>IN</td>
                            <td class='text-center' style='font-size: 15px;'>OUT</td>
                            <td class='text-center' style='font-size: 15px; letter-spacing: 0.05rem;'>ON TRAVEL</td>
                            <td class='text-center' style='font-size: 15px; letter-spacing: 0.05rem;'>ON LEAVE</td>
                            <td class='text-center' style='font-size: 15px; letter-spacing: 0.05rem;'>ON MEETING</td>
                            <td class='text-center' style='font-size: 15px; letter-spacing: 0.05rem;'>ON CLASS</td>
                            <!-- <td class='text-center' style='font-size: 15px; letter-spacing: 0.05rem;'>LOCATION</td> -->
                            <td class='text-center' style='font-size: 15px; letter-spacing: 0.05rem;'>OTHER OFFICE</td>
                            <!-- <td class='text-center' style='font-size: 15px; letter-spacing: 0.05rem;'>BREAK TIME/OUT</td> -->
                            <td style='font-size: 15px; letter-spacing: 0.05rem;'>LOCATION</td>
                            <td style='font-size: 15px; letter-spacing: 0.05rem;'>DATE</td>
                        </tr>
                    </thead>
                    <tbody>
                        <input class='date' type="hidden" name="time" id='time' value='<?= date('H'); ?>'>
                        <?php
                            $i = 0;
                            if($name['result'] == TRUE && !empty($name['result_data'])){
                                foreach($name['result_data'] as $row_data => $value){
                                    
                                    foreach ($value->name as $key => $user) {
                                        $i++;
                                        if(($value->college == 'CCSIT') || ($value->college == 'Other' && $user->in_out != 2))
                                        {
                                            ?>
                                                <tr>
                                                    <input type="hidden" name="time" id='time' value='<?= date('H:i:s'); ?>'>
                                                    <td><?= $value->borrower_name; ?>
                                                        
                                                        <?php
                                                            if($user->event === 'On-Leave' || $user->event === 'On-Travel')
                                                            {
                                                                ?><input class='user_id' type="hidden" name="user_id[]" id='user_id' value='<?= $user->user_id; ?>'><?php
                                                            }
                                                        ?>
                                                    </td>
                                                    <td align='center'>
                                                        <?php
                                                            if($user->in_out == 1)
                                                            {
                                                                ?>
                                                                    <div style='height: 15px; width: 15px;
                                                                        border-radius: 15px; background-color: green;'></div>
                                                                <?php
                                                            }
                                                        ?>
                                                    </td>
                                                    <td align='center'>
                                                        <?php
                                                            if($user->in_out == 2)
                                                            {
                                                                ?>
                                                                    <div style='height: 15px; width: 15px;
                                                                        border-radius: 15px; background-color: red;'></div>
                                                                <?php
                                                            }
                                                        ?>
                                                    </td>
                                                    <td align='center'><?php
                                                            if($user->event == 'On-Travel' && $user->in_out == 2){
                                                                ?>
                                                                    <div style='height: 15px; width: 15px;
                                                                        border-radius: 15px; background-color: rgba(0, 0, 255, 0.7);'></div>
                                                                <?php
                                                            }
                                                        ?>
                                                        <input class='event' type="hidden" name="event[]" id='event' value='<?php 
                                                            if($user->event == 'On-Travel' && $user->in_out == 2)
                                                            {
                                                                echo $user->event;
                                                            }
                                                        ?>'>
                                                    </td>
                                                    <td align='center'><?php
                                                            if($user->event == 'On-Leave' && $user->in_out == 2){
                                                                ?>
                                                                    <div style='height: 15px; width: 15px;
                                                                        border-radius: 15px; background-color: rgba(0, 0, 255, 0.7);'></div>
                                                                <?php
                                                            }
                                                        ?>
                                                        <input class='event' type="hidden" name="event[]" id='event' value='<?php 
                                                            if($user->event == 'On-Leave' && $user->in_out == 2)
                                                            {
                                                                echo $user->event;
                                                            }
                                                        ?>'>
                                                    </td>
                                                    <td align='center'><?php
                                                            if($user->event == 'On-Meeting' && $user->in_out == 2){
                                                                ?>
                                                                    <div style='height: 15px; width: 15px;
                                                                        border-radius: 15px; background-color: rgba(0, 0, 255, 0.7);'></div>
                                                                <?php
                                                            } 
                                                        ?>
                                                    </td>
                                                    <td align='center'><?php
                                                            if($user->event == 'On-Class'){
                                                                ?>
                                                                    <div style='height: 15px; width: 15px;
                                                                        border-radius: 15px; background-color: rgba(0, 0, 255, 0.7);'></div>
                                                                <?php
                                                            }
                                                        ?>
                                                    </td>
                                                    <td align='center'><?php
                                                            if($user->event == 'Other Office' || $user->event == 'GIS Tech Center'){
                                                                ?>
                                                                    <div style='height: 15px; width: 15px;
                                                                        border-radius: 15px; background-color: rgba(0, 0, 255, 0.7);'></div>
                                                                <?php
                                                            }
                                                        ?>
                                                    </td>
                                                    <td><?php
                                                            if(($user->event == 'On-Leave') || ($user->event == 'On-Travel')){
                                                                echo '';
                                                            }
                                                            else{
                                                                echo $user->room_office;
                                                            }
                                                        ?></td>
                                                    <td><?= $user->date; ?>

                                                    </td>
                                                </tr>
                                            <?php
                                        }
                                    }
                                }
                            }
                            // 
                        ?>
                    
                        <input type="hidden" id='count' value="<?= $i; ?>">
                    </tbody>
                    <!-- <tfoot>
                        <tr>
                            <th>Employee Name</th>
                            <th>In</th>
                            <th>Out</th>
                            <th>Event</th>
                            <th>Location</th>
                            <th>Time</th>
                            <th>Date</th>
                        </tr>
                    </tfoot> -->
                </table>
            </div>
        </div>
        <!-- // <p class="text-center" id="footer" style="margin-top: 0px;">&COPY; CCSIT&nbsp;-&nbsp;All Rights Reserved 2020</p> -->
        <p class="text-center" id="footer" style="margin-top: -5px;">Developed By: Dr. Alex C. Bacalla - (Microcontroller) and Benigno E. Ambus Jr. - (Application)</p>
    </div>
</div>
<script>
    $(document).ready(function(){

        

        if($('#time').val() == '07') {
            update_locator();
        }
        else{
            return false;
            break;
        }
        
        function update_locator(){
            var events = [], user_id = [], date = '';

            date = $('#date').val();
                
            $('.event').each(function(){
                if($(this).val() != '')
                {
                    events.push($(this).val());
                }
            });
            $('.user_id').each(function(){
                if($(this).val() != '')
                {
                    user_id.push($(this).val());
                }
            });
            
            const update = 'update';
            $.ajax({
                url: '<?php echo base_url("User/update_event"); ?>',
                type: 'POST',
                data: {
                    update  : update,
                    user_id : user_id,
                    events  : events,
                    date    : date
                },
                success:function(data){
                    const log_oObj = JSON.parse(data);
                    console.log(log_oObj);
                    if(log_oObj.save == true){
                        console.log(log_oObj);
                    }
                    else{
                        console.log(log_oObj);
                    }
                } 
            });
        }
    });
</script>
</body>
</html>