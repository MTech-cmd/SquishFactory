sass site/stylesheets/src:site/stylesheets/dist

mkdir -p site/scripts/dist

echo "/* eslint-disable */
import * as bootstrap from './bootstrap.js';

const popoverTriggerList = document.querySelectorAll('[data-bs-toggle=\"popover\"]');
const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new Popover(popoverTriggerEl));" > site/scripts/dist/script.js

ncp node_modules/bootstrap/dist/js/bootstrap.bundle.js site/scripts/dist/bootstrap.js
echo "/* eslint-disable */" | cat - site/scripts/dist/bootstrap.js > temp
mv temp site/scripts/dist/bootstrap.js

ncp site/scripts/src/ site/scripts/dist/