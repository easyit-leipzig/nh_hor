# Visueller Editor für Homepage-Block-Kacheln

## Installation

Bei einer bestehenden Datenbank einmalig importieren:

`database/2026-07-25_homepage_block_wysiwyg.sql`

Bei einer Neuinstallation sind die Felder bereits in `database/INSTALL_ADMINBEREICH.sql` und im vollständigen Datenbankstand enthalten.

## Verwendung

1. Adminbereich öffnen.
2. **Homepage-Blöcke** wählen.
3. Einen Block bearbeiten oder neu anlegen.
4. Farben, Layout, Abstände, Größen, Bilddarstellung, Schatten und Hover-Effekt im visuellen Editor einstellen.
5. Die Vorschau über **Desktop**, **Tablet** und **Mobil** prüfen.
6. Optional den **Experten-CSS-Modus** öffnen und zusätzliche CSS-Deklarationen eingeben.
7. **Block speichern** wählen.

Der Expertenmodus akzeptiert ausschließlich Deklarationen für die jeweilige Kachel. Selektoren, geschweifte Klammern, `@import`, JavaScript-URLs und vergleichbare unsichere Konstrukte werden abgewiesen.
