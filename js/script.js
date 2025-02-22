// BANNER
const images = document.querySelectorAll("#banner img");
console.log(images);
let currentIndex = 0;
function showImage(index) {
    if (index >= 0 && index < images.length) {
        images.forEach(img => img.style.display = 'none');
        images[index].style.display = 'block';
    }
}
function startAnimation() {
    showImage(currentIndex);
    setInterval(() => {
        currentIndex = (currentIndex + 1) % images.length;
        showImage(currentIndex);
    }, 3000);
}
// FORM
function togglePasswordStatus(element) {
    let passwordInput = element.parentElement.querySelector("input");
    // console.log(passwordInput);
    document.getElementsByTagName
    let icon = element.querySelector("i");
    // console.log(icon);

    if (passwordInput.type === "password" || icon.classList.contains("fa-eye")) {
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
        passwordInput.type = "text";
    } else {
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
        passwordInput.type = "password";
    }

}
function openRegisterForm() {
    let openRegister = document.getElementById("register-wrapper");
    let loginWrapper = document.getElementById("login-wrapper");
    loginWrapper.style.display = 'none';
    openRegister.style.display = 'block';
    openRegister.style.backdropFilter = 'brightness(0.8)';

}
function openLoginForm() {
    fetch("handles/getSession.php")
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Logout();
                openChangePasswordForm();
            }
            else {
                document.getElementById("taikhoan-container").addEventListener('click', function () {
                    let loginWrapper = document.getElementById("login-wrapper");
                    loginWrapper.style.backdropFilter = 'brightness(0.8)';
                    loginWrapper.style.display = 'block';
                });
            }
        })
        .catch(error => console.error("Loi: ", error));
}

function getUsername() {
    fetch("handles/getSession.php")
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById("taikhoan-container").innerHTML = `Xin chào, ${data.username}`;
            }
        })
        .catch(error => console.error("Lỗi:", error));
}
function closeButton() {
    let closeButtons = document.querySelectorAll(".btn-close");
    closeButtons.forEach(button => {
        button.addEventListener("click", function () {
            let formWrapper = button.closest("[id]").parentElement;
            if (formWrapper) {
                formWrapper.style.display = 'none';
            }
        });
    });
}
function validatePhone(phone) {
    let reg = /^0(\d{9}|9\d{8})$/;
    return reg.test(phone);
}
function validateUsername(username) {
    let reg = /^[a-zA-Z][a-zA-Z0-9_.]{5,29}$/;
    return reg.test(username)
}
function validatePassword(password) {
    let reg = /.{8,}/;
    return reg.test(password);
}
// console.log(validateUsername("nghiatrong"));

function validateRepassword(password, repassword) {
    return password === repassword;
}



function checkRegister() {
    let phone = document.getElementById("reg-phone");
    let username = document.getElementById("reg-username");
    let password = document.getElementById("reg-password");
    let repassword = document.getElementById("reg-repassword");
    let phoneErr = document.getElementsByClassName("phone")[0];
    let usernameErr = document.getElementsByClassName("username")[0];
    let passwordErr = document.getElementsByClassName("password")[0];
    let repasswordErr = document.getElementsByClassName("repassword")[0];
    let icon = '<i class="fa-sharp fa-solid fa-circle-exclamation"></i>';
    phoneErr.innerHTML = "";
    usernameErr.innerHTML = "";
    passwordErr.innerHTML = "";
    repasswordErr.innerHTML = "";
    let isValid = true;
    if (!validatePhone(phone.value)) {
        phoneErr.innerHTML = icon + 'Số điện thoại không hợp lệ!';
        if(isValid) phone.focus();
        isValid = false;
    }
    if (!validateUsername(username.value)) {
        usernameErr.innerHTML = icon + 'Tên tài khoản tối thiểu là 6 kí tự!';
        if(isValid) username.focus();
        isValid = false;
    }
    if (!validatePassword(password.value)) {
        passwordErr.innerHTML = icon + 'Mật khẩu tối thiểu là 8 kí tự!';
        if(isValid) password.focus();
        isValid = false;
    }
    if (!validateRepassword(password.value, repassword.value)) {
        repasswordErr.innerHTML = icon + 'Mật khẩu nhập lại không khớp!';
        if(isValid) repassword.focus();
        isValid = false;
    }
    return isValid;
}

function checkLogin() {
    let username = document.getElementById("username");
    let password = document.getElementById("password");
    let usernameErr = document.getElementById("usernameErr");
    let passwordErr = document.getElementById("passwordErr");
    let isValid = true;
    let icon = '<i class="fa-sharp fa-solid fa-circle-exclamation"></i>';
    usernameErr.innerHTML = "";
    passwordErr.innerHTML = "";
    if (!validateUsername(username.value)) {
        usernameErr.innerHTML = icon + 'Tên đăng nhập tối thiểu là 6 kí tự!';
        if(isValid) username.focus();
        isValid = false;
    }
    if (!validatePassword(password.value)) {
        passwordErr.innerHTML = icon + 'Mật khẩu tối thiểu là 8 kí tự!';
        if(isValid) password.focus();
        isValid = false;
    }
    return isValid;
}
//Login notification
function showToast(message, type) {
    let toast = document.getElementById("toast");
    toast.innerText = message;
    toast.style.backgroundColor = type ? 'rgba(0, 255, 0, 0.5)' : ' rgba(255, 0, 0, 0.9)';
    toast.style.display = 'block';
    setTimeout(() => {
        toast.style.display = 'none';
    }, 3000);
}
function loginNotification() {
    let frmLogin = document.frmLogin;
    frmLogin.addEventListener("submit", function (event) {
        event.preventDefault(); // Ngừng hành động submit mặc định

        let formData = new FormData(this); // Lấy dữ liệu từ form

        // Gửi dữ liệu bằng AJAX với fetch
        fetch("handles/handleLogin.php", { // Sử dụng action của form (handleLogin.php)
            method: "POST",
            body: formData
        })
            .then(response => response.json()) // Parse JSON response từ server

            .then(data => {
                console.log(data)
                // Hiển thị toast thông báo từ phản hồi của server
                if (data.success) {
                    showToast(data.message, data.success);
                    // document.getElementById("login-wrapper").style.display = 'none';
                    getUsername();
                    setTimeout(() => {
                        window.location.href = "../index.php";
                    }, 1900); // Chờ 2 giây trước khi điều hướng     
                }
                else {
                    showToast(data.message, data.success);
                }
            })
            .catch(error => {
                console.error("Lỗi:", error);
                showToast("Có lỗi xảy ra, vui lòng thử lại!", false); // Thông báo lỗi nếu có sự cố
            });
    });
}

function registerNotification() {
    let frmRegister = document.frmRegister;
    // console.log(frmRegister);    
    frmRegister.addEventListener('submit', function (event) {
        event.preventDefault();
        if (checkRegister()) {
            let formData = new FormData(this);
            fetch("handles/handleRegister.php", {
                method: "POST",
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    showToast(data.message, data.success);
                    if (data.success) {
                        // console.log(data);                
                        setTimeout(() => {
                            document.getElementById("register-wrapper").style.display = 'none';
                            // window.location.reload();
                            document.getElementById("login-wrapper").style.display = 'block';
                            clearInputField("#register-container ");
                        }, 2000);
                    }
                })
                .catch(error => console.error("Loi: ", error));
        }
    })
}
// let element = document.getElementById("register-container");
// console.log(element);

function closeWithoutButton(element) {
    let close = document.getElementById(element);
    document.addEventListener("mousedown", function (event) {
        if (close && !close.contains(event.target)) {
            close.parentElement.style.display = 'none';
        }
    });
}
function clearInputField(selector) {
    // console.log(document.getElementById("frmRegister"));        
    let inputFields = document.querySelectorAll(selector + "input");
    console.log(inputFields);

    inputFields.forEach(input => {
        if (input != "" && input.type != "submit") {
            switch(input.type){
                case 'text':
                    input.value = "";
                    break;
                case 'checkbox':
                    input.checked = false;
                    break;
            }
        }
    });
}

function getUsername() {
    fetch("handles/getSession.php")
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById("taikhoan-container").innerHTML = `Xin chào, ${data.username}`;
            }
        })
        .catch(error => console.error("Lỗi:", error));
}
function Logout() {
    let taikhoan = document.getElementById("taikhoan-container");
    let logout = document.getElementById("logout");

    taikhoan.addEventListener('mouseover', function () {
        logout.style.display = "block";
    });
    logout.addEventListener('mouseover', function () {
        logout.style.display = 'block';
    });

    taikhoan.addEventListener('mouseleave', function () {
        logout.style.display = 'none';

    });
    logout.addEventListener('mouseleave', function () {
        logout.style.display = 'none';
    });
}
function checkChangePassword(){
    let currentPass = document.getElementById("currentpass");
    let newPass = document.getElementById("newpass");
    let renewPass = document.getElementById("renewpass");
    let currentPassErr = document.getElementById("currentpassErr");
    let newPassErr = document.getElementById("newpassErr");
    let renewPassErr = document.getElementById("renewpassErr"); 
    currentPassErr.innerHTML = "";
    newPassErr.innerHTML = "";
    renewPassErr.innerHTML = "";   
    let isValid = true;
    let icon = '<i class="fa-sharp fa-solid fa-circle-exclamation"></i>';
    if(!validatePassword(currentPass.value)){
        currentPassErr.innerHTML = icon + 'Mật khẩu tối thiểu là 8 kí tự!';
        if(isValid) currentPass.focus();
        isValid = false;
    }
    if(!validatePassword(newPass.value)){
        newPassErr.innerHTML = icon + 'Mật khẩu tối thiểu là 8 kí tự!';
        if(isValid) newPass.focus();
        isValid = false;
    }
    if(!validatePassword(renewPass.value)){
        renewPassErr.innerHTML = icon + 'Mật khẩu tối thiểu là 8 kí tự';
        if(isValid) renewPass.focus();
        isValid = false;
    }
    if(newPass.value !== renewPass.value){
        renewPassErr.innerHTML = icon + 'Mật khẩu nhập lại không khớp!';
        if(isValid) renewPass.focus();
        isValid = false;
    }
    console.log(isValid);
    
    return isValid;

}
// function changePasswordNotification(){
//     let frmChangePassword = document.frmChangePass;
//     frmChangePassword.addEventListener("submit", function(event){
//         event.preventDefault();

//         let frmData = new FormData(frmChangePassword); 
//         fetch("handles/handleChangePassword.php", {
//             method: "POST",
//             body: frmData
//         })

//         .then(response => response.json())
//         .then(data =>{

//         })
//     });
// }
function openChangePasswordForm(){
    let btnChangePass = document.getElementById("btnChangepass");
    let changePassWrapper = document.getElementById("changepassword-wrapper");
    btnChangePass.addEventListener("click", function(){
        changePassWrapper.style.display = 'block';
        changePassWrapper.style.backdropFilter = 'brightness(0.8)';
    });
}
function display_filter() {
    document.getElementById("filter-menu").classList.toggle("active");
}
// document.addEventListener('mousedown', function (event) {
//     const A = document.getElementById('timkiem-header');
//     const B = document.getElementById('filter-menu');
//     if (A && !A.contains(event.target)) {
//         B.style.display = 'none';
//     }
// });
window.onload = function () {
    closeButton();
    // display_filter();
    startAnimation();
    loginNotification();
    registerNotification();
    getUsername();
    closeWithoutButton("register-container");
    closeWithoutButton("login-container");  
    closeWithoutButton("changepassword-container");
    
    openLoginForm();
}