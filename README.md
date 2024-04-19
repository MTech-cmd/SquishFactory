Bootstrap
Bootswatch
Fontawesome
Quicksand
PHP
HTML
JS
SASS
MariaDB
Docker
Apache
Stripe
PHPMailer

Example mellow 1340x1560

TODO: Add logo

# About
This is a website where you can customize your own squishmellow.\
This site is fully developed by me, Mehdi El Khallouki.\
I developed this website as an end-years project for my study at the Bit Academy as a full-stack developer.\

TODO: Add screenshot

# TOC
[Features](#features)
[The Stack](#the-stack)
[Installation](#installation)

# Features
There are many features to this website but the main ones are customizing and ordering squishmellows. Customizing them. Adding new ones. and much more\

# The Stack
Naturally I use the popular LAMP (Linux, Apache, MariaDB, PHP) stack but in addition I used a few other tools like Bootstrap (powered by Bootswatch) Fontawesome.\
Quicksand for the font. PHPMailer for the emailing component and Stripe as a payment processor.

TODO: Add stack logos

# Installation
To host this on your own server configure a proper LAMP stack and clone the repo then deploy all the contents of the /src directory into the root of your server folder.\
Then run the /db/import.sql script into your MySQL console (This may be the CLI, PHPMyAdmin or DataGrip).\

## Docker
There is also a dockerized version of this program available. This is accesible in the releases tab on Github.\
You do not have to run the import.sql script.
TODO: expand on Docker

## Mock data
There are also mock data and assets available for use. To initialize them right away also run /db/mock.sql. You can choose not to run this but know that the content of /assets/accessories /assets/base-mellows /assets/custom-mellows and /assets/landing must be cleared to save space on redundant assets.\
If you do decide to use the mock data the standard login and password for the admin page are "Admin" for both.