-- Pilih database Sekolahku di phpMyAdmin sebelum menjalankan skrip ini.
-- Jalankan skrip ini HANYA bila Anda tidak menjalankan `php artisan migrate`.

ALTER TABLE `footers`
    ADD COLUMN IF NOT EXISTS `tiktok` VARCHAR(255) NULL AFTER `instagram`,
    ADD COLUMN IF NOT EXISTS `instagram_handle` VARCHAR(80) NULL AFTER `youtube`,
    ADD COLUMN IF NOT EXISTS `tiktok_handle` VARCHAR(80) NULL AFTER `instagram_handle`,
    ADD COLUMN IF NOT EXISTS `youtube_handle` VARCHAR(80) NULL AFTER `tiktok_handle`,
    ADD COLUMN IF NOT EXISTS `instagram_embed_url` TEXT NULL AFTER `youtube_handle`,
    ADD COLUMN IF NOT EXISTS `tiktok_embed_url` TEXT NULL AFTER `instagram_embed_url`,
    ADD COLUMN IF NOT EXISTS `youtube_embed_url` TEXT NULL AFTER `tiktok_embed_url`;

