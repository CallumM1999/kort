# Kort

PHP link shortener using Redis

## About

Kort is a PHP app build on top of [Elegenta MVC Framework](https://github.com/thecallum/Eleganta) that allows you to add long unfriendly URL's, and get a small friendly link back. 

I created Kort because I wanted to build a project using Elegenta, an MVC PHP framework that I build in a previous project.

Kort also uses Redis. In hindsight, this wasn't a great use-case for Redis, however, I wanted to try it out, and I learned a lot from using it.

## What I learned

Overall, the project was a success. I learned a huge amount about PHP, Composer, Redis, deployment and the structuring of a project. Learn more about the framework [here](https://github.com/thecallum/Eleganta).

## Deployment

Once I had built the project locally, it was easy to deploy on Heroku.
First, I created a Heroku app using the official PHP build pack.

    heroku create --buildpack heroku/php

Next,  I pushed the project to Heroku using git.

    git push heroku master

Finally, I connected addons for Redis and MySQL to the app.

    heroku addons:create rediscloud:30
    heroku addons:create jawsdb:kitefin

The website is now deployed and is ready to use.
