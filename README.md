# Welcome to Evi Admin Panel! 🚀

![Evi Admin Panel Screenshot](./screenshot.png)

This is one of my earliest projects, developed between 2018 and 2019 during my freelancing career. Evi Admin Panel is a closed administrative interface built with PHP, featuring an interactive interface powered by jQuery.

I've made this repository available to showcase my skills in working with PHP, MySQL databases, jQuery, and adaptive layout. All aspects, including database setup, scripting, logic, and responsive design, were developed solely by me.

## Key Features:

- **User Authentication**: A secure login and closed registration system with password encryption through PHP's `password_hash`. Registration is performed via a system of special codes generated within the admin panel.
- **Password Bruteforce Protection**: It incorporates an interactive CAPTCHA mechanism, triggered upon detecting multiple login attempts (utilizing Google reCaptcha technology).
- **Two-Factor Authentication (2FA)**: An additional layer of security based on email services and Google Authenticator.
- **Interactive Interface**: A fully interactive interface with animations implemented using jQuery.
- **Adaptive Layout**: The design is responsive and adapts to different screen resolutions.

## Getting Started:

1. Create a database and import the `evi-admin.sql` dump located at the project's root.
2. Connect the database in the `functions/database.php` configuration file.
3. Launch the project from your browser by visiting `index.php`.
4. To register, use some of the pre-populated codes already available in the database.

Feel free to explore the code and functionalities. This project is a testament to my early journey in web development and my passion for creating secure, interactive web applications.

Thank you for visiting Evi Admin Panel! 🌟
