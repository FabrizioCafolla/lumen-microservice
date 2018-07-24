FROM nginx:1.10

ADD vhosts.conf /etc/nginx/conf.d/default.conf