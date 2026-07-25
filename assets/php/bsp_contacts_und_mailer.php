<?php
$contacts = new Contacts($pdo);

// Neue Anfrage anlegen
$id = $contacts->create([
    'person_id' => 1,
    'type' => 'contact_form',
    'contact_value' => 'kunde@example.de',
    'subject' => 'Testanfrage',
    'message' => 'Ich benötige Unterstützung in Mathe.'
]);

// E-Mail senden
$contacts->sendEmail($id, 'info@easyit-nachhilfe.de');

// Alle offenen Anfragen abrufen
$open = $contacts->getOpen();  
?>
