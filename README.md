# DownTown-RP

En este repositorio, podrás encontrar el GM de RolePlay basado en MTA-Paradise para Multi Theft Auto San Andreas.
Debido a que no habrá nuevas aperturas del servidor, he tomado la decisión de publicarlo para que cualquiera pueda
montarlo en su máquina, o incluso, que se anime a abrir un servidor.

No obstante, cabe recordar que estamos ante un GM con unos cuantos años a sus espaldas, desde 2010 que surge MTA-Paradise,
por lo que no se garantiza en ningún momento su correcto funcionamiento.

Además, hay sistemas que no han sido elaborados de aquí, sino que han sido extraídos de distintas fuentes (de otros GM públicos,
o sistemas públicos de MTA) que han sido adaptados a DownTown. Si eres el dueño de algunos de estos sistemas, y no estás
de acuerdo con su reutilización, por favor, ponte en contacto conmigo a través de GitHub.

Por último, agradecer a todas las personas que han colaborado con DownTown a lo largo de estos años. Cada granito de arena aporta a que se haga un gran montón, y este es el montón: un GameMode público, dispuesto a cualquiera que quiera aprender a programar, lanzar su propio servidor, o simplemente trastear.

Sistemas interesantes que tiene el GM:

- Sistema de gestión administrativa mejorado (/duda, /interiores, /vehiculos...)
- Sistema de muebles
- Sistema de sexo (en desarrollo, no se acabó de terminar)
- Sistema de casino
- Sistema de armería con entrenamiento
- Sistema de maletero en vehículos
- Sistema de detección de 'cheats' monetarios calculando ganancias del usuario / hora jugada.
- Sistema de ropas.
- Sistema de teléfono avanzado.
- Sistema de mascotas.
- Sistema de gestión policial avanzado.
- Muchos otros sistemas...

## Instrucciones para la instalación

- Lo primero es descargar la última versión del repositorio. Puedes hacerlo desde aquí: https://github.com/Succionadora/DownTown-RolePlay/releases/tag/1.4 y haciendo click
en Source code (ya sea zip o tar.gz según te convenga)

- Descomprimir el archivo descargado, ir al archivo mysql.lua de la resource sql y escribir las credenciales de MySQL.
```bash
	local server = "127.0.0.1"
	local user = "USUARIO_DB"
	local password = "CLAVE_DB"
	local db = "NOMBRE_DB"
	local port = 3306
```

- Importar el archivo server.sql que se encuentra en la carpeta db a una base de datos. Puedes hacerlo a través de phpMyAdmin o del gestor de bases de datos que utilices.
**IMPORTANTE** si vienes de MTA-Paradise, asegúrate primero de vaciar la base de datos, eliminando todas las tablas. Sino, te encontrarás problemas con no poder iniciar sesión,
no poder crear interiores, vehículos, etcétera.

- **IMPORTANTE**: sólo es necesario importar el login.sql si se pretende integrar sistemas web (foro, CAU...) con el GM. Para lo que es el servidor, no es necesario.

- En el archivo mtaserver.conf, al final del mismo (donde aparecen las resources que se iniciarán al arrancar el servido) sólo debe aparecer:
```bash
    <resource src="((Logs-Downtown))" startup="1" protected="1" />
    <resource src="sql" startup="1" protected="1" />
    <resource src="players" startup="1" />
    <resource src="gresources" startup="1" protected="1" />
```
- Descarga el módulo MySQL que necesites desde https://wiki.multitheftauto.com/wiki/Modules/MTA-MySQL y sigue las instrucciones para su instalación.
Básicamente, si descargas la versión de 32 bits, lo único que debes de hacer es crear una carpeta llamada modules (mods/deathmatch/modules) y poner ahí el módulo.

- Igualmente, en el mtaserver.conf deberás especificar qué módulo necesitas (mta_mysql.dll para Windows; mta_mysql.so para Linux)
```bash
    <module src="mta_mysql.dll"/> <!-- Windows -->
    <module src="mta_mysql.so"/> <!-- Linux -->
```

- En el caso de Linux, puede ser necesario algún módulo más. Consúltalo aquí: https://linux.mtasa.com/

- Copia la carpeta resources y el archivo acl.xml a mods/deathmatch (**IMPORTANTE** elimina primero la carpeta resources o vacíala para evitar que se mezclen sistemas de otra GM)

- Una vez realizados estos pasos, puedes proceder a abrir el servidor. Todo debería estar funcionando correctamente.

- Si no vas a utilizar la integración con el foro, es recomendable parar la resource 'foro'.

## Posibles fallos durante la instalación

- La mayoría de los problemas surgen debido a los módulos de MySQL, necesarios para el correcto funcionamiento. Sigue los pasos descritos
en la Wiki de MTA para no tener problemas: https://wiki.multitheftauto.com/wiki/Modules/MTA-MySQL

- Las credenciales de la base de datos (MySQL) deberán de ser editadas en la resource sql, archivo mysql.lua. ¡El archivo settings.xml
de MTA-Paradise SERÁ IGNORADO!

- Si te da error al importar el archivo server.sql a través de tu gestor de bases de datos, asegúrate de que la base de datos está **vacía**
  
- Si al abrir el servidor se cierra solo, el problema será 99% relacionado con MySQL. Comprueba que has seguido todos los pasos, y que estás usando el módulo mta_mysql(.dll en Windows y .so en Linux). Comprueba que dicho módulo esté en la carpeta correcta (en la que indican en la Wiki de MTA del enlace anterior) y, por último, comprueba que las credenciales en resources/sql/mysql.lua sean las correctas.

- Es muy interesante revisar el archivo mods\deathmatch\logs\server.log en caso de que haya errores. Lo mejor es borrar el fichero, abrir el servidor y cerrarlo (o esperar a que se cierre solo) y, después, revisar este archivo.

- Si has descargado este GM con anterioridad y no podías ni crear interiores ni crear vehículos, decirte que esos fallos han sido **solucionados.** Descarga la última versión.
## Integración con foro SMF
 
- Este GM es compatible con la integración de un foro SMF versión 2.1. Para ello, habrá que modificar la resource 'sqlforo'
con las credenciales de la base de datos del foro y establecer la variable enabled en true (línea 22, fichero mysql.lua de la resource sqlforo y sqllogin).

- También habrá que establecer la variable enabled en true (línea 18, fichero foro.lua de la resource foro).
 
- A partir de aquí, la resource 'foro' se encargará de ofrecer al usuario vincular su usuario IG con su cuenta de foro.
 
- Para que la resource 'foro' funcione correctamente, será necesario incluir los archivos que se encuentran en /web/foro en el directorio web de donde se aloje el foro.
 
- Una vez vinculado, los permisos se sincronizarán de acuerdo a la configuración establecida en la tablas wcf1_group y wcf1_user_to_group, donde groupIDForo
será el ID del grupo de SMF.

- En la carpeta 'db' se encuentra la estructura de la base de datos que utiliza la resource 'foro' y 'sqllogin', hecha con el sentido de
que se pueda implementar un panel de inicio de sesión vía web que permitan al usuario identificarse utilizando indistintamente
sus credenciales del servidor o del foro. El archivo .sql que contiene la estructura se llama 'login.sql' y debería de importarse en una base de
datos distinta a la del servidor, aunque NO es necesario hacer este paso si no se pretende integrar el servidor con ningún foro.

## Integración con Mantis BugTracker (CAU)

- Este GM es compatible con la integración de un bug-tracker o centro de atención al usuario (CAU). Para ello, será necesario realizar la instalación de
Mantis BugTracker(https://www.mantisbt.org/) y adaptar el sistema de inicio de sesión de dicho BugTracker con el sistema de login empleado vía web.
 
- Para realizar dicha adaptación, habría que modificar los archivos 'login_page.php' y 'login_password_page.php', haciendo que al visitar estas páginas, se redirija
al usuario al panel de login web. Se adjuntan dentro de /web/cau estos dos archivos.
 
- Serán necesarias más modificaciones para que el CAU funcione según lo que se necesite, aunque estas modificaciones forman parte del propio proyecto de Mantis BugTracker,
por lo que no se darán las modificaciones hechas aquí.
 
- Al igual que no se proporciona el código del foro SMF entero, no se proporcionará el código del CAU debido a que son versiones que están obsoletas. Por tanto,
ruego encarecidamente que se descarguen e instalen las nuevas versiones desde SMF y MantisBT respectivamente.
