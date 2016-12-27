ssh -i ~/.ssh/altitude-shared.pem bitnami@54.255.140.54 "rm -rf /opt/bitnami/apps/wordpress/htdocs/wp-content/plugins/metisa; mkdir /opt/bitnami/apps/wordpress/htdocs/wp-content/plugins/metisa"

scp -r -i ~/.ssh/altitude-shared.pem . bitnami@54.255.140.54:/opt/bitnami/apps/wordpress/htdocs/wp-content/plugins/metisa

# ssh -i ~/.ssh/altitude-shared.pem bitnami@54.255.140.54 "wp plugin --path='/opt/bitnami/apps/wordpress/htdocs/' update metisa"
