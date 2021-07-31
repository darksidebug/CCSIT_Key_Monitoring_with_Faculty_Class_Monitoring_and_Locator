<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Faculty Class Attendance</title>
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
    <div class="container-fluid">
        <div class="container-fluid">
            <h6 for="" class="text-right">Doc. Code: SLSU-QF-IN40</h6>
            <h6 for="" class="text-right" style="padding-right: 79px; margin-top: -8px;">Revision: 00</h6>
            <h6 for="" class="text-right" style="padding-right: 23px; margin-top: -8px;">Date: 20 October 2015</h6>
            <h5 class="text-center"><b>Republic Of the Philippines</h5>
            <h5 class="text-center" style="margin-top: -8px;"><b>SOUTHERN LEYTE STATE UNIVERSITY</h5>
            <h6 class="text-center" style="margin-top: -8px;">Main Campus, Sogod, Southern Leyte</h6></br>
            <h5 class="text-center" style="margin-top: -8px;"><b>College of Computer Studies and Information Technology</h5>
            <h5 class="text-center" style="letter-spacing: 1px;">FACULTY CLASS DAILY MONITORING</h5>
            <h5>Name of Faculty : <span style="font-weight: bold; letter-spacing: 1px; font-size: 18px;"></span></h5>
            <h5 style="margin-top: -8px;">Month of : 
                <select name="" id="" class="form-control" style="width: 150px; display: inline-block; border-top: none; 
                    border-left: none; border-right: none; border-radius: 0px; box-shadow: none;">
                    <option value=""><?= date("D M d Y") ?></option>
                    <option value="">January - <?= date("Y") ?></option>
                    <option value="">February - <?= date("Y") ?></option>
                    <option value="">March - <?= date("Y") ?></option>
                    <option value="">April - <?= date("Y") ?></option>
                    <option value="">May - <?= date("Y") ?></option>
                    <option value="">June - <?= date("Y") ?></option>
                    <option value="">July - <?= date("Y") ?></option>
                    <option value="">August - <?= date("Y") ?></option>
                    <option value="">September - <?= date("Y") ?></option>
                    <option value="">October - <?= date("Y") ?></option>
                    <option value="">November - <?= date("Y") ?></option>
                    <option value="">December - <?= date("Y") ?></option>
                </select>
            </h5>
            <table width="100%" style="border: 1px solid rgba(0,0,0, 0.2); margin-bottom: 50px;">
                <thead>
                    <tr rowspan="4">
                        <th width="5%" style="text-align: center; border-right: 1px solid rgba(0,0,0, 0.2);">DATE</th>
                        <th width="95%" style="border-right: 1px solid rgba(0,0,0, 0.2);">
                            <table class="table table-bordered" width="100%" style="margin-bottom: 0px; 
                                border-top: none; border-bottom: none; border-left: none !important;">
                                <tr style=" padding-bottom: 0px !important;">
                                    <th colspan="9" style="text-align: center; border: none !important;">TIME</th>
                                </tr>
                                <tr style="border-right: none;">
                                    <td colspan="5" class="text-center" style="border-left: none;">Morning Session</td>
                                    <td colspan="7" class="text-center" style="border-right: 0px !important;">Afternoon Session</td>        
                                </tr>
                                <tr>
                                    <td colspan="2" style="border-left: none;">Period 1</td>
                                    <td width="11.1%">Period 2</td>
                                    <td width="11.1%">Period 3</td>
                                    <td width="11.1%">Period 4</td>
                                    <td width="11.1%">Period 5</td>
                                    <td width="11.1%">Period 6</td>
                                    <td width="11.1%">Period 7</td>
                                    <td width="11.1%">Period 8</td>
                                    <td width="11.2%" style="border-right: none;">Period 9</td>
                                </tr>
                                <tr style="border: none;">
                                    <td colspan="2" style="border-left: none; border-bottom: none;">7:00 - 8:30</td>
                                    <td style="border-bottom: none;">8:30 - 10:00</td>
                                    <td style="border-bottom: none;">10:00 - 11:30</td>
                                    <td style="border-bottom: none;">11:30 - 1:00</td>
                                    <td style="border-bottom: none;">1:00 - 2:30</td>
                                    <td style="border-bottom: none;">2:30 - 4:00</td>
                                    <td style="border-bottom: none;">4:00 - 5:30</td>
                                    <td style="border-bottom: none;">5:30 - 7:00</td>
                                    <td style="border-bottom: none; border-right: none;">7:00 - 8:30</td>
                                </tr>
                            </table>
                        </th>
                    </tr>
                </thead>
                <tbody style="border-top: 1px solid rgba(0,0,0, 0.1);">
                    <?php
                        for($i = 1; $i < 32; $i++)
                        {
                            ?>
                                <tr style="border-bottom: 1px solid rgba(0,0,0, 0.2);">
                                    <td width="5%" style="border-right: 1px solid rgba(0,0,0, 0.2); border-bottom: none; text-align: center;
                                        height: 20px;"><?= $i ?></td>
                                    <td width="95%" style="border-bottom: none;">
                                        <table class="table" width="100%" style="margin-bottom: 0px; border: none !important;">
                                            <tr style="border-left: none; height: 20px;">
                                                <td colspan="2" style="border-right: 1px solid rgba(0,0,0, 0.2);border-top: none; border-bottom: none;">&nbsp;</td>
                                                <td width="11.1%" style="border-right: 1px solid rgba(0,0,0, 0.2);border-top: none; border-bottom: none;"></td>
                                                <td width="11.1%" style="border-right: 1px solid rgba(0,0,0, 0.2);border-top: none; border-bottom: none;"></td>
                                                <td width="11.1%" style="border-right: 1px solid rgba(0,0,0, 0.2);border-top: none; border-bottom: none;"></td>
                                                <td width="11.1%" style="border-right: 1px solid rgba(0,0,0, 0.2);border-top: none; border-bottom: none;"></td>
                                                <td width="11.1%" style="border-right: 1px solid rgba(0,0,0, 0.2);border-top: none; border-bottom: none;"></td>
                                                <td width="11.1%" style="border-right: 1px solid rgba(0,0,0, 0.2);border-top: none; border-bottom: none;"></td>
                                                <td width="11.1%" style="border-right: 1px solid rgba(0,0,0, 0.2);border-top: none; border-bottom: none;"></td>
                                                <td width="11.2%" style="border: none;"></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>                           
                            <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>