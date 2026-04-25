#URL SHORTNER

**Generate Short URL and Redirect to Your Original URL**

#Clone the Repo Using HTTPS

#Open your terminal in your System and run this command showing below

**git clone https://github.com/mohitnauty/url-shortener.git**

**cd url-shortener/**

#After check php and composer is installed in your system using

**php -v and composer -v**

#If above requirement fulfill then proceed for further, if not then download php and composer and configure in your system

#Further Process for setup, here are the steps

**1. Copy and paste file .env.example and rename it to .env**

#Create Database 

**2. Add DB name, user, password in .env file for DB_DATABASE, DB_USERNAME, DB_PASSWORD**

#Run commands in your project directory(url-shortener)

**3. composer install** #Wait for this it takes little bit time

**4. php artisan key:generate**

**5. php artisan optimize:clear**

**6. php artisan storage:link**

**7. php artisan migrate --seed**

**8. npm install**

**9. npm run build**

**10. php artisan serve**

#Setup is ready open **http://127.0.0.1:8000** in Browser

#Login Page will be visible

#Can Login Using Credentials 

**Email : superadmin@test.com**
**Password : password**

#OR you can get it from directory - /url-shortener/database/seeders/DatabaseSeeder.php

***Note:** Default password for new user : "123456"*

**When any invitation sent to any email, a new user will be created for that particular email and linked to that company.**

**Tests**

#- SuperAdmin can invite an Admin in a new company

#- An Admin can invite another Admin or Member in their own company

#- Admin and Member can create short urls

#- SuperAdmin cannot create short urls

#- Admin can only see the list of all short urls created in their own company

#- Member can only see the list of all short urls created by themselves

#- Short urls are publicly resolvable and redirect to the original url

*If any challenge faced while setup and testing feel free to connect over email*

**Thank You**
