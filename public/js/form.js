$(document).ready(function () {
    $("#fname").focus(function () {
        $("#warn-fname-div").removeClass("has-error");
        $("#warn-fname-span").remove();
    });
    $("#sname").focus(function () {
        $("#warn-sname-div").removeClass("has-error");
        $("#warn-sname-span").remove();
    });
    $("#byear").focus(function () {
        $("#warn-byear-div").removeClass("has-error");
        $("#warn-byear-span").remove();
    });
    $("#examScore").focus(function () {
        $("#warn-examScore-div").removeClass("has-error");
        $("#warn-examScore-span").remove();
    });
    $("#email").focus(function () {
        $("#warn-email-div").removeClass("has-error");
        $("#warn-email-span").remove();
    });
    $("#group").focus(function () {
        $("#warn-group-div").removeClass("has-error");
        $("#warn-group-span").remove();
    });
    $("#male").focus(function () {
        $("#warn-gender-div").removeClass("has-error");
        $("#warn-gender-span").remove();
    });
    $("#female").focus(function () {
        $("#warn-gender-div").removeClass("has-error");
        $("#warn-gender-span").remove();
    });
    $("#local").focus(function () {
        $("#warn-local-div").removeClass("has-error");
        $("#warn-local-span").remove();
    });
    $("#non-local").focus(function () {
        $("#warn-local-div").removeClass("has-error");
        $("#warn-local-span").remove();
    });
});