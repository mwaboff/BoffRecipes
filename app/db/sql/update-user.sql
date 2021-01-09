INSERT INTO users
    (username, hashed_pass, email)
VALUES
    (:username, :hashed_pass, :email)
ON DUPLICATE KEY UPDATE
    username = :username,
    hashed_pass = :hashed_pass,
    email = :email
;