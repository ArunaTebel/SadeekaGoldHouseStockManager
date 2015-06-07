$(document).ready(function () {

    $("#reports_date_from").hide();
    $("#reports_date_to").hide();

    $("#sales_category_name").change(function () {
        var selectedCategoryName = $("#sales_category_name>option:selected").text();
        $("#sales_serial_no").empty();
        $.post(getItemSerialsByCategoryNameUrl,
                {'categoryName': selectedCategoryName},
        function (response) {
            if (response['success'] !== false) {
                $.each(response, function (i, value) {
                    $('#sales_serial_no').append($('<option>').text(value).attr('value', value));
                    $("#sales_weight_g").prop("disabled", false);
                    $("#sales_weight_mg").prop("disabled", false);
                    $("#sales_date").prop("disabled", false);
                    $("#sales_Sell").prop("disabled", false);
                });
            } else {
                $("#sales_weight_g").attr('disabled', 'disabled');
                $("#sales_weight_mg").attr('disabled', 'disabled');
                $("#sales_date").attr('disabled', 'disabled');
                $("#sales_Sell").attr('disabled', 'disabled');
            }

        });
    });

    $('input:radio[name="reports[sales_range]"]').change(
            function () {
                if ($('input:radio[id="reports_sales_range_2"]').is(':checked')) {
                    $("#reports_date_from").show();
                    $("#reports_date_to").show();
                } else {
                    $("#reports_date_from").hide();
                    $("#reports_date_to").hide();
                }
            });

});