$(document).ready(function () {
    if (typeof getItemSerialsByCategoryNameUrl !== 'undefined') {
        setSerialNumberByCategory();
    }
    $("#reports_date_from").hide();
    $("#reports_date_to").hide();
    $("#sales_category_name").change(function () {
        setSerialNumberByCategory();
    });
    $('#category_category').change(function () {
        var nextCategoryName = $("#category_category>option:selected").text();
        $("#category_serial_no").empty();
        $.post(setNextSerialNoByCategoryUrl,
                {'categoryName': nextCategoryName},
        function (response) {
            if (response['success'] !== false) {
                    $('#category_serial_no').val(response);
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

    $('#sales_serial_no').change(function () {
        setWeightsBySerialNumber();
    });

    $('#delete-item-modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var deteleItemUrl = button.data('whatever') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        modal.find('#item-delete-btn').attr("href", deteleItemUrl);
    });

    $('#delete-category-modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var deteleCategoryUrl = button.data('whatever') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        modal.find('#category-delete-btn').attr("href", deteleCategoryUrl);
    });

    function setWeightsBySerialNumber() {
        var serialNo = $("#sales_serial_no>option:selected").text();
        $.post(getItemWeightBySerialUrl, {'serialNo': serialNo}, function (response) {
            if (response['success'] != false) {
                $('#sales_weight_g').val(response['weight_g']);
                $('#sales_weight_mg').val(response['weight_mg']);
            }
        });
    }

    function setSerialNumberByCategory() {
        var selectedCategoryName = $("#sales_category_name>option:selected").text();
        $("#sales_serial_no").empty();
        $.post(getItemSerialsByCategoryNameUrl,
                {'categoryName': selectedCategoryName},
        function (response) {
            if (response['success'] !== false) {
                $.each(response, function (i, value) {
                    $('#sales_serial_no').append($('<option>').text(value).attr('value', i));
                    $("#sales_weight_g").prop("disabled", false);
                    $("#sales_weight_mg").prop("disabled", false);
                    $("#sales_date").prop("disabled", false);
                    $("#sales_Sell").prop("disabled", false);
                    setWeightsBySerialNumber();
                });
            } else {
                $("#sales_weight_g").attr('disabled', 'disabled');
                $("#sales_weight_mg").attr('disabled', 'disabled');
                $("#sales_date").attr('disabled', 'disabled');
                $("#sales_Sell").attr('disabled', 'disabled');
            }
            $("#sales_serial_no").trigger('chosen:updated');

        });
    }

    $(".clickable-row").click(function () {
        window.document.location = $(this).data("href");

    });
//    $('.clickable-row').hover(function () {
//        $(this).addClass('hover');
//    }, function () {
//        $(this).removeClass('hover');
//    })


});