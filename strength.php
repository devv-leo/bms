<?php
error_log("Debug: Including conn.php in strength.php");
include_once 'conn.php';
error_log("Debug: After including conn.php");

// Test connection
if (!$con) {
    error_log("Debug: Connection failed in strength.php: " . mysqli_connect_error());
}

function r_format($query) {
    global $con;
    error_log("Debug: Inside r_format, con is: " . ($con ? "connected" : "not connected"));
    $sql = mysqli_query($con, $query);
    $row = mysqli_fetch_array($sql);
    $number = $row['total'];
    if(isset($number)){
        $number = (0+str_replace(",", "", $number));
        if (!is_numeric($number)) return false;
        if     ($number > 1000000000000) return round(($number/1000000000000), 2).'T';
        elseif ($number == 1000000000000) return round(($number/1000000000000), 2).'.00T';
        elseif ($number > 1000000000) return round(($number/1000000000), 2).'B';
        elseif ($number == 1000000000) return round(($number/1000000000), 2).'.00B';
        elseif ($number > 1000000) return round(($number/1000000), 2).'M';
        elseif ($number == 1000000) return round(($number/1000000), 2).'.00M';
        elseif ($number > 10000) return round(($number/1000), 2).'K';
        elseif ($number == 10000) return round(($number/1000), 2).'.00K';
        elseif ($number < 10000) return $number;
        return r_format($number);
    }else{
        if (isset($number)) {
            # code...
        }else{
            $number="0";
            return $number;
        }
        return r_format($number);
    }
}
?>