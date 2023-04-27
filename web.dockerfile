FROM nginx:alpine

# Copy configuration
ADD vhost.conf /etc/nginx/conf.d/default.conf

# Logging symlinks
RUN ln -sf /dev/stdout /var/log/nginx/access.log \
	&& ln -sf /dev/stderr /var/log/nginx/error.log

# Copy static files
COPY public /var/www/public
