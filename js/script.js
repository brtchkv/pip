function checkFields() {

    let value = $("#y").val();
    let correctFields = true;
    if (value.length === 0) {
        $("#y").attr("style", "border: 2px solid red; mix-blend-mode: normal;");
        $("#y").attr("placeholder", "Введите число от -5 до 5");
        event.preventDefault();
        correctFields = false;
    }

    if (!$('input[type="radio"]').is(":checked")) {
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