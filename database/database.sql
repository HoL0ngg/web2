-- ---------------------------------------------------
-- TẠO CƠ SỞ DỮ LIỆU BÁN MỸ PHẨM (WEB2)
-- ---------------------------------------------------
DROP DATABASE IF EXISTS webbanhang;
create database webbanhang;
use webbanhang;
-- Bảng ChungLoai
CREATE TABLE ChungLoai (
    machungloai INT PRIMARY KEY,
    tenchungloai VARCHAR(50)
);
-- Bảng TheLoai
CREATE TABLE TheLoai (
    matheloai INT PRIMARY KEY,
    tentheloai VARCHAR(50),
    machungloai INT,
    FOREIGN KEY (machungloai) REFERENCES ChungLoai(machungloai)
);
-- Bảng Brand
CREATE TABLE Brand (
    brand_id INT PRIMARY KEY,
    brand_name VARCHAR(100)
);
-- Bảng NhomQuyen
CREATE TABLE `NhomQuyen` (
    `role_id` INT NOT NULL PRIMARY KEY,
    `role_name` VARCHAR(50) NOT NULL,
    `trangthai` INT NOT NULL -- 1: đang dùng, 0: tắt
);
-- Bảng DanhMucChucNang
CREATE TABLE `DanhMucChucNang` (
    `function_id` VARCHAR(50) NOT NULL PRIMARY KEY,
    `function_name` VARCHAR(50) NOT NULL,
    `trangthai` INT NOT NULL -- 1: đang dùng, 0: tắt
);
-- Bảng users
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255),
    role_id INT,
    status TINYINT NOT NULL DEFAULT 1,
    FOREIGN KEY (role_id) REFERENCES NhomQuyen(role_id)
);
-- Bảng ChiTietNhomQuyen
CREATE TABLE `ChiTietNhomQuyen` (
    `role_id` INT NOT NULL,
    `function_id` VARCHAR(50) NOT NULL,
    `action` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`role_id`, `function_id`, `action`),
    FOREIGN KEY (`role_id`) REFERENCES NhomQuyen(`role_id`),
    FOREIGN KEY (`function_id`) REFERENCES DanhMucChucNang(`function_id`)
);
-- Bảng NhanVien
CREATE TABLE NhanVien (
    employee_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    name VARCHAR(50),
    phone VARCHAR(20) UNIQUE,
    email VARCHAR(100) UNIQUE,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);
-- Bảng KhachHang
CREATE TABLE KhachHang (
    customer_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    customer_name VARCHAR(50),
    phone VARCHAR(20) UNIQUE,
    email VARCHAR(100) UNIQUE,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);
-- Bảng DiaChi
CREATE TABLE DiaChi (
    address_id INT PRIMARY KEY,
    level1 VARCHAR(50),
    level2 VARCHAR(50),
    level3 VARCHAR(50),
    level4 VARCHAR(50)
);
-- Bảng KhachHang_DiaChi
CREATE TABLE KhachHang_DiaChi (
    customer_id INT,
    address_id INT,
    is_default BOOLEAN DEFAULT FALSE,
    PRIMARY KEY (customer_id, address_id),
    FOREIGN KEY (customer_id) REFERENCES KhachHang(customer_id),
    FOREIGN KEY (address_id) REFERENCES DiaChi(address_id)
);
-- Bảng NhaCungCap
CREATE TABLE NhaCungCap (
    supplier_id INT PRIMARY KEY,
    supplier_name VARCHAR(50),
    address VARCHAR(100)
);
-- Bảng SanPham
CREATE TABLE SanPham (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(50),
    quantity INT,
    price INT,
    mota TEXT,
    brand_id INT,
    matheloai INT,
    status TINYINT NOT NULL DEFAULT 1,
    FOREIGN KEY (brand_id) REFERENCES Brand(brand_id),
    FOREIGN KEY (matheloai) REFERENCES TheLoai(matheloai)
);
-- Bảng SanPhamHinhAnh
CREATE TABLE SanPhamHinhAnh (
    image_id INT AUTO_INCREMENT PRIMARY KEY,
    image_url VARCHAR(255) NOT NULL,
    is_main TINYINT NOT NULL DEFAULT 1,
    product_id INT NOT NULL,
    FOREIGN KEY (product_id) REFERENCES SanPham(product_id)
);
-- Bảng SuKienGiamGia
CREATE TABLE SuKienGiamGia (
    flashsale_id INT PRIMARY KEY,
    startDate DATETIME,
    endDate DATETIME,
    tenSuKien VARCHAR(100)
);
-- Bảng SanPhamGiamGia
CREATE TABLE SanPhamGiamGia (
    flashsale_id INT,
    product_id INT,
    discount_percent INT,
    quantity INT,
    PRIMARY KEY (flashsale_id, product_id),
    FOREIGN KEY (flashsale_id) REFERENCES SuKienGiamGia(flashsale_id),
    FOREIGN KEY (product_id) REFERENCES SanPham(product_id)
);
-- Bảng YeuThich
CREATE TABLE YeuThich (
    love_id INT,
    customer_id INT,
    product_id INT,
    PRIMARY KEY (love_id),
    FOREIGN KEY (customer_id) REFERENCES KhachHang(customer_id),
    FOREIGN KEY (product_id) REFERENCES SanPham(product_id)
);
-- Bảng DonHang
CREATE TABLE DonHang (
    order_id INT PRIMARY KEY,
    employee_id INT,
    customer_id INT,
    address_id INT,
    orderDate DATE,
    total INT,
    status ENUM(
        'processing',
        'shipping',
        'delivered',
        'cancelled'
    ),
    reviewDate DATE,
    reviewDetails VARCHAR(255),
    FOREIGN KEY (employee_id) REFERENCES NhanVien(employee_id),
    FOREIGN KEY (customer_id) REFERENCES KhachHang(customer_id),
    FOREIGN KEY (address_id) REFERENCES DiaChi(address_id)
);
-- Bảng ChiTietDonHang
CREATE TABLE ChiTietDonHang (
    order_id INT,
    product_id INT,
    quantity INT,
    price INT,
    PRIMARY KEY (order_id, product_id),
    FOREIGN KEY (order_id) REFERENCES DonHang(order_id),
    FOREIGN KEY (product_id) REFERENCES SanPham(product_id)
);
-- Bảng PhieuNhap
CREATE TABLE PhieuNhap (
    receipt_id INT PRIMARY KEY,
    employee_id INT,
    supplier_id INT,
    time DATE,
    total INT,
    FOREIGN KEY (employee_id) REFERENCES NhanVien(employee_id),
    FOREIGN KEY (supplier_id) REFERENCES NhaCungCap(supplier_id)
);
-- Bảng ChiTietPhieuNhap
CREATE TABLE ChiTietPhieuNhap (
    receipt_id INT,
    product_id INT,
    quantity INT,
    price INT,
    PRIMARY KEY (receipt_id, product_id),
    FOREIGN KEY (receipt_id) REFERENCES PhieuNhap(receipt_id),
    FOREIGN KEY (product_id) REFERENCES SanPham(product_id)
);
-- THÊM DỮ LIỆU MẪU --
-- ChungLoai
INSERT INTO ChungLoai
VALUES (1, 'Trang Điểm'),
    (2, 'Chăm Sóc Da Mặt'),
    (3, 'Chăm Sóc Cơ Thể'),
    (4, 'Chăm Sóc Tóc & Chăm Sóc Da Đầu'),
    (5, 'Chăm Sóc Cá Nhân'),
    (6, 'Nước Hoa');
-- TheLoai
INSERT INTO TheLoai
VALUES (1, 'Kem dưỡng da', 2),
    (2, 'Sữa rửa mặt', 2),
    (3, 'Son môi', 1),
    (4, 'Kem chống nắng', 2),
    (5, 'Mặt nạ', 2),
    (6, 'Sữa tắm', 3),
    (7, 'Dầu gội', 4),
    (8, 'Nước hoa', 6);
-- Brand
INSERT INTO Brand
VALUES (1, 'Innisfree'),
    (2, 'Laneige'),
    (3, 'Maybelline'),
    (4, 'L\'Oreal');
-- NhomQuyen
INSERT INTO `NhomQuyen` (`role_id`, `role_name`, `trangthai`)
VALUES (1, 'Admin', 1),
    (2, 'Nhân viên', 1),
    (3, 'Khách hàng', 1);
-- DanhMucChucNang
INSERT INTO `DanhMucChucNang` (`function_id`, `function_name`, `trangthai`)
VALUES ('khachhang', 'Quản lý khách hàng', 1),
    ('nhanvien', 'Quản lý nhân viên', 1),
    ('taikhoan', 'Quản lý tài khoản', 1),
    ('nhacungcap', 'Quản lý nhà cung cấp', 1),
    ('phanquyen', 'Phân quyền', 1),
    ('donhang', 'Quản lý đơn hàng', 1),
    ('sanpham', 'Quản lý sản phẩm', 1),
    ('thongke', 'Thống kê', 1),
    ('nhaphang', 'Nhập hàng', 1),
    ('giamgia', 'Sự kiện giảm giá', 1);
-- ChiTietNhomQuyen admin
INSERT INTO `ChiTietNhomQuyen` (`role_id`, `function_id`, `action`)
VALUES (1, 'khachhang', 'create'),
    (1, 'khachhang', 'read'),
    (1, 'khachhang', 'update'),
    (1, 'khachhang', 'delete'),
    (1, 'nhanvien', 'create'),
    (1, 'nhanvien', 'read'),
    (1, 'nhanvien', 'update'),
    (1, 'nhanvien', 'delete'),
    (1, 'taikhoan', 'create'),
    (1, 'taikhoan', 'read'),
    (1, 'taikhoan', 'update'),
    (1, 'taikhoan', 'delete'),
    (1, 'nhacungcap', 'create'),
    (1, 'nhacungcap', 'read'),
    (1, 'nhacungcap', 'update'),
    (1, 'nhacungcap', 'delete'),
    (1, 'phanquyen', 'create'),
    (1, 'phanquyen', 'read'),
    (1, 'phanquyen', 'update'),
    (1, 'phanquyen', 'delete'),
    (1, 'donhang', 'create'),
    (1, 'donhang', 'read'),
    (1, 'donhang', 'update'),
    (1, 'donhang', 'delete'),
    (1, 'sanpham', 'create'),
    (1, 'sanpham', 'read'),
    (1, 'sanpham', 'update'),
    (1, 'sanpham', 'delete'),
    (1, 'thongke', 'create'),
    (1, 'thongke', 'read'),
    (1, 'thongke', 'update'),
    (1, 'thongke', 'delete'),
    (1, 'nhaphang', 'create'),
    (1, 'nhaphang', 'read'),
    (1, 'nhaphang', 'update'),
    (1, 'nhaphang', 'delete'),
    (1, 'giamgia', 'create'),
    (1, 'giamgia', 'read'),
    (1, 'giamgia', 'update'),
    (1, 'giamgia', 'delete');
-- ChiTietNhomQuyen nhanvien
INSERT INTO `ChiTietNhomQuyen` (`role_id`, `function_id`, `action`)
VALUES (2, 'khachhang', 'read'),
    (2, 'donhang', 'create'),
    (2, 'donhang', 'read'),
    (2, 'donhang', 'update'),
    (2, 'sanpham', 'create'),
    (2, 'sanpham', 'read'),
    (2, 'sanpham', 'update'),
    (2, 'nhaphang', 'create'),
    (2, 'nhaphang', 'read'),
    (2, 'giamgia', 'create'),
    (2, 'giamgia', 'read'),
    (2, 'giamgia', 'update');
-- ChiTietNhomQuyen khachhang
INSERT INTO `ChiTietNhomQuyen` (`role_id`, `function_id`, `action`)
VALUES (3, 'khachhang', 'read'),
    (3, 'donhang', 'read'),
    (3, 'sanpham', 'read'),
    (3, 'giamgia', 'read');
-- users
-- admin / password: admin, use password_hash
INSERT INTO users (username, password, role_id, status)
VALUES (
        'admin',
        '$2y$10$v7gyqp/9YMQPH14G1Tx8Yu0uz0NTu9Z8YWRM1/3iAEa2aVDy5Vz9a',
        1,
        1
    );
-- admin: admin
-- khach1 / password: khach1
INSERT INTO users (username, password, role_id, status)
VALUES (
        'khach1',
        '$2y$10$DiW9Xp1xFZkSlYJxzSFLrOdWa4FJSHTGqhr7V2HmhA9NvV0EvnDNq',
        3,
        1
    );
-- khach1: khach1
-- khach2 / password: khach2
INSERT INTO users (username, password, role_id, status)
VALUES (
        'khach2',
        '$2y$10$TNTXZ3D3cQx/fMPXHrX.jOJ7lXDiPIZlLrPykq.Jj4ppup0snQvuS',
        3,
        1
    );
-- khach2: khach2
-- NhanVien
INSERT INTO NhanVien
VALUES (
        1,
        1,
        'Nguyễn Văn A',
        '0123456789',
        'admin@email.com'
    );
-- KhachHang
INSERT INTO KhachHang
VALUES (
        1,
        2,
        'Trần Thị B',
        '0741852369',
        'khach1@email.com'
    ),
    (
        2,
        3,
        'Lê Văn C',
        '0321456789',
        'khach2@email.com'
    );
-- DiaChi
INSERT INTO DiaChi
VALUES (
        1,
        'TP. HCM',
        'Quận 1',
        'Phường Bến Nghé',
        '123 Lê Lợi'
    ),
    (
        2,
        'TP. HCM',
        'Quận Bình Thạnh',
        'Phường 1',
        '113 Xô Viết Nghệ Tĩnh'
    ),
    (
        3,
        'TP. HCM',
        'Quận 3',
        'Phường 6',
        '456 Cách Mạng'
    );
-- KhachHang_DiaChi
INSERT INTO KhachHang_DiaChi
VALUES (1, 1, TRUE),
    (2, 2, TRUE),
    (2, 3, FALSE);
-- NhaCungCap
INSERT INTO NhaCungCap
VALUES (1, 'Nhà cung cấp A', '789 Hai Bà Trưng'),
    (2, 'Nhà cung cấp B', '321 Nguyễn Trãi');
-- SanPham
INSERT INTO SanPham (
        product_id,
        product_name,
        quantity,
        price,
        mota,
        brand_id,
        matheloai,
        status
    )
VALUES (
        1,
        'Son Môi MAC Ruby Woo',
        50,
        400000,
        'Son môi màu đỏ cổ điển, giúp làm sáng khuôn mặt',
        1,
        1,
        1
    ),
    (
        2,
        'Kem Dưỡng Da Nivea',
        100,
        150000,
        'Kem dưỡng ẩm giúp da mềm mịn, cấp nước sâu cho da khô',
        2,
        2,
        1
    ),
    (
        3,
        'Sữa Rửa Mặt Cetaphil',
        75,
        100000,
        'Sữa rửa mặt dịu nhẹ, phù hợp với da nhạy cảm',
        3,
        2,
        1
    ),
    (
        4,
        'Kem Chống Nắng La Roche-Posay',
        60,
        350000,
        'Kem chống nắng bảo vệ da khỏi tia UVA và UVB',
        4,
        2,
        1
    ),
    (
        5,
        'Mặt Nạ Dưỡng Da Innisfree',
        90,
        200000,
        'Mặt nạ dưỡng da, giúp da sáng khỏe và mịn màng',
        4,
        5,
        1
    ),
    (
        6,
        'Sữa Tắm Dove',
        120,
        120000,
        'Sữa tắm dưỡng ẩm, cho làn da mềm mịn',
        3,
        3,
        1
    ),
    (
        7,
        'Dầu Gội Pantene',
        110,
        120000,
        'Dầu gội làm sạch tóc, bảo vệ da đầu khỏi gàu',
        2,
        4,
        1
    ),
    (
        8,
        'Nước Hoa Chanel No.5',
        15,
        2500000,
        'Nước hoa nữ sang trọng với hương thơm quyến rũ',
        1,
        6,
        1
    ),
    -- Trang Điểm
    (
        9,
        'Son Kem Lì Maybelline Super Stay',
        80,
        220000,
        'Son kem lì lâu trôi, màu sắc thời thượng',
        3,
        1,
        1
    ),
    -- Chăm Sóc Da Mặt
    (
        10,
        'Kem Dưỡng Ẩm Laneige Water Bank',
        60,
        550000,
        'Cung cấp độ ẩm chuyên sâu, giúp da căng mọng',
        2,
        2,
        1
    ),
    (
        11,
        'Sữa Rửa Mặt Trà Xanh Innisfree',
        100,
        130000,
        'Chiết xuất trà xanh, làm sạch và kiềm dầu',
        1,
        2,
        1
    ),
    (
        12,
        'Kem Chống Nắng Innisfree SPF50+',
        70,
        250000,
        'Chống nắng dạng sữa, nhẹ da và không bết dính',
        1,
        4,
        1
    ),
    (
        13,
        'Mặt Nạ Ngủ Laneige',
        55,
        450000,
        'Mặt nạ dưỡng da ban đêm, tái tạo làn da khi ngủ',
        2,
        5,
        1
    ),
    -- Chăm Sóc Cơ Thể
    (
        14,
        'Sữa Tắm Hương Hoa Hồng',
        90,
        180000,
        'Hương hoa hồng dịu nhẹ, mang lại cảm giác thư giãn',
        4,
        6,
        1
    ),
    -- Chăm Sóc Tóc & Da Đầu
    (
        15,
        'Dầu Gội Dược Liệu Thái Dương',
        85,
        95000,
        'Ngăn rụng tóc, giúp tóc chắc khỏe và mềm mượt',
        1,
        7,
        1
    ),
    -- Nước Hoa
    (
        16,
        'Nước Hoa Dior Sauvage',
        20,
        2800000,
        'Mùi hương nam tính, mạnh mẽ và lôi cuốn',
        3,
        8,
        1
    ),
    (
        17,
        'Nước Hoa Gucci Bloom',
        18,
        2600000,
        'Mùi hương nhẹ nhàng, nữ tính từ hoa trắng',
        2,
        8,
        1
    );
;
-- SanPhamHinhAnh
INSERT INTO SanPhamHinhAnh(image_url, is_main, product_id)
VALUES ('imgs/sp1.jpg', TRUE, 1),
    ('imgs/sp1_1.jpg', FALSE, 1),
    ('imgs/sp2.jpg', TRUE, 2),
    ('imgs/sp3.jpg', TRUE, 3),
    ('imgs/sp3_1.jpg', FALSE, 3),
    ('imgs/sp4.jpg', TRUE, 4),
    ('imgs/sp5.jpg', TRUE, 5),
    ('imgs/sp6.png', TRUE, 6),
    ('imgs/sp7.jpg', TRUE, 7),
    ('imgs/sp8.jpg', TRUE, 8),
    ('imgs/sp9.jpg', TRUE, 9),
    ('imgs/sp10.jpg', TRUE, 10),
    ('imgs/sp11.jpg', TRUE, 11),
    ('imgs/sp12.jpg', TRUE, 12),
    ('imgs/sp13.jpg', TRUE, 13),
    ('imgs/sp14.jpg', TRUE, 14),
    ('imgs/sp15.jpg', TRUE, 15),
    ('imgs/sp16.jpg', TRUE, 16),
    ('imgs/sp17.jpg', TRUE, 17);
-- SuKienGiamGia
INSERT INTO SuKienGiamGia
VALUES (
        1,
        '2025-04-01 00:00:00',
        '2025-04-10 23:59:59',
        'Flash Sale 4/2025'
    );
-- SanPhamGiamGia
INSERT INTO SanPhamGiamGia
VALUES (1, 1, 10, 20),
    (1, 3, 15, 50);
INSERT INTO YeuThich
VALUES (1, 1, 3),
    (2, 2, 1);
-- DonHang
INSERT INTO DonHang
VALUES (
        1,
        1,
        1,
        1,
        '2025-04-03',
        300000,
        'delivered',
        '2025-04-05',
        'Hài lòng về sản phẩm'
    ),
    (
        2,
        1,
        2,
        2,
        '2025-04-04',
        360000,
        'shipping',
        NULL,
        NULL
    );
-- ChiTietDonHang
INSERT INTO ChiTietDonHang
VALUES (1, 1, 2, 120000),
    (1, 3, 1, 180000),
    (2, 2, 1, 250000),
    (2, 3, 1, 180000);
-- PhieuNhap
INSERT INTO PhieuNhap
VALUES (1, 1, 1, '2025-03-28', 500000),
    (2, 1, 2, '2025-04-01', 800000);
-- ChiTietPhieuNhap
INSERT INTO ChiTietPhieuNhap
VALUES (1, 1, 10, 100000),
    (1, 2, 5, 220000),
    (2, 3, 20, 150000),
    (2, 4, 5, 280000);