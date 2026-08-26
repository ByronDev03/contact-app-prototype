<h1 align="center">Contact Manager App</h1>

---

### Frontend



---

### Backend



---

### Database Arquitecture

<details>
<summary>Conceptual Design (ER Diagram)</summary>

<div align="center">
    <img src="/assets/conceptual_design.png" width="600" alt="er relational"/>
</div>
</details>

<details>
<summary>Logical Design (Relational Model)</summary>

<div align="center">
    <img src="/assets/logical_design.png" width="600" alt="relational model"/>
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
    created_at  DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE contact (
    contact_id    CHAR(36)      NOT NULL PRIMARY KEY,
    user_id       CHAR(36)      NOT NULL,
    name          VARCHAR(80)   NOT NULL, 
    phone         VARCHAR(20)   NOT NULL UNIQUE,
    created_at    DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at    DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_contact_user
    FOREIGN KEY (user_id) REFERENCES user(user_id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
```
</details>