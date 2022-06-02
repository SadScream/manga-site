<?php
require_once("database/connect.php");
require_once("database/genres.php");
require_once("database/publishers.php");

/**
 * @var mysqli $connect
 */

function get_manga(mysqli $connect, $id) {
    $query = "select * from manga where id={$id}";
    $exec = mysqli_query($connect, $query) or die(mysqli_error($connect));

    if ($exec->num_rows == 0) {
        return false;
    } else {
        return mysqli_fetch_array($exec);
    }
}

function get_name(mysqli $connect, $id) {
    $query = "select * from manga_name where id={$id}";
    $exec = mysqli_query($connect, $query) or die(mysqli_error($connect));

    if ($exec->num_rows == 0) {
        return false;
    } else {
        return mysqli_fetch_array($exec);
    }
}

if(!isset($_GET['id']))
    header("Location: index.php");

$all_genres = get_genres_array($connect);
$all_publishers = get_publishers_array($connect);
$manga_id = $_GET['id'];
$manga = get_manga($connect, $manga_id);

if ($manga == false) {
    header("Location: index.php");
}
else {
    $name = get_name($connect, $manga["name_id"]);
    $genres = get_manga_genres_str($connect, $all_genres, $manga_id);
    $publishers = get_manga_publishers_str($connect, $all_publishers, $manga_id);
    $type = "manga";
    $type_ru = "манга";

    if ($manga["type"] == 1) {
        $type = "manhva";
        $type_ru = "манхва";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title><?php echo $name['name_ru']; ?></title>
    <link rel="stylesheet" href="styles/fonts.css?<?php echo date('h:i:s'); ?>">
    <link rel="stylesheet" href="styles/base.css?<?php echo date('h:i:s'); ?>">
    <link rel="stylesheet" href="styles/navigation-bar.css?<?php echo date('h:i:s'); ?>">
    <link rel="stylesheet" href="styles/content-bar-manga.css?<?php echo date('h:i:s'); ?>">
    <link rel="stylesheet" href="styles/additional-bar.css?<?php echo date('h:i:s'); ?>">
</head>
<body>
    <div id="main">
        <div id="navigation-bar">
            <div id="navigation-bar-title-wrapper">
                <div id="navigation-bar-title"><a href="">MangaStore</a></div>
            </div>
            <div id="navigation-bar-buttons">
                <div class="navigation-bar-button"><a href="index.php">Главная</a></div>
                <div class="navigation-bar-button"><a href="manga-list.php">Каталог</a></div>
                <div class="navigation-bar-button"><a href="#info-bar">Контакты</a></div>
                <div class="navigation-bar-button"><a href="#info-bar">О нас</a></div>
            </div>
        </div>
        <span></span>
        <div id="content-bar">
            <div id="column-bar">
                <div id="column-image-wrapper">
                    <div id="column-image">
                        <img src="images/<?php echo $type; ?>/<?php echo $manga["image"]; ?>">
                        <div class="cover"></div>
                    </div>
                </div>
                <div id="column-info-wrapper">
                    <div class="manga header">
                        <?php

                        echo "<h1>{$name["name_ru"]}</h1>";

                        if ($name["name_en"] != "") {
                            $full_name = $name["name_en"];

                            if ($name["name_another"] != "") {
                                $full_name = $full_name . " / " . $name["name_another"];
                            }

                            echo "<h2>{$full_name}</h2>";
                        } else {
                            echo "<h2>{$name["name_another"]}</h2>";
                        }
                        ?>
                    </div>
                    <div class="manga info">
                        <div class="info-table">
                            <div class="info-row">
                                <div class="key">Год: выпуска</div>
                                <div class="value"><?php echo $manga["release_year"]; ?></div>
                            </div>
                            <div class="info-row">
                                <div class="key">Тип:</div>
                                <div class="value"><?php echo $type_ru; ?></div>
                            </div>
                            <div class="info-row">
                                <div class="key">Жанры:</div>
                                <div class="value"><?php echo $genres; ?></div>
                            </div>
                            <div class="info-row">
                                <div class="key">Издательства:</div>
                                <div class="value"><?php echo $publishers; ?></div>
                            </div>
                            <div class="info-row">
                                <div class="key">Читатели:</div>
                                <div class="value"><?php echo $manga["views"]; ?></div>
                            </div>
                        </div>
                        <div class="description">
                            <p><?php echo $manga["description"]; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <span></span>
        <div id="info-bar">
            <div class="info-bar-block">
                <h5>Обратная связь</h5>
                <h6><a href="">Баги и предложения</a></h6>
                <h6><a href="">Обращение</a></h6>
            </div>
            <div class="info-bar-block">
                <h5>Соц сети</h5>
                <h6><a href="">Twitter</a> - подписывайтесь на наш Твиттер</h6>
                <h6><a href="">Instagram</a> - подписывайтесь на наш Инстаграм</h6>
            </div>
            <div class="info-bar-block">
                <h5>О нас</h5>
                <h6>Комиксы</h6>
                <h6>Copyright © 2022 SadScream</h6>
            </div>
        </div>
    </div>
</body>
</html>
