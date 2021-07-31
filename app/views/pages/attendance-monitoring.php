<div style="width: 100%; background-color: #fff; height: 100%;">
    <div class="container" style="padding-top: 170px;">
        <div class="row">
            <div class="col-md-12">
                <table id="tbl-attendance" class="table table-hover table-striped table-condensed" >
                    <thead>
                        <tr>
                            <th>Employee Name</th>
                            <th>Keys Borrowed</th>
                            <th>Time Borrowed</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if(!empty($employees))
                            {
                                foreach ($employees as $key => $value) {
                                    ?>
                                        <tr>
                                            <td><a href="<?= base_url('/pages/class_attendance/attendance-class-sched/'.$value->borrower); ?>"><?= $value->borrower; ?></a></td>
                                            <td><?= $value->Room_Key ?></td>
                                            <td><?= $value->Time_Borrowed ?></td>
                                            <td><?= date("D, M d Y"); ?></td>
                                        </tr>
                                    <?php
                                }
                            }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Employee Name</th>
                            <th>Keys Borrowed</th>
                            <th>Time Borrowed</th>
                            <th>Date</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <p class="text-center" id="footer" style="margin-top: 50px;">&COPY; CCSIT&nbsp;-&nbsp;All Rights Reserved 2020</p>
        <p class="text-center" id="footer" style="">Developed By: Dr. Alex C. Bacalla - (Microcontroller) and Benigno E. Ambus Jr. - (Application)</p>
</div>
<script>
    $(document).ready(function(){
        $("#tbl-attendance").DataTable();
    });
</script>
</body>
</html>