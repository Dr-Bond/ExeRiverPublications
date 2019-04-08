var $ = require('jquery');

require('../css/global.scss');
require('bootstrap');
import '../css/main.css';

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});