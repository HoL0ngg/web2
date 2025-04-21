// BANNER
// const images = document.querySelectorAll("#banner img");
// console.log(images);
// let currentIndex = 0;
// function showImage(index) {
//     if (index >= 0 && index < images.length) {
//         images.forEach(img => img.style.display = 'none');
//         images[index].style.display = 'block';
//     }
// }
// function startAnimation() {
//     showImage(currentIndex);
//     setInterval(() => {
//         currentIndex = (currentIndex + 1) % images.length;
//         showImage(currentIndex);
//     }, 3000);
// }
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
            else {
                document.getElementById("taikhoan-container").innerHTML =
                    `<i class="fa-solid fa-user" style="color: #6794c1;"></i>
                        <div style="color: #5cb3f1;">Tài khoản</div>`;
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
        if (isValid) phone.focus();
        isValid = false;
    }
    if (!validateUsername(username.value)) {
        usernameErr.innerHTML = icon + 'Tên tài khoản tối thiểu là 6 kí tự!';
        if (isValid) username.focus();
        isValid = false;
    }
    if (!validatePassword(password.value)) {
        passwordErr.innerHTML = icon + 'Mật khẩu tối thiểu là 8 kí tự!';
        if (isValid) password.focus();
        isValid = false;
    }
    if (!validateRepassword(password.value, repassword.value)) {
        repasswordErr.innerHTML = icon + 'Mật khẩu nhập lại không khớp!';
        if (isValid) repassword.focus();
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
        if (isValid) username.focus();
        isValid = false;
    }
    if (!validatePassword(password.value)) {
        passwordErr.innerHTML = icon + 'Mật khẩu tối thiểu là 8 kí tự!';
        if (isValid) password.focus();
        isValid = false;
    }
    return isValid;
}
//Login notification
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
function loginNotification() {
    let frmLogin = document.frmLogin;
    frmLogin.addEventListener("submit", function (event) {
        event.preventDefault(); // Ngừng hành động submit mặc định

        let formData = new FormData(this); // Lấy dữ liệu từ form

        // Gửi dữ liệu bằng AJAX với fetch
        fetch("handles/LoginController.php", {
            method: "POST",
            body: formData
        })
            .then(response => response.json()) // Parse JSON response từ server            

            .then(data => {
                console.log(data)
                // Hiển thị toast thông báo từ phản hồi của server
                if (data.success) {
                    showToast(data.message, data.success);
                    // Cập nhật session cart và wishlist vào database
                    UpdateCartSessionToDatabase();
                    UpdateWishlistSessionToDatabase();
                    setTimeout(() => {
                        window.location.href = "../index.php";
                    }, 1000);
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

document.getElementById('cart-container').addEventListener('click', (e) => {
    window.location.href = "cart.php?action=cart";
})

document.getElementById('love-container').addEventListener('click', (e) => {
    window.location.href = "index.php?loveProduct";
})

function UpdateCartSessionToDatabase() {
    fetch('cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `action=UpdateCartSessionToDatabase`
    })
        .then(res => res.json())
        .then(data => {
            console.log(data);
        });
}

function UpdateWishlistSessionToDatabase() {
    fetch('XuLyYeuThich.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `action=UpdateWishlistSessionToDatabase`
    })
        .then(res => res.json())
        .then(data => {
            console.log(data);
        });
}

function registerNotification() {
    let frmRegister = document.frmRegister;
    // console.log(frmRegister);  
    if (!frmRegister) return;
    frmRegister.addEventListener('submit', function (event) {
        event.preventDefault();
        if (checkRegister()) {
            let formData = new FormData(this);
            fetch("handles/RegisterController.php", {
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

function closeWithoutButton(element) {
    let close = document.getElementById(element);
    document.addEventListener("mousedown", function (event) {
        if (close && !close.contains(event.target)) {
            close.parentElement.style.display = 'none';
        }
    });
}
function clearInputField(selector) {
    let inputFields = document.querySelectorAll(selector + "input");
    console.log(inputFields);

    inputFields.forEach(input => {
        if (input != "" && input.type != "submit") {
            switch (input.type) {
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
function checkChangePassword() {
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
    if (!validatePassword(currentPass.value)) {
        currentPassErr.innerHTML = icon + 'Mật khẩu tối thiểu là 8 kí tự!';
        if (isValid) currentPass.focus();
        isValid = false;
    }
    if (!validatePassword(newPass.value)) {
        newPassErr.innerHTML = icon + 'Mật khẩu tối thiểu là 8 kí tự!';
        if (isValid) newPass.focus();
        isValid = false;
    }
    if (!validatePassword(renewPass.value)) {
        renewPassErr.innerHTML = icon + 'Mật khẩu tối thiểu là 8 kí tự';
        if (isValid) renewPass.focus();
        isValid = false;
    }
    if (newPass.value !== renewPass.value) {
        renewPassErr.innerHTML = icon + 'Mật khẩu nhập lại không khớp!';
        if (isValid) renewPass.focus();
        isValid = false;
    }
    console.log(isValid);

    return isValid;

}
function changePasswordNotification() {
    let frmChangePassword = document.frmChangePass;
    frmChangePassword.addEventListener("submit", function (event) {
        event.preventDefault();

        if (checkChangePassword()) {
            let frmData = new FormData(frmChangePassword);
            fetch("handles/handleChangePassword.php", {
                method: "POST",
                body: frmData
            })

                .then(response => response.json())
                .then(data => {
                    showToast(data.message, data.success);
                    if (data.success) {
                        let taikhoan = document.getElementById("taikhoan-container");
                        let logout = document.getElementById("logout");

                        taikhoan.addEventListener('mouseover', function () {
                            logout.style.display = "none";
                        });
                        setTimeout(() => {
                            let taikhoanContainer = document.getElementById("taikhoan-container");
                            let username = sessionStorage.getItem("username");
                            if (username == null) {
                                taikhoanContainer.innerHTML = `<i class="fa-solid fa-user" style="color: #6794c1;"></i>
                                    <div style="color: #5cb3f1;">Tài khoản</div>`;
                            }
                            else {
                                console.log("Chưa xóa session");

                            }
                            clearInputField("#changepassword-container ");
                            document.getElementById("changepassword-wrapper").style.display = 'none';
                            document.getElementById("login-wrapper").style.display = 'block';
                            document.getElementById("login-wrapper").style.backdropFilter = 'brightness(0.8)';
                        }, 2000);
                    }

                })
                .catch(error => console.error("Loi: ", error));
        }
    });
}
function openChangePasswordForm() {
    let btnChangePass = document.getElementById("btnChangePass");
    let changePassWrapper = document.getElementById("changepassword-wrapper");
    btnChangePass.addEventListener("click", function () {
        changePassWrapper.style.display = 'block';
        changePassWrapper.style.backdropFilter = 'brightness(0.8)';
    });
}
window.addEventListener("scroll", function () {
    if (window.scrollY > 50) {
        this.document.getElementById("top-header").style.height = '65px';
        // this.document.getElementById("bot-header").style.height = '55px';
    }
    else {
        this.document.getElementById("top-header").style.height = '80px';
        // this.document.getElementById("bot-header").style.height = '60px';
    }
});
// function display_filter() {
//     document.getElementById("filter-menu").classList.toggle("active");
// }

//Pagination

// function displayProduct(pagenum, productArray, numOfProducts) {
//     const startIndex = (pagenum - 1) * numOfProducts;
//     const endIndex = startIndex + numOfProducts;
//     let proContainer = document.getElementById("product-container");
//     let s = "";
//     for (let i = startIndex; i < endIndex && i < productArray.length; i++) {
//         s += `<div class="product">
//         <div class="product-img">
//             <img src="${productArray[i].img}" alt="img1">
//         </div>
//         <div class="productArray-info">
//             <p>${productArray[i].name}</p>
//             <div class="product-price">${productArray[i].price}</div>
//             <button class="add-to-cart" onClick='addToCart(${productArray[i].id}, 1)'>Thêm vào giỏ</button>
//         </div>
//     </div>`;
//     }
//     proContainer.innerHTML = s;

// }

function changeColorPagenum(pagenum) {
    const btnArray = document.querySelectorAll("#pagenum div");
    // console.log(btnArray);
    btnArray[pagenum - 1].classList.add("active");
    btnArray.forEach(btn => {
        btn.addEventListener("click", function () {
            btnArray.forEach(item => {
                item.classList.remove("active")
            });
            btn.classList.add("active");
        });
    });
}

// function phantrang(pagenum, proArray, numOfProducts) {
//     const pageNum = document.getElementById("pagenum");
//     console.log(pagenum);
//     if (!pageNum) return;

//     displayProduct(pagenum, proArray, numOfProducts);

//     const totalPages = Math.ceil(proArray.length / numOfProducts);

//     for (let i = 1; i <= totalPages; i++) {
//         const button = document.createElement("div");
//         button.setAttribute("class", "#pagenum div");
//         button.textContent = i;
//         button.addEventListener("click", function () {
//             displayProduct(i, proArray, numOfProducts);
//         });
//         pageNum.appendChild(button);
//     }
//     changeColorPagenum();
// }
function loadLoveProducts() {
    fetch('XuLyYeuThich.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `action=getLoveProducts`
    })
        .then(res => res.json())
        .then(data => {
            console.log(data);
            if (data.status == "error") {
                showToast(data.message, false);
                return;
            }
            const heartIcons = document.querySelectorAll(".heart-icon i");
            heartIcons.forEach(icon => {
                icon.classList.remove("fa-solid");
                icon.classList.add("fa-regular");
            });
            data.data.forEach(productId => {
                const heartIcon = [...heartIcons].find(icon => icon.closest(".product").dataset.id == productId.product_id);

                if (heartIcon) {
                    heartIcon.classList.remove("fa-regular");
                    heartIcon.classList.add("fa-solid");
                }
            });
        }).catch(err => {
            console.error("Lỗi khi load sản phẩm yêu thích:", err);
        });
}

async function loadProducts(pagenum = 1) {
    const urlParams = new URLSearchParams(window.location.search);
    const maChungLoai = parseInt(urlParams.get("maChungloai") || 0);
    const maTheLoai = parseInt(urlParams.get("maTheLoai") || 0);
    console.log(maChungLoai, maTheLoai);
    let minPrice = document.getElementById("minprice").value.replace(/,/g, "");
    minPrice = parseInt(minPrice) || 0;
    let maxPrice = document.getElementById("maxprice").value.replace(/,/g, "");
    maxPrice = parseInt(maxPrice) || 9000000;
    const keyword = document.getElementById("timkiem").value.trim();
    const checkboxes_brand = document.querySelectorAll(".brandname");
    const selected_checkboxes_brand = [];

    for (let i = 0; i < checkboxes_brand.length; i++) {
        if (checkboxes_brand[i].checked) {
            selected_checkboxes_brand.push(parseInt(checkboxes_brand[i].value));
        }
    }

    const checkboxes_loaisanpham = document.querySelectorAll(".loaisanphamcb");
    const selected_checkboxes_loaisanpham = [];

    for (let i = 0; i < checkboxes_loaisanpham.length; i++) {
        if (checkboxes_loaisanpham[i].checked) {
            selected_checkboxes_loaisanpham.push(parseInt(checkboxes_loaisanpham[i].value));
        }
    }



    const response = await fetch(`../api/pagination_api.php?pagenum=${pagenum}&keyword=${encodeURIComponent(keyword)}&selected_checkboxes_brand=${encodeURIComponent(JSON.stringify(selected_checkboxes_brand))}&selected_checkboxes_loaisanpham=${encodeURIComponent(JSON.stringify(selected_checkboxes_loaisanpham))}&minprice=${minPrice}&maxprice=${maxPrice}&maChungLoai=${maChungLoai}&maTheLoai=${maTheLoai}`);

    const data = await response.json();
    console.log(data);
    if (!data || !data.products || data.products.length === 0) {
        document.getElementById("product-container").innerHTML = "<p>Không tìm thấy sản phẩm nào phù hợp.</p>";
        document.getElementById("pagenum").innerHTML = "";
        return;
    }
    let proContainer = document.getElementById("product-container");
    const pageNum = document.getElementById("pagenum");
    if (!pageNum) return;
    pageNum.innerHTML = "";
    let s = "";
    data.products.forEach(product => {
        s += `<div class="product" data-id="${product.product_id} ">
        <div class="product-img">
            <img src="${product.image_url}" alt="img1" onclick="getInfoProduct(${product.product_id})">
        </div>
        <div class="productArray-info">
            <p>${product.product_name}</p>
            <div class="product-price">${product.price} VNĐ</div>
        </div>
        <div class="product-button-container">
            <div class="heart-icon" onClick="toggleLove(this, ${product.product_id})"><i class="fa-regular fa-heart"></i></div>
            <div style="width: 100%; height: 100%;">
            <button class="add-to-cart" onClick='addToCart(${product.product_id}, 1)'>Thêm vào giỏ</button>
            </div>        
        </div>
        <div style="margin: 7px;">
                <button class="product-detail-button" onClick='getInfoProduct(${product.product_id})'>Chi tiết</button>
        </div>
    </div>`;
    });
    proContainer.innerHTML = s;
    for (let i = 1; i <= data.totalPage; i++) {
        const button = document.createElement("div");
        button.setAttribute("class", "#pagenum div");
        button.textContent = i;
        button.addEventListener("click", function () {
            loadProducts(i);
            scrollToContent()
        });
        pageNum.appendChild(button);
    }
    changeColorPagenum(pagenum);
    loadLoveProducts();
}



function toggleLove(element, productId) {
    const icon = element.querySelector("i");
    fetch('XuLyYeuThich.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `action=toggleLove&productId=${productId}`
    })
        .then(res => res.json())
        .then(data => {
            console.log(data);
            if (data.status == "error") {
                showToast(data.message, false);
                return;
            }
            if (icon.classList.contains("fa-solid")) {
                icon.classList.add("fa-regular");
                icon.classList.remove("fa-solid");
            }
            else {
                icon.classList.remove("fa-regular");
                icon.classList.add("fa-solid");
            }
            showToast(data.message, true);
        });
}
function scrollToContent() {
    const content = document.getElementById("content-wrapper");
    const headerHeight = document.getElementById("header")?.offsetHeight || 0;
    if (content) {
        const contentTop = content.offsetTop; // Vị trí top tương đối với <body>
        const scrollToY = contentTop - headerHeight - 10; // Trừ đi chiều cao header nếu cần
        // console.log(contentTop);
        // console.log(scrollToY);  

        window.scrollTo({
            top: scrollToY,
            behavior: "smooth"
        });
    }

}

document.getElementById("timkiem").addEventListener("keyup", () => loadProducts(1));

document.getElementById("filters").addEventListener("click", function () {
    const url = new URL(window.location.href);
    url.searchParams.delete("maChungloai");
    url.searchParams.delete("maTheLoai");   
    window.history.pushState({}, '', url);
    loadProducts(1);
});


const resetbtn = document.getElementById('reset-filters');
if (resetbtn) {
    resetbtn.addEventListener('click', function () {
        document.getElementById('minprice').value = "";
        document.getElementById('maxprice').value = "";
        document.querySelectorAll(".brandname").forEach(cb => cb.checked = false);
        document.querySelectorAll(".loaisanphamcb").forEach(cb => cb.checked = false);
        document.getElementById("timkiem").value = "";
        loadProducts(1);
    });
}

document.getElementById("filters").addEventListener('click', function () {
    const url = new URL(window.location.href);
    url.searchParams.delete("maChungloai");
    url.searchParams.delete("maTheLoai");
    document.querySelectorAll(".loaisanpham").forEach(i => i.classList.remove("active"));
    loadProducts(1);
});


function loadproductleftmenu(){
    const loaiSanPhamItems = document.querySelectorAll(".loaisanpham");
    loaiSanPhamItems.forEach(item => {
    item.addEventListener("click", function () {
        // Lấy maTheLoai từ data-matheloai
        document.getElementById('minprice').value = "";
        document.getElementById('maxprice').value = "";
        document.querySelectorAll(".brandname").forEach(cb => cb.checked = false);
        document.querySelectorAll(".loaisanphamcb").forEach(cb => cb.checked = false);
        document.getElementById("timkiem").value = "";

        const maTheLoai = parseInt(this.dataset.matheloai);
        const maChungloai = parseInt(this.dataset.machungloai);

        const url = new URL(window.location.href);
        url.searchParams.delete("maChungloai")
        url.searchParams.set("maChungloai", maChungloai);
        url.searchParams.set("maTheLoai", maTheLoai);
        history.pushState({}, "", url);

        loaiSanPhamItems.forEach(i => i.classList.remove("active"));
        this.classList.add("active");

        loadProducts(1);
    });
});
}

function formatNumberInput(input) {
    let value = input.value.replace(/\D/g, "");

    input.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

document.getElementById("minprice").addEventListener("input", function () {
    formatNumberInput(this);
});
document.getElementById("maxprice").addEventListener("input", function () {
    formatNumberInput(this);
});




addToCart = (id, quantity) => {
    fetch('cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `action=addtocart&id=${id}&quantity=${quantity}`
    })
        .then(res => res.text())
        .then(data => {
            Toastify({
                text: `🛒 Đã thêm vào giỏ hàng!`,
                duration: 3000,
                gravity: "top",
                position: "center",
                timerProgressBar: true,
                style: {
                    background: "#4CAF50",
                    color: "#fff",
                    padding: "10px",
                    borderRadius: "8px",
                }
            }).showToast();
        });
    updateCartCount();
}

function updateCartCount() {
    // Cập nhật số lượng sản phẩm trong giỏ hàng
    fetch('cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `action=getCartCount`
    })
        .then(res => res.json())
        .then(data => {
            if (data.count < 10)
                document.getElementById("cart-count").innerText = data.count;
            else document.getElementById("cart-count").innerText = "9+";
        })
}
//PRODUCT DETAIL
function getInfoProduct(productId) {
    fetch(`view/product_detail.php?productId=${productId}`)
        .then(response => response.text())
        .then(html => {
            document.getElementById("modal-container").innerHTML = html;

            const container = document.getElementById("container-product-detail");
            // container.style.display = 'flex';

            const detail = document.getElementById("product-detail");

            // Đóng khi click ra ngoài modal
            document.addEventListener("mousedown", function handler(e) {
                if (!detail.contains(e.target)) {
                    container.style.display = 'none';
                    document.removeEventListener("mousedown", handler); // tránh gắn nhiều lần
                }
            });

            // Đóng khi nhấn nút close
            document.querySelector("#product-detail .btn-close").addEventListener("click", () => {
                container.style.display = 'none';
            });

            // Gắn lại nút tăng/giảm
            document.querySelector(".quantity-control button:first-child").addEventListener("click", () => {
                const input = document.getElementById("quantity");
                if (parseInt(input.value) > 1) input.value = parseInt(input.value) - 1;
            });

            document.querySelector(".quantity-control button:last-child").addEventListener("click", () => {
                const input = document.getElementById("quantity");
                const max = parseInt(input.getAttribute('max'));
                if (parseInt(input.value) < max) input.value = parseInt(input.value) + 1;
                console.log(input.value);

            });

            // Xử lý nút Thêm vào giỏ
            document.querySelector("#container-product-detail .add-to-cart").addEventListener("click", () => {
                const quantity = parseInt(document.getElementById("quantity").value);
                console.log("Đã thêm " + quantity + " sản phẩm vào giỏ hàng");
                addToCart(productId, quantity);

                container.style.display = 'none';
            });

        });
}


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

function HuyDonHang() {
    const cancelButtons = document.querySelectorAll('.cancel-btn');
    cancelButtons.forEach(button => {
        button.addEventListener('click', function () {
            const row = this.closest('tr');
            const statusCell = row.querySelector('.status-cell');
            const orderId = statusCell.dataset.orderId;
            const currentStatus = statusCell.innerText.trim();
            let newStatus = "cancelled";
            if (currentStatus === 'shipping' || currentStatus === 'delivered') {
                showToast('Đơn hàng đã được xử lý không thể hủy');
                return;
            }
            if (currentStatus === 'cancelled') {
                showToast('Đơn hàng đã được hủy');
                return;
            }
            if (confirm("xác nhận đơn hàng")) {
                fetch('change_status_order.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `order_id=${orderId}&status=${newStatus}`
                })
                    .then(res => res.text())
                    .then(data => {
                        statusCell.innerText = newStatus;
                        showToast("Hủy thành công", true);
                    })
            }
        });

    });
}


function filterOrders() {
    const from = document.getElementById('fromDate').value;
    const to = document.getElementById('toDate').value;
    const status = document.getElementById('orderStatus').value;


    const formData = new URLSearchParams();
    formData.append('from', from);
    formData.append('to', to);
    formData.append('status', status);

    fetch('get_filter_orderhistory.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: formData.toString()
    })
    .then(res => res.text())
    .then(data => {
        const tbody = document.getElementById('orderTable');
        tbody.innerHTML = data;
        HuyDonHang();
    })
    .catch(error => {
        console.error("Lỗi khi lọc đơn hàng:", error);
    });
}
 function refreshOrders(){
    document.getElementById('fromDate').value="";
    document.getElementById('toDate').value="";
    document.getElementById('orderStatus').selectedIndex = 0;
    filterOrders();
 }

window.onload = function () {
    console.log("Window loaded");
    closeButton();
    loginNotification();
    registerNotification();
    closeWithoutButton("register-container");
    closeWithoutButton("login-container");
    closeWithoutButton("changepassword-container");
    openChangePasswordForm();
    changePasswordNotification();

    console.log("Window loaded: before openLoginForm");

    openLoginForm();
    openLoginForm();

    console.log("Window loaded: after openLoginForm");


    loadProducts();
    HuyDonHang();
    loadproductleftmenu();
}

