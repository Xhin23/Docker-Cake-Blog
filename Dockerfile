FROM xhin23/lampcake
COPY ./src/ /var/www/html/
COPY ./init/ /var/www/html/init
ENTRYPOINT /var/www/html/init/init.sh && /bin/bash
