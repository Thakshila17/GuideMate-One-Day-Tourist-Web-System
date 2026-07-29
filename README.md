# 🌍 GuideMate System

## 📌 About the Project

GuideMate is a web-based travel guide system designed to help users plan one-day trips efficiently. It allows users to explore attractions, view attraction details, save places, and generate routes with time and distance in a simple and user-friendly way.

---

## 🎯 Key Features

- 👤 User registration and login system
- 🗺️ View and manage attractions
- 📍 Save places & generate routes
- 🛠️ Admin panel for system management

---

## ⚙️ Technologies Used

- **Backend:** PHP (Laravel Framework)
- **Frontend:** HTML, CSS, JavaScript, Bootstrap
- **Database:** MySQL
- **Tools:** VS Code, XAMPP, OpenStreetMap, Leaflet

---

## 🛠️ Setup Instructions

### 📌 Requirements

Make sure you have the following installed:

- XAMPP
- PHP (version 8 or above recommended)
- MySQL
- Composer
- Node.js & npm
- Web browser (Chrome recommended)

---

### 📂 Project Setup

1. Extract the project folder
2. Copy the folder into:

```
C:\xampp\htdocs
```

3. Start:

- Apache
- MySQL

---

### 📦 Install Dependencies (IMPORTANT)

To reduce file size, the `vendor` and `node_modules` folders are not included.

Run the following commands inside the project folder:

```bash
composer install
npm install
```

---

### 🗄️ Database Setup

1. Open phpMyAdmin

```
http://localhost/phpmyadmin
```

2. Create a new database:

```
guidemate_db
```

3. Import the database file:

- Click the database
- Go to **Import**
- Select the `.sql` file
- Click **Go**

---

### ⚙️ Configuration

1. Open `.env` file

2. Update database settings:

```
DB_DATABASE=guidemate_db
DB_USERNAME=root
DB_PASSWORD=
```

---

### ▶️ Running the System

1. Open terminal in project folder

2. Run:

```bash
php artisan serve
```

3. Open browser and go to:

```
http://127.0.0.1:8000/login
```

---

## 🔑 Login Details

### 👤 User

- Username: johnPerera
- Password: john123

### 🔐 Admin

- Name: admin
- Password: admin123

---

## ⚠️ Important Notes

- The `vendor` and `node_modules` folders are excluded to reduce file size
- Run the following commands before starting the project:

```bash
composer install
npm install
```

- The `.git` folder has been removed as it is not required for running the system

- The `storage` folder has been cleaned (logs, cache, and unnecessary files removed)

- If images or uploaded files are not displaying, run:

```bash
php artisan storage:link
```

- Ensure your `.env` file is correctly configured before running the project

- If any issue occurs, try clearing cache:

```bash
php artisan config:clear
php artisan cache:clear
```

---

## 📌 Project Status

This system was developed as part of an academic project.

---

## 👨‍💻 Author

**Senerath SPTM**
**E2320536**
**ITE2953 - Programming Group Project**
