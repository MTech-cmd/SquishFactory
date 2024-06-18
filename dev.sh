npm install

npm run build

sass --watch site/stylesheets/src:site/stylesheets/dist &

nodemon --watch site/scripts/src --ext js --exec "sh -c '
  ncp site/scripts/src/ site/scripts/dist/
  echo \"Copied JS files\"
'" &

wait