**Run project**
- ./run.sh

**Restore DB dump**
- cd dump
- ./mysql.sh
- cd /home/dump
- mysql -u root -proot visitor_counter < ./dump.sql


- Please open site http://localhost:8185

- Please opne simple DB adminer http://localhost:8006/?server=mysql&username=visitor_counter&db=visitor_counter&password=password# visitor_info


To solve the problem, I used the md5 hash of the fields: ip_address + user_agent + page_url.
but a variant with the use of a multi-column UNIQUE index is possible

example
UNIQUE KEY `un_visitor` (`ip_address`,`user_agent`, `page_url`)

**educational project, passwords are changed in commands directly, don't be surprised by this :-)**