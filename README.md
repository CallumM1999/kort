# Kort

 PHP link shortener.

## Contents

- [About](#About)

### About

Kort is a website built on top of [Elegenta](https://github.com/CallumM1999/Eleganta), a PHP MVC framework that I built. The purpose of this site was to reinforce what I learned when building the framework.

The main focus was the functionality, so I kept design simple and used Bootstrap.

I also used [Redis](https://redis.io/) in the framework, because I have wanted to learn it for a while. I will admit, this probably wasnt the best usecase for redis, however, this project was about learning, and that it has acheieved.

### What I learned

Overall, the project was a success. This time I focused on the functionality, and it paid off.

#### Framework

I would say the biggest issue was the templating engine I added to my framework. It was lacking many features, and some methods did't work correctly. Next time, I would use an open source framework, such as Blade.

Also seperating a controller by the route method. I would have route routes for get and post.

#### Deployment

I also learned how to deploy a PHP application to Heroku. It was incredibly simple when using heroku cli.

#### Composer

I also used composer for the first time. It is very similar to NPM.

### Deployment

Once I had build the project locally, it was easy to deploy it on heroku.
First, I created a heroku app using the official php buildpack.

    heroku create --buildpack heroku/php

Then I pushed the project to heroku.

    git push heroku master

Finally, I connected addons for redis any mysql.

    heroku addons:create rediscloud:30
    heroku addons:create jawsdb:kitefin

The site is now live any ready to use.