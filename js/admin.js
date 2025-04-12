function effectSideBar() {
    const allSideMenu = document.querySelectorAll("#menu ul li a");
    // Lấy đường dẫn hiện tại trên URL
    const currentPage = new URLSearchParams(window.location.search).get("page");

    allSideMenu.forEach(item => {
        // Lấy giá trị 'page' từ href
        const page = new URL(item.href).searchParams.get("page");
        if (page === currentPage) {
            item.parentElement.classList.add("active");
        } else {
            item.parentElement.classList.remove("active");
        }
    });

}
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
    
    fetch("handles/handleUser.php", { 
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
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

// async function loadUsers() {        
//     const response = await fetch("handles/getUsers.php");
//     const users = await response.json();
//     let userTable = document.getElementById("userTable");
//     if(userTable) userTable.innerHTML = "";
//     let rows = "";
//     // console.log(users);
    
//     if(users.length == 0){
//         rows += `<tr>
//                     <td colspan="7">Không tìm thấy dữ liệu</td>
//                 </tr>`
//     }else{
//         users.forEach(user =>{  
//             // console.log(user);
                          
//             rows += `<tr>
//                          <td>${user.user_id}</td>
//                          <td>${user.username}</td>
//                          <td>${user.phone}</td>
//                          <td>${user.email}</td>
//                          <td>${user.status == 0 ? `<span class="status-no-complete">Bị khóa</span>` : `<span class="status-complete">Hoạt động</span>`}</td>
//                          <td>${user.role_id == 1 ? "Admin" : "User"}</td>
//                          <td>
//                              <a href="admin.php?page=user&act=update&uid=${user.user_id}"><button class="edit-btn">✏️ Sửa</button></a>
//                              <button class="delete-btn-user" data-id=${user.user_id}>❌ Xóa</button>
//                          </td>            
//                      </tr>`;
//         });
//     }
//     if(userTable != null){
//         userTable.innerHTML = rows;
//     }
// }
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

