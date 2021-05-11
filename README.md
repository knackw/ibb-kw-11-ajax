#IBB Weiterbildung Bilddatenbanken mit Ajax und MySQL®

Link: https://www.ibb.com/weiterbildung/bilddatenbanken-mit-ajax-und-mysql

Webdesign und -entwicklung ist aus der heutigen Zeit kaum mehr wegzudenken. Neben Internetseiten, 
die für Präsentationszwecke und Eigenwerbung bestimmter Zielgruppen genutzt werden, gibt es auch 
solche, die lediglich mit verschiedenen Eingaben und Abfragen einen Sinn ergeben. Dazu zählen 
z. B. Foren, Reservierungs- bzw. Buchungs-Systeme oder automatisierte Bestell-Abwicklungen.
Dieser Kurs vermittelt Ihnen fortgeschrittene Kenntnisse bezüglich der Erstellung dynamischer 
Webinhalte. Danach sind Sie in der Lage, anhand von Kundenangaben einen mit einer Datenbank 
verbundenen Webauftritt zu erstellen.

## Inhalt der Weiterbildung

- Erstellung eines eigenen CMS
- Weiterführende PHP-Kenntnisse
- Ajax-Programmierung bzgl. Datenerfassung
- Einrichtung lokaler Server
- PHP- und MySQL-Installation

### PHP

- Umgebungsvariablen GET, POST, SESSION
- ARRAYS (indiziert, assoziativ)
- Empfang/Verwaltung Upload Bild
- Anlage Javascript Array/PHP Array in Ausgabedokument
- Erstellung eines Demo-Eingabeformulars

### MySQL

- Definitionen einer Datenbank
- phpmyadmin für Datenverwaltung
- einfache SQL-Abfragen für Datenbank
- Umgebungsvariablen auslesen und in Datenbank ablegen

### Vorbereitung für die Datenerfassung

- Formular mit Upload-Möglichkeiten
- Photoshop-Bildaufbereitung für Slideshow
- html-Gerüst für „alle Gruppenmitglieder“ erstellen
- Datenbank: Einrichtung von Tabellen

### Ausgabemodul

- Auslesen der Daten mit SQL
- Empfang der Daten in Ajax-Modul
- html-Ausgabe
- Projektgestaltung und Präsentation des CMS

## 1. Installieren von Docker und Docker Compose

Siehe hierzu: https://github.com/knackw/docker_nginx_php8_mariadb10_phpmyadmin410

## 2. Installation der HTML Entwicklungsumgebung

**1) Webserver erzeugen**

Mit dem unten angegeben Terminal Kommando wird Entwicklungsumgebung generiert 
und anschließen der Service (Server) gestartet. Du musst Dich im Verzeichnis des Projektes befinden, 
indem sich die Datei docker-compose.yml befindet.

`docker-compose up`

Sollte ein Fehler aufgetreten sein und am Setup Anpassungen vorgenommen haben musst Du folgenden Befehl ausführen.

`docker-compose up --build`

Zum Beenden des Services gibst du

`docker-compose down`

ein.

**2) Tabelle anlegen**

Um die Tabelle zu erzeugen muss das Script `tables_creator.php` im Verzeichnis `./www/public/connection/` ausgeführt werden.

## 5. Schlussbemerkung

Solltest Du Fehler entdecken, Vorschläge oder Anregungen haben scheu Dich nicht mir ein Ticket zu schreiben. 

Happy coding :)





