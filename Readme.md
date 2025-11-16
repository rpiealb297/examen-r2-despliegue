# Guía de comprobación de PHP, instalación y uso del módulo Rewrite

## 1. Comprobar si PHP está activado

En la terminal ejecuta:

    php -v

- Si aparece una versión de PHP, significa que está instalado y activo.
- Si no aparece, continúa con el siguiente apartado.

---

## 2. Instalar PHP en Ubuntu

Actualiza e instala PHP y el módulo para Apache:

    sudo apt update
    sudo apt install php libapache2-mod-php php-cli

Reinicia Apache:

    sudo systemctl restart apache2

Puedes volver a comprobar:

    php -v

---

## 3. Comprobar y activar el módulo `rewrite` de Apache

Para ver si el módulo `rewrite` está activo:

    apache2ctl -M | grep rewrite

- Si ves `rewrite_module`, el módulo está activado.
- Si no aparece nada, actívalo con:

    sudo a2enmod rewrite
    sudo systemctl restart apache2

Después, permite el uso de `.htaccess` en tu VirtualHost. Edita el sitio por defecto:

    sudo nano /etc/apache2/sites-available/000-default.conf

Dentro del bloque `<VirtualHost>` asegúrate de tener un bloque parecido a:

    <Directory /var/www/>
        AllowOverride All
        Require all granted
    </Directory>

Guarda los cambios y reinicia Apache:

    sudo systemctl restart apache2

---

## 4. Uso de la aplicación

# API – Documentación de Uso

Esta API recibe peticiones HTTP y devuelve respuestas en formato JSON con distintos códigos de estado según el endpoint utilizado.

## 1. GET → `/load/client`
Devuelve una lista de clientes de prueba.

**Método:** GET  
**URL:** /load/client  
**Respuesta:**  
- **200 OK**  
- JSON con varios clientes de ejemplo.

---

## 2. POST → `/create/client`
Indica que un cliente ha sido creado correctamente.

**Método:** POST  
**URL:** /create/client  
**Respuesta:**  
- **201 Created**  
- JSON confirmando la creación.

---

## 3. PUT → `/update/client`
Indica que un cliente ha sido actualizado correctamente.

**Método:** PUT  
**URL:** /update/client  
**Respuesta:**  
- **202 Accepted**  
- JSON confirmando la actualización.

---

## 4. GET → `/admin/load`
Petición no autorizada para este recurso.

**Método:** GET  
**URL:** /admin/load  
**Respuesta:**  
- **401 Unauthorized**  
- JSON indicando que no está autorizado a acceder.

---

## 5. GET → `/admin/password`
Recurso prohibido.

**Método:** GET  
**URL:** /admin/password  
**Respuesta:**  
- **403 Forbidden**  
- JSON indicando que el acceso está prohibido.

---

## Notas
- Todas las respuestas se entregan en formato JSON.
- El servidor gestiona automáticamente los códigos de estado.
- No se permite CORS para llamadas externas.

