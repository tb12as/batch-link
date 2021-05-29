# Paste Link (API) 
<p>This application is made based on personal needs, as well as a programming exercise for me. There are only APIs built with laravel in this repository, for the front-end I haven't made it yet.</p>

<p>And one more thing, the text that you are reading now is the result of a translation from google translate, so I apologize if there is a tense or writing error in the previous paragraph or this paragraph.</p>

## After clone
1. ```cd paste-link```
2. ```composer install```
3. ```cp .env.example .env```
4. ```php artisan key:generate```
5. (database configuraton in .env file)
6. ```php artisan migrate --seed```
7. ```php artisan serve```
8. (default user in UserSeeder.php file)
