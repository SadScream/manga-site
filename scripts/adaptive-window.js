let info_bar = $("#info-bar"),
    header = $("#navigation-bar"),
    header_title = $("#navigation-bar-title"),
    header_refs = $("#navigation-bar-buttons");

function isHorizontal() {
    return window.innerWidth/1.15 > window.innerHeight
}

function setHeaderSize(event) {
    if (isHorizontal()) {
        $(header).css({"height": "10vh"});
        $(header_title).css({"fontSize": "180%"});
        $(header_refs).css({"fontSize": "90%"});
    } else {
        $(header).css({"height": "9vh"});
        $(header_title).css({"fontSize": "245%"});
        $(header_refs).css({"fontSize": "130%"});
    }
}

function setAdditionalSize(event) {
    if (isHorizontal()) {
        $(info_bar).css({"fontSize": "100%"});
    } else {
        $(info_bar).css({"fontSize": "140%"});
    }
}