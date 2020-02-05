
require('../css/app.css');
require('../css/main.scss');

var $  = require( 'jquery' );
require( 'datatables.net' );
require( 'datatables.net-dt' );
var Chart = require('chart.js');

$(document).ready(function() {
    let currentDomain = window.location.pathname;
    if (currentDomain == '/'){
        $( "#v-pills-home-tab" ).addClass( "active" )
    }
    if (currentDomain == '/orders/'){
        $( "#v-pills-orders-tab" ).addClass( "active" )
    }
    if (currentDomain == '/external/orders/'){
        $( "#v-pills-external-orders-tab" ).addClass( "active" )
    }
    if (currentDomain == '/products/in'){
        $( "#v-pills-stockin-tab" ).addClass( "active" )
    }
    if (currentDomain == '/products/out'){
        $( "#v-pills-stockout-tab" ).addClass( "active" )
    }
    if (currentDomain == '/findplace'){
        $( "#v-pills-find-tab" ).addClass( "active" )
    }
    if (currentDomain == '/products/replace'){
        $( "#v-pills-switch-tab" ).addClass( "active" )
    }
    if (currentDomain == '/products/'){
        $( "#v-pills-stock-tab" ).addClass( "active" )
    }
    if (currentDomain == '/contributors'){
        $( "#v-pills-contributors-tab" ).addClass( "active" )
    }
    if (currentDomain == '/admin'){
        $( "#v-pills-admin-tab" ).addClass( "active" )
    }

    $(document).ready(function() {
        $('table').DataTable();
    } );
    $('#history-table').DataTable({
        "order": [[ 4, "desc" ]],
        colReorder: true,
        dom: "<'row'<'col-sm-3'l><'col-sm-3'f><'col-sm-6'p>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    });
    $('#products-table').DataTable({
        "order": [[ 0, "asc" ]],
        colReorder: true,
        dom: "<'row'<'col-sm-3'l><'col-sm-3'f><'col-sm-6'p>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    });
    $('#find-place-table').DataTable({
        "order": [[ 3, "asc" ]],
        colReorder: true,
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
        colReorder: true,
        dom: "<'row'<'col-sm-3'l><'col-sm-3'f><'col-sm-6'p>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",s
    });
    $('#shelfs-table').DataTable({
        "order": [[ 3, "asc" ]],
        colReorder: true,
        dom: "<'row'<'col-sm-3'l><'col-sm-3'f><'col-sm-6'p>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    });
    $('#allorders').DataTable({
        "order": [[ 3, "desc" ]],
        colReorder: true,
        dom: "<'row'<'col-sm-3'l><'col-sm-3'f><'col-sm-6'p>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    });
    $('#userorders').DataTable({
        "order": [[ 3, "desc" ]],
        colReorder: true,
        dom: "<'row'<'col-sm-3'l><'col-sm-3'f><'col-sm-6'p>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    });
    $( "select" ).addClass( "selectpicker" )
});


$.fn.dataTable.ext.classes.sPageButton = 'btn btn-dark';

var data = $('#data-result').data('data');
var days = $('#days-result').data('days');
var datatab = data.split(",");
var daystab = days.split(",");



var ctx = document.getElementById('myChart');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: daystab,
        datasets: [{
            label: 'Transactions per day',
            data: datatab,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(215, 154, 124, 0.2)',
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(215, 154, 124, 1)',
            ],
            borderWidth: 1,
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                }
            }]
        },
        maintainAspectRatio: false,
    }
});
Chart.defaults.global.defaultFontSize = 17;