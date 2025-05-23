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
  const currentPage =
    new URLSearchParams(window.location.search).get("page") || "admin_home";

  allSideMenu.forEach((item) => {
    // Get the 'page' parameter from the href
    const page =
      new URL(item.href, window.location.origin).searchParams.get("page") ||
      "admin_home";
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
      leftContainer.style.width = "60px";
      rightContainer.style.width = "calc(100% - 60px)";
      imgLogo.src = "imgs/logomini.svg";
    } else {
      leftContainer.style.width = "20%";
      rightContainer.style.width = "80%";
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

function validatePhone(phone) {
  let reg = /^0(\d{9}|9\d{8})$/;
  return reg.test(phone);
}
function validateUsername(username) {
  let reg = /^[a-zA-Z][a-zA-Z0-9_.]{5,29}$/;
  return reg.test(username);
}
function validatePassword(password) {
  let reg = /.{8,}/;
  return reg.test(password);
}

function checkAddUser() {
  let username = document.getElementById("username");
  let phone = document.getElementById("phone");
  let password = document.getElementById("password");

  if (!validateUsername(username.value)) {
    showToast("Tên tài khoản tối thiểu là 6 kí tự!", false);
    return false;
  }

  if (!validatePhone(phone.value)) {
    showToast("Số điện thoại không hợp lệ!", false);
    return false;
  }

  if (!(password.value === "") && !validatePassword(password.value)) {
    showToast("Mật khẩu tối thiểu là 8 kí tự!", false);
    return false;
  }
  return true;
}

// Lấy form element
// Lấy các form elements
const addUserFrm = document.getElementById("addUserForm");
const updateUserFrm = document.getElementById("updateUserForm");

// Định nghĩa handler chung cho cả thêm và sửa user
const userFormHandler = function (event) {
  event.preventDefault();
  if (!checkAddUser()) return;
  const formData = new FormData(this);

  // Thêm action vào formData để server biết là thêm hay sửa
  formData.append("action", this.id === "addUserForm" ? "add" : "update");
  // const actionUrl = this.id === 'addUserForm'
  //     ? "admin.php?page=user&act=addUser"
  //     : "admin.php?page=user&act=updateUser";

  fetch("api/user_api.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      console.log(data);

      if (data.success) {
        handleSuccessResponse(data);
      } else {
        handleErrorResponse(data);
        console.error("Lỗi:", data.message);
      }
    })
    .catch((error) => {
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

document.addEventListener("click", function (event) {
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
      cancelButtonText: "Hủy",
    }).then((result) => {
      if (result.isConfirmed) {
        // return true khi nhan confirmbuttontext(xoa), return false khi nhan cancel(Huy)
        let dataForm = new FormData();
        dataForm.append("action", "xoa");
        dataForm.append("id", userId);

        fetch("handles/handleUser.php", {
          method: "POST",
          body: dataForm,
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.success) {
              Swal.fire("Đã xóa!", "Người dùng đã bị xóa.", "success");
              handleSuccessResponse(data);
            } else {
              Swal.fire("Lỗi!", "Không thể xóa người dùng.", "error");
              handleErrorResponse(data);
            }
          })
          .catch((error) => {
            console.error("Lỗi hệ thống: ", error);
            Swal.fire("Lỗi!", "Có lỗi xảy ra trong hệ thống.", "error");
          });
      }
    });
  }
});

// ADD PRODUCT
const productAddForm = document.getElementById("productAddForm");
if (productAddForm) {
  productAddForm.addEventListener("submit", async (e) => {
    e.preventDefault();

    if (validateProductForm()) {
      let formData = new FormData(e.target); // Sửa ở đây
      formData.append("action", "addProduct");
      try {
        const response = await fetch("api/product_api.php", {
          method: "POST",
          body: formData,
        });
        const data = await response.json();
        if (data.success) {
          handleSuccessResponse(data);
        } else {
          handleErrorResponse(data);
          console.error("Lỗi:", data.message);
        }
      } catch (error) {
        // Sửa ở đây
        console.error("Lỗi hệ thống: ", error);
        showToast("Lỗi hệ thống", false);
      }
    }
  });
}
const productUpdateForm = document.getElementById("productUpdateForm");
if (productUpdateForm) {
  productUpdateForm.addEventListener("submit", async (e) => {
    e.preventDefault();

    if (validateProductForm()) {
      let formData = new FormData(e.target); // Sửa ở đây
      formData.append("action", "updateProduct");

      const urlParams = new URLSearchParams(window.location.search);
      const productId = urlParams.get("id");
      if (productId) {
        formData.append("product_id", productId);
      }
      try {
        const response = await fetch("api/product_api.php", {
          method: "POST",
          body: formData,
        });
        const data = await response.json();
        if (data.success) {
          handleSuccessResponse(data);
        } else {
          handleErrorResponse(data);
          console.error("Lỗi:", data.message);
        }
      } catch (error) {
        // Sửa ở đây
        console.error("Lỗi hệ thống: ", error);
        showToast("Lỗi hệ thống", false);
      }
    }
  });
}
function validateProductForm() {
  let isValid = true;

  const productName = document.getElementById("productname").value.trim();
  const quantity = document.getElementById("quantity").value.trim();
  const price = document.getElementById("price").value.trim();
  const theloai = document.getElementById("theloai").value.trim();
  const thuonghieu = document.getElementById("thuonghieu").value.trim();
  const mota = document.getElementById("mota").value.trim();
  const imageInput = document.getElementById("imageInput").files.length;
  const previewImage = document.querySelector("#imagePreview img");
  const hasPreviewImage =
    previewImage && previewImage.getAttribute("src") !== "imgs/addImg.png";

  if (productName === "") {
    isValid = false;
    showToast("Vui lòng nhập tên sản phẩm", isValid);
    return isValid;
  }

  // if (quantity === '' || isNaN(quantity) || quantity <= 0) {
  //     isValid = false;
  //     showToast("Vui lòng nhập số lượng hợp lệ!", isValid);
  //     return isValid;
  // }

  // Kiểm tra Giá
  // if (price === '' || isNaN(price) || price <= 0) {
  //     isValid = false;
  //     showToast("Vui lòng nhập giá hợp lệ.", isValid);
  //     return isValid;
  // }

  // Kiểm tra Thể loại
  if (theloai === "") {
    isValid = false;
    showToast("Vui lòng chọn thể loại.", isValid);
    return isValid;
  }

  // Kiểm tra Thương hiệu
  if (thuonghieu === "") {
    isValid = false;
    showToast("Vui lòng chọn thương hiệu.", isValid);
    return isValid;
  }

  // Kiểm tra Mô tả (không bắt buộc nhưng có thể kiểm tra nếu cần)
  if (mota === "") {
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
// DELETE PRODUCT
function fetchData(url, data) {
  let formData = new FormData();
  for (let key in data) {
    formData.append(key, data[key]);
  }

  return fetch(url, {
    method: "POST",
    body: formData,
  }).then((response) => response.json());
}
// document.addEventListener("click", function (event) {
//   if (event.target.classList.contains("delete-btn-product")) {
//     let productId = event.target.getAttribute("data-id");
//     fetchData("api/product_api.php", {
//       action: "checkProduct",
//       product_id: productId,
//     }).then((data) => {
//       // let notification = {success: false, message: ""};
//       if (data.success) {
//         Swal.fire({
//           title: "Thông báo",
//           text: "Sản phẩm đã được bán ra, bạn có muốn ẩn sản phẩm không?",
//           icon: "warning",
//           showCancelButton: true,
//           confirmButtonColor: "#d33",
//           cancelButtonColor: "#3085d6",
//           confirmButtonText: "Có",
//           cancelButtonText: "Không",
//         }).then((result) => {
//           if (result.isConfirmed) {
//             fetchData("api/product_api.php", {
//               action: "hideProduct",
//               product_id: productId,
//             }).then((data) => {
//               if (data.success) {
//                 handleSuccessResponse(data);
//                 location.reload();
//               } else {
//                 handleErrorResponse(data);
//                 location.reload();
//               }
//             });
//           }
//         });
//       } else {
//         Swal.fire({
//           title: "Xác nhận xóa",
//           text: "Bạn có chắc chắn muốn xóa sản phẩm này không?",
//           icon: "warning",
//           showCancelButton: true,
//           confirmButtonColor: "#d33",
//           cancelButtonColor: "#3085d6",
//           confirmButtonText: "Xóa",
//           cancelButtonText: "Hủy",
//         }).then((result) => {
//           if (result.isConfirmed) {
//             fetchData("api/product_api.php", {
//               action: "deleteProduct",
//               product_id: productId,
//             }).then((data) => {
//               if (data.success) {
//                 // notification.success = true;
//                 // notification.message = "Xóa sản phẩm thành công!";
//                 handleSuccessResponse(data);
//                 location.reload();
//               } else {
//                 // notification.message = "Ẩn sản phẩm không thành công";
//                 handleErrorResponse(data);
//                 // this.location.reload();
//               }
//             });
//           }
//         });
//       }
//     });
//   }
// });

document.addEventListener("click", function (event) {
  if (event.target.classList.contains("delete-btn-product")) {
    let productId = event.target.getAttribute("data-id");
    fetchData("api/product_api.php", {
      action: "checkProduct",
      product_id: productId,
    }).then((data) => {
      // let notification = {success: false, message: ""};
      if (data.success) {
        Swal.fire({
          title: "Thông báo",
          text: "Sản phẩm đã được bán ra, bạn có muốn ẩn sản phẩm không?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#d33",
          cancelButtonColor: "#3085d6",
          confirmButtonText: "Có",
          cancelButtonText: "Không",
        }).then((result) => {
          if (result.isConfirmed) {
            fetchData("api/product_api.php", {
              action: "hideProduct",
              product_id: productId,
            }).then((data) => {
              if (data.success) {
                handleSuccessResponse(data);
                location.reload();
              } else {
                handleErrorResponse(data);
                location.reload();
              }
            });
          }
        });
      } else {
        fetchData("api/product_api.php", {
          action: "checkProductIsImported",
          product_id: productId,
        }).then((data) => {
          if (data.success) {
            Swal.fire({
              title: "Thông báo",
              text: "Sản phẩm đã tồn tại trong phiếu nhập, bạn có muốn ẩn sản phẩm không?",
              icon: "warning",
              showCancelButton: true,
              confirmButtonColor: "#d33",
              cancelButtonColor: "#3085d6",
              confirmButtonText: "Có",
              cancelButtonText: "Không",
            }).then((result) => {
              if (result.isConfirmed) {
                fetchData("api/product_api.php", {
                  action: "hideProduct",
                  product_id: productId,
                }).then((data) => {
                  if (data.success) {
                    handleSuccessResponse(data);
                    location.reload();
                  } else {
                    handleErrorResponse(data);
                    location.reload();
                  }
                });
              }
            });
          } else {
            Swal.fire({
              title: "Xác nhận xóa",
              text: "Bạn có chắc chắn muốn xóa sản phẩm này không?",
              icon: "warning",
              showCancelButton: true,
              confirmButtonColor: "#d33",
              cancelButtonColor: "#3085d6",
              confirmButtonText: "Xóa",
              cancelButtonText: "Hủy",
            }).then((result) => {
              if (result.isConfirmed) {
                fetchData("api/product_api.php", {
                  action: "deleteProduct",
                  product_id: productId,
                }).then((data) => {
                  if (data.success) {
                    // notification.success = true;
                    // notification.message = "Xóa sản phẩm thành công!";
                    handleSuccessResponse(data);
                    location.reload();
                  } else {
                    // notification.message = "Ẩn sản phẩm không thành công";
                    handleErrorResponse(data);
                    // this.location.reload();
                  }
                });
              }
            });
          }
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
  } else {
    console.log("Khong tim thay message");
  }
};

function showOrderDetail(button) {
  const orderId = button.value;
  fetch("get_order_details.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded", //dưới dạng html
    },
    body: "order_id=" + encodeURIComponent(orderId),
  })
    .then((response) => response.text())
    .then((data) => {
      // Đổ dữ liệu vào bảng chi tiết
      document
        .getElementById("detail-table")
        .getElementsByTagName("tbody")[0].innerHTML = data;
      // Hiển thị popup
      document.getElementById("order-detail-popup").classList.add("show");
    })
    .catch((error) => {
      console.error("Lỗi khi lấy chi tiết đơn hàng:", error);
    });
}
function hideOrderDetail() {
  const popup = document.getElementById("order-detail-popup");
  popup.classList.remove("show");
}

//NHOM QUYEN
function openPopup(id) {
  document.getElementById("overlay").classList.remove("hidden");
  document.getElementById(id).classList.remove("hidden");
}

function closePopup() {
  document.getElementById("overlay").classList.add("hidden");
  document
    .querySelectorAll(".popup-modal")
    .forEach((p) => p.classList.add("hidden"));
}
const btnRole = document.querySelectorAll(".btn_role")[0];
if (btnRole) {
  btnRole.addEventListener("click", function (e) {
    e.preventDefault();
    openPopup("popup-them-nhomquyen");
  });
}
const btnFunc = document.querySelectorAll(".btn_role")[1];
if (btnFunc) {
  btnFunc.addEventListener("click", function (e) {
    e.preventDefault();
    openPopup("popup-them-chucnang");
  });
}

function themNhomQuyen() {
  console.log("hihih");

  const ten = document.getElementById("ten_nhom_quyen").value;
  if (!ten) {
    showToast("Vui lòng nhập tên nhóm quyền", false);
    return;
  }
  let formData = new FormData();
  formData.append("action", "addRole");
  formData.append("role_name", ten);
  fetch("api/permission_api.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      console.log(data);

      if (data.success) {
        handleSuccessResponse(data);
        closePopup();
        location.reload();
      } else {
        showToast("Loi" + data.message, data.success);
      }
    });
}

function themChucNang() {
  const ten = document.getElementById("ten_chuc_nang").value;
  const ma = document.getElementById("ma_chuc_nang").value;
  if (!ten || !ma) {
    showToast("Vui lòng nhập tên và mã chức năng", false);
    return;
  }
  let formData = new FormData();
  formData.append("action", "addChucNang");
  formData.append("function_name", ten);
  formData.append("function_id", ma);
  fetch("api/permission_api.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        handleSuccessResponse(data);
        closePopup();
        location.reload();
      } else {
        showToast("Loi" + data.message, data.success);
      }
    })
    .catch((error) => {
      console.error("Lỗi hệ thống: ", error);
      showToast("Lỗi hệ thống", false);
    });
}

const permissionForm = document.getElementById("permission-form");
if (permissionForm) {
  permissionForm.addEventListener("submit", async (e) => {
    e.preventDefault();
    const url = new URL(window.location.href);
    const role_id = url.searchParams.get("role_id");
    let formData = new FormData(e.target);
    formData.append("action", "updatePermission");
    formData.append("role_id", role_id);
    try {
      const response = await fetch("api/permission_api.php", {
        method: "POST",
        body: formData,
      });
      const data = await response.json();
      if (data.success) {
        handleSuccessResponse(data);
        location.reload();
      } else {
        showToast("Loi " + data.message, data.success);
      }
    } catch (error) {
      console.error("Lỗi hệ thống: ", error);
      showToast("Lỗi hệ thống", false);
    }
  });
}
// SEARCH PRODUCTS
const searchInput = document.getElementById("search-input-product");
const searchCombobox = document.getElementById("search-combobox");

// Khai báo biến để lưu id của timeout
let typingTimer;

// Thời gian chờ sau khi ngừng gõ (300ms)
const typingInterval = 300; // milliseconds
function performSearch() {
  const keyword = searchInput.value;
  const type = searchCombobox.value;

  fetchData("api/product_api.php", {
    action: "searchProduct",
    keyword: keyword,
    type: type,
  })
    .then((data) => {
      // console.log(data);
      renderProducts(
        data.products,
        data.actions.canUpdate,
        data.actions.canDelete,
        keyword
      );
    })
    .catch((error) => console.error("Error:", error));
}
if (searchInput) {
  searchInput.addEventListener("input", function () {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(performSearch, typingInterval);
  });
}
if (searchCombobox) {
  searchCombobox.addEventListener("change", performSearch);
}

function highlightKeyword(text, keyword) {
  if (!keyword) return text; // Không có từ khóa thì trả nguyên
  const escapedKeyword = keyword.replace(/[.*+?^${}()|[\]\\]/g, "\\$&"); // Escape keyword
  const regex = new RegExp(`(${escapedKeyword})`, "gi"); // Tạo regex không phân biệt hoa thường

  return text.replace(regex, `<span class="highlight">$1</span>`);
}

function renderProducts(products, canUpdate, canDelete, keyword) {
  const tableBody = document.querySelector("#product-list table"); // chọn bảng
  let html = `
        <tr>
            <th>Mã sản phẩm</th>
            <th>Tên sản phẩm</th>
            <th>Tên thương hiệu</th>
            <th>Thể loại</th>
            <th>Số lượng</th>
            <th>Giá</th>
            <th>Ảnh</th>
            <th>Trạng thái</th>
            ${canUpdate || canDelete ? "<th>Thao tác</th>" : ""}
        </tr>
    `;

  if (products.length > 0) {
    products.forEach((product) => {
      html += `
            <tr class="${product.status == 0 ? "hidden-product" : ""}">
                <td>${highlightKeyword(product.product_id, keyword)}</td>
                <td>${highlightKeyword(product.product_name, keyword)}</td>
                <td>${highlightKeyword(product.brand_name, keyword)}</td>
                <td>${highlightKeyword(product.tentheloai, keyword)}</td>
                <td>${highlightKeyword(product.quantity, keyword)}</td>
                <td>${highlightKeyword(product.price, keyword)}</td>
                <td><img src="${product.image_url}" alt="product-image" /></td>
                <td>${
                  product.status == 0
                    ? '<span class="status-no-complete">Ẩn sản phẩm</span>'
                    : '<span class="status-complete">Hiển thị</span>'
                }</td>
                ${
                  canUpdate || canDelete
                    ? `
                    <td>
                        ${
                          canUpdate
                            ? `<div><a href="admin.php?page=product&action=edit&id=${product.product_id}" class="btn">✏️ Sửa</a></div>`
                            : ""
                        }
                        ${
                          canDelete
                            ? `<div style="margin-top: 5px;"><button class="delete-btn-product btn" data-id="${product.product_id}">❌ Xóa</button></div>`
                            : ""
                        }
                    </td>
                    `
                    : ""
                }
            </tr>
            `;
    });
  } else {
    const colspan = canUpdate || canDelete ? 9 : 8;
    html += `
            <tr>
                <td colspan="${colspan}" style="text-align: center; font-weight: bold; padding: 17px;">Không tìm thấy sản phẩm</td>
            </tr>
        `;
  }

  tableBody.innerHTML = html;
}

//SEARCH USER
const searchInputUser = document.getElementById("search-input-user");
const cboUser = document.getElementById("search-combobox-user");

if (searchInputUser) {
  searchInputUser.addEventListener("input", function () {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(performSearchUser, typingInterval);
  });
}
if (cboUser) {
  cboUser.addEventListener("change", performSearchUser);
}

function performSearchUser() {
  const keyword = searchInputUser.value;
  const type = cboUser.value;

  fetchData("api/user_api.php", {
    action: "searchUser",
    keyword: keyword,
    type: type,
  })
    .then((data) => {
      // console.log(data);
      renderUsers(
        data.users,
        data.actions.canUpdate,
        data.actions.canDelete,
        keyword
      );
    })
    .catch((error) => console.error("Error:", error));
}
function renderUsers(users, canUpdate, canDelete, keyword) {
  const tableBody = document.querySelector(".user-list table");
  let html = `<thead>
        <th>ID</th>
        <th>Tên đăng nhập</th>
        <th>Họ tên</th>
        <th>Số điện thoại</th>
        <th>Email</th>
        <th>Trạng thái</th>
        <th>Vai trò</th>    
        ${canUpdate || canDelete ? "<th>Thao tác</th>" : ""}
        </thead>
    `;
  if (users.length == 0) {
    const colspan = canUpdate || canDelete ? 8 : 7;
    html += `
            <tr>
                <td colspan="${colspan}" style="text-align: center; font-weight: bold; padding: 17px;">Không tìm thấy người dùng</td>
            </tr>
        `;
  } else {
    users.forEach((user) => {
      html += `
            <tr class="${user.status == 0 ? "hidden-product" : ""}">
                <td>${user.user_id}</td>
                <td>${user.username}</td>
                <td>${user.fullname}</td>
                <td>${user.phone}</td>
                <td>${user.email}</td>
                <td>${
                  user.status == 0
                    ? '<span class="status-no-complete">Bị khóa</span>'
                    : '<span class="status-complete">Hoạt động</span>'
                }</td>
                <td>${user.role_name}</td>                
                ${
                  canUpdate || canDelete
                    ? `
                    <td>
                        ${
                          canUpdate
                            ? `<a href="admin.php?page=user&act=update&uid=${user.user_id}}">
                                            <button class="edit-btn">✏️ Sửa</button>
                                        </a>`
                            : ""
                        }
                    </td>
                    `
                    : ""
                }
            </tr>
            `;
    });
  }
  tableBody.innerHTML = html;
  // ${canDelete ? `<div style="margin-top: 5px;"><button class="delete-btn-product btn" data-id="${user.user_id}">❌ Xóa</button></div>` : ''}
}
