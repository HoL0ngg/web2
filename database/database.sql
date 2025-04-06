
-- ---------------------------------------------------
-- TẠO CƠ SỞ DỮ LIỆU BÁN MỸ PHẨM (WEB2)
-- ---------------------------------------------------

-- Bảng ChungLoai
CREATE TABLE ChungLoai (
    machungloai INT PRIMARY KEY,
    tenchungloai VARCHAR(50)   
);

-- Bảng TheLoai
CREATE TABLE TheLoai (
    matheloai INT PRIMARY KEY,
    tenTheLoai VARCHAR(50),
    machungloai INT,
    FOREIGN KEY (machungloai) REFERENCES ChungLoai(machungloai)
);

-- Bảng Brand
CREATE TABLE Brand (
    brand_id INT PRIMARY KEY,
    brand_name VARCHAR(50)
);

-- Bảng NhomQuyen
CREATE TABLE NhomQuyen (
    role_id INT PRIMARY KEY,
    role_name VARCHAR(50)
);

-- Bảng DanhMucChucNang
CREATE TABLE DanhMucChucNang (
    function_id INT PRIMARY KEY,
    function_name VARCHAR(50)
);

-- Bảng NguoiDung
CREATE TABLE NguoiDung (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    tenDangNhap VARCHAR(50),
    password VARCHAR(255),
    role_id INT,
    status ENUM('0','1'),
    FOREIGN KEY (role_id) REFERENCES NhomQuyen(role_id)
);

-- Bảng ChiTietNhomQuyen
CREATE TABLE ChiTietNhomQuyen (
    role_id INT,
    function_id INT,
    action VARCHAR(100),
    PRIMARY KEY (role_id, function_id),
    FOREIGN KEY (role_id) REFERENCES NhomQuyen(role_id),
    FOREIGN KEY (function_id) REFERENCES DanhMucChucNang(function_id)
);

-- Bảng NhanVien
CREATE TABLE NhanVien (
    employee_id INT PRIMARY KEY,
    user_id INT,
    name VARCHAR(50),
    phone VARCHAR(20),
    email VARCHAR(100),
    FOREIGN KEY (user_id) REFERENCES NguoiDung(user_id)
);

-- Bảng KhachHang
CREATE TABLE KhachHang (
    customer_id INT PRIMARY KEY,
    user_id INT,
    customer_name VARCHAR(50),
    phone VARCHAR(20),
    email VARCHAR(100),
    FOREIGN KEY (user_id) REFERENCES NguoiDung(user_id)
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
    product_id INT PRIMARY KEY,
    product_name VARCHAR(50),
    quantity INT,
    price INT,
    description TEXT,
    brand_id INT,
    matheloai INT,
    status ENUM('disable','enable'),
    FOREIGN KEY (brand_id) REFERENCES Brand(brand_id),
    FOREIGN KEY (matheloai) REFERENCES TheLoai(matheloai)
);

-- Bảng SanPhamHinhAnh
CREATE TABLE SanPhamHinhAnh (
    image_id INT AUTO_INCREMENT PRIMARY KEY,
    image_url VARCHAR(255),
    is_main BOOLEAN DEFAULT FALSE,
    product_id INT,
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
    status ENUM('processing','shipping','delivered','cancelled'),
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
INSERT INTO ChungLoai VALUES 
(1, 'Chăm sóc da'),
(2, 'Trang điểm');

-- TheLoai
INSERT INTO TheLoai VALUES 
(1, 'Sữa rửa mặt', 1),
(2, 'Kem dưỡng', 1),
(3, 'Son môi', 2),
(4, 'Kem nền', 2);

-- Brand
INSERT INTO Brand VALUES 
(1, 'Innisfree'),
(2, 'Laneige'),
(3, 'Maybelline'),
(4, 'L\'Oreal');

-- NhomQuyen
INSERT INTO NhomQuyen VALUES 
(1, 'Admin'),
(2, 'Khách hàng');


-- NguoiDung
-- admin / password: admin, use password_hash
INSERT INTO NguoiDung (tenDangNhap, password, role_id, status)
VALUES ('admin', '$2y$10$v7gyqp/9YMQPH14G1Tx8Yu0uz0NTu9Z8YWRM1/3iAEa2aVDy5Vz9a', 1, '1'); -- admin: admin

-- khach1 / password: khach1
INSERT INTO NguoiDung (tenDangNhap, password, role_id, status)
VALUES ('khach1', '$2y$10$DiW9Xp1xFZkSlYJxzSFLrOdWa4FJSHTGqhr7V2HmhA9NvV0EvnDNq', 2, '1'); -- khach1: khach1

-- khach2 / password: khach2
INSERT INTO NguoiDung (tenDangNhap, password, role_id, status)
VALUES ('khach2', '$2y$10$TNTXZ3D3cQx/fMPXHrX.jOJ7lXDiPIZlLrPykq.Jj4ppup0snQvuS', 2, '1'); -- khach2: khach2

-- NhanVien
INSERT INTO NhanVien VALUES 
(1, 1, 'Nguyễn Văn A', '0123456789', 'admin@email.com');

-- KhachHang
INSERT INTO KhachHang VALUES 
(1, 2, 'Trần Thị B', '0741852369', 'khach1@email.com'),
(2, 3, 'Lê Văn C', '0321456789', 'khach2@email.com');

-- DiaChi
INSERT INTO DiaChi VALUES 
(1, 'TP. HCM', 'Quận 1', 'Phường Bến Nghé', '123 Lê Lợi'),
(2, 'TP. HCM', 'Quận Bình Thạnh', 'Phường 1', '113 Xô Viết Nghệ Tĩnh'),
(3, 'TP. HCM', 'Quận 3', 'Phường 6', '456 Cách Mạng');

-- KhachHang_DiaChi
INSERT INTO KhachHang_DiaChi VALUES 
(1, 1, TRUE),
(2, 2, TRUE),
(2, 3, FALSE);

-- NhaCungCap
INSERT INTO NhaCungCap VALUES 
(1, 'Nhà cung cấp A', '789 Hai Bà Trưng'),
(2, 'Nhà cung cấp B', '321 Nguyễn Trãi');

-- SanPham
INSERT INTO SanPham VALUES 
(1, 'Sữa rửa mặt trà xanh', 50, 120000, 'Dành cho da dầu', 1, 1, 'enable'),
(2, 'Kem dưỡng ẩm ban đêm', 30, 250000, 'Cấp nước hiệu quả', 2, 2, 'enable'),
(3, 'Son lì đỏ rượu', 100, 180000, 'Màu đẹp lâu trôi', 3, 3, 'enable'),
(4, 'Kem nền kiềm dầu', 20, 300000, 'Che phủ tốt', 4, 4, 'enable');

-- SanPhamHinhAnh
INSERT INTO SanPhamHinhAnh(image_url, is_main, product_id) VALUES 
('images/sp1_main.jpg', TRUE, 1),
('images/sp1_1.jpg', FALSE, 1),
('images/sp2_main.jpg', TRUE, 2),
('images/sp3_main.jpg', TRUE, 3),
('images/sp3_1.jpg', FALSE, 3),
('images/sp4_main.jpg', TRUE, 4);

-- SuKienGiamGia
INSERT INTO SuKienGiamGia VALUES 
(1, '2025-04-01 00:00:00', '2025-04-10 23:59:59', 'Flash Sale 4/2025');

-- SanPhamGiamGia
INSERT INTO SanPhamGiamGia VALUES 
(1, 1, 10, 20),
(1, 3, 15, 50);

INSERT INTO YeuThich VALUES 
(1, 1, 3),
(2, 2, 1);

-- DonHang
INSERT INTO DonHang VALUES 
(1, 1, 1, 1, '2025-04-03', 300000, 'delivered', '2025-04-05', 'Hài lòng về sản phẩm'),
(2, 1, 2, 2, '2025-04-04', 360000, 'shipping', NULL, NULL);

-- ChiTietDonHang
INSERT INTO ChiTietDonHang VALUES 
(1, 1, 2, 120000),
(1, 3, 1, 180000),
(2, 2, 1, 250000),
(2, 3, 1, 180000);

-- PhieuNhap
INSERT INTO PhieuNhap VALUES 
(1, 1, 1, '2025-03-28', 500000),
(2, 1, 2, '2025-04-01', 800000);

-- ChiTietPhieuNhap
INSERT INTO ChiTietPhieuNhap VALUES 
(1, 1, 10, 100000),
(1, 2, 5, 220000),
(2, 3, 20, 150000),
(2, 4, 5, 280000);

