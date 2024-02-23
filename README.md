# Silk Road Honeypot Project

## Table of Contents

1. [Overview](#overview)
2. [Honeypots with Solution](#honeypots-with-solution)
   - [Challenge 1 - Bruteforce](#challenge-1---bruteforce)
   - [Challenge 2 - SQL Injection](#challenge-2---sql-injection)
   - [Challenge 3 - XSS Payload](#challenge-3---xss-payload)
   - [Challenge 4 - Enumeration](#challenge-4---enumeration)
3. [Secure Part of Web Environment](#secure-part-of-web-environment)
   - [Admin Panel](#admin-panel)
   - [Logging Dashboards](#logging-dashboards)
   - [Telnet honeypot](#telnet-honeypot)
4. [Setting up the Web Environment](#setting-up-the-web-environment)

## Overview

Welcome to the Silk Road Honeypot Project! This project is designed to simulate a virtual environment. In this context, our honeypot emulates a vulnerable system that attracts potential attackers, allowing us to gather data and analyze their tactics.

## Honeypots with Solution


### Challenge 1 - Bruteforce
The goal of the challenge is to login to the secret login field. There will be a hint that gives a username and points to the directory `/hints/steghide.jpg` that says that the password might be in there. You will need to extract a bruteforce list with passwords out of that file using `steghide` using this command:

```bash
steghide extract -sf <stego_image> -xf <extracted_data>
```


In this command, `<stego_image>` should be replaced with the path to the steganographic image, and `<extracted_data>` should be replaced with the desired output file name where the passwords will be extracted.

Then just bruteforce with hydra or BurpSuite

Good luck with the challenge!

### Challenge 2 - SQL Injection
The goal of the challenge is to find the admin password.
There is a SQL Injection vulnerability in the search of the items. In this databases there is another table with userinformation.

```' UNION SELECT * FROM users -- ```
With this sql command you can find user information of user1.
But we need the admin password!


```' UNION SELECT * FROM users WHERE username = "admin" -- ```
We could use a where statement to find the admin password.

### Challenge 3 - XSS Payload

In this challenge you need to find the exact xss payload that corresponds to my payload. The input from the user gets checked in this challenge compared to a payload i created. If the payload is the same the user will get alerted with an challenge completed. Otherwise the xss payload will the passed through the ``` htmlspecialchars($input); ``` function to disable xss.

The solution is to use the following xss payload.
```
<img src='' onerror='alert(1)'>
```

If this payload is used the challenge will be completed.

### Challenge 4 - Enumeration

When you look in the sources you can find a non-encoded js file:

```
(async()=>{
    await new Promise((e=>window.addEventListener("load", e))),
    document.querySelector("form").addEventListener("submit", (e=>{
        e.preventDefault();
        const r = {
            u: "input[name=username]",
            p: "input[name=password]"
        }
          , t = {};
        for (const e in r)
            t[e] = btoa(document.querySelector(r[e]).value).replace(/=/g, "");
        return "YWRtaW4" !== t.u ? alert("Incorrect Username") : "VGhpc0lzQ29tcGxldGVHaWJiZXJpc2hEYXRhSEFIQQ" !== t.p ? alert("Incorrect Password") : void alert(`Challenged solved!`)
    }
    ))
}
)();


```

You can find base64 encode credentials: YWRtaW4 - VGhpc0lzQ29tcGxldGVHaWJiZXJpc2hEYXRhSEFIQQ

When you decode them you get : admin - ThisIsCompleteGibberishDataHAHA

With this these credentials you can login and complete the challenge.

## Secure Part of Web Environment

### Admin Panel

Our secure part of the web environment is located in the ``` private/admin ``` directory.

When logged in with our admin credentials you get sent over to a admin panel with a overview of the following:
- Currently logged in users
- Total registered users
- Manage users button

![Overview admin panel](/images/overview-admin.png "Overview")

Next when clicked on the manage users button you get sent over to a managing page for our users. On this page we have the following functions:
- Enable users
- Disable users

![Overview users manage](/images/manager-users.png "Overview")

When a user has been disabled and he tries to login they get an error notification telling them that their account has been disabled.

### Logging Dashboards

#### Attempts per user / challenge

This shows from which ip's the most request are made to that challenge

![Attempts per challenge](/images/Attemptsperchallenge.png "Attempts")


#### Total attempts per challenge

This visual shows the total number of request that are made per challenge
![Total Attempts per challenge](/images/totalattemptsperchallenge.png "Attempts")


#### Payloads Challenge 2

This diagram shows what payloads are most used in the SQL-injection Challenge 2

![Payloads challenge 2](/images/payloadschallenge2.png "payloads")

#### Telnet honeypot - Logins
This show from which ip's the most connections are made to the telnet honeypot
![Logins telnet honeypot](/images/telnethoneypot.png "telnethoneypot")

### Telnet honeypot
For our honeypot on another port, we used opencanary. Opencanary is a fake environnement that uses python. With this service we can log the attempted logins into our telnet honeypot. Opencanary provides more than enough honeypots that we can deploy to keep the attacker busy.

Opencanary is installed in the following way

```
$ sudo apt-get install python3-dev python3-pip python3-virtualenv python3-venv python3-scapy libssl-dev libpcap-dev
$ virtualenv env/
$ . env/bin/activate
$ pip install opencanary
```

When this is installed you can chroot into it using.

```
. env/bin/activate
```

With this you should generate a config file like so.
```
opencanaryd --copyconfig
```
This will generate a config file where in you can disable and enable services. After configuring the file located in ``` /etc/opencanaryd/opencanaryd.conf ```. You can start the honeypot using the following start command.

To start the honeypot/honeypots.

```
opencanaryd --start
```

Now the honeypot should be up and running. Check the log file for active logs.

## Setting up the Web Environment

To get started with the Silk Road Honeypot Project, follow these steps:

Before getting started you should have the following topics already installed as a prequisite.
- PHP for the web environment
- SQLite3 php plugin
- Apache-utils installed
- Mariadb installed
- Nginx

1. **Clone the Repository**

Before cloning the Silk Road honeypot project. Start with moving yourself into your prefered web hosting directory (/usr/share/nginx/).

```
git clone git@gitlab.ti.howest.be:ti/2023-2024/s3/websecurityandhoneypot/honeypotproject/group-08/code/honeypot-web.git
```
2. **Nginx Configuration**

When the project has been cloned you should change nginx configuration file according to the following layout.

<i>Where "change" is placed you should put your own configuration there.</i>

```

server {
    listen       80;
    server_name  honeypot;
    server_tokens off;

    return 301 https://$host$request_uri;
}

server {
    listen              443 ssl default_server;
    server_name         honeypot;
    ssl_certificate     /etc/ssl/certs/nginx-selfsigned.crt;
    ssl_certificate_key /etc/ssl/private/nginx-selfsigned.key;
    ssl_protocols       TLSv1 TLSv1.1 TLSv1.2 TLSv1.3;
    ssl_ciphers         HIGH:!aNULL:!MD5;

    root   /usr/share/nginx/honeypot-web;
    index  index.php index.html index.htm;

    server_tokens off;

    autoindex off;

    add_header X-Frame-Options "deny";
    add_header X-Content-Type-Options "nosniff";
    add_header Strict-Transport-Security "max-age=172800;
    includeSubDomains" always;

    location / {
        try_files $uri $uri/ =404;
        limit_except GET POST { deny all; }
    }

    location /hints/ {
        autoindex on;
        allow all;
    }

    location ~ /.git {
        deny all;
        return 404;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
        fastcgi_param  SCRIPT_FILENAME   $document_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_param DB_SERVER "127.0.0.1";
        fastcgi_param DB_USERNAME "admin";
        fastcgi_param DB_PASSWORD "%PCkuM@UFeP&g6";
        fastcgi_param DB_NAME "honeypot";
    }

    location ~ /\.ht {
        deny all;
    }

    location ^~ /private/admin/ {
    auth_basic "Administrator's Area";
    auth_basic_user_file /etc/apache2/.htpasswd;

    location ~ ^/private/admin/(admin_index.php|users.php)$ {
        auth_basic "Administrator's Area";
        auth_basic_user_file /etc/apache2/.htpasswd;

        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
        fastcgi_param  SCRIPT_FILENAME   $document_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_param DB_SERVER "127.0.0.1";
        fastcgi_param DB_USERNAME "admin";
        fastcgi_param DB_PASSWORD "%PCkuM@UFeP&g6";
        fastcgi_param DB_NAME "honeypot";
    }

    location ~ \.php$ {
        auth_basic "Administrator's Area";
        auth_basic_user_file /etc/apache2/.htpasswd;

        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
        fastcgi_param  SCRIPT_FILENAME   $document_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_param DB_SERVER "127.0.0.1";
        fastcgi_param DB_USERNAME "admin";
        fastcgi_param DB_PASSWORD "%PCkuM@UFeP&g6";
        fastcgi_param DB_NAME "honeypot";
    }

     try_files $uri $uri/ =404;
 }



}
```

3. **Mariadb configuration**

To make sure the login and registration works. You need to make a database with a user and a new table.

To make a database with a table execute the following script:
```
CREATE DATABASE honeypot;
USE honeypot;

CREATE TABLE `accounts` (
  `AccountsID` int(11) NOT NULL AUTO_INCREMENT,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `profile_picture` longblob DEFAULT NULL,
  `logged_in` tinyint(1) DEFAULT 0,
  `enabled` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`AccountsID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
```

Next make a user with the according nginx configuration credentials. This user needs to have the following grants:
- INSERT
- UPDATE
- SELECT

When this is done you should be able to connect to the mariadb database.

4. **PHP file configuration**

PHP needs a "connection.php" file to connect to the database. 

Example of connection.php file:

```
<?php

$dbServer = getenv("DB_SERVER");
$dbUsername = getenv("DB_USERNAME");
$dbPassword = getenv("DB_PASSWORD");
$dbName = getenv("DB_NAME");

$conn = new mysqli($dbServer, $dbUsername, $dbPassword, $dbName);
    
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
```

5. **Apache-utils**

- Install

   ```bash
   sudo apt install apache2-utils
   ```

- Make password

    ```bash
    htpasswd -c /etc/apache2/.htpasswd username
    ```

6. **Final**

- Make sure all needed services are up and running.

Now you have the web environment up and running.
