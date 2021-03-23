$(function() {

    jQuery('#country').change(function () {
        var ccode = $("#country").val();
        $.ajax({
            url: "get_state.php",
            type: 'GET',
            data: "cc=" + ccode,
            success: function (res) {
                $('#state').val('').trigger('change');
                $('#city').val('').trigger('change');
                $("#state").html(res);
            }
        });
    });

    jQuery('#state').change(function () {
        var ccode = $("#country").val();
        var ocode = $("#state").val();
        $.ajax({
            url: "get_city.php",
            type: 'GET',
            data: "oc=" + ocode + "&cc=" + ccode,
            success: function (res) {
                $('#city').val('').trigger('change');
                $("#city").html(res);
            }
        });
    });

});