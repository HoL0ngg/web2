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
                     <th>Tên</th>
                     <th>Số điện thoại</th>
                     <th>Email</th>
                     <th>Trạng thái</th>
                     <th>Vai trò</th>
                     <th>Hành động</th>
                 </tr>
             </thead>
             <tbody id="userTable">
                 <!-- <tr>
                     <td>1</td>
                     <td>Nguyễn Văn A</td>
                     <td>00009625566</td>
                     <td>a@gmail.com</td>
                     <td>Admin</td>
                     <td>
                         <a href="admin.php?page=user&act=update"><button class="edit-btn">✏️ Sửa</button></a>
                         <button class="delete-btn">❌ Xóa</button>
                     </td>
                 </tr>
                 <tr>
                     <td>2</td>
                     <td>Trần Thị B</td>
                     <td>00009625566</td>
                     <td>b@gmail.com</td>
                     <td>Người dùng</td>
                     <td>
                         <a href="admin.php?page=user&act=update"><button class="edit-btn">✏️ Sửa</button></a>
                         <button class="delete-btn">❌ Xóa</button>
                     </td>
                 </tr> -->
             </tbody>
         </table>
     </section>
 </main>

 <style>
     /* Reset CSS */
     * {
         margin: 0;
         padding: 0;
         box-sizing: border-box;
         font-family: Arial, sans-serif;
     }

     /* Main Content */
     .main-content {
         padding: 20px;
         background: #ECF0F1;
         min-height: 100vh;
     }

     header {
         display: flex;
         justify-content: space-between;
         align-items: center;
         font-size: 24px;
         margin-bottom: 20px;
     }

     .add-user-btn {
         background: #27AE60;
         color: white;
         border: none;
         width: 148px;
         height: 30px;
         border-radius: 5px;
         cursor: pointer;
     }

     .add-user-btn a {
         font-weight: 600;
         text-decoration: none;
         color: white;
         /* width: 100%;
         height: 30px; */
         /* border: 3px solid black; */
     }

     .add-user-btn:hover {
         background: #219150;
     }

     /* Bảng danh sách người dùng */
     .user-list {
         background: white;
         padding: 20px;
         border-radius: 10px;
         box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
     }

     table {
         width: 100%;
         border-collapse: collapse;
         margin-top: 10px;
     }

     th,
     td {
         border: 1px solid #BDC3C7;
         padding: 10px;
         text-align: center;
     }

     td a {
         text-decoration: none;
         color: black;
         /* border: 2px solid red; */
         /* padding: 10px; */
     }

     th {
         background: #3498DB;
         color: white;
     }

     /* Nút chỉnh sửa & xóa */
     .edit-btn,
     .delete-btn {
         border: none;
         /* padding: 5px 10px; */
         width: 70px;
         height: 30px;
         cursor: pointer;
         /* margin: 0 5px; */
         border-radius: 5px;
         border: 1px solid #BDC3C7;
     }

     .edit-btn {
         background: white;
     }

     .delete-btn {
         background: white;
         color: black;
     }

     .edit-btn:hover {
         background: #D4AC0D;
     }

     .delete-btn:hover {
         background: #C0392B;
     }
 </style>