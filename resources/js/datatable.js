import $ from "jquery";
import DataTable from "datatables.net-bs5";
import "datatables.net-buttons-bs5";
import "datatables.net-select-bs5";
import "laravel-datatables-vite/js/dataTables.buttons.js";
import "laravel-datatables-vite/js/dataTables.renderers.js";

window.jQuery = window.$ = $;
window.DataTable = DataTable;

$.extend(true, DataTable.defaults, {
    dom:
        "<'row'<'col-sm-12 mb-4'B>>" +
        "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
});

$.extend(true, DataTable.Buttons.defaults, {
    dom: {
        buttonLiner: {
            tag: "",
        },
    },
});

$.extend(DataTable.ext.classes, {
    sTable: "dataTable table table-striped table-bordered table-hover",
});
