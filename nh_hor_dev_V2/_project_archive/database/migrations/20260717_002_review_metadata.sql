-- @transactional false
-- Ergänzt Bewertungsmetadaten idempotent.
ALTER TABLE content_items
  ADD COLUMN IF NOT EXISTS review_date DATE NULL AFTER og_image,
  ADD COLUMN IF NOT EXISTS reviewer_name VARCHAR(120) NULL AFTER review_date,
  ADD COLUMN IF NOT EXISTS reviewer_age SMALLINT UNSIGNED NULL AFTER reviewer_name,
  ADD COLUMN IF NOT EXISTS reviewer_school_type VARCHAR(120) NULL AFTER reviewer_age;

ALTER TABLE content_revisions
  ADD COLUMN IF NOT EXISTS review_date DATE NULL AFTER meta_description,
  ADD COLUMN IF NOT EXISTS reviewer_name VARCHAR(120) NULL AFTER review_date,
  ADD COLUMN IF NOT EXISTS reviewer_age SMALLINT UNSIGNED NULL AFTER reviewer_name,
  ADD COLUMN IF NOT EXISTS reviewer_school_type VARCHAR(120) NULL AFTER reviewer_age;
