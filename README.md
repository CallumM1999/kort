# Kort

 PHP link shortener.

## Contents

- [About](#About)

### About

Kort is a website built on top of [Elegenta](https://github.com/CallumM1999/Eleganta), a PHP MVC framework that I built. The purpose of this site was to reinforce what I had learned when building the framework.

The main focus was the functionality, so I kept design simple and used Bootstrap.

I also used [Redis](https://redis.io/) in the framework. I will admit, this probably wasn't the best use-case for Redis, however, I wanted to learn it.

### What I learned

Overall, the project was a success. I learned a huge amount about PHP, Composer, Redis, deployment and the structuring of a project. Learn more about the framework [here](https://github.com/CallumM1999/Eleganta).

### Deployment

Once I had build the project locally, it was easy to deploy on Heroku.
First, I created a Heroku app using the official PHP build pack.

    heroku create --buildpack heroku/php

Next,  I pushed the project to Heroku using git.

    git push heroku master

Finally, I connected addons for Redis and MySQL to the app.

    heroku addons:create rediscloud:30
    heroku addons:create jawsdb:kitefin

The website is now deployed and is ready to use.
