<h1 align="center">Backend – Contact App Manager</h1>

---

## Manejo de errores y validaciones

<details>
<summary>/users</summary>

<details>
<summary>Tests en create.php</summary>

<details>
	<summary>Test 1. → </summary>
	<img src="/frontend/assets/users_imgs/users_createT1.avif" width="600"/>
</details>

<details>
	<summary>Test 2.  → </summary>
	<img src="/frontend/assets/users_imgs/users_createT2.avif" width="600"/>
</details>

<details>
	<summary>Test 3.  → </summary>
	<img src="/frontend/assets/users_imgs/users_createT3.avif" width="600"/>
</details>

<details>
	<summary>Test 4.  → </summary>
	<img src="/frontend/assets/users_imgs/users_createT4.avif" width="600"/>
</details>

<details>
	<summary>Test 5.  → </summary>
	<img src="/frontend/assets/users_imgs/users_createT5.avif" width="600"/>
</details>

<details>
	<summary>Test 6.  → </summary>
	<img src="/frontend/assets/users_imgs/users_createT6.avif" width="600"/>
</details>	

</details>

---

<details>
<summary>Tests en get.php</summary>

<details>
	<summary>Test 1.  → </summary>
	<img src="/frontend/assets/users_imgs/users_getT1.avif" width="600"/>
</details>

<details>
	<summary>Test 2.  → </summary>
	<img src="/frontend/assets/users_imgs/users_getT2.avif" width="600"/>
</details>

<details>
	<summary>Test 3.  → </summary>
	<img src="/frontend/assets/users_imgs/users_getT3.avif" width="600"/>
</details>

<details>
	<summary>Test 4.  → </summary>
	<img src="/frontend/assets/users_imgs/users_getT4.avif" width="600"/>
</details>

<details>
	<summary>Test 5.  → </summary>
	<img src="/frontend/assets/users_imgs/users_getT5.avif" width="600"/>
</details>

<details>
	<summary>Test 6.  → </summary>
	<img src="/frontend/assets/users_imgs/users_getT6.avif" width="600"/>
</details>

</details>
	
---

<details>
<summary>Tests en update.php</summary>

<details>
	<summary>Test 1. Método HTTP incorrecto → 405 Method Not Allowed</summary>
	<img src="/frontend/assets/users_imgs/users_updateT1.avif" width="600"/>
</details>

<details>
	<summary>Test 2. JSON inválido → 400 Bad Request</summary>
	<img src="/frontend/assets/users_imgs/users_updateT2.avif" width="600"/>
</details>

<details>
	<summary>Test 3. Campos obligatorios faltantes → 400 Bad Request</summary>
	<img src="/frontend/assets/users_imgs/users_updateT3.avif" width="600"/>
</details>

<details>
	<summary>Test 4. Nombre mayor a 80 caracteres → 400 Bad Request</summary>
	<img src="/frontend/assets/users_imgs/users_updateT4.avif" width="600"/>
</details>

<details>
	<summary>Test 5. Email con formato inválido → 400 Bad Request</summary>
	<img src="/frontend/assets//users_imgs/users_updateT5.avif" width="600"/>
</details>

<details>
	<summary>Test 6. Usuario inexistente → 404 Not Found</summary>
	<img src="/frontend/assets/users_imgs/users_updateT6.avif" width="600"/>
</details>

<details>
	<summary>Test 7. Email perteneciente a otro usuario → 409 Conflict</summary>
	<img src="/frontend/assets/users_imgs/users_updateT7.avif" width="600"/>
</details>

<details>
	<summary>Test 8. Actualización correcta → 200 OK</summary>
	<img src="/frontend/assets/users_imgs/users_updateT8.avif" width="600"/>
</details>

<details>
	<summary>Test 9. Error interno de base de datos → 500 Internal Server Error</summary>
	<img src="/frontend/assets/users_imgs/users_updateT9.avif" width="600"/>
</details>

</details>	

---

<details>
<summary>Tests en delete.php</summary>

<details>
	<summary>Test 1. Método HTTP incorrecto → 405 Method Not Allowed</summary>
	<img src="/frontend/assets/users_imgs/users_deleteT1.avif" width="600"/>
</details>

<details>
	<summary>Test 2. JSON inválido → 400 Bad Request</summary>
	<img src="/frontend/assets/users_imgs/users_deleteT2.avif" width="600"/>
</details>

<details>
	<summary>Test 3. user_id faltante → 400 Bad Request</summary>
	<img src="/frontend/assets/users_imgs/users_deleteT3.avif" width="600"/>
</details>

<details>
	<summary>Test 4. Usuario inexistente → 404 Not Found</summary>
	<img src="/frontend/assets/users_imgs/users_deleteT4.avif" width="600"/>
</details>

<details>
	<summary>Test 5. Eliminación exitosa → 200 OK</summary>
	<img src="/frontend/assets/users_imgs/users_deleteT5.avif" width="600"/>
</details>

<details>
	<summary>Test 6. Error interno de base de datos → 500 Internal Server Error</summary>
	<img src="/frontend/assets/users_imgs/users_deleteT6.avif" width="600"/>
</details>

<details>
	<summary>Test 7. UUID con formato inválido → 400 Bad Request</summary>
	<img src="/frontend/assets/users_imgs/users_deleteT7.avif" width="600"/>
</details>

<details>
	<summary>Test 8. Enviar user_id con espacios antes y después → 200 OK</summary>
	<img src="/frontend/assets/users_imgs/users_deleteT8.avif" width="600"/>
</details>

<details>
	<summary>Test 9. user_id enviado como número → 400 Bad Request</summary>
	<img src="/frontend/assets/users_imgs/users_deleteT9.avif" width="600"/>
</details>

<details>
	<summary>Test 10. Enviar user_id: null → 400 Bad Request</summary>
	<img src="/frontend/assets/users_imgs/users_deleteT10.avif" width="600"/>
</details>

<details>
	<summary>Test 11. Enviar user_id: "" → 400 Bad Request</summary>
	<img src="/frontend/assets/users_imgs/users_deleteT11.avif" width="600"/>
</details>

<details>
	<summary>Test 12. Enviar espacios " " → 400 Bad Request</summary>
	<img src="/frontend/assets/users_imgs/users_deleteT12.avif" width="600"/>
</details>

</details>

</details>

---

<details>
<summary>/contacts</summary>

<details>
<summary>Tests en create.php</summary>

<details>
	<summary>Test 1. Creación exitosa → 201 Created</summary>
	<img src="/frontend/assets/contacts_imgs/contacts_createT1.avif" width="600"/>
</details>

<details>
	<summary>Test 2. Método HTTP incorrecto → 405 Method Not Allowed</summary>
	<img src="/frontend/assets/contacts_imgs/contacts_createT2.avif" width="600"/>
</details>

<details>
	<summary>Test 3. JSON inválido → 400 Bad Request</summary>
	<img src="/frontend/assets/contacts_imgs/contacts_createT3.avif" width="600"/>
</details>

<details>
	<summary>Test 4. Campos obligatorios faltantes → 400 Bad Request</summary>
	<img src="/frontend/assets/contacts_imgs/contacts_createT4.avif" width="600"/>
</details>

<details>
	<summary>Test 5. user_id inexistente → 404 Not Found</summary>
	<img src="/frontend/assets/contacts_imgs/contacts_createT5.avif" width="600"/>
</details>

<details>
	<summary>Test 6. Tipos de datos incorrectos → 400 Bad Request</summary>
	<img src="/frontend/assets/contacts_imgs/contacts_createT6.avif" width="600"/>
</details>

<details>
	<summary>Test 7. Error interno de base de datos → 500 Internal Server Error</summary>
	<img src="/frontend/assets/contacts_imgs/contacts_createT7.avif" width="600"/>
</details>

</details>

---
 
<details>
<summary>Tests de get.php</summary>

<details>
	<summary>Test 1. Obtener datos → 200 OK</summary>
	<img src="/frontend/assets/contacts_imgs/contacts_getT1.avif" width="600"/>
</details>

<details>
	<summary>Test 2. Obtener contactos por user_id → 200 OK</summary>
	<img src="/frontend/assets/contacts_imgs/contacts_getT2.avif" width="600"/>
</details>

<details>
	<summary>Test 3. user_id inválido → 400 Bad Request</summary>
	<img src="/frontend/assets/contacts_imgs/contacts_getT3.avif" width="600"/>
</details>

<details>
	<summary>Test 4. user_id válido pero inexistente → 200 OK</summary>
	<img src="/frontend/assets/contacts_imgs/contacts_getT4.avif" width="600"/>
</details>

<details>
	<summary>Test 5. user_id vacío → 400 Bad Request</summary>
	<img src="/frontend/assets/contacts_imgs/contacts_getT5.avif" width="600"/>
</details>

<details>
	<summary>Test 6. Error interno de base de datos → 500 Internal Server Error</summary>
	<img src="/frontend/assets/contacts_imgs/contacts_getT6.avif" width="600"/>
</details>

<details>
	<summary>Test 7. Método HTTP incorrecto → 405 Method Not Allowed</summary>
	<img src="/frontend/assets/contacts_imgs/contacts_getT7.avif" width="600"/>
</details>

</details>

---

<details>
<summary>Test de update.php</summary>

<details>
	<summary>Test 1. Actualización exitosa → 200 OK</summary>
	<img src="/frontend/assets/contacts_imgs/contacts_updateT1.avif" width="600"/>
</details>

<details>
	<summary>Test 2.  → </summary>
	<img src="/frontend/assets/contacts_imgs/contacts_updateT2.avif" width="600"/>
</details>

<details>
	<summary>Test 3.  → </summary>
	<img src="/frontend/assets/contacts_imgs/contacts_updateT3.avif" width="600"/>
</details>

<details>
	<summary>Test 4.  → </summary>
	<img src="/frontend/assets/contacts_imgs/contacts_updateT4.avif" width="600"/>
</details>

<details>
	<summary>Test 5.  → </summary>
	<img src="/frontend/assets/contacts_imgs/contacts_updateT5.avif" width="600"/>
</details>

<details>
	<summary>Test 6.  → </summary>
	<img src="/frontend/assets/contacts_imgs/contacts_updateT6.avif" width="600"/>
</details>

</details>

---

<details>
<summary>Test de delete.php</summary>

<details>
	<summary>Test 1. → </summary>
	<img src="/frontend/assets/contacts_imgs/contacts_deleteT1.avif" width="600"/>
</details>

<details>
	<summary>Test 2.  → </summary>
	<img src="/frontend/assets/contacts_imgs/contacts_deleteT2.avif" width="600"/>
</details>

<details>
	<summary>Test 3.  → </summary>
	<img src="/frontend/assets/contacts_imgs/contacts_deleteT3.avif" width="600"/>
</details>

<details>
	<summary>Test 4.  → </summary>
	<img src="/frontend/assets/contacts_imgs/contacts_deleteT4.avif" width="600"/>
</details>

<details>
	<summary>Test 5.  → </summary>
	<img src="/frontend/assets/contacts_imgs/contacts_deleteT5.avif" width="600"/>
</details>

<details>
	<summary>Test 6.  → </summary>
	<img src="/frontend/assets/contacts_imgs/contacts_deleteT6.avif" width="600"/>
</details>

</details>

</details>

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