-- @transactional false
-- Ergänzt SEO-Felder und den kombinierten Inhaltsindex in älteren Installationen.
ALTER TABLE content_items
  ADD COLUMN IF NOT EXISTS canonical_url VARCHAR(255) NULL AFTER meta_description,
  ADD COLUMN IF NOT EXISTS og_image VARCHAR(255) NULL AFTER canonical_url;

CREATE INDEX IF NOT EXISTS idx_content_featured
  ON content_items (content_type, status, featured, sort_order);
