# Parche de Seguridad Nº1

- Fecha de liberación del parche: 28/04/2020

- Este es un parche de seguridad, para subsanar dos fallos que han sido detectados.

- Para su instalación, sólo se debe de copiar las carpetas 'freecam' y 'gui' y pegarlas en el directorio de resources.

- Si has descargado el GM después de la fecha de liberación del parche, no será necesario aplicar el parche.

## Detalles del Parche

- Resource freecam, se hizo una modificación hace mucho tiempo que incluía un comando para que, al estar en
freecam, te fuera curando automáticamente. Sin embargo, el comando no comprueba si eres staff o no, por lo
que si el comando es utilizado por un usuario cualquiera, podrá regenerar su vida todo lo que quiera.

- Resource gui, se hizo una modificación para que en caso de que fallaran resources esenciales, se pudieran
reiniciar incluso aunque no se tuvieran permisos. Se hizo con el fin de que en caso de que fallara el sistema
de login, se pudiera reiniciar la resource esencial sin tener que estar identificado.
