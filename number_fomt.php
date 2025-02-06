<?php
include_once 'conn.php';  // use existing connection

function rup_format($query) {
    global $con;  // use the connection from conn.php
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
        return number_format($number,2);
    }else{
        $number="0";
        return $number;
    }
}
?>