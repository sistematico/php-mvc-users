# PHP MVC SQLite CRUD (Users Version)

[![GitHub Workflow Status](https://img.shields.io/github/workflow/status/sistematico/php-mvc-users/Deploy?label=Github%20Action&logo=github&logoColor=white&style=flat-square)](https://github.com/sistematico/php-mvc-users/actions?query=workflow%3ADeploy)

PHP MVC CRUD using SQLite to create user log-in &amp; signup system

Simple CRUD project (Create, Read, Update, Delete) made with [PHP](https://php.net), [Mini3](https://github.com/panique/mini3) and [Twitter Boostrap 5](https://getbootstrap.com) with [SQLite3](https://www.sqlite.org) as database.

## Prerequisites
- [Nginx](https://www.nginx.com) or [Apache](https://www.apache.org)
- [PHP](https://php.net)
- [Composer](https://getcomposer.org)
- [Docker(opcional)](https://www.docker.com/)
- [Faith](https://en.wikipedia.org/wiki/Faith)

## Installation
- Unzip or clone this repository on your web server's webroot: `cd /var/www/html && git clone https://github.com/sistematico/php-mvc-lite`
- Got to https://site.com/pages/about and follow the instructions.
- Pray.

## Nginx
Nginx config suggestion:

```
server {
    listen 80;
    server_name localhost;
    error_log  /var/log/nginx/error.log;
    access_log /var/log/nginx/access.log;
    root /var/www/php-mvc-lite/public;

    location / {
    	index index.php;
        try_files /$uri /$uri/ /index.php?url=$uri&$args;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
    }    
}
```

## Docker

- https://gist.github.com/sistematico/8798adbc6b55e8e34b0bd093588b7a5f

## Demo

- [https://mvc-users.lucasbrum.net](https://mvc-users.lucasbrum.net)

## Credits
- [Arch Linux](https://archlinux.org)
- [Mini3](https://github.com/panique/mini3)
- [Twitter Boostrap 4](https://getbootstrap.com)
- [jQuery](https://jquery.com)
- [Composer](https://getcomposer.org)

## Contribute
- Collaborators are welcome!

## Contact
- lucas@archlinux.com.br

## Help
Donate any amount through <a href="https://pag.ae/bfxkQW"><img src="https://img.shields.io/badge/pagseguro-green"></a> or <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=DWHJL387XNW96&source=url"><img src="https://img.shields.io/badge/paypal-blue"></a>
