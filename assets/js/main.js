var $ = require('jquery');

require('../css/global.scss');
require('bootstrap');

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});