<VirtualHost *:80>
    ServerName localhost  # Set this to your desired server name

    DocumentRoot "C:/Apache24/htdocs"  # Path to your document root

    WSGIScriptAlias / /C:/Apache24/htdocs/app.wsgi  # Path to app.wsgi

    <Directory "C:/Apache24/htdocs">  # Path to your directory
        Options FollowSymLinks
        AllowOverride None
        Require all granted
    </Directory>
</VirtualHost>
