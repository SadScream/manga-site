function isEmpty(s) {
    return s.length == 0;
}

function isEmptyArr(arr) {
    return arr.length == 0;
}

function checkboxClicked(sender) {
    $(sender).parent().children(".checkbox").focus();
}

function setCheckboxListener() {
    $(".checkbox-text").click(function (e) {
        checkboxClicked(this);
    })
}

function resetFilters() {
    $(".search-filter-checkbox").prop('checked', false);
    $(".search-filter-input").val("");
}

function setResetFiltersListener() {
    let el = $("#search-filter-buttons").children("button")[0];

    $(el).click(function (e) {
        resetFilters();
        showFiltered();
    });
}

function checkFields(year_from, year_to, views_from, views_to) {
    if (!isEmpty(year_from) && year_from < 1930) {
        alert("Год не может быть меньше 1930");
        return false;
    } else if (!isEmpty(year_to) && year_to > 2021) {
        alert("Год не может быть больше 2021");
        return false;
    } else if (!isEmpty(views_from) && views_from < 0) {
        alert("Количество просмотров не может быть отрицательным");
        return false;
    } else if (!isEmpty(views_to) && views_to > 100000000) {
        alert("Слишком большое количество просмотров");
        return false;
    }

    return true;
}

function setData(data, name, str_field, array_field=null) {
    if (str_field != null && !isEmpty(str_field)) {
        data[name] = str_field;
    } else if (array_field != null && !isEmptyArr(array_field)) {
        data[name] = [];

        for (el of array_field) {
            data[name].push($(el).val());
        }
    }
}

function makeRequest(name, year_from, year_to, views_from, views_to, genres, publishers, types) {
    let data = {};

    setData(data, "name", name);
    setData(data, "year_from", year_from);
    setData(data, "year_to", year_to);
    setData(data, "views_from", views_from);
    setData(data, "views_to", views_to);
    setData(data, "genres", null, genres);
    setData(data, "publishers", null, publishers);
    setData(data, "types", null, types);

    console.log(data);
    let form = document.createElement('form');

    form.style.visibility = 'hidden';
    form.method = 'POST';
    form.action = document.location.pathname;

    for (let key of Object.keys(data)) {
        let input = document.createElement('input');
        input.name = key;
        input.value = data[key];
        form.appendChild(input);
    }

    document.body.appendChild(form);
    form.submit();
}

function showFiltered() {
    let name = $(".search-filter-name>.name").val(),

        year_group = $("#year").children("input"),
        year_from = $(year_group[0]).val(), year_to = $(year_group[1]).val(),

        views_group = $("#views").children("input"),
        views_from = $(views_group[0]).val(), views_to = $(views_group[1]).val(),

        genres_checked = $("#genres").find("input:checkbox:checked"),
        publishers_checked = $("#publishers").find("input:checkbox:checked"),
        types_checked = $("#types").find("input:checkbox:checked");


    if (!checkFields(year_from, year_to, views_from, views_to)) {
        return;
    }

    console.log("fields are ok");

    makeRequest(name,
        year_from, year_to,
        views_from, views_to,
        genres_checked, publishers_checked, types_checked);
}

function setShowFilteredListener() {
    let el = $("#search-filter-buttons").children("button")[1];

    $(el).click(function (e) {
        showFiltered();
    });
}

setCheckboxListener();
setResetFiltersListener();
setShowFilteredListener();