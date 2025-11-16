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

### 4.1. Descargar la aplicación

Clona el repositorio:

    git clone https://github.com/pepe/mi-app-next

Entra en la carpeta del proyecto:

    cd mi-app-next

### 4.2. Desplegar en Apache

Copia el contenido del proyecto a la carpeta del sitio web.  
Por ejemplo, si tu dominio será:

- Para **José Martínez Pérez** → `www.miaplicacionjomape.com`
- Para **María Rodríguez Pérez** → `www.miaplicacionmarope.com`

Crea la carpeta del sitio:

    sudo mkdir -p /var/www/www.miaplicacion<iniciales>.com

Copia los archivos:

    sudo cp -r * /var/www/www.miaplicacion<iniciales>.com/

Ajusta permisos (ejemplo básico):

    sudo chown -R www-data:www-data /var/www/www.miaplicacion<iniciales>.com

### 4.3. Configurar el VirtualHost (resumen)

Crea un archivo de sitio en Apache, por ejemplo:

    sudo nano /etc/apache2/sites-available/www.miaplicacion<iniciales>.com.conf

Con una estructura similar a:

    <VirtualHost *:80>
        ServerName www.miaplicacion<iniciales>.com
        DocumentRoot /var/www/www.miaplicacion<iniciales>.com

        <Directory /var/www/www.miaplicacion<iniciales>.com>
            AllowOverride All
            Require all granted
        </Directory>
    </VirtualHost>

Activa el sitio y recarga Apache:

    sudo a2ensite www.miaplicacion<iniciales>.com.conf
    sudo systemctl reload apache2

### 4.4. Acceso desde el navegador

En el navegador, accede a:

    http://www.miaplicacion<iniciales>.com

Si todo está correcto, la aplicación debería mostrarse usando Apache, con PHP (si es necesario) y con el módulo `rewrite` disponible para `.htaccess`.

