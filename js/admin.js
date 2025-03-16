console.log("Hello");

function effectSideBar() {
    const allSideMenu = document.querySelectorAll("#menu ul li a");

    // Lấy đường dẫn hiện tại trên URL
    const currentPage = new URLSearchParams(window.location.search).get("page");
    console.log(allSideMenu);
    
    allSideMenu.forEach(item => {
        // Lấy giá trị 'page' từ href
        const page = new URL(item.href).searchParams.get("page");

        // Nếu trang hiện tại trùng với menu item -> Thêm class "active"
        if (page === currentPage) {
            item.classList.add("active");
        } else {
            item.classList.remove("active");
        }

        item.addEventListener("click", function () {
            allSideMenu.forEach(ele => ele.classList.remove("active"));
            this.classList.add("active");
        });
    });
}

window.onload = function () {
    effectSideBar();
};
