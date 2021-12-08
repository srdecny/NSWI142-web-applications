#!/bin/bash
set -e

SSH_USERNAME="CHANGEME"
SSH_PORT="42222"
DB_USERNAME="CHANGEME"
DB_PASSWORD="CHANGEME"

if grep -q "CHANGEME" php/db_config.php; then
		echo "Please change the database credentials in php/db_config.php. WeirdChamp"
		exit 1
fi

if [ "$SSH_USERNAME" = "CHANGEME" ] || [ "$DB_USERNAME" = "CHANGEME" ] || [ "$DB_PASSWORD" = "CHANGEME" ]; then
		echo "Please change the default values in the script before running it. WeirdChamp"
		exit 1
fi

SSH="$SSH_USERNAME@webik.ms.mff.cuni.cz"

echo "Rsyncing php folder"
rsync -r -e 'ssh -p '$SSH_PORT php/ $SSH:~/public_html/

echo "Clearing out database"
ssh $SSH -p $SSH_PORT "mysql -u $DB_USERNAME -p$DB_PASSWORD -e \"DROP DATABASE stud_$DB_USERNAME\""
ssh $SSH -p $SSH_PORT "mysql -u $DB_USERNAME -p$DB_PASSWORD -e \"CREATE DATABASE stud_$DB_USERNAME\""

echo "Executing SQL scripts"
for script in db/*.sql; do
	ssh $SSH -p $SSH_PORT mysql -u $DB_USERNAME -p$DB_PASSWORD -D stud_$DB_USERNAME < $script
	echo $script executed!
done
