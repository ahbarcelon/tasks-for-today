# Tasks for Today

A CodeIgniter 4 + MySQL task manager. The Welcome, Task List, Profile, and About pages are public. Creating, editing, and archiving tasks requires login.

## Features

- Public Welcome page (`/`) showing only today's active tasks
- Public Task List (`/tasks`) showing every active task
- Public Profile and About pages
- Session-based login and POST-only logout
- Protected create (`/tasks/new`), update, and archive actions
- Server-side validation: title and task date are required
- Soft delete through `tasks.is_archived`; archived rows stay in the database and disappear from public lists
- CSRF protection on every form submission
- Docker and Railway deployment configuration

## Demo account

```text
Username: demo.student
Password: DemoPassword123!
```

The migration and seeder use `password_hash()`; the database stores only the password hash.

## Local setup with XAMPP

Requirements: PHP 8.2+ with `intl`, `mbstring`, and `mysqli`; MySQL/MariaDB; and XAMPP or another PHP environment.

1. Start MySQL.
2. Create the database:

   ```powershell
   C:\xampp\mysql\bin\mysql.exe -u root -e "CREATE DATABASE tasks_today_db"
   ```

3. Copy `.env.example` to `.env` and update the database values if needed.
4. Create the schema and sample records:

   ```powershell
   php spark migrate --all
   php spark db:seed TasksTodaySeeder
   ```

5. Start the application:

   ```powershell
   php spark serve
   ```

6. Open `http://localhost:8080`.

The seeder resets the tasks and users tables. Do not run it against data you want to keep.

## Routes

| Method | Route | Access | Purpose |
|---|---|---|---|
| GET | `/` | Public | Today's active tasks |
| GET | `/tasks` | Public | All active tasks |
| GET | `/profile` | Public | Demo user profile |
| GET | `/about` | Public | Project information |
| GET/POST | `/login` | Public | Login form and authentication |
| POST | `/logout` | Logged in | End the session |
| GET | `/tasks/new` | Logged in | New task form |
| POST | `/tasks` | Logged in | Create a task |
| GET | `/tasks/{id}/edit` | Logged in | Edit form |
| POST | `/tasks/{id}` | Logged in | Update a task |
| POST | `/tasks/{id}/delete` | Logged in | Set `is_archived = true` |

## GitHub setup

The `.gitignore` excludes `.env`, dependency folders, sessions, logs, caches, and debug files.

```powershell
git init
git add .
git commit -m "Build authenticated task manager"
git branch -M main
git remote add origin https://github.com/YOUR_USERNAME/tasks-for-today.git
git push -u origin main
```

Create the empty repository on GitHub before adding the remote. Do not add a GitHub README or `.gitignore` when creating it, because this project already contains both.

## Railway deployment

This repository includes a `Dockerfile`. Its entrypoint runs pending migrations before Apache starts. The authentication migration creates the demo user on a fresh database, so deployment does not need to run the destructive seeder.

1. In Railway, create a new project and choose **Deploy from GitHub repo**.
2. Select this repository.
3. Add a MySQL service to the same Railway project.
4. In the web service's Variables tab, add references to the MySQL service values using these exact names:

   ```text
   MYSQLHOST
   MYSQLPORT
   MYSQLUSER
   MYSQLPASSWORD
   MYSQLDATABASE
   ```

   Railway commonly supplies these automatically when the services are linked. The app also detects `RAILWAY_PUBLIC_DOMAIN` and uses it as the HTTPS base URL.

5. Generate a public domain for the web service under **Settings → Networking**.
6. Redeploy if Railway does not redeploy automatically after the database variables are added.
7. Open the public URL and log in with the demo account above.

The container honors Railway's `PORT` variable and serves only the `public/` directory.

## Verification checklist

- `php spark migrate --all` completes without errors.
- The demo password column begins with a password-hash prefix such as `$2y$`; plaintext is not stored.
- `/`, `/tasks`, `/profile`, and `/about` load while logged out.
- `/tasks/new` and `/tasks/{id}/edit` redirect to `/login` while logged out.
- Blank task title or task date returns validation messages.
- Logged-in create and update actions persist changes.
- Archive changes `is_archived` to `1` without deleting the row.
- Archived tasks are absent from both `/` and `/tasks`.
