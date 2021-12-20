let filter_wrapper = $("#filter-wrapper"),
    manga_list_wrapper = $("#manga-list-wrapper");

function isHorizontal() {
    return window.innerWidth/1.51 > window.innerHeight
}

function setFilterWrapperSize(event) {
    if (isHorizontal()) {
        $(manga_list_wrapper).css({
            "height": "100%"
        })
        $(filter_wrapper).css({
            "position": "sticky",
            "float": "right"
        })
    } else {
        $(manga_list_wrapper).css({
            "height": "calc((100%) - 90vh)"
        })
        $(filter_wrapper).css({
            "position": "relative",
            "float": "none"
        })
    }
}