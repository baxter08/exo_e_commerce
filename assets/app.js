/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';
import './styles/slider.scss';


// start the Stimulus application
import './bootstrap';
import 'tw-elements';

import {
    Carousel,
    initTE
} from "tw-elements";
initTE({
    Carousel
}, true); // set second parameter to true if you want to use a debugger

import 'htmx.org';
window.htmx = require('htmx.org');

import {
    Collapse,
    Dropdown,
    Ripple,
    initTE,
} from "tw-elements";

initTE({
    Collapse,
    Dropdown,
    Ripple
});