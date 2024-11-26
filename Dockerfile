FROM registry.port30.net:443/techglow/docker-images:latest
COPY ./deployment/techglow.se /etc/nginx/sites-enabled/techglow.se
COPY techglow/ /var/www/techglow/
RUN rm /etc/nginx/sites-enabled/default