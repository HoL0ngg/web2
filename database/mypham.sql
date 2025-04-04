CREATE DATABASE webbanhang;
--để sẵn chưa sửa code theo db này
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    name VARCHAR(50) NOT NULL,
    password VARCHAR(100) NOT NULL,
    status TINYINT(1) NOT NULL DEFAULT 1 -- 1 = hoạt động, 0 = khóa,
    manhomquyen INT NOT NULL,
    FOREIGN KEY (manhomquyen) REFERENCES NhomQuyen(manhomquyen)
);
CREATE TABLE NhomQuyen (
    manhomquyen INT PRIMARY KEY AUTO_INCREMENT,
    tennhomquyen VARCHAR(100) NOT NULL
);
CREATE TABLE DanhMucChucNang (
    machucnang INT PRIMARY KEY AUTO_INCREMENT,
    tenchucnang VARCHAR(100) NOT NULL
);
CREATE TABLE ChiTietNhomQuyen (
    manhomquyen INT NOT NULL,
    machucnang INT NOT NULL,
    hanhdong VARCHAR(100) NOT NULL,
    PRIMARY KEY (manhomquyen, machucnang),
    FOREIGN KEY (manhomquyen) REFERENCES NhomQuyen(manhomquyen) ON DELETE CASCADE,
    FOREIGN KEY (machucnang) REFERENCES DanhMucChucNang(machucnang) ON DELETE CASCADE
);
--test thử user thì xài cái nì
CREATE TABLE `users` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `username` varchar(50) NOT NULL,
    `phone` varchar(15) NOT NULL,
    `email` varchar(100) NOT NULL,
    `password` varchar(255) NOT NULL,
    `status` int(11) NOT NULL,
    `role` int(11) NOT NULL,
    PRIMARY KEY (`id`)
)