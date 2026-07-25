<?php
/**
 * Notes
 *
 * Verwaltung von Personennotizen
 *
 * Tabelle:
 * notes
 *
 * @version 1.0
 */

class Notes
{

    private PDO $db;


    public function __construct(PDO $db)
    {
        $this->db = $db;
    }



    /**
     * Eine Notiz laden
     */
    public function get(int $id): ?array
    {

        $stmt = $this->db->prepare(
            "
            SELECT *
            FROM notes
            WHERE id = ?
            LIMIT 1
            "
        );


        $stmt->execute([$id]);


        $note = $stmt->fetch(PDO::FETCH_ASSOC);


        return $note ?: null;

    }




    /**
     * Alle Notizen einer Person
     */
    public function getByPerson(int $person_id): array
    {

        $stmt = $this->db->prepare(
            "
            SELECT *

            FROM notes

            WHERE to_person = ?

            ORDER BY created_at DESC
            "
        );


        $stmt->execute([$person_id]);


        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }





    /**
     * Neue Notiz erstellen
     */
    public function create(
        int $person_id,
        string $content
    ): int
    {


        $stmt = $this->db->prepare(
            "
            INSERT INTO notes
            (
                to_person,
                content
            )

            VALUES
            (
                :to_person,
                :content
            )
            "
        );


        $stmt->execute(
            [
                'to_person'=>$person_id,
                'content'=>trim($content)
            ]
        );


        return (int)$this->db->lastInsertId();

    }





    /**
     * Notiz ändern
     */
    public function update(
        int $id,
        string $content
    ): bool
    {


        $stmt = $this->db->prepare(
            "
            UPDATE notes

            SET content = ?

            WHERE id = ?
            "
        );


        return $stmt->execute(
            [
                trim($content),
                $id
            ]
        );

    }





    /**
     * Notiz löschen
     */
    public function delete(int $id): bool
    {

        $stmt = $this->db->prepare(
            "
            DELETE FROM notes
            WHERE id = ?
            "
        );


        return $stmt->execute([$id]);

    }





    /**
     * Anzahl Notizen einer Person
     */
    public function countByPerson(int $person_id): int
    {


        $stmt = $this->db->prepare(
            "
            SELECT COUNT(*)

            FROM notes

            WHERE to_person = ?
            "
        );


        $stmt->execute([$person_id]);


        return (int)$stmt->fetchColumn();

    }





    /**
     * Synchronisiert persons.notes
     *
     * notes = Anzahl vorhandener Notizen
     */
    public function updatePersonCounter(int $person_id): bool
    {


        $count = $this->countByPerson($person_id);


        $stmt = $this->db->prepare(
            "
            UPDATE persons

            SET notes = ?

            WHERE id = ?
            "
        );


        return $stmt->execute(
            [
                $count,
                $person_id
            ]
        );

    }



}