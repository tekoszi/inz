
require('../css/app.css');
require('../css/main.scss');

var $  = require( 'jquery' );
require( 'datatables.net' );
require( 'datatables.net-dt' );

$(document).ready(function() {

    $(document).ready(function() {
        $('table').DataTable();
    } );
    $('#history-table').DataTable({
        "order": [[ 4, "desc" ]],
        dom: "<'row'<'col-sm-3'l><'col-sm-3'f><'col-sm-6'p>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    });
    $('#products-table').DataTable({
        "order": [[ 8, "asc" ]],
        dom: "<'row'<'col-sm-3'l><'col-sm-3'f><'col-sm-6'p>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    });
    $('#find-place-table').DataTable({
        "order": [[ 3, "asc" ]],
        dom: "<'row'<'col-sm-3'l><'col-sm-3'f><'col-sm-6'p>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    });
    $('#users-table').DataTable({
        dom: "<'row'<'col-sm-3'l><'col-sm-3'f><'col-sm-6'p>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    });
    $('#racks-table').DataTable({
        "order": [[ 3, "asc" ]],
        dom: "<'row'<'col-sm-3'l><'col-sm-3'f><'col-sm-6'p>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",s
    });
    $('#shelfs-table').DataTable({
        "order": [[ 3, "asc" ]],
        dom: "<'row'<'col-sm-3'l><'col-sm-3'f><'col-sm-6'p>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    });
    $( "select" ).addClass( "selectpicker" )


});

$.fn.dataTable.ext.classes.sPageButton = 'btn btn-dark';
