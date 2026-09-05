<h1 align="center">Contact Manager App</h1>

A full-stack contact management application for creating, managing and organizing users and contacts.

---

## About the Project
<p align="justify">Contact Manager App is a full-stack web application designed to manage users and contacts.</p>

<p align="justify">The application allows users to perform CRUD operations through a frontend interface connected to a PHP REST API and a MySQL database.</p>

<p align="justify">This project is being developed as a learning project to practice full-stack web development concepts, including frontend development, backend development, REST APIs, HTTP methods, database design and operations, validation, and error handling.</p>

---

## Features



---

## Technologies
**Frontend**
- HTML5
- CSS3
- JavaScript

**Backend**
- PHP
- REST API

**Database**
- MySQL

---

### Database Arquitecture

<details>
<summary>Conceptual Design (ER Diagram)</summary>

<div align="center">
    <img src="/frontend/assets/conceptual_design.png" width="600" alt="er relational"/>
</div>
</details>

<details>
<summary>Logical Design (Relational Model)</summary>

<div align="center">
    <img src="/frontend/assets/logical_design.png" width="600" alt="relational model"/>
</div>
</details>

<details>
<summary>Physical Design (SQL Schema)</summary>

```sql
CREATE DATABASE bd_contact_app;

USE bd_contact_app;

CREATE TABLE user (
    user_id     CHAR(36)      NOT NULL PRIMARY KEY,
    name        VARCHAR(80)   NOT NULL, 
    email       VARCHAR(80)   NOT NULL UNIQUE,
    password    VARCHAR(255)  NOT NULL,
    created_at  DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE contact (
    contact_id    CHAR(36)      NOT NULL PRIMARY KEY,
    user_id       CHAR(36)      NOT NULL,
    name          VARCHAR(80)   NOT NULL, 
    phone         VARCHAR(20)   NOT NULL,
    created_at    DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at    DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_contact_user
    FOREIGN KEY (user_id) REFERENCES user(user_id) ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
```
</details>

---

## Installation

---

## Author
*Developed by Byron Jorge Ortega Cuenca*