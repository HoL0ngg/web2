let dataVN = [];

fetch('https://raw.githubusercontent.com/kenzouno1/DiaGioiHanhChinhVN/master/data.json')
    .then(res => res.json())
    .then(data => {
        dataVN = data;
        loadCities(); // hàm này sẽ tạo options cho select tỉnh
        setupSavedAddressSelection(); // thêm dòng này để xử lý sau khi dữ liệu đã load
    });

function loadCities() {
    const thanhpho = document.getElementById('thanhpho');
    dataVN.forEach(city => {
        const option = document.createElement('option');
        option.value = city.Name;
        option.textContent = city.Name;
        thanhpho.appendChild(option);
    });

    thanhpho.addEventListener('change', function () {
        loadDistricts(this.value);
        document.getElementById('phuong').innerHTML = '<option value="">Chọn phường/xã</option>';
    });
}

function loadDistricts(cityName) {
    const quan = document.getElementById('quan');
    quan.innerHTML = '<option value="">Chọn quận/huyện</option>';

    const city = dataVN.find(c => c.Name === cityName);
    if (!city) return;

    city.Districts.forEach(district => {
        const option = document.createElement('option');
        option.value = district.Name;
        option.textContent = district.Name;
        quan.appendChild(option);
    });

    quan.addEventListener('change', function () {
        loadWards(cityName, this.value);
    });
}

function loadWards(cityName, districtName) {
    const phuong = document.getElementById('phuong');
    phuong.innerHTML = '<option value="">Chọn phường/xã</option>';

    const city = dataVN.find(c => c.Name === cityName);
    const district = city?.Districts.find(d => d.Name === districtName);
    if (!district) return;

    district.Wards.forEach(ward => {
        const option = document.createElement('option');
        option.value = ward.Name;
        option.textContent = ward.Name;
        phuong.appendChild(option);
    });
}

document.getElementById('confirm-btn').addEventListener('click', function (e) {
    const form = document.getElementById('checkoutForm');
    let cnt = 0;
    // --- Lấy dữ liệu input ---
    const fullname = form.querySelector('#txtHoten');
    const phone = form.querySelector('#txtSDT');
    const email = form.querySelector('#txtEmail');
    const diachi = form.diachi_user;

    const city = form.thanhpho;
    const district = form.quan;
    const ward = form.phuong;
    const addressDetail = form.diachi;
    const paymentMethod = form.querySelector('input[name="payment-method"]:checked');

    // --- Validate Họ tên ---
    if (fullname.value.trim() === '') {
        ++cnt;
        fullname.parentElement.classList.add('error');
        fullname.focus();
    } else
        fullname.parentElement.classList.remove('error');


    // --- Validate số điện thoại ---
    const phoneRegex = /^0\d{9}$/;
    if (!phoneRegex.test(phone.value.trim())) {
        ++cnt;
        phone.parentElement.classList.add('error');
        phone.focus();
    } else phone.parentElement.classList.remove('error');

    // --- Validate Email ---
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email.value.trim())) {
        ++cnt;
        email.parentElement.classList.add('error');
        email.focus();
    } else email.parentElement.classList.remove('error');

    // --- Validate địa chỉ-- -
    if (!diachi.value) {
        ++cnt;
        diachi.classList.add('error');
        diachi.focus();
    } else diachi.classList.remove('error');
    if (!city.value) {
        ++cnt;
        city.classList.add('error');
        city.focus();
    } else city.classList.remove('error');
    if (!district.value) {
        ++cnt;
        district.classList.add('error');
        district.focus();
    } else district.classList.remove('error');
    if (!ward.value) {
        ++cnt;
        ward.classList.add('error');
        ward.focus();
    } else ward.classList.remove('error');
    if (addressDetail.value.trim() === '') {
        addressDetail.classList.add('error');
        addressDetail.focus();
    } else addressDetail.classList.remove('error');

    if (cnt > 0) {
        e.preventDefault();
    } else {

        form.submit(); // ✅ Gửi form nếu không có lỗi
    }
});

function setupSavedAddressSelection() {
    const diachiSelect = document.getElementById('diachi_user');
    const citySelect = document.getElementById('thanhpho');
    const districtSelect = document.getElementById('quan');
    const wardSelect = document.getElementById('phuong');
    const addressInput = document.getElementById('diachi');

    diachiSelect.addEventListener('change', function () {
        const selectedOption = diachiSelect.options[diachiSelect.selectedIndex];

        const city = selectedOption.getAttribute('data-thanhpho');
        const district = selectedOption.getAttribute('data-quan');
        const ward = selectedOption.getAttribute('data-phuong');
        const sonha = selectedOption.getAttribute('data-sonha');

        if (diachiSelect.value > 0) {
            // 1. Gán tỉnh/thành phố
            citySelect.value = city;
            loadDistricts(city); // gọi lại để load quận sau khi chọn tỉnh

            // 2. Chờ chút để quận được tạo ra
            setTimeout(() => {
                districtSelect.value = district;
                loadWards(city, district); // load tiếp phường

                setTimeout(() => {
                    wardSelect.value = ward;
                }, 100); // thêm delay để đảm bảo phường được load xong
            }, 100);

            addressInput.value = sonha;

            citySelect.disabled = true;
            districtSelect.disabled = true;
            wardSelect.disabled = true;
            addressInput.disabled = true;
        } else {
            citySelect.disabled = false;
            districtSelect.disabled = false;
            wardSelect.disabled = false;
            addressInput.disabled = false;

            citySelect.value = '';
            districtSelect.innerHTML = '<option value="">Chọn quận/huyện</option>';
            wardSelect.innerHTML = '<option value="">Chọn phường/xã</option>';
            addressInput.value = '';
        }
    });
}
