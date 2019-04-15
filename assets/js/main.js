var $ = require('jquery');

require('bootstrap');
import '../css/main.css';
require('../css/global.scss');
require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});