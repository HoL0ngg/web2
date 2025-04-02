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
function showToast(message, type) {
    let toast = document.getElementById("toast");
    toast.innerText = message;
    toast.style.backgroundColor = type ? '#219150' : ' rgba(255, 0, 0, 0.9)';
    toast.style.display = 'block';
    setTimeout(() => {
        toast.style.display = 'none';
    }, 4000);
}
// function addUsers() {
//     let addUserFrm = document.getElementById("addUserForm");

//     // Định nghĩa handler cho submit để có thể xóa sự kiện sau
//     const submitHandler = function(event) {
//         event.preventDefault();

//         let formData = new FormData(this);
        
//         fetch("handles/addUsers.php", {
//             method: "POST",
//             body: formData
//         })
//         .then(response => response.json())
//         .then(data => {
//             // showToast(data.message, data.success);

//             if (data.success) {
//                 this.reset();
//                 // loadUsers();                                
//                 addUserFrm.removeEventListener("submit", submitHandler);

//                 //Lưu thông báo vào sessionStorage trước khi chuyển hướng
//                 sessionStorage.setItem("toastMessage", data.message);
//                 sessionStorage.setItem("toastSuccess", data.success);
//                 window.location.href = "../admin.php?page=user";                
//             }
//         })
//         .catch(error => console.error("Lỗi: ", error));
//     };

//     // Gắn sự kiện submit vào form
//     addUserFrm.addEventListener("submit", submitHandler);
// }
async function addUserNotification(){
    const response = await fetch("handles/handleUser.php");
    const notification = await response.json();
    if(notification.success){
        sessionStorage.setItem("toastMessage", data.message);
        sessionStorage.setItem("toastSuccess", data.success);
    }
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

