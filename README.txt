BEDIENUNGSANLEITUNG:

Wenn man die Datenbank neu anlegt:
- Die Datenbank kann anhand der Datei "database_setup.sql" vollständig nachgebaut werden.
- Die INSERT INTO Statements fügen einige User, Reservierungen, Zimmer und Newsbeiträge automatisch in die Datenbank ein.
- Der Datenbank-Administrator muss manuell angelegt werden, indem man sich zuerst als normaler user auf der Webseite registriert. 
  In der Datenbank muss man diesen gerade erstellten user-Eintrag aus der "users" Tabelle aussuchen und den Eintrag in der Spalte "rolle" von "user" auf "admin" ändern.

Zugangsdaten zur Datenbank "hotel_management" (auch in der Datei "dbaccess.php" zu finden):
- host: localhost
- user: "hotel_administrator"
- passwort: "admin"


