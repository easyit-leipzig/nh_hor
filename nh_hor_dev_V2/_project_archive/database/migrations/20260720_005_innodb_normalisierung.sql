-- @transactional false
-- Konvertiert alle fachlichen Tabellen auf InnoDB. DDL kann in MariaDB implizit committen.
ALTER TABLE admin_users ENGINE=InnoDB;
ALTER TABLE content_items ENGINE=InnoDB;
ALTER TABLE content_revisions ENGINE=InnoDB;
ALTER TABLE audit_log ENGINE=InnoDB;
ALTER TABLE tutors ENGINE=InnoDB;
ALTER TABLE tutor_competencies ENGINE=InnoDB;
ALTER TABLE tutor_reviews ENGINE=InnoDB;

-- Fremdschlüssel werden vom PHP-Migrationsschritt nach einer Datenprüfung ergänzt.
