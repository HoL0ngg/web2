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
            imgLogo.src = "img/logomini.svg";
        } else {
            leftContainer.style.width = '20%';
            rightContainer.style.width = '80%'
            imgLogo.src = "img/logo3.svg";
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
    
    fetch("handles/handleUser.php", {  // Dùng chung endpoint
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            handleSuccessResponse(data);
        } else {
            console.log((data));
            
            handleSuccessResponse(data);
            console.error("Lỗi:", data.message);
        }
    })
    .catch(error => console.error("Lỗi hệ thống: ", error));
};

// Hàm xử lý chung khi thành công
function handleSuccessResponse(data) {
    sessionStorage.setItem("toastMessage", data.message);
    sessionStorage.setItem("toastSuccess", data.success);
    
    if (data.redirect) {
        window.location.href = data.redirect;
    }
}

// Gắn sự kiện submit vào các form nếu tồn tại
if (addUserFrm) {
    addUserFrm.addEventListener("submit", userFormHandler);
}

if (updateUserFrm) {
    updateUserFrm.addEventListener("submit", userFormHandler);
}

async function loadUsers() {        
    const response = await fetch("handles/getUsers.php");
    const users = await response.json();
    let userTable = document.getElementById("userTable");
    if(userTable) userTable.innerHTML = "";
    let rows = "";
    console.log(users);
    
    if(users.length == 0){
        rows += `<tr>
                    <td colspan="7">Không tìm thấy dữ liệu</td>
                </tr>`
    }else{
        users.forEach(user =>{  
            // console.log(user);
                          
            rows += `<tr>
                         <td>${user.id}</td>
                         <td>${user.username}</td>
                         <td>${user.phone}</td>
                         <td>${user.email}</td>
                         <td>${user.status == 0 ? `<span class="status-no-complete">Bị khóa</span>` : `<span class="status-complete">Hoạt động</span>`}</td>
                         <td>${user.role == 1 ? "Admin" : "User"}</td>
                         <td>
                             <a href="admin.php?page=user&act=update&uid=${user.id}"><button class="edit-btn">✏️ Sửa</button></a>
                             <button class="delete-btn">❌ Xóa</button>
                         </td>            
                     </tr>`;
        });
    }
    if(userTable != null){
        userTable.innerHTML = rows;
    }
}
window.onload = function () {
    effectSideBar();
    hiddenSideBar();  
    // addUsers();
    // addUsers();
    loadUsers();      
    let message = sessionStorage.getItem("toastMessage");
    let success = sessionStorage.getItem("toastSuccess");

    if (message) {
        showToast(message, success); // Chuyển đổi string thành boolean
        sessionStorage.removeItem("toastMessage");
        sessionStorage.removeItem("toastSuccess");
    }else{
        console.log("Khong tim thay message");
        
    }
};

