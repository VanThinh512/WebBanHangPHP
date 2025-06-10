<?php include 'app/views/shares/header.php'; ?>
<div class="category-list-container">
    <h1 class="page-title">Quản lý danh mục sản phẩm</h1>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="/webbanhang/Category/add" class="btn btn-success">
            <i class="fas fa-plus-circle mr-1"></i> Thêm danh mục mới
        </a>
    </div>
    <div id="category-alert"></div>
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="pl-4">ID</th>
                            <th>Tên danh mục</th>
                            <th>Mô tả</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody id="category-table-body"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
function loadCategories() {
    fetch('/webbanhang/api/category')
        .then(res => res.json())
        .then(data => {
            const tbody = document.getElementById('category-table-body');
            tbody.innerHTML = '';
            if (!data.length) {
                tbody.innerHTML = `<tr><td colspan="4" class="text-center text-muted">Chưa có danh mục nào. Hãy thêm danh mục mới!</td></tr>`;
                return;
            }
            data.forEach(category => {
                tbody.innerHTML += `
                    <tr>
                        <td class="pl-4">${category.id}</td>
                        <td>${category.name}</td>
                        <td>${category.description ? category.description.substring(0,100) : ''}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="/webbanhang/Category/edit/${category.id}" class="btn btn-sm btn-warning mr-1">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <button class="btn btn-sm btn-danger" onclick="deleteCategory(${category.id})">
                                    <i class="fas fa-trash-alt"></i> Xóa
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
            });
        });
}
function deleteCategory(id) {
    if (!confirm('Bạn có chắc chắn muốn xóa danh mục này?')) return;
    fetch(`/webbanhang/api/category/${id}`, { method: 'DELETE' })
        .then(res => res.json())
        .then(data => {
            document.getElementById('category-alert').innerHTML = `<div class="alert alert-${data.success ? 'success' : 'danger'} mt-3">${data.message || (data.success ? 'Xóa thành công!' : 'Xóa thất bại!')}</div>`;
            loadCategories();
        });
}
document.addEventListener('DOMContentLoaded', loadCategories);
</script>
<?php include 'app/views/shares/footer.php'; ?>