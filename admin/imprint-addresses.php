<?php
declare(strict_types=1);
require __DIR__ . '/includes/admin-functions.php';
admin_require_role('admin');

$error = '';
$notice = (string)($_GET['result'] ?? '');
$types = ['business'=>'Geschäftlich','residential'=>'Privat','postal'=>'Postanschrift','billing'=>'Rechnung','other'=>'Sonstige'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_is_valid((string)($_POST['csrf_token'] ?? ''))) {
        http_response_code(403);
        exit('Ungültige Anfrage.');
    }

    try {
        $action = (string)($_POST['action'] ?? 'save');
        $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT, ['options'=>['min_range'=>1]]) ?: null;

        if ($action === 'delete') {
            if (!$id) throw new RuntimeException('Ungültige Adress-ID.');
            $stmt = db()->prepare('DELETE FROM addresses WHERE id=:id');
            $stmt->execute(['id'=>$id]);
            admin_log('delete', 'address', $id);
            header('Location: ' . app_path('/admin/imprint-addresses.php?result=deleted'), true, 303);
            exit;
        }

        $toPerson = filter_var($_POST['to_person'] ?? null, FILTER_VALIDATE_INT, ['options'=>['min_range'=>1]]) ?: null;
        $addressType = (string)($_POST['address_type'] ?? 'business');
        if (!$toPerson) throw new RuntimeException('Bitte eine Person auswählen.');
        if (!isset($types[$addressType])) throw new RuntimeException('Ungültiger Adresstyp.');

        $personCheck = db()->prepare('SELECT COUNT(*) FROM imprint_persons WHERE id=:id');
        $personCheck->execute(['id'=>$toPerson]);
        if ((int)$personCheck->fetchColumn() !== 1) throw new RuntimeException('Die ausgewählte Person existiert nicht.');

        $textFields = [
            'label'=>120,'organization'=>190,'department'=>190,'care_of'=>190,
            'address_line_1'=>190,'address_line_2'=>190,'address_line_3'=>190,
            'building'=>120,'street_name'=>190,'house_number'=>40,'post_office_box'=>80,
            'district'=>120,'city'=>120,'administrative_area'=>120,'postal_code'=>40,
            'country_name'=>120,'phone'=>80,'email'=>190
        ];
        $data = ['to_person'=>$toPerson, 'address_type'=>$addressType];
        foreach ($textFields as $field=>$max) {
            $value = trim((string)($_POST[$field] ?? ''));
            if (mb_strlen($value) > $max) throw new RuntimeException('Ein Eingabefeld überschreitet die zulässige Länge.');
            $data[$field] = $value;
        }

        $countryCode = strtoupper(trim((string)($_POST['country_code'] ?? 'DE')));
        if (!preg_match('/^[A-Z]{2}$/', $countryCode)) throw new RuntimeException('Der Ländercode muss aus genau zwei Buchstaben bestehen.');
        $data['country_code'] = $countryCode;

        if ($data['email'] !== '' && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) throw new RuntimeException('Bitte eine gültige E-Mail-Adresse angeben.');
        if ($data['city'] === '' && $data['address_line_1'] === '') throw new RuntimeException('Bitte mindestens Ort oder Adresszeile 1 angeben.');
        if ($data['country_name'] === '') throw new RuntimeException('Bitte das Land angeben.');

        foreach (['latitude'=>[-90,90], 'longitude'=>[-180,180]] as $field=>$range) {
            $raw = trim((string)($_POST[$field] ?? ''));
            if ($raw === '') { $data[$field] = null; continue; }
            if (!is_numeric($raw)) throw new RuntimeException('Koordinaten müssen numerisch sein.');
            $number = (float)$raw;
            if ($number < $range[0] || $number > $range[1]) throw new RuntimeException('Koordinate außerhalb des zulässigen Bereichs.');
            $data[$field] = $number;
        }

        foreach (['valid_from','valid_until'] as $field) {
            $raw = trim((string)($_POST[$field] ?? ''));
            if ($raw !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $raw)) throw new RuntimeException('Ungültiges Datumsformat.');
            $data[$field] = $raw !== '' ? $raw : null;
        }
        if ($data['valid_from'] && $data['valid_until'] && $data['valid_until'] < $data['valid_from']) throw new RuntimeException('Das Gültigkeitsende darf nicht vor dem Beginn liegen.');
        $data['is_primary'] = isset($_POST['is_primary']) ? 1 : 0;

        if ($data['is_primary'] === 1) {
            $clear = db()->prepare('UPDATE addresses SET is_primary=0 WHERE to_person=:to_person' . ($id ? ' AND id<>:id' : ''));
            $clearParams = ['to_person'=>$toPerson];
            if ($id) $clearParams['id'] = $id;
            $clear->execute($clearParams);
        }

        $columns = array_keys($data);
        if ($id) {
            $sets = implode(', ', array_map(static fn($c) => "$c=:$c", $columns));
            $data['id'] = $id;
            $stmt = db()->prepare("UPDATE addresses SET $sets WHERE id=:id");
            $stmt->execute($data);
            admin_log('update', 'address', $id, ['to_person'=>$toPerson]);
            $result = 'updated';
        } else {
            $names = implode(', ', $columns);
            $values = implode(', ', array_map(static fn($c) => ":$c", $columns));
            $stmt = db()->prepare("INSERT INTO addresses ($names) VALUES ($values)");
            $stmt->execute($data);
            $id = (int)db()->lastInsertId();
            admin_log('create', 'address', $id, ['to_person'=>$toPerson]);
            $result = 'created';
        }
        header('Location: ' . app_path('/admin/imprint-addresses.php?result=' . $result), true, 303);
        exit;
    } catch (PDOException $e) {
        $error = 'Die Adresse konnte nicht gespeichert werden.';
        error_log('Adresse: ' . $e->getMessage());
    } catch (Throwable $e) {
        $error = $e->getMessage();
    }
}

$persons = db_available() ? db()->query("SELECT p.id,p.salutation,p.title,p.firstname,p.lastname,r.role FROM imprint_persons p JOIN imprint_roles r ON r.id=p.to_role ORDER BY p.lastname,p.firstname,p.id")->fetchAll() : [];
$addresses = db_available() ? db()->query("SELECT a.*,p.salutation,p.title,p.firstname,p.lastname,r.role FROM addresses a JOIN imprint_persons p ON p.id=a.to_person JOIN imprint_roles r ON r.id=p.to_role ORDER BY a.is_primary DESC,p.lastname,p.firstname,a.id")->fetchAll() : [];

function address_person_label(array $p): string {
    return trim(implode(' ', array_filter([(string)$p['salutation'],(string)$p['title'],(string)$p['firstname'],(string)$p['lastname']]))) . ' [' . (string)$p['role'] . ']';
}

$adminTitle = 'Adressen';
require __DIR__ . '/includes/header.php';
?>
<div class="admin-actions"><h1 style="margin-right:auto">Adressen</h1><a class="admin-btn" href="<?= admin_e(app_path('/admin/imprint-persons.php')) ?>">Personen verwalten</a><a class="admin-btn" href="<?= admin_e(app_path('/admin/imprint-contacts.php')) ?>">Kontakte verwalten</a></div>
<p>Internationale Anschriften personengebunden verwalten. Pro Person kann genau eine Adresse als primär markiert werden.</p>
<?php if ($notice): ?><p class="admin-notice admin-notice--success">Änderung gespeichert.</p><?php endif; ?>
<?php if ($error): ?><p class="admin-notice admin-notice--error"><?= admin_e($error) ?></p><?php endif; ?>

<section class="admin-card" style="margin-bottom:2rem">
<h2>Adresse anlegen</h2>
<form method="post" class="admin-form admin-form--columns">
<input type="hidden" name="csrf_token" value="<?= admin_e(csrf_token()) ?>"><input type="hidden" name="action" value="save">
<label>Person<select name="to_person" required><option value="">Bitte wählen</option><?php foreach($persons as $p): ?><option value="<?= (int)$p['id'] ?>"><?= admin_e(address_person_label($p)) ?></option><?php endforeach; ?></select></label>
<label>Adresstyp<select name="address_type"><?php foreach($types as $value=>$label): ?><option value="<?= admin_e($value) ?>"><?= admin_e($label) ?></option><?php endforeach; ?></select></label>
<label>Bezeichnung<input name="label" maxlength="120" placeholder="Hauptgeschäftsstelle"></label>
<label>Organisation<input name="organization" maxlength="190"></label>
<label>Abteilung<input name="department" maxlength="190"></label>
<label>c/o<input name="care_of" maxlength="190"></label>
<label>Adresszeile 1<input name="address_line_1" maxlength="190"></label>
<label>Adresszeile 2<input name="address_line_2" maxlength="190"></label>
<label>Adresszeile 3<input name="address_line_3" maxlength="190"></label>
<label>Gebäude<input name="building" maxlength="120"></label>
<label>Straße<input name="street_name" maxlength="190"></label>
<label>Hausnummer<input name="house_number" maxlength="40"></label>
<label>Postfach<input name="post_office_box" maxlength="80"></label>
<label>Stadtteil / Bezirk<input name="district" maxlength="120"></label>
<label>Ort<input name="city" maxlength="120"></label>
<label>Bundesland / Region<input name="administrative_area" maxlength="120"></label>
<label>Postleitzahl<input name="postal_code" maxlength="40"></label>
<label>ISO-Ländercode<input name="country_code" maxlength="2" value="DE" required></label>
<label>Land<input name="country_name" maxlength="120" value="Deutschland" required></label>
<label>Telefon<input name="phone" maxlength="80"></label>
<label>E-Mail<input name="email" type="email" maxlength="190"></label>
<label>Breitengrad<input name="latitude" type="number" min="-90" max="90" step="0.0000001"></label>
<label>Längengrad<input name="longitude" type="number" min="-180" max="180" step="0.0000001"></label>
<label>Gültig ab<input name="valid_from" type="date"></label>
<label>Gültig bis<input name="valid_until" type="date"></label>
<label><input name="is_primary" type="checkbox" value="1"> Primäradresse dieser Person</label>
<button class="admin-btn admin-btn--gold" type="submit">Adresse anlegen</button>
</form>
</section>

<?php foreach($addresses as $a): ?>
<section class="admin-card" style="margin-bottom:1.5rem">
<form method="post" class="admin-form admin-form--columns">
<input type="hidden" name="csrf_token" value="<?= admin_e(csrf_token()) ?>"><input type="hidden" name="action" value="save"><input type="hidden" name="id" value="<?= (int)$a['id'] ?>">
<h2 style="grid-column:1/-1">#<?= (int)$a['id'] ?> – <?= admin_e(address_person_label($a)) ?><?= (int)$a['is_primary']===1?' · Primäradresse':'' ?></h2>
<label>Person<select name="to_person" required><?php foreach($persons as $p): ?><option value="<?= (int)$p['id'] ?>"<?= (int)$p['id']===(int)$a['to_person']?' selected':'' ?>><?= admin_e(address_person_label($p)) ?></option><?php endforeach; ?></select></label>
<label>Adresstyp<select name="address_type"><?php foreach($types as $value=>$label): ?><option value="<?= admin_e($value) ?>"<?= $value===$a['address_type']?' selected':'' ?>><?= admin_e($label) ?></option><?php endforeach; ?></select></label>
<?php foreach(['label'=>'Bezeichnung','organization'=>'Organisation','department'=>'Abteilung','care_of'=>'c/o','address_line_1'=>'Adresszeile 1','address_line_2'=>'Adresszeile 2','address_line_3'=>'Adresszeile 3','building'=>'Gebäude','street_name'=>'Straße','house_number'=>'Hausnummer','post_office_box'=>'Postfach','district'=>'Stadtteil / Bezirk','city'=>'Ort','administrative_area'=>'Bundesland / Region','postal_code'=>'Postleitzahl','country_code'=>'ISO-Ländercode','country_name'=>'Land','phone'=>'Telefon','email'=>'E-Mail'] as $field=>$label): ?><label><?= admin_e($label) ?><input name="<?= admin_e($field) ?>" value="<?= admin_e((string)$a[$field]) ?>"></label><?php endforeach; ?>
<label>Breitengrad<input name="latitude" type="number" min="-90" max="90" step="0.0000001" value="<?= admin_e((string)($a['latitude'] ?? '')) ?>"></label>
<label>Längengrad<input name="longitude" type="number" min="-180" max="180" step="0.0000001" value="<?= admin_e((string)($a['longitude'] ?? '')) ?>"></label>
<label>Gültig ab<input name="valid_from" type="date" value="<?= admin_e((string)($a['valid_from'] ?? '')) ?>"></label>
<label>Gültig bis<input name="valid_until" type="date" value="<?= admin_e((string)($a['valid_until'] ?? '')) ?>"></label>
<label><input name="is_primary" type="checkbox" value="1"<?= (int)$a['is_primary']===1?' checked':'' ?>> Primäradresse dieser Person</label>
<div><button class="admin-btn" type="submit">Speichern</button></div>
</form>
<form method="post" class="admin-inline-form" onsubmit="return confirm('Adresse wirklich löschen?');"><input type="hidden" name="csrf_token" value="<?= admin_e(csrf_token()) ?>"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= (int)$a['id'] ?>"><button class="admin-btn admin-btn--danger" type="submit">Löschen</button></form>
</section>
<?php endforeach; ?>
<?php require __DIR__ . '/includes/footer.php'; ?>
