# Batch Link
<p>This application is made based on personal needs, as well as a programming exercise for me.</p>

<p>And one more thing, the text that you are reading now is the result of a translation from google translate, so I apologize if there is a tense or writing error in the previous paragraph or this paragraph.</p>

## After clone
```sh
cd batch-link
```
```sh
composer install
```
```sh
cp .env.example .env
```

```sh
php artisan key:generate
```

(database configuraton in .env file)

```sh
php artisan migrate --seed
```

```sh
npm install
```

```sh
npm run dev
```

```sh
php artisan serve
```
(default user in UserSeeder.php file)
