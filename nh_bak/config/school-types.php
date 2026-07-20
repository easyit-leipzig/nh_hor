<?php
declare(strict_types=1);

return [
    'grundschule' => [
        'file' => 'nachhilfe-grundschule-leipzig.php',
        'name' => 'Grundschule',
        'title' => 'Nachhilfe Grundschule Leipzig | Grundlagen sicher aufbauen',
        'description' => 'Nachhilfe für Grundschulkinder in Leipzig: Mathematik, Lesen, Schreiben, Sachunterricht und Lernorganisation – orientiert an den aktuellen sächsischen Lehrplänen.',
        'lead' => 'In der Grundschule entstehen Zahlvorstellung, Sprache, Lernfreude und erste selbstständige Arbeitsweisen. Die Förderung greift die verbindlichen Lernbereiche des sächsischen Lehrplans auf und übersetzt sie in verständliche, kindgerechte Lernschritte.',
        'focus' => 'Grundlagen, Lernfreude und verlässliche Routinen',
        'topics' => ['Zahlvorstellung und Rechnen','Sachaufgaben','Lesen und Textverständnis','Rechtschreibung','Sachunterricht','Arbeitsorganisation'],
        'standards_intro' => 'Der sächsische Grundschullehrplan verbindet Wissenserwerb mit Lernkompetenz, fächerverbindendem Arbeiten und zunehmender Selbstständigkeit. In Mathematik geht es nicht nur um richtige Ergebnisse, sondern um Vorstellungen, Strategien und das Erklären von Lösungswegen.',
        'competencies' => [
            ['title' => 'Mathematische Grundlagen', 'text' => 'Zahlen sicher erfassen, Rechenoperationen verstehen, Größen und Formen anwenden sowie Sachaufgaben sprachlich und rechnerisch erschließen.'],
            ['title' => 'Lesen und Schreiben', 'text' => 'Texte sinnentnehmend lesen, Inhalte wiedergeben, Wörter und Sätze zunehmend sicher schreiben und eigene Texte verständlich strukturieren.'],
            ['title' => 'Sachunterricht und Weltwissen', 'text' => 'Beobachten, beschreiben, vergleichen, einfache Zusammenhänge erkennen und Fragen an Natur, Technik und Gesellschaft entwickeln.'],
            ['title' => 'Lernkompetenz', 'text' => 'Arbeitsaufträge verstehen, Materialien ordnen, Ergebnisse kontrollieren und schrittweise verlässliche Routinen aufbauen.'],
        ],
        'support' => [
            'Lücken werden mit anschaulichen Materialien und kleinen, überprüfbaren Schritten geschlossen.',
            'Rechenwege und Gedanken werden schriftlich festgehalten, damit Fehlerquellen sichtbar werden.',
            'Lesen, Sprache und Mathematik werden dort verbunden, wo Textverständnis über den Erfolg entscheidet.',
            'Übungsumfang und Tempo richten sich nach Konzentrationsspanne und aktuellem Lernstand.'
        ],
        'roadmap' => [
            ['step' => '1', 'title' => 'Sichere Basis', 'text' => 'Grundfertigkeiten und Zahlvorstellungen überprüfen.'],
            ['step' => '2', 'title' => 'Verstehen', 'text' => 'Aufgaben handelnd, bildlich und sprachlich erschließen.'],
            ['step' => '3', 'title' => 'Üben', 'text' => 'Strategien wiederholen, ohne bloß Aufgabenmuster auswendig zu lernen.'],
            ['step' => '4', 'title' => 'Selbstständig anwenden', 'text' => 'Neue Aufgaben erklären, kontrollieren und zunehmend allein bearbeiten.'],
        ],
        'sources' => [
            ['label' => 'Sächsische Lehrplandatenbank – Grundschule Mathematik', 'url' => 'https://www.schulportal.sachsen.de/lplandb/lehrplan/68'],
            ['label' => 'Sächsische Lehrplandatenbank – Grundschule Deutsch', 'url' => 'https://www.schulportal.sachsen.de/lplandb/lehrplan/908'],
            ['label' => 'Sächsische Lehrplandatenbank – Grundschule Sachunterricht', 'url' => 'https://www.schulportal.sachsen.de/lplandb/lehrplan/80'],
        ],
    ],
    'oberschule' => [
        'file' => 'nachhilfe-oberschule-leipzig.php',
        'name' => 'Oberschule',
        'title' => 'Nachhilfe Oberschule Leipzig | Schule und Abschluss',
        'description' => 'Nachhilfe für Oberschülerinnen und Oberschüler in Leipzig – lehrplanorientierte Grundlagenarbeit, aktueller Schulstoff und gezielte Abschlussvorbereitung.',
        'lead' => 'Die Oberschule verbindet Allgemeinbildung, Berufsorientierung und unterschiedliche Abschlusswege. Die Förderung orientiert sich an den aktuellen sächsischen Fachlehrplänen und konzentriert sich zugleich auf die Aufgaben, die im Unterricht und in Prüfungen tatsächlich verlangt werden.',
        'focus' => 'Schulstoff sichern und Abschlüsse vorbereiten',
        'topics' => ['Mathematik','Physik und Chemie','Informatik','Deutsch und Sprachen','Präsentationen','Abschlussprüfungen'],
        'standards_intro' => 'Aktuelle Bildungsstandards beschreiben Kompetenzen für den Ersten und den Mittleren Schulabschluss. Dazu gehören fachliches Wissen, problemlösendes Denken, Kommunikation, der Umgang mit Darstellungen sowie die Anwendung auf alltags- und berufsbezogene Situationen.',
        'competencies' => [
            ['title' => 'Sicher mit Grundlagen arbeiten', 'text' => 'Rechnen, Terme, Gleichungen, Funktionen, Geometrie und Daten so festigen, dass neue Themen darauf aufbauen können.'],
            ['title' => 'Naturwissenschaftlich denken', 'text' => 'Beobachtungen auswerten, Modelle nutzen, Größen berechnen, Experimente beschreiben und Ergebnisse begründen.'],
            ['title' => 'Aufgaben verstehen', 'text' => 'Operatoren, Fachsprache, Tabellen, Diagramme und mehrschrittige Aufgaben systematisch entschlüsseln.'],
            ['title' => 'Abschlüsse vorbereiten', 'text' => 'Prüfungsformate kennenlernen, Themen priorisieren, Zeit einteilen und typische Fehler gezielt auswerten.'],
        ],
        'support' => [
            'Grundlagen und aktueller Unterrichtsstoff werden getrennt diagnostiziert und anschließend sinnvoll verbunden.',
            'Die Aufgabenbearbeitung folgt einer festen Struktur: verstehen, planen, schriftlich lösen, prüfen und erklären.',
            'Berufsbezogene und alltagsnahe Anwendungen machen abstrakte Inhalte nachvollziehbar.',
            'Vor Abschlussprüfungen wird mit prüfungsnahen Formaten und realistischen Zeitvorgaben gearbeitet.'
        ],
        'roadmap' => [
            ['step' => '1', 'title' => 'Lernstand ordnen', 'text' => 'Sichere und unsichere Themen sichtbar machen.'],
            ['step' => '2', 'title' => 'Lücken schließen', 'text' => 'Fehlende Grundlagen gezielt nacharbeiten.'],
            ['step' => '3', 'title' => 'Anwenden', 'text' => 'Aufgaben in wechselnden Kontexten und Darstellungen lösen.'],
            ['step' => '4', 'title' => 'Prüfung trainieren', 'text' => 'Operatoren, Zeitmanagement und Kontrolle festigen.'],
        ],
        'sources' => [
            ['label' => 'Sächsische Lehrplandatenbank – Oberschule Mathematik', 'url' => 'https://www.schulportal.sachsen.de/lplandb/lehrplan/67'],
            ['label' => 'Sächsische Lehrplandatenbank – Oberschule Informatik', 'url' => 'https://www.schulportal.sachsen.de/lplandb/lehrplan/514'],
            ['label' => 'KMK – aktuelle Bildungsstandards', 'url' => 'https://www.kmk.org/bildungsministerkonferenz/bildungsthemen/bildungsstandards.html'],
        ],
    ],
    'gymnasium' => [
        'file' => 'nachhilfe-gymnasium-leipzig.php',
        'name' => 'Gymnasium',
        'title' => 'Nachhilfe Gymnasium Leipzig | Unterstufe bis Oberstufe',
        'description' => 'Nachhilfe für Gymnasiastinnen und Gymnasiasten in Leipzig – lehrplanorientiert von der Unterstufe bis zur gymnasialen Oberstufe.',
        'lead' => 'Am Gymnasium steigen Abstraktion, Fachsprache und die Anforderungen an Transfer und Begründung. Die Unterstützung folgt den aktuellen sächsischen Fachlehrplänen und baut zugleich die Lernstrategien auf, die für Klausuren und die Oberstufe benötigt werden.',
        'focus' => 'Transfer, Fachsprache und anspruchsvolle Prüfungsformate',
        'topics' => ['Unter- und Mittelstufe','Oberstufe','Mathematik','Physik und Chemie','Informatik','Klausurtraining'],
        'standards_intro' => 'Gymnasiale Aufgaben verlangen zunehmend, Wissen nicht nur wiederzugeben, sondern auf unbekannte Situationen zu übertragen, Zusammenhänge fachsprachlich zu erklären, Modelle kritisch zu nutzen und Lösungswege nachvollziehbar zu begründen.',
        'competencies' => [
            ['title' => 'Mathematisch argumentieren', 'text' => 'Begriffe präzise verwenden, Vermutungen prüfen, Lösungswege begründen und Darstellungen sicher wechseln.'],
            ['title' => 'Modelle nutzen', 'text' => 'Reale Sachverhalte mathematisch oder naturwissenschaftlich modellieren und die Grenzen eines Modells einschätzen.'],
            ['title' => 'Experiment und Auswertung', 'text' => 'Messwerte, Diagramme und Versuchsaufbauten auswerten, Unsicherheiten erkennen und Schlussfolgerungen formulieren.'],
            ['title' => 'Informatische Systeme verstehen', 'text' => 'Daten, Algorithmen, Modelle, Implementierungen und vernetzte Systeme strukturiert analysieren.'],
        ],
        'support' => [
            'Begriffe, Formeln und Verfahren werden aus ihren Zusammenhängen heraus rekonstruiert.',
            'Transferaufgaben werden schrittweise von bekannten Strukturen zu neuen Situationen aufgebaut.',
            'Fachsprache, Operatoren und schriftliche Begründungen werden bewusst trainiert.',
            'Für Klausuren werden Aufgabenmix, Zeitstrategie und Fehlerkontrolle unter realistischen Bedingungen geübt.'
        ],
        'roadmap' => [
            ['step' => '1', 'title' => 'Begriffe klären', 'text' => 'Definitionen, Größen und Zusammenhänge sicher erfassen.'],
            ['step' => '2', 'title' => 'Verfahren verstehen', 'text' => 'Nicht nur rechnen, sondern begründen, warum ein Weg funktioniert.'],
            ['step' => '3', 'title' => 'Transfer aufbauen', 'text' => 'Bekannte Methoden auf veränderte Aufgaben übertragen.'],
            ['step' => '4', 'title' => 'Klausuren beherrschen', 'text' => 'Komplexe Aufgaben strukturiert, vollständig und kontrolliert bearbeiten.'],
        ],
        'sources' => [
            ['label' => 'Sächsische Lehrplandatenbank – Gymnasium Mathematik', 'url' => 'https://www.schulportal.sachsen.de/lplandb/lehrplan/461'],
            ['label' => 'Sächsische Lehrplandatenbank – Gymnasium Physik', 'url' => 'https://www.schulportal.sachsen.de/lplandb/lehrplan/523'],
            ['label' => 'Sächsische Lehrplandatenbank – Gymnasium Chemie', 'url' => 'https://www.schulportal.sachsen.de/lplandb/lehrplan/521'],
            ['label' => 'Sächsische Lehrplandatenbank – Gymnasium Informatik', 'url' => 'https://www.schulportal.sachsen.de/lplandb/lehrplan/630'],
        ],
    ],
    'berufsschule' => [
        'file' => 'nachhilfe-berufsschule-leipzig.php',
        'name' => 'Berufsschule',
        'title' => 'Nachhilfe Berufsschule Leipzig | Ausbildung sicher meistern',
        'description' => 'Nachhilfe für Berufsschule und Ausbildung in Leipzig – Mathematik, Naturwissenschaften, Informatik und fachbezogene Grundlagen passend zu Bildungsgang und Lernfeld.',
        'lead' => 'Berufliche Bildung verbindet Theorie, betriebliche Praxis und konkrete Handlungssituationen. Deshalb wird die Unterstützung nicht nach einem allgemeinen Standardschema, sondern anhand des Bildungsgangs, des Lernfelds und der aktuellen Aufgaben aufgebaut.',
        'focus' => 'Theorie mit beruflicher Anwendung verbinden',
        'topics' => ['Berufsbezogene Mathematik','Technische Grundlagen','Informatik','Fachrechnen','Dokumentation','Prüfungsvorbereitung'],
        'standards_intro' => 'Berufsschulische Lehrpläne unterscheiden sich nach Ausbildungsberuf und Bildungsgang. Häufig sind sie lernfeldorientiert: Fachwissen soll in beruflichen Handlungssituationen geplant, angewendet, dokumentiert und bewertet werden.',
        'competencies' => [
            ['title' => 'Fachrechnen anwenden', 'text' => 'Prozent-, Verhältnis-, Größen- und Formelrechnungen mit konkreten beruflichen Situationen verbinden.'],
            ['title' => 'Technische Zusammenhänge verstehen', 'text' => 'Einheiten, Größen, Diagramme, Kennlinien und Modelle sicher lesen und anwenden.'],
            ['title' => 'Handlungsschritte dokumentieren', 'text' => 'Berechnungen, Entscheidungen und Ergebnisse fachlich nachvollziehbar darstellen.'],
            ['title' => 'Prüfungsaufgaben strukturieren', 'text' => 'Komplexe berufliche Situationen in Teilaufgaben zerlegen und systematisch bearbeiten.'],
        ],
        'support' => [
            'Ausbildungsberuf, Lernfeld, verwendete Formelsammlung und Prüfungsvorgaben bilden den Ausgangspunkt.',
            'Theoretische Inhalte werden an realen oder prüfungsnahen beruflichen Situationen erklärt.',
            'Einheiten, Formeln und Dokumentationsschritte werden konsequent schriftlich und nachvollziehbar geführt.',
            'Vor Zwischen- oder Abschlussprüfungen werden typische Aufgabenketten unter Zeitvorgaben bearbeitet.'
        ],
        'roadmap' => [
            ['step' => '1', 'title' => 'Bildungsgang klären', 'text' => 'Ausbildungsberuf, Lernfeld und Prüfungsziel erfassen.'],
            ['step' => '2', 'title' => 'Grundlagen sichern', 'text' => 'Fachrechnen, Einheiten und technische Begriffe ordnen.'],
            ['step' => '3', 'title' => 'Praxis verbinden', 'text' => 'Wissen in beruflichen Handlungssituationen anwenden.'],
            ['step' => '4', 'title' => 'Prüfung vorbereiten', 'text' => 'Aufgabenketten, Dokumentation und Zeitmanagement trainieren.'],
        ],
        'sources' => [
            ['label' => 'Sächsische Lehrplandatenbank – berufsbildende Schulen', 'url' => 'https://www.schulportal.sachsen.de/lplandb/'],
            ['label' => 'Sächsisches Staatsministerium – Lehrpläne und Arbeitsmaterialien', 'url' => 'https://www.schule.sachsen.de/lehrplaene-und-arbeitsmaterialien-6025.html'],
        ],
    ],
    'abitur' => [
        'file' => 'abiturvorbereitung-leipzig.php',
        'name' => 'Abitur',
        'title' => 'Abiturvorbereitung Leipzig | Strukturiert und fachlich sicher',
        'description' => 'Abiturvorbereitung in Leipzig für Mathematik, Physik, Chemie, Informatik und Sprachen – orientiert an Bildungsstandards, Lehrplänen und Prüfungsformaten.',
        'lead' => 'Eine gute Abiturvorbereitung verbindet Fachwissen, Kompetenzbereiche, Operatoren und Prüfungspraxis. Aus Lehrplan, Bildungsstandards, persönlichem Lernstand und verfügbarer Zeit entsteht ein realistischer Themen- und Trainingsplan.',
        'focus' => 'Priorisieren, trainieren und unter Prüfungsbedingungen anwenden',
        'topics' => ['Themenanalyse','Kompetenzbereiche','Operatoren','Original- und Beispielaufgaben','Zeitmanagement','Fehlerauswertung'],
        'standards_intro' => 'Für die Allgemeine Hochschulreife gelten bundesweite Bildungsstandards unter anderem für Mathematik, fortgeführte Fremdsprachen sowie Biologie, Chemie und Physik. Sie beschreiben Kompetenzbereiche und Anforderungsniveaus, die in den Länderlehrplänen und Prüfungen umgesetzt werden.',
        'competencies' => [
            ['title' => 'Fachwissen vernetzen', 'text' => 'Themen nicht isoliert wiederholen, sondern Begriffe, Methoden und Zusammenhänge über mehrere Lernbereiche hinweg verbinden.'],
            ['title' => 'Operatoren sicher umsetzen', 'text' => 'Erkennen, ob beschrieben, erläutert, hergeleitet, beurteilt oder berechnet werden muss.'],
            ['title' => 'Komplexe Aufgaben planen', 'text' => 'Materialien auswerten, Teilprobleme erkennen, geeignete Methoden auswählen und Ergebnisse kontrollieren.'],
            ['title' => 'Unter Prüfungsbedingungen arbeiten', 'text' => 'Zeit, Hilfsmittel, Darstellung und Kontrolle so organisieren, dass Wissen zuverlässig abrufbar wird.'],
        ],
        'support' => [
            'Zuerst werden Prüfungsanforderungen, Themenstand und verfügbare Zeit in einer Prioritätenmatrix geordnet.',
            'Wiederholung und Aufgabenpraxis wechseln sich ab; bloßes Lesen ersetzt keine aktive Bearbeitung.',
            'Aufgaben werden vollständig mit Ansatz, Begründung, Einheiten und Ergebnisprüfung geschrieben.',
            'Regelmäßige Probeklausuren machen Fortschritt, Zeitprobleme und wiederkehrende Fehler sichtbar.'
        ],
        'roadmap' => [
            ['step' => '1', 'title' => 'Anforderungen analysieren', 'text' => 'Lehrplan, Prüfungsgebiete und Operatoren erfassen.'],
            ['step' => '2', 'title' => 'Prioritäten setzen', 'text' => 'Lücken nach Relevanz und verfügbarem Zeitraum ordnen.'],
            ['step' => '3', 'title' => 'Aufgaben trainieren', 'text' => 'Kompetenzbereiche und Anforderungsniveaus gezielt üben.'],
            ['step' => '4', 'title' => 'Prüfung simulieren', 'text' => 'Vollständige Aufgaben unter realistischen Bedingungen lösen.'],
        ],
        'sources' => [
            ['label' => 'KMK – Bildungsstandards', 'url' => 'https://www.kmk.org/bildungsministerkonferenz/bildungsthemen/bildungsstandards.html'],
            ['label' => 'KMK – Gymnasiale Oberstufe und Abitur', 'url' => 'https://www.kmk.org/bildungsministerkonferenz/vertiefende-bildungsinhalte/bildungswege-und-schulabschluesse/gymnasiale-oberstufe-und-abitur.html'],
            ['label' => 'Sächsische Lehrplandatenbank', 'url' => 'https://www.schulportal.sachsen.de/lplandb/'],
        ],
    ],
    'studium' => [
        'file' => 'nachhilfe-studium-leipzig.php',
        'name' => 'Studium',
        'title' => 'Nachhilfe Studium Leipzig | Mathematik, Physik, Chemie & Informatik',
        'description' => 'Unterstützung für Studierende in Leipzig bei Mathematik, Physik, Chemie, Informatik, Programmierung und Datenbanken – ausgerichtet an Modulbeschreibung und Prüfungsordnung.',
        'lead' => 'Im Studium gibt es keinen einheitlichen schulischen Lehrplan. Verbindlich sind vielmehr Modulbeschreibungen, Studien- und Prüfungsordnungen sowie die konkreten Anforderungen von Vorlesung, Übung und Prüfung. Genau daran wird die Unterstützung ausgerichtet.',
        'focus' => 'Abstrakte Grundlagen nachvollziehbar rekonstruieren',
        'topics' => ['Hochschulmathematik','Physikmodule','Chemische Grundlagen','Programmierung','Datenbanken und SQL','Prüfungsvorbereitung'],
        'standards_intro' => 'Studiengänge unterscheiden sich deutlich in Umfang, Notation und Schwerpunkt. Deshalb werden zunächst Modulhandbuch, Vorlesungsplan, Übungsblätter, zugelassene Hilfsmittel und Prüfungsform analysiert. Daraus entsteht ein passender Lernweg.',
        'competencies' => [
            ['title' => 'Abstraktion nachvollziehen', 'text' => 'Definitionen, Modelle und formale Schreibweisen aus anschaulichen Grundideen heraus rekonstruieren.'],
            ['title' => 'Beweise und Herleitungen lesen', 'text' => 'Voraussetzungen, Zwischenschritte und Schlussfolgerungen voneinander trennen und selbst formulieren.'],
            ['title' => 'Übungsaufgaben selbstständig lösen', 'text' => 'Ansätze entwickeln, geeignete Verfahren auswählen und Lösungen vollständig dokumentieren.'],
            ['title' => 'Prüfungswissen organisieren', 'text' => 'Stoffumfang, Aufgabentypen, Formeln und Zeitbedarf in einen realistischen Plan überführen.'],
        ],
        'support' => [
            'Ausgangspunkt sind die tatsächlichen Unterlagen des konkreten Moduls, nicht ein allgemeines Standardprogramm.',
            'Fehlende Schulgrundlagen werden genau dort nachgeholt, wo sie das Verständnis universitärer Inhalte blockieren.',
            'Rechenwege, Code, SQL-Abfragen und Herleitungen werden konsequent selbst geschrieben und erklärt.',
            'Vor Prüfungen werden repräsentative Aufgaben ausgewählt, priorisiert und unter Zeitvorgaben bearbeitet.'
        ],
        'roadmap' => [
            ['step' => '1', 'title' => 'Modul analysieren', 'text' => 'Lernziele, Stoffumfang und Prüfungsform klären.'],
            ['step' => '2', 'title' => 'Grundlagen rekonstruieren', 'text' => 'Fehlende Begriffe und Voraussetzungen gezielt aufarbeiten.'],
            ['step' => '3', 'title' => 'Übungen beherrschen', 'text' => 'Methoden auf typische und veränderte Aufgaben anwenden.'],
            ['step' => '4', 'title' => 'Prüfung vorbereiten', 'text' => 'Aufgabenmix, Hilfsmittel und Zeitstrategie erproben.'],
        ],
        'sources' => [
            ['label' => 'Maßgeblich: Modulhandbuch des jeweiligen Studiengangs', 'url' => 'https://www.htwk-leipzig.de/studieren/studiengaenge'],
            ['label' => 'Maßgeblich: Studien- und Prüfungsordnung der jeweiligen Hochschule', 'url' => 'https://www.uni-leipzig.de/studium/im-studium/studienorganisation'],
        ],
    ],
];
