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
    toast.style.backgroundColor = type ? 'rgba(0, 255, 0, 0.5)' : ' rgba(255, 0, 0, 0.9)';
    toast.style.display = 'block';
    setTimeout(() => {
        toast.style.display = 'none';
    }, 3000);
}
function addUsers(){
    let frmAddUserFrm = document.getElementById("addUserForm");
    frmAddUserFrm.addEventListener("submit", function(event){
        event.preventDefault();

        let formData = new FormData(this);
        fetch("handles/addUsers.php",{
            method: "POST",            
            body: formData
        })

        .then(response => response.json())
        .then(data =>{
            showToast(data.message, data.success);
            if(data.success){
                this.reset();
                loadUsers();
                setTimeout(() => {
                    window.location.href = "../admin.php?page=user";
                }, 3000);
            }
        })
        .catch(error => console.error("Lỗi: ", error));
        // showToast("Đã xảy ra lỗi, vui lòng thử lại!", false);
    });
}
async function loadUsers() {
    const response = await fetch("handles/getUsers.php");
    const users = await response.json();
    
    let rows = "";

    users.forEach(user =>{                
        rows += `<tr>
                     <td>${user.id}</td>
                     <td>${user.username}</td>
                     <td>${user.phone}</td>
                     <td>${user.email}</td>
                     <td>${user.role == 1 ? "Admin" : "User"}</td>
                     <td>
                         <a href="admin.php?page=user&act=update"><button class="edit-btn">✏️ Sửa</button></a>
                         <button class="delete-btn">❌ Xóa</button>
                     </td>            
                 </tr>`;
    });
    document.getElementById("userTable").innerHTML = rows;
}
window.onload = function () {
    effectSideBar();
    hiddenSideBar();  
    // addUsers();
    loadUsers();  
};
