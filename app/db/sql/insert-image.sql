INSERT INTO images
    (image_data)
VALUES
    (:image_data)
ON DUPLICATE KEY UPDATE
    image_data = :image_data
;