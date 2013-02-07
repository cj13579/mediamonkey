# MediaMonkey

MediaMonkey is a PHP based media management system which allows you to access your media from your XBMC library where ever you are in the world.

## Notes

It is advised that you password protect access to the site so to prevent unauthorised access to your media. To configure apache for this you can use this quick-fire guide:

### Apache Security Config

Add the following to your site document. For example, /etc/apache2/sites-available/defaut

    <Directory "/var/www/downloads/">
      DAV on
      Options +Indexes
      AuthType Basic
      AuthName "Private Documentation Repository"
      AuthUserFile /etc/apache2/downloadusers
      Require valid-user
      AllowOverride None
      Order allow,deny
      allow from all
    </Directory>
                                        
Create user file by running the following command:
                                        
    sudo httpd -c /etc/apache2/users
                                            
Restart Apache
                                            
                                            
## LICENSE
                                            
This software is available under the following licenses:
                                            
* GPL
                                              
===========
