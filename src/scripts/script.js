import * as bootstrap from './bootstrap.bundle.min.js';
const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new Popover(popoverTriggerEl));