#!/bin/bash
#production servefr 
PD_SERVER=192.168.1.4
#backup production server
BPD_SERVER=192.168.1.5
#QA server 
QA_SERVER=192.168.1.7
USERNAME=amandeep
cd /var/www/html
if [[ "$#" -eq 0 ]] ; then
echo "specify the version to rollback to as an argument"
sleep 2
exit
fi

VERSION=$1
DIRECTORY=/var/www/html/$VERSION
if [ ! -d "$DIRECTORY" ] ; then 
echo "directory doesnt exist"
sleep 2
exit
fi

cd /var/www/html/$VERSION

#push the project to production server
sftp $USERNAME@$PD_SERVER:/var/www/html/ <<EOF
 put -r healthyrecipies
chmod 777 healthyrecipies*
EOF
echo "Rollback to $VERSION completed- Primary Production Server"
sleep 5s

sftp $USERNAME@$BPD_SERVER:/var/www/html/ <<EOF
 put -r healthyrecipies
chmod 777 healthyrecipies*
EOF
echo "Rollback to $VERSION completed- Backup Production Server"
sleep 5s

sftp $USERNAME@$QA_SERVER:/var/www/html/ <<EOF
put -r healthyrecipies
chmod 777 healthyrecipies*
EOF
echo "Rollback to $VERSION completed- QA  Server"
sleep 5s

echo "script now exiting .......Thank you" 

sleep 5s
exit


