FROM nginx:1.10

ADD Docker/vhosts.conf /etc/nginx/conf.d/default.conf