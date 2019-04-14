var $ = require('jquery');

require('bootstrap');
import '../css/main.css';
require('../css/global.scss');

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});