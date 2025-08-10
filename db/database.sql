CREATE TABLE monan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ten_mon VARCHAR(255),
    mo_ta TEXT,
    gia DECIMAL(10,2),
    hinh_anh VARCHAR(255)
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    so_ban INT,
    monan_id INT,
    so_luong INT,
    tong_tien DECIMAL(10,2),
    trang_thai VARCHAR(50) DEFAULT 'pending',  // pending, confirmed, paid
    thoi_gian TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    password VARCHAR(255),  // Mã hóa sau
    role VARCHAR(20)  // admin, staff
);
INSERT INTO users (username, password, role) VALUES ('admin', 'admin123', 'admin'), ('staff', 'staff123', 'staff');
