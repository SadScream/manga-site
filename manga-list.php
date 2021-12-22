<?php
require_once("database/connect.php");
require_once("database/genres.php");
require_once("database/publishers.php");

$query_all_manga = "select * from manga where id >= 0";
$select_all_condition = "";
$select_by_name_condition = "";
$select_by_genre_condition = "";
$name = "";
$year_from = "";
$year_to = "";
$views_from = "";
$views_to = "";
$selected_genres = array();
$selected_publishers = array();
$selected_manga = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST["name"])) {
        $name = $_POST["name"];
        $select_by_name_condition = "
            AND (LCASE(name_ru) LIKE LCASE('%{$name}%') 
            OR LCASE(name_en) LIKE LCASE('%{$name}%'))";
    }
    if (!empty($_POST["year_from"]) ||
            !empty($_POST["year_to"]) ||
            isset($_POST["views_from"]) ||
            isset($_POST["views_to"])) {

        if (!empty($_POST["year_from"])) {
            $year_from = $_POST["year_from"];
            $select_all_condition .= " AND release_year >= {$year_from} ";
        }
        if (!empty($_POST["year_to"])) {
            $year_to = $_POST["year_to"];
            $select_all_condition .= " AND release_year <= {$year_to} ";
        }
        if (isset($_POST["views_from"])) {
            $views_from = $_POST["views_from"];
            $select_all_condition .= " AND views >= {$views_from} ";
        }
        if (isset($_POST["views_to"])) {
            $views_to = $_POST["views_to"];
            $select_all_condition .= " AND views <= {$views_to} ";
        }
    }
    if (isset($_POST["genres"])) {
        $selected_genres = explode(",", $_POST["genres"]);
    }
    if (isset($_POST["publishers"])) {
        $selected_publishers = explode(",", $_POST["publishers"]);
    }
    if (isset($_POST["types"])) {
        $selected_manga = explode(",", $_POST["types"]);
    }
}

$query_all_manga .= $select_all_condition;

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Каталог</title>
    <link rel="stylesheet" href="styles/fonts.css?<?php echo date('h:i:s'); ?>">
    <link rel="stylesheet" href="styles/base.css?<?php echo date('h:i:s'); ?>">
    <link rel="stylesheet" href="styles/navigation-bar.css?<?php echo date('h:i:s'); ?>">
    <link rel="stylesheet" href="styles/content-bar-catalog.css?<?php echo date('h:i:s'); ?>">
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
                <div class="navigation-bar-button"><a href="">Контакты</a></div>
                <div class="navigation-bar-button"><a href="">О нас</a></div>
            </div>
        </div>
        <span></span>
        <div id="content-bar">
            <div id="container">
                <div id="manga-list-page-wrapper">
                    <div id="manga-list-wrapper">
                        <?php
                        /**
                         * @var mysqli $connect
                         */

                        $q_all = mysqli_query($connect, $query_all_manga) or die(mysqli_error($connect));

                        if ($q_all) {
                            while ($row = mysqli_fetch_array($q_all)) {
                                $type_s = "Манга";
                                $type = "manga";

                                if (count($selected_manga) &&
                                    !in_array(strval($row['type']), $selected_manga))
                                {
                                    continue;
                                }

                                if ($row['type'] == 1) {
                                    $type_s = "Манхва";
                                    $type = "manhva";
                                }

                                if (count($selected_genres) > 0) {
                                    $genres = get_manga_genres($connect, $row["id"]);

                                    if (count(array_intersect($selected_genres, $genres)) != count($selected_genres)) {
                                        continue;
                                    }
                                }

                                if (count($selected_publishers) > 0) {
                                    $publishers = get_manga_publishers($connect, $row["id"]);

                                    if (count(array_intersect($selected_publishers, $publishers)) != count($selected_publishers)) {
                                        continue;
                                    }
                                }

                                $query_name = "select * from manga_name where id={$row['name_id']} {$select_by_name_condition} limit 1";
                                $q_name = mysqli_query($connect, $query_name) or die(mysqli_error($connect));

                                if ($q_name->num_rows == 0) {
                                    continue;
                                }

                                $names = mysqli_fetch_array($q_name);
                                $name_ru = $names['name_ru'];

                                echo "
                                    <div class='manga-card-wrapper'>
                                        <a href=''>
                                            <div class='manga-card-info'>
                                                <h5 class='manga-card-type'>{$type_s}</h5>
                                                <h3 class='manga-card-name'>{$name_ru}</h3>
                                            </div>
                                        </a>
                                        <img src='images/{$type}/{$row['image']}'>
                                    </div>
                                ";
                            }
                        }
                        ?>
                    </div>
                </div>
                <div id="filter-wrapper">
                    <div id="search-filter">
                        <div id="search-filter-wrapper">
                            <div class="search-filter-name">
                                <input type="text" placeholder="Поиск на названию" class="search-filter-input name" value="<?php echo $name;?>">
                            </div>
                            <div class="search-filter-group">
                                <div class="search-filter-title">Год выпуска</div>
                                <div class="search-filter-content">
                                    <div id="year" class="search-filter-input-group">
                                        <input type="text" placeholder="От" class="search-filter-input" value="<?php echo $year_from;?>">
                                        <span>—</span>
                                        <input type="text" placeholder="До" class="search-filter-input" value="<?php echo $year_to;?>">
                                    </div>
                                </div>
                            </div>
                            <div class="search-filter-group">
                                <div class="search-filter-title">Количество просмотров</div>
                                <div class="search-filter-content">
                                    <div id="views" class="search-filter-input-group">
                                        <input type="text" placeholder="От" class="search-filter-input" value="<?php echo $views_from;?>">
                                        <span>—</span>
                                        <input type="text" placeholder="До" class="search-filter-input" value="<?php echo $views_to;?>">
                                    </div>
                                </div>
                            </div>
                            <div class="search-filter-group">
                                <div class="search-filter-title">Жанры</div>
                                <div id="genres" class="search-filter-content">
                                    <?php

                                    $all_genres = get_genres_array($connect);
                                    foreach ($all_genres as $i => $name) {
                                        $name = mb_convert_case($name, MB_CASE_TITLE, 'UTF-8');
                                        $checked = "";

                                        if (in_array(strval($i), $selected_genres)) {
                                            $checked = "checked";
                                        }

                                        echo "
                                            <label class='search-filter-checkbox-wrapper'>
                                                <input type='checkbox' name='genres' value='{$i}' class='search-filter-checkbox' {$checked}>
                                                <span class='checkbox-text'>{$name}</span>
                                            </label>
                                        ";
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="search-filter-group">
                                <div class="search-filter-title">Издатели</div>
                                <div id="publishers" class="search-filter-content">
                                    <?php
                                    $all_publishers = get_publishers_array($connect);

                                    foreach ($all_publishers as $i => $name) {
                                        $checked = "";

                                        if (in_array(strval($i), $selected_publishers)) {
                                            $checked = "checked";
                                        }

                                        echo "
                                            <label class='search-filter-checkbox-wrapper'>
                                                <input type='checkbox' value='{$i}' class='search-filter-checkbox' {$checked}>
                                                <span class='checkbox-text'>{$name}</span>
                                            </label>
                                        ";
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="search-filter-group">
                                <div class="search-filter-title">Тип</div>
                                <div id="types" class="search-filter-content">
                                    <?php
                                    $manga_checked = "";
                                    $manhva_checked = "";

                                    if (in_array("0", $selected_manga)) {
                                        $manga_checked = "checked";
                                    }
                                    if (in_array("1", $selected_manga)) {
                                        $manhva_checked = "checked";
                                    }

                                    echo "
                                    <label class='search-filter-checkbox-wrapper'>
                                        <input type='checkbox' value='0' class='search-filter-checkbox' {$manga_checked}>
                                        <span class='checkbox-text'>Манга</span>
                                    </label>
                                    <label class='search-filter-checkbox-wrapper'>
                                        <input type='checkbox' value='1' class='search-filter-checkbox' {$manhva_checked}>
                                        <span class='checkbox-text'>Манхва</span>
                                    </label>
                                    "
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="search-filter-buttons">
                        <button>Сбросить</button>
                        <button class="button-accept">Показать</button>
                    </div>
                </div>
            </div>
        </div>
        <span></span>
        <div id="info-bar">
            <div class="info-bar-block">
                <h5>Обратная связь</h5>
                <h6><a href="">Баги и предложения</a></h6>
                <h6><a href="">О нарушении авторских прав обращайтесь сюда</a></h6>
            </div>
            <div class="info-bar-block">
                <h5>Соц сети</h5>
                <h6><a href="">Twitter</a> - подписывайтесь на наш Твиттер</h6>
                <h6><a href="">Instagram</a> - подписывайтесь на наш Инстаграм</h6>
            </div>
            <div class="info-bar-block">
                <h5>О нас</h5>
                <h6>Сайт с манго 0_о</h6>
                <h6>Copyright © 2021 SadScream</h6>
            </div>
        </div>
    </div>
    <script src="scripts/jquery-3.6.0.min.js"></script>
    <script src="scripts/adaptive-window.js"></script>
    <script src="scripts/adaptive-window-catalog.js"></script>
    <script src="scripts/search-filter.js"></script>
    <script>
        setHeaderSize(null);
        // setFilterWrapperSize(null);
        setAdditionalSize(null);
        window.addEventListener('resize', setHeaderSize, true);
        // window.addEventListener('resize', setFilterWrapperSize, true);
        window.addEventListener('resize', setAdditionalSize, true);
    </script>
</body>
</html>
