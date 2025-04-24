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
const confirmBtn = document.getElementById('confirm-btn');
if (confirmBtn) {
    confirmBtn.addEventListener('click', function (e) {
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
            if (paymentMethod.value === 'momo' || paymentMethod.value === 'vnpay') {
                document.getElementById('qr-section-container').style.display = 'block';

                const qrSection = document.getElementById('qr-section');
                const qrImage = document.getElementById('qr-image');
                // Gọi API QR code miễn phí
                qrImage.src = 'https://api.qrserver.com/v1/create-qr-code/?data=longkute' + '&size=200x200';

            } else if (paymentMethod.value === 'cod') {
                form.submit();
            } else if (paymentMethod.value === 'visa') {
                document.getElementById('visa-section-container').style.display = 'block';
            }
        }
    });

}
function setupSavedAddressSelection() {
    const diachiSelect = document.getElementById('diachi_user');
    const citySelect = document.getElementById('thanhpho');
    const districtSelect = document.getElementById('quan');
    const wardSelect = document.getElementById('phuong');
    const addressInput = document.getElementById('diachi');

    if (diachiSelect) {
        diachiSelect.addEventListener('change', function () {
            const selectedOption = diachiSelect.options[diachiSelect.selectedIndex];

            const city = selectedOption.getAttribute('data-thanhpho');
            const district = selectedOption.getAttribute('data-quan');
            const ward = selectedOption.getAttribute('data-phuong');
            const sonha = selectedOption.getAttribute('data-sonha');
            if (diachiSelect.value === '0') {
                citySelect.disabled = true;
                districtSelect.disabled = true;
                wardSelect.disabled = true;
                addressInput.disabled = true;
            }
            else if (diachiSelect.value > 0) {
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
}

if (document.querySelector('.qr-exitbtn')) document.querySelector('.qr-exitbtn').addEventListener('click', function () {
    document.getElementById('qr-section-container').style.display = 'none';
    document.getElementById('qr-image').src = ''; // Xóa ảnh QR để tránh hiển thị lại ảnh cũ
})

if (document.getElementById('confirm-payment')) document.getElementById('confirm-payment').addEventListener('click', function () {
    document.getElementById('qr-section-container').style.display = 'none';
    showToast('Đang xử lý thanh toán...', true);
    setTimeout(() => {
        document.getElementById('checkoutForm').submit();
    }, 2000);
})

if (document.querySelector('.visa-exitbtn')) document.querySelector('.visa-exitbtn').addEventListener('click', function () {
    document.getElementById('visa-section-container').style.display = 'none';
})

if (document.getElementById('visa-confirm')) document.getElementById('visa-confirm').addEventListener('click', function () {
    if (validateVisaForm()) {
        document.getElementById('visa-section-container').style.display = 'none';
        showToast('Đang xử lý thanh toán...', true);
        setTimeout(() => {
            document.getElementById('checkoutForm').submit();
        }, 2000);
    } else {
        showToast('Vui lòng kiểm tra lại thông tin', false);
    }
})

function validateVisaForm() {
    const cardNumber = document.getElementById('card-number');
    const zip = document.getElementById('ZIP');
    const expiryDate = document.getElementById('expiry-date');
    console.log(expiryDate);

    const cvv = document.getElementById('cvv');

    let isValid = true;

    if (!validateCardNumber(cardNumber)) {
        isValid = false;
    }


    if (zip.value.trim() === '' || zip.value.length < 5) {
        isValid = false;
    }

    if (!validateExpiryDate(expiryDate)) {
        isValid = false;
    }

    if (cvv.value.trim() === '' || cvv.value.length < 3) {
        isValid = false;
    }


    return isValid;
}

function validateCardNumber(inputElement) {
    // Lấy giá trị hiện tại và loại bỏ các ký tự không phải số
    let value = inputElement.value.replace(/[^0-9]/g, '');

    // Chia giá trị thành các nhóm 4 số và nối bằng dấu ' - '
    let formattedValue = value.match(/.{1,4}/g)?.join('-') || '';

    // Gán giá trị định dạng lại vào input
    inputElement.value = formattedValue;

    if (inputElement.value.trim().length != 19) {
        inputElement.parentElement.classList.add('error');
        inputElement.parentElement.classList.remove('valid');
        inputElement.focus();
        return false;
    } else {
        inputElement.parentElement.classList.remove('error');
        inputElement.parentElement.classList.add('valid');
        return true;
    }
}

function validateExpiryDate(inp) {
    let value = inp.value.replace(/[^0-9]/g, ''); // Loại bỏ ký tự không phải số
    if (value.length > 2) {
        value = value.slice(0, 2) + '/' + value.slice(2); // Thêm dấu '/' sau 2 số đầu
    }
    inp.value = value; // Cập nhật giá trị trong ô input

    // check giá trị ngày
    const regex = /^(0[1-9]|1[0-2])\/\d{2}$/;

    if (!regex.test(inp.value)) {
        inp.parentElement.classList.add('error');
        inp.parentElement.classList.remove('valid');
        inp.focus();
        return false; // Sai định dạng
    }

    const [month, year] = inp.value.split('/');
    const currentYear = new Date().getFullYear() % 100; // Lấy 2 chữ số cuối của năm hiện tại
    const currentMonth = new Date().getMonth() + 1; // Tháng hiện tại (0-11)

    // Kiểm tra nếu năm nhỏ hơn năm hiện tại hoặc năm bằng nhưng tháng nhỏ hơn
    if (year < currentYear || (year == currentYear && month < currentMonth)) {
        inp.parentElement.classList.add('error');
        inp.parentElement.classList.remove('valid');
        inp.focus();
        return false; // Ngày tháng đã qua
    }
    inp.parentElement.classList.remove('error');
    inp.parentElement.classList.add('valid');
    return true; // Ngày tháng hợp lệ
}

function validateNumber(inp) {
    inp.value = inp.value.replace(/[^0-9]/g, '');

    if (inp.value.trim().length != inp.maxLength) {
        inp.parentElement.classList.add('error');
        inp.parentElement.classList.remove('valid');
        inp.focus();
        return false;
    } else {
        inp.parentElement.classList.remove('error');
        inp.parentElement.classList.add('valid');
        return true;
    }
}