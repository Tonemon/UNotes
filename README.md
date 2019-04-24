# UNotes Project
<p align="center">My own note-taking software made with 5 programming languages (screenshots below).<br>
  <img alt="PICTURE logo" src="https://user-images.githubusercontent.com/18640201/56651894-563eff80-668a-11e9-9f90-905e0ff8e1ed.png" width="400">
  <img alt="PICTURE logo" src="https://user-images.githubusercontent.com/18640201/56652031-a322d600-668a-11e9-99d1-3648257ceb17.png" width="400">
  <img alt="PICTURE logo" src="https://user-images.githubusercontent.com/18640201/56652160-fac14180-668a-11e9-8b84-9f31cefc6dac.png" width="400">
  <img alt="PICTURE logo" src="https://user-images.githubusercontent.com/18640201/56652220-25ab9580-668b-11e9-964a-b8214b89372f.png" width="400">
</p>

## About This Project
UNotes is a small note-taking software, which can be installed locally to take offline notes. I made this with html, css, a bit of JavaScript, PHP &amp; mySQL. The purpose of this project is to build a small note-taking website/software like Evernote using PHP (for the backend) and mySQL (for the databases) without building an actual application using programming languages like Java or Python. I've chosen PHP for this project, because I am learning that language at the moment.

## Features
<ul>
  <li>3 Different user accounts with different permissions: normal, premium &amp; admin,<br>
  Normal user: unlimited notes, 3 notebooks, no premium features<br>
  Premium user: unlimited notes, unlimited notebooks, premium crown on 'all users' page and more<br>
  Admin user: All of the above, permission to add new users, respond to questions and more
  </li>
  <li>Take notes and save them in different notebooks to keep them seperated,</li>
  <li>Bookmark your most important notes to keep them at the top of the notes page,</li>
  <li>Let normal users use the built-in support panel for their questions and let admins respond to them,</li>
  <li>Users can change most of their information (like username, password and other information) on their own,</li>
  <li>User status shows when a user is Online/Offline just by logging in.</li>
</ul>

## Important Details
1. The UNotes project has 2 main domains: ```unotes.me``` and ```my.unotes.me```. The first domain acts like a homepage with the register new account option, about us page and more. The ```my.unotes.me``` page has a login page and is the place to take your notes.
2. This project contains two databases (called ```UNotesMAIN``` and ```UNotesDAT```). The ```UNotesMAIN``` database contains 4 tables: new users (from /register page), questions (from the support panel), users (with all active users) and usersclosed (with all deleted accounts). The ```UNotesDAT``` database contains 2 tables per user: the ```notes.#id#``` and ```notebook.#id#```.
3. There are 3 different account types with different perks and permissions:<br>
```Normal user```: This type of user has the basic features and would not have to pay for this service.<br>
```Premium user```: This type of user has all of the features available would need to pay a subscription fee.<br>
```Admin user```: This type of user helps maintaining the website and is able to add new users and edit their information.
4. Feel free to add/remove any user except the admin account (with userid 1 in the ```UNotesMAIN``` database), because this will create big problems with new user accounts.
5. It's recommended (for security reasons) to change the (password hashing) salt after installation on the ```my.unotes.me``` domain.
6. It's recommended to change the administrator account password (with userid 1), because this account can add/remove other accounts and other admins.

## Installation
If you want to install this project locally, please follow the following steps:
1. Download the latest version of this project (by using the 'Clone' option or the 'download from cloud' button on this page).
2. Make sure your system has apache, php and mysql installed (I'm using AMPPS because it has them all in one place).
3. Extract the two main folders (domains) called ```unotes.me``` and ```my.unotes.me``` to your localhost folder.
3. For optimal performance (and easier access) add the two entries below to your ```.host``` file:<br>
(This will let you use a custom url instead of ```localhost/unotes.me``` and ```localhost/my.unotes.me```)
<pre>127.0.0.1 unotes.me
127.0.0.1 my.unotes.me</pre>
4. Go to your PHPMyAdmin configuration (default: ```http://localhost/phpmyadmin/```) and add 2 new databases (called ```UNotesDAT``` and ```UNotesMAIN```) and add a user (called ```UNotesDAT```).<br>
For more information about the PHP connections and the password configuration go to the ```_inc/dbconn.php``` file.
5. Import the ```UNotesDAT.sql``` file to the 'UNotesDAT' database.
6. Import the ```UNotesMAIN.sql``` file to the 'UNotesMAIN' database.
7. Make sure the ```UNotes``` database user has permission to view/edit both databases.<br>
This can be done on the users page (```Users``` > ```Edit Privileges``` > ```Database``` > ```Add privileges on the following database(s)```)
6. Go to the <a href="http://unotes.me" target="_blank">homepage</a> or <a href="http://my.unotes.me" target="_blank">login page</a> and sign in using the following credentials:
<pre>Username: admin (the administrator account), password: admin
Username: premium (the premium account), password: premium
Username: normal (the normal account), password: normal</pre>
