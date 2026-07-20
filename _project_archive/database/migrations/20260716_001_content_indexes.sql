ALTER TABLE content_items
  ADD INDEX idx_content_featured (content_type, status, featured, sort_order);

ALTER TABLE content_items
  ADD COLUMN canonical_url VARCHAR(255) NULL AFTER meta_description,
  ADD COLUMN og_image VARCHAR(255) NULL AFTER canonical_url;
