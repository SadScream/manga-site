<?php
require_once("database/connect.php");
require_once("database/genres.php");
require_once("database/publishers.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Главная</title>
    <link rel="stylesheet" href="styles/fonts.css?<?php echo date('h:i:s'); ?>">
    <link rel="stylesheet" href="styles/base-main.css?<?php echo date('h:i:s'); ?>">
    <link rel="stylesheet" href="styles/navigation-bar-main.css?<?php echo date('h:i:s'); ?>">
    <link rel="stylesheet" href="styles/content-bar-main.css?<?php echo date('h:i:s'); ?>">
    <link rel="stylesheet" href="styles/additional-bar.css?<?php echo date('h:i:s'); ?>">
</head>
<body>
    <div id="main">
        <div id="navigation-bar">
            <div id="navigation-bar-title-wrapper">
                <div id="navigation-bar-title"><a href="">MangaStore</a></div>
            </div>
            <div id="navigation-bar-buttons">
                <div class="navigation-bar-button"><a href="">Главная</a></div>
                <div class="navigation-bar-button"><a href="manga-list.php">Каталог</a></div>
                <div class="navigation-bar-button"><a href="">Контакты</a></div>
                <div class="navigation-bar-button"><a href="">О нас</a></div>
            </div>
        </div>
        <span></span>
        <div id="content-bar">
            <input type="radio" name="Categories" id="manga" checked="True">
            <input type="radio" name="Categories" id="manhva">
            <div id="content-popular">
                <div id="categories-bar">
                    <div id="categories-popular-text">Популярная манга</div>
                    <div class="categories-bar-button-wrapper">
                        <label id="manga_label" for="manga">Манга</label>
                    </div>
                    <div class="categories-bar-button-wrapper">
                        <label id="manhva_label" for="manhva">Манхва</label>
                    </div>
                </div>
                <span></span>
                <div class="content-popular-list">
                    <?php
                    /**
                     * @var mysqli $connect
                     */

                    $all_genres = get_genres_array($connect);
                    $all_publishers = get_publishers_array($connect);
                    $query_all_manga = "select * from manga where views>=10000 order by views desc";
                    $q_all = mysqli_query($connect, $query_all_manga) or die(mysqli_error($connect));


                    if ($q_all) {
                        while ($row = mysqli_fetch_array($q_all)) {
                            $type = "manga";

                            if ($row['type'] == 1) {
                                $type = "manhva";
                            }

                            $query_name = "select * from manga_name where id={$row['name_id']} limit 1";
                            $q_name = mysqli_query($connect, $query_name) or die(mysqli_error($connect));

                            $names = mysqli_fetch_array($q_name);
                            $name_ru = $names['name_ru'];
                            $name_additional = $names['name_en'];

                            $release_year = $row['release_year'];

                            if ($name_additional == null) {
                                $name_additional = $names['name_another'];
                            }

                            $genres = get_manga_genres_str($connect, $all_genres, $row['id']);
                            $publishers = get_manga_publishers_str($connect, $all_publishers, $row['id']);

                            echo "
                                <div class='content-popular-element-wrapper {$type}' id='{$row['id']}'>
                                    <div class='content-popular-element'>
                                        <div class='content-popular-image'>
                                            <img src='images/{$type}/{$row['image']}'>
                                        </div>
                                        <div class='content-popular-info'>
                                            <h4>{$name_ru}</h4>
                                            <h6>Жанры: {$genres}</h6>
                                            <h6>Издательство: {$publishers}</h6>
                                            <h6>Год: {$release_year}</h6>
                                        </div>
                                        <div class='content-popular-description'>
                                            <h5>Описание: {$row['description']}<h5>
                                        </div>
                                        <div class='content-popular-button'>
                                            <button>Читать</button>
                                        </div>
                                    </div>
                                </div>    
                                ";
                        }
                    }

                    ?>
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
                <h5>Twitter</h5>
                <h6><a href="">twitter</a> - подписывайтесь на наш Твиттер</h6>
                <h6><a href="">instagram</a> - подписывайтесь на наш Инстаграм</h6>
            </div>
            <div class="info-bar-block">
                <h5>О нас</h5>
                <h6>Сайт с манго 0_о</h6>
                <h6>Copyright © 2021 SadScream</h6>
            </div>
        </div>
    </div>
    <script src="scripts/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        function setSize(event) {
            // подгонка размера элементов под размер экрана

            let popular_element_wrapper = $(".content-popular-element-wrapper"),
                popular_element_image_block = $(".content-popular-image"),
                popular_element_img = $(".content-popular-image>img"),
                popular_element_info = $(".content-popular-info"),
                popular_element_description = $(".content-popular-description"),
                popular_element_button = $(".content-popular-button");

            for (let i = 0; i < popular_element_info.length; i++) {
                let wrapper_block = popular_element_wrapper[i],
                    image_block = popular_element_image_block[i],
                    img = popular_element_img[i],
                    info = popular_element_info[i],
                    desc = popular_element_description[i],
                    button = popular_element_button[i];

                if (window.innerWidth/1.44 > window.innerHeight) {
                    // горизонтально

                    $(wrapper_block).css("height", "48%");

                    $(image_block).css({"width": "35%",
                        "height": "45%",
                        "alignItems": "flex-start",
                        "justifyContent": "flex-start",
                        "marginLeft": "5%",
                        "top": "5%"
                    });

                    $(img).css({"width": "auto", "height": "100%"});
                    $(info).css({"width": "60%", "height": "45%"});
                    $(desc).css({"height": "33%", "top": "2%"});
                    $(button).css({"height": "20%", "top": "0%"});
                }
                else {
                    // вертикально

                    $(wrapper_block).css("height", "30%");

                    $(image_block).css({"width": "100%",
                        "height": "50%",
                        "alignItems": "center",
                        "justifyContent": "center",
                        "marginLeft": "0%",
                        "top": "0%"
                    });

                    $(img).css({"width": "auto", "height": "85%"});
                    $(info).css({"width": "100%", "height": "15%", "top": "0%"});
                    $(desc).css({"height": "20%", "top": "0%"});
                    $(button).css({"height": "15%", "top": "0%"});
                }
            }
        }

        setSize(null);
        window.addEventListener('resize', setSize, true);
    </script>
</body>
</html>