<?php
$link = mysqli_connect("localhost", "root", "", "room_keys_monitoring");
 
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
 
$sql = "SELECT Room_Key, borrower, Time_Borrowed, Date_Borrowed 
FROM `room_keys_monitoring` 
WHERE date(`Date_Borrowed`) = CURRENT_DATE
ORDER BY `Date_Borrowed` desc";
if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result) > 0){
        echo "<center>";
        echo "<H1>Attendance Monitoring</H1>";
        echo "<table border = '1', cellspacing = '0', cellpadding = '10'";
            echo "<tr>";
                echo "<th>Room</th>";
                echo "<th>Instructor</th>";
                echo "<th>Date and Time</th>";
            echo "</tr>";
        while($row = mysqli_fetch_array($result)){
            echo "<tr>";
                echo "<td>" . $row['Room_Key'] . "</td>";
                echo "<td>" . $row['borrower'] . "</td>";
                echo "<td>" . $row['Date_Borrowed'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        mysqli_free_result($result);
    } else{
        echo "No records matching your query were found.";
    }
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
mysqli_close($link);
?>