// function effectSideBar() {
//     const allSideMenu = document.querySelectorAll("#menu ul li a");
//     // Lấy đường dẫn hiện tại trên URL
//     const currentPage = new URLSearchParams(window.location.search).get("page");

//     allSideMenu.forEach(item => {
//         // Lấy giá trị 'page' từ href
//         const page = new URL(item.href).searchParams.get("page");
//         if (page === currentPage) {
//             item.parentElement.classList.add("active");
//         } else {
//             item.parentElement.classList.remove("active");
//         }
//     });

// }
function effectSideBar() {
    const allSideMenu = document.querySelectorAll("#menu ul li a");
    // Get the current page from the URL, default to 'admin_home' if no page parameter
    const currentPage = new URLSearchParams(window.location.search).get("page") || "admin_home";

    allSideMenu.forEach(item => {
        // Get the 'page' parameter from the href
        const page = new URL(item.href, window.location.origin).searchParams.get("page") || "admin_home";
        // Set the active class if the page matches
        if (page === currentPage) {
            item.parentElement.classList.add("active");
        } else {
            item.parentElement.classList.remove("active");
        }
    });
}

// Call the function when the page loads
document.addEventListener("DOMContentLoaded", effectSideBar);
function hiddenSideBar() {
    let hiddenBtn = document.getElementById("hideSideBar");
    let leftContainer = document.getElementById("container-left");
    let rightContainer = document.getElementById("container-right");
    let imgLogo = document.querySelector("#logo img");
    hiddenBtn.addEventListener("click", function () {
        let icon = this.querySelector("i");
        let attributeOfIcon = icon.getAttribute("class");
        if (attributeOfIcon.indexOf("fa-less-than") != -1) {            
            leftContainer.style.width = '60px';
            rightContainer.style.width = 'calc(100% - 60px)';
            imgLogo.src = "imgs/logomini.svg";
        } else {
            leftContainer.style.width = '20%';
            rightContainer.style.width = '80%'
            imgLogo.src = "imgs/logo3.svg";
        }
        icon.classList.toggle("fa-less-than");
        icon.classList.toggle("fa-greater-than");
    });
}

// Hàm hiển thị toast
function showToast(message, isSuccess) {
    Swal.fire({
        icon: isSuccess ? "success" : "error",
        title: isSuccess ? "Thành công!" : "Lỗi!",
        text: message,
        toast: true, // Hiển thị dạng toast nhỏ thay vì popup lớn
        position: "top-end",
        showConfirmButton: false,
        timer: 3500,
        timerProgressBar: true,
        background: isSuccess ? "#f0fff4" : "#fff0f0",
        color: isSuccess ? "#2d7d46" : "#d33",
    });
}
 
// Lấy form element
// Lấy các form elements
const addUserFrm = document.getElementById("addUserForm");
const updateUserFrm = document.getElementById("updateUserForm");

// Định nghĩa handler chung cho cả thêm và sửa user
const userFormHandler = function(event) {
    event.preventDefault();
    
    const formData = new FormData(this);
    
    // Thêm action vào formData để server biết là thêm hay sửa
    formData.append('action', this.id === 'addUserForm' ? 'add' : 'update');
    // const actionUrl = this.id === 'addUserForm' 
    //     ? "admin.php?page=user&act=addUser" 
    //     : "admin.php?page=user&act=updateUser";
    
    fetch("../api/user_api.php", { 
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        
        if (data.success) {
            handleSuccessResponse(data);
        } else {            
            handleErrorResponse(data);
            console.error("Lỗi:", data.message);
        }
    })
    .catch(error => {
        console.error("Lỗi hệ thống: ", error);
        showToast("Lỗi hệ thống", false);
    });
};

// Hàm xử lý chung khi thành công
function handleSuccessResponse(data) {    
    sessionStorage.setItem("toastMessage", data.message);
    sessionStorage.setItem("toastSuccess", data.success);
    
    if (data.redirect && data.success) {
        window.location.href = data.redirect;
    }
}
function handleErrorResponse(data) {
    showToast(data.message, false);
    // Không chuyển hướng khi có lỗi
}
// Gắn sự kiện submit vào các form nếu tồn tại
if (addUserFrm) {
    addUserFrm.addEventListener("submit", userFormHandler);
}

if (updateUserFrm) {
    updateUserFrm.addEventListener("submit", userFormHandler);
}

document.addEventListener("click", function(event) {
    if (event.target.classList.contains("delete-btn-user")) {
        let userId = event.target.getAttribute("data-id");

        Swal.fire({
            title: "Xác nhận xóa",
            text: "Bạn có chắc chắn muốn xóa người dùng này không?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Xóa",
            cancelButtonText: "Hủy"
        }).then((result) => {
            if (result.isConfirmed) { // return true khi nhan confirmbuttontext(xoa), return false khi nhan cancel(Huy)
                let dataForm = new FormData();
                dataForm.append('action', 'xoa');
                dataForm.append('id', userId);

                fetch("handles/handleUser.php", {
                    method: "POST",
                    body: dataForm
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire("Đã xóa!", "Người dùng đã bị xóa.", "success");
                        handleSuccessResponse(data);
                    } else {
                        Swal.fire("Lỗi!", "Không thể xóa người dùng.", "error");
                        handleErrorResponse(data);
                    }
                })
                .catch(error => {
                    console.error("Lỗi hệ thống: ", error);
                    Swal.fire("Lỗi!", "Có lỗi xảy ra trong hệ thống.", "error");
                });
            }
        });
    }
});

// ADD PRODUCT
const productAddForm = document.getElementById("productAddForm");
if(productAddForm){
    productAddForm.addEventListener('submit', async (e) => {
        e.preventDefault();
    
        if(validateProductForm()){
            let formData = new FormData(e.target); // Sửa ở đây
            formData.append("action","addProduct");
            try {
                const response = await fetch('api/product_api.php', {
                    method: "POST",
                    body: formData
                });
                const data = await response.json();
                if (data.success) {
                    handleSuccessResponse(data);
                } else {
                    handleErrorResponse(data);
                    console.error("Lỗi:", data.message);
                }
            } catch (error) { // Sửa ở đây
                console.error("Lỗi hệ thống: ", error);
                showToast("Lỗi hệ thống", false);
            }
        }
    });
}
const productUpdateForm = document.getElementById("productUpdateForm");
if(productUpdateForm){
    productUpdateForm.addEventListener('submit', async (e) => {
        e.preventDefault();
    
        if(validateProductForm()){
            let formData = new FormData(e.target); // Sửa ở đây
            formData.append("action","updateProduct");

            const urlParams = new URLSearchParams(window.location.search);
            const productId = urlParams.get('id');
            if (productId) {
                formData.append("product_id", productId);
            }     
            try {
                const response = await fetch('api/product_api.php', {
                    method: "POST",
                    body: formData
                });
                const data = await response.json();
                if (data.success) {
                    handleSuccessResponse(data);
                } else {
                    handleErrorResponse(data);
                    console.error("Lỗi:", data.message);
                }
            } catch (error) { // Sửa ở đây
                console.error("Lỗi hệ thống: ", error);
                showToast("Lỗi hệ thống", false);
            }
        }
    });
}
function validateProductForm() {
    let isValid = true;    
    
    const productName = document.getElementById('productname').value.trim();
    const quantity = document.getElementById('quantity').value.trim();
    const price = document.getElementById('price').value.trim();
    const theloai = document.getElementById('theloai').value.trim();
    const thuonghieu = document.getElementById('thuonghieu').value.trim();
    const mota = document.getElementById('mota').value.trim();
    const imageInput = document.getElementById('imageInput').files.length;     
    const previewImage = document.querySelector('#imagePreview img');
    const hasPreviewImage = previewImage && previewImage.getAttribute('src') !== 'imgs/addImg.png';

    if (productName === '') {
        isValid = false;
        showToast("Vui lòng nhập tên sản phẩm", isValid);
        return isValid;
    }

    if (quantity === '' || isNaN(quantity) || quantity <= 0) {
        isValid = false;
        showToast("Vui lòng nhập số lượng hợp lệ!", isValid);
        return isValid;
    }

    // Kiểm tra Giá
    if (price === '' || isNaN(price) || price <= 0) {
        isValid = false;
        showToast("Vui lòng nhập giá hợp lệ.", isValid);
        return isValid;
    }

    // Kiểm tra Thể loại
    if (theloai === '') {
        isValid = false;
        showToast("Vui lòng chọn thể loại.", isValid);
        return isValid;
    }

    // Kiểm tra Thương hiệu
    if (thuonghieu === '') {
        isValid = false;
        showToast("Vui lòng chọn thương hiệu.", isValid);
        return isValid;
    }

    // Kiểm tra Mô tả (không bắt buộc nhưng có thể kiểm tra nếu cần)
    if (mota === '') {
        isValid = false;
        showToast("Vui lòng nhập mô tả sản phẩm", isValid);
        return isValid;
    }
    if (imageInput === 0 && !hasPreviewImage) {
        isValid = false;
        showToast("Vui lòng chọn hình ảnh sản phẩm.", isValid);
        return isValid;
    }
    return isValid;
}

window.onload = function () {
    effectSideBar();
    hiddenSideBar(); 
    // loadUsers();      
    
    let message = sessionStorage.getItem("toastMessage");
    let success = sessionStorage.getItem("toastSuccess") === "true";
    console.log(message);
    console.log(success);
    if (message) {
        showToast(message, success); // Chuyển đổi string thành boolean
        sessionStorage.removeItem("toastMessage");
        sessionStorage.removeItem("toastSuccess");
    }else{
        console.log("Khong tim thay message");
        
    }    
};


function showOrderDetail(button) {
    const orderId = button.value;
    fetch('get_order_details.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',//dưới dạng html
        },
        body: 'order_id=' + encodeURIComponent(orderId)
    })
        .then(response => response.text())
        .then(data => {
            // Đổ dữ liệu vào bảng chi tiết
            document.getElementById("detail-table").getElementsByTagName("tbody")[0].innerHTML = data;
            // Hiển thị popup
            document.getElementById("order-detail-popup").classList.add("show");
        })
        .catch(error => {
            console.error('Lỗi khi lấy chi tiết đơn hàng:', error);
        });
}
function hideOrderDetail() {
    const popup = document.getElementById("order-detail-popup");
    popup.classList.remove("show");
}
