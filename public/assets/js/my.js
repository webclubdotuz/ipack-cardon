
$("form").submit(function (event) {
    if ($(this).hasClass("submitted")) {
        event.preventDefault();
    } else {
        // add loading icon
        $text = $(this).find(":submit").text();
        $(this).find(":submit").html('<i class="bx bx-loader bx-spin font-size-16 align-middle me-2"></i>' + $text);
        $(this).addClass("submitted");
    }
});



$(function() {

    $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
        localStorage.setItem('lastTab', $(this).attr('href'));
    });

    var lastTab = localStorage.getItem('lastTab');

    if (lastTab) {
        $('[href="' + lastTab + '"]').tab('show');
    }

});


$(".money").inputmask({
    alias: "numeric",
    groupSeparator: " ",
    autoGroup: true,
    digits: 0,
    digitsOptional: false,
    prefix: '',
    placeholder: "",
    rightAlign: false,
    autoUnmask: true,
    removeMaskOnSubmit: true,
    unmaskAsNumber: true
});
