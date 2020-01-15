
require('../css/app.css');
require('../css/main.scss');

var $  = require( 'jquery' );
require( 'datatables.net' );
require( 'datatables.net-dt' );

$(document).ready(function() {
    let mainContenerPath = '';
    let stockInPath = 'products/in';
    let stockOutPath = 'products/out';
    let findPlacePath = 'findplace';
    let swapPath = 'products/replace';
    let availabilityPath = 'products';
    let contributorsPath = 'contributors';
    let adminPath = 'admin';
    let domain = 'http://127.0.0.1:8001/'; // only on dev!
    // let domain = 'http://127.0.0.1:8000/'; // only on dev!
    let currentDomain = window.location.pathname;
    let paths = [mainContenerPath, stockInPath, stockOutPath, findPlacePath, swapPath, availabilityPath, contributorsPath,adminPath];
    let idNavArray = [];

    $('.nav-link').each(function () {
        idNavArray.push(this.id);
    });

    for (let i = 0; i < paths.length; i++) {
        updateWindowLocation(idNavArray[i], paths[i], domain);
    }

    for (let i = 0; i < paths.length; i++) {
        updateNavTab(idNavArray[i], paths[i], currentDomain);
    }

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

});

function updateWindowLocation (selector, path, domain) {
    $('#' + selector).click(function(event) {
        event.preventDefault();
        window.location.replace(domain + path);
    });
}

function updateNavTab (selector, path, currentDomain) {
    let mainPath = '/';
    path = (path !== mainPath) ? mainPath + path : path;

    if (currentDomain === path) {
        $('.nav-link').removeClass('active');
        $('#' + selector).addClass('active');
    }
}

$.fn.dataTable.ext.classes.sPageButton = 'btn btn-dark';