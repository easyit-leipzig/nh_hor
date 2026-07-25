<?php
/**
 * Persons
 *
 * Verwaltung von Personendaten
 *
 * @version 1.0
 */

class Persons
{

    private PDO $db;


    public function __construct(PDO $db)
    {
        $this->db = $db;
    }



    /**
     * Eine Person laden
     */
    public function get(int $id): ?array
    {

        $stmt = $this->db->prepare(
            "
            SELECT *
            FROM persons
            WHERE id = ?
            LIMIT 1
            "
        );


        $stmt->execute([$id]);


        $person = $stmt->fetch(PDO::FETCH_ASSOC);


        return $person ?: null;

    }




    /**
     * Alle aktiven Personen
     */
    public function getAll(): array
    {

        $stmt = $this->db->query(
            "
            SELECT *
            FROM persons
            WHERE active = 1
            ORDER BY lastname, firstname
            "
        );


        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }




    /**
     * Personen suchen
     */
    public function search(string $value): array
    {

        $stmt = $this->db->prepare(
            "
            SELECT *

            FROM persons

            WHERE

            firstname LIKE ?
            OR lastname LIKE ?
            OR company LIKE ?

            ORDER BY lastname, firstname
            "
        );


        $search = '%' . $value . '%';


        $stmt->execute(
            [
                $search,
                $search,
                $search
            ]
        );


        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }





    /**
     * Neue Person speichern
     */
    public function create(array $data): int
    {

        $stmt = $this->db->prepare(
            "
            INSERT INTO persons
            (
                role_id,
                salutation,
                title,
                firstname,
                lastname,
                company,
                birthday,
                street,
                house_number,
                zip,
                city,
                country,
                notes,
                active
            )

            VALUES
            (
                :role_id,
                :salutation,
                :title,
                :firstname,
                :lastname,
                :company,
                :birthday,
                :street,
                :house_number,
                :zip,
                :city,
                :country,
                :notes,
                :active
            )
            "
        );


        $stmt->execute(
            [
                'role_id'      => $data['role_id'] ?? null,
                'salutation'   => $data['salutation'] ?? null,
                'title'        => $data['title'] ?? null,
                'firstname'    => $data['firstname'] ?? null,
                'lastname'     => $data['lastname'] ?? null,
                'company'      => $data['company'] ?? null,
                'birthday'     => $data['birthday'] ?? null,
                'street'       => $data['street'] ?? null,
                'house_number' => $data['house_number'] ?? null,
                'zip'          => $data['zip'] ?? null,
                'city'         => $data['city'] ?? null,
                'country'      => $data['country'] ?? 'Deutschland',
                'notes'        => $data['notes'] ?? 0,
                'active'       => $data['active'] ?? 1
            ]
        );


        return (int)$this->db->lastInsertId();

    }





    /**
     * Person aktualisieren
     */
    public function update(
        int $id,
        array $data
    ): bool
    {

        $stmt = $this->db->prepare(
            "
            UPDATE persons

            SET

            role_id=:role_id,
            salutation=:salutation,
            title=:title,
            firstname=:firstname,
            lastname=:lastname,
            company=:company,
            birthday=:birthday,
            street=:street,
            house_number=:house_number,
            zip=:zip,
            city=:city,
            country=:country,
            notes=:notes,
            active=:active


            WHERE id=:id
            "
        );


        return $stmt->execute(
            [
                'id'=>$id,

                'role_id'=>$data['role_id'] ?? null,
                'salutation'=>$data['salutation'] ?? null,
                'title'=>$data['title'] ?? null,
                'firstname'=>$data['firstname'] ?? null,
                'lastname'=>$data['lastname'] ?? null,
                'company'=>$data['company'] ?? null,
                'birthday'=>$data['birthday'] ?? null,
                'street'=>$data['street'] ?? null,
                'house_number'=>$data['house_number'] ?? null,
                'zip'=>$data['zip'] ?? null,
                'city'=>$data['city'] ?? null,
                'country'=>$data['country'] ?? 'Deutschland',
                'notes'=>$data['notes'] ?? 0,
                'active'=>$data['active'] ?? 1
            ]
        );

    }





    /**
     * Person deaktivieren
     */
    public function deactivate(int $id): bool
    {

        $stmt=$this->db->prepare(
            "
            UPDATE persons
            SET active=0
            WHERE id=?
            "
        );


        return $stmt->execute([$id]);

    }





    /**
     * Vollständigen Namen erzeugen
     */
    public function getDisplayName(array $person): string
    {

        return implode(
            ' ',
            array_filter(
                [
                    $person['salutation'] ?? '',
                    $person['title'] ?? '',
                    $person['firstname'] ?? '',
                    $person['lastname'] ?? ''
                ],
                function($v)
                {
                    return trim((string)$v)!=='';
                }
            )
        );

    }


}
