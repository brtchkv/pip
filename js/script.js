function checkFields() {

    let value = $("#y").val().replace(/,/g, '.');
    let correctFields = true;
    if (value.length === 0) {
        $("#y").attr("style", "border: 2px solid red; mix-blend-mode: normal;");
        $("#y").attr("placeholder", "Введите число от -5 до 5");
        event.preventDefault();
        correctFields = false;
    }

    if (!($('input[type="radio"]').is(":checked") || $('#r option').is(":selected"))) {
        $('circle').each(function () {
            $(this).attr("style", "stroke: red; stroke-width: 1.5;");
        });
        event.preventDefault();
        correctFields = false;
    }

    if (!$("#xValue").val()) {
        $('.buttonNumber').each(function () {
            $(this).attr("style", "border: 2px solid red;");
        });
        event.preventDefault();
        correctFields = false;
    }

    if (correctFields) {
        $('main').addClass('animated zoomOut fast');
    }

    return correctFields;

}

function regularTableR() {
    $('circle').each(function () {
        $(this).attr("style", "stroke: #C8CCD4; stroke-width: 1.5;");
    });
}

function regularTableX() {
    $('.buttonNumber').each(function () {
        $(this).attr("style", "stroke-width: 2; stroke: #C8CCD4;");
    });
}

function mindX(clickedId) {
    document.getElementById("xValue").value = clickedId;
}

function checkData() {

    let value = $("#y").val().replace(/,/g, '.');

    if ($.isNumeric(value) || value == "-" || value == "") {
        $("#y").attr("style", 'border: 2px solid #d0d1c7;');
    } else {
        document.getElementById("y").className = "invalid";
        $("#y").attr("placeholder", "Введите число от -5 до 5");
        document.getElementById("y").value = "";
        $("#y").attr("style", 'border: 2px solid red; mix-blend-mode: normal;');
    }

    if (value.length === 0) {
        $("#y").attr("style", 'border: 2px solid #d0d1c7;');
        $("#y").attr("placeholder", "Введите число от -5 до 5");
    }

    if ((-5 > value) || (value > 5)) {
        document.getElementById("y").className = "invalid";
        $("#y").attr("placeholder", "Введите число от -5 до 5");
        document.getElementById("y").value = "";
        $("#y").attr("style", 'border: 2px solid red; mix-blend-mode: normal;');
    }
}

function showTable() {
    $('#dataTable').removeClass('hide');
    $('#tableResponse').addClass('hide');

    document.getElementById("historyButton").onclick = hideTable;
}

function hideTable() {
    $('#dataTable').addClass('hide');
    $('#tableResponse').removeClass('hide');

    document.getElementById("historyButton").onclick = showTable;
}