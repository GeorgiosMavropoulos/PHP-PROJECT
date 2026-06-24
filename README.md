\# 🚴 Cit-E Cycling — Web Portal \& Admin Dashboard



A full-stack PHP web application for managing a regional cycling club network — built with vanilla \*\*PHP, MySQL (PDO), HTML, CSS, and Bootstrap 5\*\*.



Public visitors can register interest in upcoming cycling events, while authenticated admins get a secure dashboard to manage participants, search performance data, and view aggregated club statistics.



\---



\## ✨ Features



\### Public side

\- \*\*Event interest registration\*\* — visitors submit their details via a validated form, with duplicate-entry and email-format checks handled server-side.

\- \*\*Responsive landing page\*\* — built with Bootstrap 5, mobile-friendly layout.



\### Admin dashboard (session-protected)

\- \*\*Secure authentication\*\* — login system using PHP sessions, with route-level guards on every restricted page (any direct URL access without a valid session is redirected).

\- \*\*Full CRUD on participants\*\* — create, view, edit, and delete cyclist records (name, email, power output, distance, club).

\- \*\*Smart search\*\*

&#x20; - Search participants by first/last name (partial match).

&#x20; - Search by club name, returning the full roster \*\*plus auto-calculated statistics\*\*: total/average distance and total/average power output across all club members.

\- \*\*SQL injection protection\*\* — all queries use parameterized PDO statements (`prepare` / `bindParam`).

\- \*\*XSS protection\*\* — all dynamic output is escaped with `htmlspecialchars()` before being rendered.

\- \*\*Logout flow\*\* with confirmation prompts to prevent accidental session loss.



\---



\## 🛠️ Tech Stack



| Layer | Technology |

|---|---|

| Backend | PHP 8, PDO (MySQL driver) |

| Database | MySQL / MariaDB |

| Frontend | HTML5, CSS3, Bootstrap 5.3, Font Awesome 6 |

| Auth | PHP native sessions |



\---



\## 📂 Project Structure



```

├── index.html                     # Public landing page

├── register\_form.html             # Public event-interest registration form

├── register.php                   # Handles registration form submission

├── admin\_login.html                # Admin login form

├── login.php                      # Authenticates admin \& starts session

├── logout.php                     # Destroys session

├── admin\_menu.php                  # Admin dashboard home

├── search\_form.php                 # Search UI (by participant or club)

├── search\_result.php               # Search logic + club statistics

├── view\_participants\_edit\_delete.php  # Participant list with edit/delete actions

├── edit\_participant\_form.php       # Edit form for a single participant

├── edit\_participant.php            # Handles participant update

├── delete.php                      # Handles participant deletion

├── dbconnect.php                   # Centralized DB connection config

└── cycling.sql                     # Database schema + seed data

```



\---



\## 🗄️ Database Schema



Four tables: `user` (admin credentials), `participant` (cyclists \& their stats), `club` (cycling clubs), and `interest` (public event sign-ups).



```sql

participant(id, firstname, surname, email, power\_output, distance, club\_id)

club(id, name, location)

interest(id, firstname, surname, email, terms)

user(id, username, password)

```



\---



\## 🚀 Getting Started



1\. \*\*Clone the repo\*\*

&#x20;  ```bash

&#x20;  git clone https://github.com/GeorgiosMavropoulos/cit-e-cycling.git

&#x20;  ```

2\. \*\*Import the database\*\*

&#x20;  ```bash

&#x20;  mysql -u root -p < cycling.sql

&#x20;  ```

3\. \*\*Configure the connection\*\* in `dbconnect.php`:

&#x20;  ```php

&#x20;  $servername = "localhost";

&#x20;  $username   = "root";

&#x20;  $password   = "your\_password";

&#x20;  $database   = "cycling";

&#x20;  ```

4\. \*\*Serve the app\*\* (e.g. with PHP's built-in server or XAMPP/WAMP):

&#x20;  ```bash

&#x20;  php -S localhost:8000

&#x20;  ```

5\. Visit `http://localhost:8000` — register interest as a visitor, or log in via \*\*Admin login\*\* (seed credentials: `admin` / `password123`).



\---



\## 🔐 Security Notes



This was built as a learning project to practice secure PHP fundamentals:

\- Parameterized queries throughout (no raw string concatenation in SQL).

\- Output escaping on every user-supplied value rendered to HTML.

\- Session-based access control on all admin routes.



> Seed credentials are for local/demo use only — rotate them before any real deployment, and consider hashing passwords (e.g. `password\_hash()`) for production use.



\---



\## 📈 Possible Next Steps



\- Password hashing with `password\_hash()` / `password\_verify()`

\- CSRF tokens on forms

\- Pagination for large participant lists

\- REST API layer for the participant/club data



\---



ub.com/GeorgiosMavropoulos) · \[LinkedIn](https://www.linkedin.com/in/george-mavropoulos-509a6a326/)

