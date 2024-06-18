/* eslint-disable */
import * as bootstrap from './bootstrap.js';

const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new Popover(popoverTriggerEl));
