FROM nginx:1.10

ADD Docker/nginx/vhosts.conf /etc/nginx/conf.d/default.conf