<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý người dùng</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
        .role-admin {
            color: #dc3545;
            font-weight: bold;
        }
        .role-user {
            color: #28a745;
        }
        .action-buttons a {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Quản lý người dùng</h1>
            <div>
                <a href="/webbanhang/account/addUser" class="btn btn-success">
                    <i class="fas fa-user-plus"></i> Thêm người dùng
                </a>
                <a href="/webbanhang/product" class="btn btn-secondary ml-2">
                    <i class="fas fa-home"></i> Trang chủ
                </a>
            </div>
        </div>

        <?php if (empty($accounts)): ?>
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> Chưa có người dùng nào trong hệ thống.
            </div>
        <?php else: ?>
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-users"></i> Danh sách người dùng
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Họ tên</th>
                                    <th scope="col">Vai trò</th>
                                    <th scope="col" class="text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($accounts as $account): ?>
                                <tr>
                                    <td><?= $account->id ?></td>
                                    <td><?= htmlspecialchars($account->username) ?></td>
                                    <td><?= htmlspecialchars($account->fullname) ?></td>
                                    <td>
                                        <span class="badge <?= $account->role === 'admin' ? 'badge-danger' : 'badge-success' ?>">
                                            <?= $account->role === 'admin' ? 'ADMIN' : 'User' ?>
                                        </span>
                                    </td>
                                    <td class="text-center action-buttons">
                                        <a href="/webbanhang/account/editUser/<?= $account->id ?>" class="btn btn-sm btn-info" title="Sửa">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="#" onclick="confirmDelete(<?= $account->id ?>, '<?= htmlspecialchars($account->username) ?>')" class="btn btn-sm btn-danger" title="Xóa">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Modal xác nhận xóa -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">Xác nhận xóa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Bạn có chắc chắn muốn xóa người dùng <span id="delete-username" class="font-weight-bold"></span>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <a href="#" id="confirm-delete" class="btn btn-danger">Xóa</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function confirmDelete(id, username) {
            document.getElementById('delete-username').textContent = username;
            document.getElementById('confirm-delete').href = '/webbanhang/account/deleteUser/' + id;
            $('#deleteModal').modal('show');
        }
    </script>
</body>
</html>
