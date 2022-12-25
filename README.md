# Caid

## How to use
- create a folder in xampp/htdocs/caid
- start xampp
- browse http://localhost/caid

## setting up db
- start xampp
- go to http://localhost/phpmyadmin/
- create a database name it 'caidsa'
- click the caidsa icon on the left panel (make sure na click)
- click import from the upper tab
- import caidsa.sql
- change configration under db/config change details according to your setup

## How to Add Game
- add the game folder in assets/game/yourfoldername
- add game module then name the game base on the folder created in assets  game/yourfoldername
- The game is references as assets/game/yourfoldername/index.html
- must ensure the the game has an index.html

## Note:
- able to add module
- able to user
- able to add admin
- able to login
- module content currently on merge conflict (will push on separate branch)
- quiz currently working on. 
- able to show list of students (no styling yet)
