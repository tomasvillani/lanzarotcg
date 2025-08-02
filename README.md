<p align="center"><a href="#"><img src="/public/img/logo-extendido.png" width="400" alt="LanzaroTCG"></a></p>

## LanzaroTCG

LanzaroTCG es una plataforma web diseñada para facilitar el intercambio de cartas de juegos de cartas coleccionables (TCG), actualmente soportando colecciones de One Piece, Digimon, Pokémon y Magic: The Gathering. Los usuarios pueden crear, proponer y gestionar intercambios de manera sencilla y segura, conectando con otros coleccionistas para ampliar sus mazos.

LanzaroTCG surge de mi interés tanto por el desarrollo web como por el mundo de los TCG, especialmente Pokémon, que ha sido una gran inspiración. La idea fue crear un espacio donde los aficionados pudieran intercambiar cartas de forma cómoda y confiable.

Además, LanzaroTCG surgió para cubrir una necesidad real en la comunidad de Lanzarote, donde no existía hasta ahora un espacio digital dedicado exclusivamente al intercambio de cartas de TCG. De esta forma, busca fomentar la interacción y el crecimiento de la comunidad local y más allá.

## ¿Qué pueden hacer los usuarios de LanzaroTCG?

En LanzaroTCG, los usuarios pueden gestionar su colección de cartas de manera intuitiva, agregando, editando o eliminando las cartas que poseen. También pueden proponer intercambios ofreciendo cartas propias y solicitando cartas de otros coleccionistas.

Además, la plataforma permite gestionar todas las propuestas de intercambio recibidas, aceptándolas, rechazándolas o consultando detalles para tomar la mejor decisión. Así, LanzaroTCG facilita un proceso seguro y transparente para que los usuarios amplíen y mejoren sus mazos con confianza.

## Instalación

Para ejecutar **LanzaroTCG** localmente, sigue estos pasos:

### Requisitos previos:

- PHP >= 8.1 , y todas las extensiones necesarias:
```
sudo apt install software-properties-common -y
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update
sudo apt install php php-cli php-mbstring php-xml php-bcmath php-curl php-zip unzip curl -y
```
Confirma la instalación de PHP:
```
php -v
```
- Composer
```
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```
Verifica la instalación:
```
composer --version
```
- MySQL
```
sudo apt install mysql-server php-mysql -y
```
Configura la base de datos y el usuario correspondiente:
```
sudo mysql
CREATE DATABASE lanzarotcg;
CREATE USER 'lanzarotcg'@'localhost' IDENTIFIED BY 'lanzarotcg';
GRANT ALL PRIVILEGES ON *.* TO 'lanzarotcg'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```
- Node.js
```
sudo apt install nodejs npm
```
Confirma la instalación:
```
node -v
npm -v
```
- Git
```
sudo apt install git
```
Confirma la instalación:
```
git --version
```

1. Clona el repositorio:
```
git clone https://github.com/tomasvillani/lanzarotcg.git
```
2. Accede a la carpeta:
```
cd lanzarotcg
```
3. Otorga los permisos correspondientes:
```
sudo chmod 777 -R ./*
```
4. Instala las dependencias de Composer y de Node.js:
```
composer install
npm install
npm run build
```
5. Copia el archivo .env.example a un archivo .env.
6. Modifica estas líneas del .env:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lanzarotcg
DB_USERNAME=lanzarotcg
DB_PASSWORD=lanzarotcg
```
7. Genera la clave de encriptación:
```
php artisan key:generate
```
8. Ejecuta las migraciones:
```
php artisan migrate
```
9. Para poder almacenar las imágenes para las cartas, ejecuta el siguiente comando:
```
php artisan storage:link
```
10. Inicia el servicio:
```
php artisan serve
```

De esta manera, si accedes por 127.0.0.1:8000, la página debe aparecer sin problema.

### Tareas programadas (opcional)

LanzaroTCG incluye una tarea programada que elimina automáticamente los intercambios caducados y las cartas asociadas a partir del día siguiente de la propuesta.

Para que esta funcionalidad funcione correctamente en entornos de producción, debes añadir el siguiente cron job a tu sistema:
```
* * * * * cd /ruta/a/tu/proyecto && php artisan schedule:run >> /dev/null 2>&1
```

## Documentos de interés

Consulta los siguientes documentos para obtener información detallada sobre el proceso de desarrollo:

- [Documento de análisis](https://drive.google.com/file/d/1cfj9VyrZCsYJsvvssfEttVlIQ6ubsBtb/view?usp=sharing)
- [Documento de diseño](https://drive.google.com/file/d/1MrqSNClZ07Ei8lgATAisC2sm_jUi9F7z/view?usp=sharing)
