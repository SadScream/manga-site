let h_font = $("h4,h5,h6"),
    categories_bar = $("#categories-bar"),
    content_popular = $("#content-popular"),
    pe_wrapper = $(".content-popular-element-wrapper"),
    pe_image_block = $(".content-popular-image"),
    pe_img = $(".content-popular-image>img"),
    pe_info = $(".content-popular-info"),
    pe_description = $(".content-popular-description");

function isHorizontal() {
    return window.innerWidth/1.15 > window.innerHeight
}

function setContentPopularSize(event) {
    // подгонка размера элементов под размер экрана

    if (isHorizontal()) {
        // горизонтально

        $(".content-popular-element-wrapper h4").css({"fontSize": "1em"});
        $(".content-popular-element-wrapper h5").css({"fontSize": "0.9em"});
        $(".content-popular-element-wrapper h6").css({"fontSize": "0.8em"});
        $(h_font).css({"marginTop": "15px"});
        $(content_popular).css({"width": "72vw"});
        $(categories_bar).css({"height": "12vh"});

        $(pe_wrapper).css({
            "width": "33vw",
            "height": "60vh",
            "maxHeight": "490px",
            "margin": "3vh 0 3vh 0"
        });

        $(pe_image_block).css({
            "width": "35%",
            "alignItems": "flex-start",
            "justifyContent": "unset"
        });

        $(pe_img).css({"width": "100%", "height": "100%"});

        $(pe_info).css({
            "width": "calc(65% - 1vw)",
            "height": "45%",
            "display": "block",
        });
        $(pe_description).css({"height": "40%"});
    } else {
        // вертикально

        $(".content-popular-element-wrapper h4").css({"fontSize": "1.2em"});
        $(".content-popular-element-wrapper h5").css({"fontSize": "1.1em"});
        $(".content-popular-element-wrapper h6").css({"fontSize": "1em"});
        $(h_font).css({"marginTop": "5px"});
        $(content_popular).css({"width": "90vw"});
        $(categories_bar).css({"height": "8vh"});

        $(pe_wrapper).css({
            "width": "42vw",
            "height": "45vh",
            "maxHeight": "740px",
            "margin": "1vh 0 1vh 0"
        });

        $(pe_image_block).css({
            "width": "100%",
            "alignItems": "center",
            "justifyContent": "center"
        });

        $(pe_img).css({"width": "45%", "height": "100%"});

        $(pe_info).css({
            "width": "100%",
            "height": "20%",
            "display": "flex",
            "justifyContent": "center",
            "flexDirection": "column"
        });

        $(pe_description).css({"height": "20%"});
    }
}