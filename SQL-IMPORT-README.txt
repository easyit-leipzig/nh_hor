SQL-IMPORT FÜR DEN ADMINBEREICH
================================

In phpMyAdmin die gewünschte Datenbank auswählen und genau diese Datei importieren:

    SQL_ADMINBEREICH_IMPORTIEREN.sql

Die gleiche Datei liegt zusätzlich hier:

    database/INSTALL_ADMINBEREICH.sql

Das Skript legt die Tabelle homepage_blocks an und fügt Beispieldaten nur dann ein,
wenn die jeweiligen Datensätze noch nicht vorhanden sind.

Die bisherigen Einzeldateien bleiben zusätzlich unter database/migrations erhalten.
