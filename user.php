 <!-- Style -->
<link rel="stylesheet" href="css/admin_user.css">

 <!-- Main Content -->
 <main class="main-content">
     <header>
         <h1>Quản Lý Người Dùng</h1>
         <button class="add-user-btn"><a href="admin.php?page=user&act=add">➕Thêm người dùng</a></button>
     </header>

     <!-- Danh sách người dùng -->
     <section class="user-list">
         <table>
             <thead>
                 <tr>
                     <th>ID</th>
                     <th>Tên đăng nhập</th>
                     <th>Số điện thoại</th>
                     <th>Email</th>
                     <th>Trạng thái</th>
                     <th>Vai trò</th>
                     <th>Hàng động</th>
                 </tr>
             </thead>
             <tbody id="userTable">
                 <tr>
                     <td>1</td>
                     <td>Nguyễn Văn A</td>
                     <td>00009625566</td>
                     <td>a@gmail.com</td>
                     <td>Hoạt động</td>
                     <td>Admin</td>
                     <td>
                         <a href="admin.php?page=user&act=update"><button class="edit-btn">✏️ Sửa</button></a>
                         <button class="delete-btn-user">❌ Xóa</button>
                     </td>
                 </tr>
                 <tr>
                     <td>2</td>
                     <td>Trần Thị B</td>
                     <td>00009625566</td>
                     <td>b@gmail.com</td>
                     <td>Không hoạt động</td>
                     <td>Người dùng</td>
                     <td>
                         <a href="admin.php?page=user&act=update"><button class="edit-btn">✏️ Sửa</button></a>
                         <button class="delete-btn-user">❌ Xóa</button>
                     </td>
                 </tr>
             </tbody>
         </table>
     </section>
 </main>
