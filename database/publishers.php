<?php
require_once("connect.php");

/**
 * @var mysqli $connect
 */

function get_publishers_array(mysqli $connect) {
    $all_publishers = array();
    $query_publisher_names = "select * from publisher";
    $q_publisher_names = mysqli_query($connect, $query_publisher_names) or die(mysqli_error($connect));
    $row = mysqli_fetch_array($q_publisher_names);

    for ($i = $row['id']; $row; $i=$row['id']) {
        $all_publishers[$i] = $row['name'];
        $row = mysqli_fetch_array($q_publisher_names);
    }

    return $all_publishers;
}

function get_manga_publishers_str($connect, $all_publishers, $id) {
    $result = "";

    $query_publishers = "select * from manga_publishers where manga_id={$id}";
    $q_publishers = mysqli_query($connect, $query_publishers) or die(mysqli_error($connect));

    if ($row = mysqli_fetch_array($q_publishers)) {
        $result = $all_publishers[$row['publisher_id']];
    }

    while ($row = mysqli_fetch_array($q_publishers)) {
        $result .= ", {$all_publishers[$row['publisher_id']]}";
    }

    return $result;
}
?>
