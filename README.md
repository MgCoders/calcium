# Silicon - Website Cudecoop
Si_14 - This website was developed with Wordpress

The Graphic Design was developed by lateral http://lateral.com.uy/


Wordpress en contenedor Docker detrás de Nginx+LetsEncrypt
----------------------------------------------------------
### Sitio

Cada sitio debe configurar su virtual host en el docker-compose.yml y datos para el certificado LetsEncrypt en variables de entorno y el contenedor Nginx descubre el puerto interno al levantarlo. Para cada sitio nuevo, hay que configurar un subdominio en AWS que será el virtual host.

En env del docker-compose.yml

    VIRTUAL_HOST: silicon.mgcoders.com
    LETSENCRYPT_HOST: silicon.mgcoders.com
    LETSENCRYPT_EMAIL: info@mgcoders.com

### Servidor

Es necesario crear una red compartida:

    sudo docker network create nginx-proxy

### Secretos

Los secretos van en variables de entorno.

### Posibles Problemas

#### Error
    ERROR: for web  Cannot start service web: driver failed programming external
    connectivity on endpoint 9452d5f10a14_silicon_web_1
    (76ffe36c3639478cb5a1d0269dbeb831fd1e7ad7a17c3a5d2537eff44aa4c59b): Error
    starting userland proxy: Bind for 0.0.0.0:80: unexpected error (Failure
    EADDRINUSE)
    ERROR: Encountered errors while bringing up the project.

#### Solucion en mac
    sudo /usr/sbin/apachectl stop

