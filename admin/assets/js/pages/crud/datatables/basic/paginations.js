"use strict";
var KTDatatablesBasicPaginations = {
    init: function () {
        $("#kt_table_1").DataTable({
            responsive: !0,
            pagingType: "full_numbers",
            columnDefs: []
        })
    }
};
jQuery(document).ready(function () {
    KTDatatablesBasicPaginations.init()
});