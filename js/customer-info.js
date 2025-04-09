const data = {
    "Hà Nội": {
        "Ba Đình": ["Phúc Xá", "Trúc Bạch", "Vĩnh Phúc"],
        "Đống Đa": ["Cát Linh", "Hàng Bột", "Nam Đồng"]
    },
    "Hồ Chí Minh": {
        "Quận 1": ["Bến Nghé", "Bến Thành", "Cô Giang"],
        "Quận 3": ["Phường 1", "Phường 2", "Phường 3"]
    }
};


loadQuan = () => {
    const city = document.getElementById("thanhpho").value;
    const districtSelect = document.getElementById("quan");
    const wardSelect = document.getElementById("phuong");

    console.log(city);


    districtSelect.innerHTML = '<option value="">Chọn quận/huyện</option>';
    wardSelect.innerHTML = '<option value="">Chọn xã/phường</option>';

    if (city && data[city]) {
        for (let district in data[city]) {
            districtSelect.options[districtSelect.options.length] = new Option(district, district);
        }
    }
}

loadThanhPho = () => {
    const citySelect = document.getElementById("thanhpho");
    for (let city in data) {
        citySelect.options[citySelect.options.length] = new Option(city, city);
    }

}

loadPhuong = () => {
    const city = document.getElementById("thanhpho").value;
    const district = document.getElementById("quan").value;
    const wardSelect = document.getElementById("phuong");

    wardSelect.innerHTML = '<option value="">Chọn xã/phường</option>';

    if (city && district && data[city][district]) {
        for (let ward of data[city][district]) {
            wardSelect.options[wardSelect.options.length] = new Option(ward, ward);
        }
    }

}
loadThanhPho();

document.getElementById('confirm-btn').addEventListener('click', function (e) {
    const form = document.getElementById('checkoutForm');
    let cnt = 0;
    // --- Lấy dữ liệu input ---
    const fullname = form.querySelector('#txtHoten');
    const phone = form.querySelector('#txtSDT');
    const email = form.querySelector('#txtEmail');
    const city = form.thanhpho;
    const district = form.quan;
    const ward = form.phuong;
    const addressDetail = form.diachi;
    const paymentMethod = form.querySelector('input[name="payment-method"]:checked');

    // --- Validate Họ tên ---
    if (fullname.value.trim() === '') {
        ++cnt;
        fullname.parentElement.classList.add('error');
    } else
        fullname.parentElement.classList.remove('error');


    // --- Validate số điện thoại ---
    const phoneRegex = /^0\d{9}$/;
    if (!phoneRegex.test(phone.value.trim())) {
        ++cnt;
        phone.parentElement.classList.add('error');
    } else phone.parentElement.classList.remove('error');

    // --- Validate Email ---
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email.value.trim())) {
        ++cnt;
        email.parentElement.classList.add('error');
    } else email.parentElement.classList.remove('error');

    // --- Validate địa chỉ-- -
    if (!city.value) {
        ++cnt;
        city.classList.add('error');
    } else city.classList.remove('error');
    if (!district.value) {
        ++cnt;
        district.classList.add('error');
    } else district.classList.remove('error');
    if (!ward.value) {
        ++cnt;
        ward.classList.add('error');
    } else ward.classList.remove('error');
    if (addressDetail.value.trim() === '') {
        addressDetail.classList.add('error');
    } else addressDetail.classList.remove('error');

    if (cnt > 0) {
        e.preventDefault();
    } else {
        form.submit(); // ✅ Gửi form nếu không có lỗi
    }
});