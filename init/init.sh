#!/bin/bash
service mysql start
mysql -u root --password=7gNdqn=zpx2D{{bh < /var/www/html/init/init.sql
mysql -u root --password=7gNdqn=zpx2D{{bh blog < /var/www/html/init/blog.sql
rm -rf /var/www/html/init
apache2-foreground
