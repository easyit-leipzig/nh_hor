ALTER TABLE content_items
    ADD COLUMN review_date DATE NULL AFTER meta_description,
    ADD COLUMN reviewer_name VARCHAR(120) NULL AFTER review_date,
    ADD COLUMN reviewer_age SMALLINT UNSIGNED NULL AFTER reviewer_name,
    ADD COLUMN reviewer_school_type VARCHAR(120) NULL AFTER reviewer_age;

ALTER TABLE content_revisions
    ADD COLUMN review_date DATE NULL AFTER meta_description,
    ADD COLUMN reviewer_name VARCHAR(120) NULL AFTER review_date,
    ADD COLUMN reviewer_age SMALLINT UNSIGNED NULL AFTER reviewer_name,
    ADD COLUMN reviewer_school_type VARCHAR(120) NULL AFTER reviewer_age;
