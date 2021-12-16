<?php
require_once("connect.php");

/**
 * @var mysqli $connect
 */

function get_genres_array(mysqli $connect) {
    $all_genres = array();
    $query_genre_names = "select * from genre";
    $q_genre_names = mysqli_query($connect, $query_genre_names) or die(mysqli_error($connect));
    $row = mysqli_fetch_array($q_genre_names);

    for ($i = $row['id']; $row; $i=$row['id']) {
        $all_genres[$i] = $row['name'];
        $row = mysqli_fetch_array($q_genre_names);
    }

    return $all_genres;
}

function get_manga_genres_str($connect, $all_genres, $id) {
    $result = "";

    $query_genres = "select * from manga_genres where manga_id={$id}";
    $q_genres = mysqli_query($connect, $query_genres) or die(mysqli_error($connect));

    if ($row = mysqli_fetch_array($q_genres)) {
        $result = $all_genres[$row['genre_id']];
    }

    while ($row = mysqli_fetch_array($q_genres)) {
        $result .= ", {$all_genres[$row['genre_id']]}";
    }

    return $result;
}
?>
