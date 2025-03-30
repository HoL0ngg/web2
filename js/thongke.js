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