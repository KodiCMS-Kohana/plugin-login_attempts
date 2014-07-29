# Login attempts plugin for KodiCMS

Sometimes you need to add an extra protection to password-protected website. This article explains how access to the login page can be restricted after three unsuccessful login attempts. This schema uses visitors IP address to store log attempts in the database and block access to login feature for 30 minutes after third unsuccessful attempt.

There are a number of reasons to restrict access. One reason is security. Quite often users try to guess login and password combination to get unauthorized access to the system. Another reason is extra load on server.

## Install
Copy files to directory `cms\plugins\login_attempts`

## Installing using git
`git submodule add https://github.com/KodiCMS/plugin-login_attempts.git cms\plugins\login_attempts`

## Config
See `cms\plugins\login_attempts\config\login_attempts.php`