<p>An application for maintaining a database of rented films></p>
<p>(HTML5, CSS, Bootstrap 5, PHP, SQL, Laravel)</p>

<h3 align="left">Description</h3>
<p>The video library is envisioned as an app where there is only one administrator, and they can add, edit, or delete movies, genres, and people associated with the film (such as stars, writers). The administrator adds new members and manages the borrowing of movies by members, as well as keeps track of the movie records and returns from members who have rented them. If a member fails to return a movie on time, they pay a late fee, which the admin also monitors, and after the fee is paid, the admin clears their records. There is also a statistics page where, in the form of charts, one can see the most rented movies, the most active members, and more.</p>

<p>Check out this project on YT: https://www.youtube.com/watch?v=5KEDkjO4-6U</p>

<h3 align="left">Iinstallation and settings</h3>

1. Clone the repository
2. composer install
3. Copy env.example to .env file and configure the database settings.
4. php artisan key:generate
5. npm install (you may need to run npm audit and npm audit fix if the installed versions are outdated and require updating).
6. npm run dev
7. npm run build
8. php artisan migrate (ensure that the database settings in the .env file are configured and that the database is created in phpMyAdmin or a similar tool).
9. php artisan db:seed (you can logIn in app with email: admin@gmail.com and password: password)
10. php artisan serve
