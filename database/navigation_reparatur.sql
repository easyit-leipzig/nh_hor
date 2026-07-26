-- Reparatur/Audit für die datenbankgestützte Navigation
-- Vorher Sicherung der Tabelle navigation_items erstellen.

-- 1. Leere URLs normalisieren
UPDATE navigation_items
SET url = '#'
WHERE url IS NULL OR TRIM(url) = '';

-- 2. Aktivwerte normalisieren
UPDATE navigation_items
SET is_active = 1
WHERE is_active IS NULL;

-- 3. Verwaiste Parent-Verweise auf die Hauptebene setzen
UPDATE navigation_items AS child
LEFT JOIN navigation_items AS parent ON parent.id = child.parent_id
SET child.parent_id = NULL
WHERE child.parent_id IS NOT NULL
  AND child.parent_id <> 0
  AND parent.id IS NULL;

-- 4. Kontrolle: Diese Abfrage muss mindestens einen aktiven Haupteintrag liefern.
SELECT id, parent_id, title, url, sort_order, is_active
FROM navigation_items
WHERE is_active <> 0
ORDER BY COALESCE(NULLIF(parent_id, 0), 0), sort_order, id;
