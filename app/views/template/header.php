<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CCSIT ROOM KEYS MONITORING</title>
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
                <h1 style="color: #fff;">College of Computer Studies and Information Technology</h1>
            </div>
        </div>
        <div class="container bar">  
            <a href="#" class='navbar-brand'>ROOM KEYS AND FACULTY CLASS MONITORING</a>
            <div class="navbar-right" id="align" align="right">
                <a href="<?php echo base_url('/pages/attendance/attendance-monitoring'); ?>" class="btn btn__reg"
                style='position: relative; right: 24.7rem;'>BORROWED KEYS</a>
                <a href="<?php echo base_url('/pages/index'); ?>" 
                style="margin-right: 5px; position: relative; top: -33px;" class="btn btn__reg">BORROW KEY</a>
                <a href="<?php echo base_url('/pages/return'); ?>" class="btn btn__login"
                style="position: relative; margin-top: -55px;">RETURN KEY</a>
            </div>
        </div>
    </div>
	