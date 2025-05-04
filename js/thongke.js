const ctx = document.getElementById('myChart').getContext('2d');

const myChart = new Chart(ctx, {
    type: 'line', // Loại biểu đồ (bar, line, pie, etc.)
    data: {
        labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4'],
        datasets: [{
            label: 'Doanh thu (triệu VND)',
            data: [12, 19, 3, 5], // Dữ liệu
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true, // Tự động thay đổi kích thước
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

const Back = () => {
    document.getElementById('myChart').classList.add('hide');
    document.querySelector('.back-button').classList.add('hide');
    showAllThongKe();
}

const showAllThongKe = () => {
    document.querySelectorAll('.thongke-item').forEach(item => {
        item.classList.remove('hide');
    }
    )
}

const hideAllThongKe = () => {
    document.querySelectorAll('.thongke-item').forEach(item => {
        item.classList.add('hide');
    })
}

document.querySelectorAll('.thongke-item').forEach((item) => {
    item.addEventListener("click", (e) => {
        showBieuDo();
    })
})

const showBieuDo = () => {
    document.querySelector('.back-button').classList.remove('hide');
    document.getElementById('myChart').classList.remove('hide');
    hideAllThongKe();

}

document.getElementById("select-filter").addEventListener("change", function () {
    var filterValue = this.value;
    var startDateInput = document.getElementById("startDate");
    var endDateInput = document.getElementById("endDate");

    if (filterValue === "custom") {
        startDateInput.readOnly = false; // Cho phép nhập dữ liệu
        endDateInput.readOnly = false;
    } else {
        startDateInput.readOnly = true;  // Ngăn người dùng nhập thủ công
        endDateInput.readOnly = true;
    }
    console.log(filterValue);

    var today = new Date();

    if (filterValue === "30") {
        var startDate = new Date();
        startDate.setDate(today.getDate() - 30);
        startDateInput.value = startDate.toISOString().split("T")[0]; // Định dạng YYYY-MM-DD
        endDateInput.value = today.toISOString().split("T")[0];
    } else if (filterValue === "7") {
        var startDate = new Date();
        startDate.setDate(today.getDate() - 7);
        startDateInput.value = startDate.toISOString().split("T")[0];
        endDateInput.value = today.toISOString().split("T")[0];
    } else if (filterValue === "custom") {
        startDateInput.value = ""; // Cho phép nhập thủ công
        endDateInput.value = "";
    }


    fetch("xulithongke.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "start=" + startDateInput.value + "&end=" + endDateInput.value
    })
        .then(response => response.text()) // Chuyển đổi dữ liệu phản hồi sang dạng text
        .then(data => {
            document.querySelector("table").innerHTML = data; // Cập nhật bảng dữ liệu
        })
        .catch(error => console.error("Lỗi khi gửi yêu cầu:", error)); // Bắt lỗi nếu có vấn đề
});


function updateDateInputs() {
    var filterValue = document.getElementById("select-filter").value;
    var today = new Date();
    var startDateInput = document.getElementById("startDate");
    var endDateInput = document.getElementById("endDate");

    if (filterValue === "30") {
        var startDate = new Date();
        startDate.setDate(today.getDate() - 30);
        startDateInput.value = startDate.toISOString().split("T")[0];
        endDateInput.value = today.toISOString().split("T")[0];
    } else if (filterValue === "7") {
        var startDate = new Date();
        startDate.setDate(today.getDate() - 7);
        startDateInput.value = startDate.toISOString().split("T")[0];
        endDateInput.value = today.toISOString().split("T")[0];
    } else if (filterValue === "custom") {
        startDateInput.value = "";
        endDateInput.value = "";
    }

    // Đặt các input thành readonly nếu không phải "Tùy chỉnh"
    startDateInput.readOnly = (filterValue !== "custom");
    endDateInput.readOnly = (filterValue !== "custom");

    fetch("xulithongke.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "start=" + startDateInput.value + "&end=" + endDateInput.value
    })
        .then(response => response.text()) // Chuyển đổi dữ liệu phản hồi sang dạng text
        .then(data => {
            document.querySelector("table").innerHTML = data; // Cập nhật bảng dữ liệu
        })
        .catch(error => console.error("Lỗi khi gửi yêu cầu:", error)); // Bắt lỗi nếu có vấn đề
}

function handleCustomDateChange() {
    var start = document.getElementById("startDate").value;
    var end = document.getElementById("endDate").value;

    if (start && end) {
        fetch("xulithongke.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "start=" + start + "&end=" + end
        })
            .then(response => response.text())
            .then(data => {
                document.querySelector("table").innerHTML = data;
            })
            .catch(error => console.error("Lỗi khi gửi yêu cầu:", error));
    }
}

// Khi người dùng chọn ngày trong chế độ "Tùy chỉnh"
document.getElementById("startDate").addEventListener("change", handleCustomDateChange);
document.getElementById("endDate").addEventListener("change", handleCustomDateChange);

// Gọi hàm khi trang tải xong
document.addEventListener("DOMContentLoaded", updateDateInputs);
