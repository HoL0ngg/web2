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