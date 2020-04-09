# DownTown-RP

En este repositorio, podrás encontrar el GM de RolePlay basado en MTA-Paradise para Multi Theft Auto San Andreas.
Debido a que no habrá nuevas aperturas del servidor, he tomado la decisión de publicarlo para que cualquiera pueda
montarlo en su máquina, o incluso, que se anime a abrir un servidor.

No obstante, cabe recordar que estamos ante un GM con unos cuantos años a sus espaldas, desde 2010 que surge MTA-Paradise,
por lo que no se garantiza en ningún momento su correcto funcionamiento.

Además, hay sistemas que no han sido elaborados de aquí, sino que han sido extraídos de distintas fuentes (de otros GM públicos,
o sistemas públicos de MTA) que han sido adaptados a DownTown. Si eres el dueño de algunos de estos sistemas públicos, y no estás
de acuerdo con su reutilización, por favor, ponte en contacto conmigo a través de GitHub.

Sistemas interesantes que tiene la GM:

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

## Base para la Instalación

Se recomienda encarecidamente montar el servidor sobre la base MTA-Paradise, accesible desde https://github.com/mabako/mta-paradise/
Una vez instalado MTA-Paradise y siendo funcional, eliminar la carpeta 'resources' de ese GM y sustituirla por la de este.

## Detalles a tener en cuenta de cara a la Instalación

- La mayoría de los problemas surgen debido a los módulos de MySQL, necesarios para el correcto funcionamiento. Sigue los pasos descritos
en la Wiki de MTA para no tener problemas: https://wiki.multitheftauto.com/wiki/Modules/MTA-MySQL

- En el caso de Linux, puede ser necesario algún módulo más. Consúltalo aquí: https://linux.mtasa.com/

- Las credenciales de la base de datos (MySQL) deberán de ser editadas en la resource sql, archivo mysql.lua. ¡El archivo settings.xml
de MTA-Paradise SERÁ IGNORADO!

- En el archivo mtaserver.conf, al final del mismo, donde aparecen las resources que se iniciarán al arrancar el servidor, sólo debe aparecer:
```bash
    <resource src="((Logs-Downtown))" startup="1" protected="1" />
    <resource src="sql" startup="1" protected="1" />
    <resource src="players" startup="1" />
    <resource src="gresources" startup="1" protected="1" />
```
Este recurso o resource 'gresources' lo único que hace es iniciar el resto de sistemas.
  
 - Una vez esté todo funcionando, es recomendable reiniciar de forma manual las resources items, factions y gui para su correcta interoperabilidad.
 
 - Si no se va a realizar la integración con un foro SMF, es recomendable parar de forma manual (stop) las resources 'sqlforo', 'foro' y 'sqllogin'
 
 - En la carpeta 'db' se encuentran las estructuras SQL necesarias para el correcto funcionamiento del servidor. Una vez que se haya probado que
 MTA-Paradise funcione como debería, se debería de vaciar la base de datos, y subir el archivo .sql llamado 'server.sql'
 
 - Se adjunta también el archivo acl.xml, reemplazable por el proporcionado por MTA-Paradise para que no haya problemas en cuanto a permisos.
 
 ## Integración con foro SMF
 
 - Este GM es compatible con la integración de un foro SMF versión 2.1. Para ello, habrá que modificar la resource 'sqlforo'
 con las credenciales de la base de datos del foro.
 
 - A partir de aquí, la resource 'foro' se encargará de ofrecer al usuario vincular su usuario IG con su cuenta de foro.
 
 - Una vez vinculado, los permisos se sincronizarán de acuerdo a la configuración establecida en la tabla wcf1_user_to_group, donde groupIDForo
 será el ID del grupo de SMF.

- En la carpeta 'db' se encuentra la estructura de la base de datos que utiliza la resource 'foro' y 'sqllogin', hecha con el sentido de
que se pueda implementar un panel de inicio de sesión vía web u otros servicios, que permitan al usuario identificarse utilizando indistintamente
sus credenciales del servidor o del foro. El archivo .sql que contiene la estructura se llama 'login.sql' y debería de importarse en una base de
datos distinta a la del servidor, aunque NO es necesario hacer este paso si no se pretende integrar el servidor con ningún foro.

