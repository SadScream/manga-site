<?php
require_once("database/connect.php");
require_once("database/genres.php");
require_once("database/publishers.php");
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

                        $query_all_manga = "select * from manga";
                        $q_all = mysqli_query($connect, $query_all_manga) or die(mysqli_error($connect));

                        if ($q_all) {
                            while ($row = mysqli_fetch_array($q_all)) {
                                $type_s = "Манга";
                                $type = "manga";

                                if ($row['type'] == 1) {
                                    $type_s = "Манхва";
                                    $type = "manhva";
                                }

                                $query_name = "select * from manga_name where id={$row['name_id']} limit 1";
                                $q_name = mysqli_query($connect, $query_name) or die(mysqli_error($connect));

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
                                <input type="text" placeholder="Поиск на названию" class="search-filter-input name">
                            </div>
                            <div class="search-filter-group">
                                <div class="search-filter-title">Год выпуска</div>
                                <div class="search-filter-content">
                                    <div class="search-filter-input-group">
                                        <input type="text" placeholder="От" class="search-filter-input">
                                        <span>—</span>
                                        <input type="text" placeholder="До" class="search-filter-input">
                                    </div>
                                </div>
                            </div>
                            <div class="search-filter-group">
                                <div class="search-filter-title">Количество просмотров</div>
                                <div class="search-filter-content">
                                    <div class="search-filter-input-group">
                                        <input type="text" placeholder="От" class="search-filter-input">
                                        <span>—</span>
                                        <input type="text" placeholder="До" class="search-filter-input">
                                    </div>
                                </div>
                            </div>
                            <div class="search-filter-group">
                                <div class="search-filter-title">Жанры</div>
                                <div class="search-filter-content">
                                    <?php
                                    /**
                                     * @var mysqli $connect
                                     */

                                    $all_genres = get_genres_array($connect);
                                    foreach ($all_genres as $i => $name) {
                                        $name = mb_convert_case($name, MB_CASE_TITLE, 'UTF-8');

                                        echo "
                                            <label class='search-filter-checkbox-wrapper'>
                                                <input type='checkbox' value='{$i}' class='search-filter-checkbox'>
                                                <span class='checkbox-text'>{$name}</span>
                                            </label>
                                        ";
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="search-filter-group">
                                <div class="search-filter-title">Издатели</div>
                                <div class="search-filter-content">
                                    <?php
                                    /**
                                     * @var mysqli $connect
                                     */

                                    $all_publishers = get_publishers_array($connect);

                                    foreach ($all_publishers as $i => $name) {
                                        echo "
                                            <label class='search-filter-checkbox-wrapper'>
                                                <input type='checkbox' value='{$i}' class='search-filter-checkbox'>
                                                <span class='checkbox-text'>{$name}</span>
                                            </label>
                                        ";
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="search-filter-group">
                                <div class="search-filter-title">Тип</div>
                                <div class="search-filter-content">
                                    <label class="search-filter-checkbox-wrapper">
                                        <input type="checkbox" value="0" class="search-filter-checkbox">
                                        <span class="checkbox-text">Манга</span>
                                    </label>
                                    <label class="search-filter-checkbox-wrapper">
                                        <input type="checkbox" value="1" class="search-filter-checkbox">
                                        <span class="checkbox-text">Манхва</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="search-filter-buttons">

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
    <script>
        function checkboxClicked(sender) {
            $(sender).parent().children(".checkbox").focus();
        }
        $(".checkbox-text").click(function (e) {
            checkboxClicked(this);
        })

        setHeaderSize(null);
        // setFilterWrapperSize(null);
        setAdditionalSize(null);
        window.addEventListener('resize', setHeaderSize, true);
        // window.addEventListener('resize', setFilterWrapperSize, true);
        window.addEventListener('resize', setAdditionalSize, true);
    </script>
</body>
</html>
