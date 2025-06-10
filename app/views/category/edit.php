<?php include 'app/views/shares/header.php'; ?>
<div class="category-form-container">
    <h1 class="page-title">Chỉnh sửa danh mục</h1>
    <form id="category-edit-form" autocomplete="off">
        <input type="hidden" id="category-id" name="id">
        <div class="form-group">
            <label for="name">Tên danh mục <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="description">Mô tả</label>
            <textarea class="form-control" id="description" name="description" rows="4"></textarea>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Cập nhật danh mục</button>
            <a href="/webbanhang/Category" class="btn btn-secondary ml-2">Quay lại</a>
        </div>
    </form>
    <div id="category-edit-alert"></div>
</div>
<script>
function getCategoryIdFromUrl() {
    const match = window.location.pathname.match(/\/edit\/(\d+)/);
    return match ? match[1] : null;
}
function fillCategoryForm(category) {
    document.getElementById('category-id').value = category.id;
    document.getElementById('name').value = category.name;
    document.getElementById('description').value = category.description || '';
}
document.addEventListener('DOMContentLoaded', function() {
    const id = getCategoryIdFromUrl();
    if (!id) return;
    fetch(`/webbanhang/api/category/${id}`)
        .then(res => res.json())
        .then(data => {
            if (data && data.id) {
                fillCategoryForm(data);
            } else {
                document.getElementById('category-edit-alert').innerHTML = '<div class="alert alert-danger">Không tìm thấy danh mục!</div>';
            }
        });
});
document.getElementById('category-edit-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const id = document.getElementById('category-id').value;
    const name = document.getElementById('name').value.trim();
    const description = document.getElementById('description').value.trim();
    const alertDiv = document.getElementById('category-edit-alert');
    alertDiv.innerHTML = '';
    if (!name) {
        alertDiv.innerHTML = '<div class="alert alert-danger">Tên danh mục không được để trống.</div>';
        return;
    }
    fetch(`/webbanhang/api/category/${id}`, {
        method: 'PUT',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({ name, description })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alertDiv.innerHTML = '<div class="alert alert-success">' + (data.message || 'Cập nhật thành công!') + '</div>';
        } else {
            alertDiv.innerHTML = '<div class="alert alert-danger">' + (data.message || 'Cập nhật thất bại!') + '</div>';
        }
    });
});
</script>
<?php include 'app/views/shares/footer.php'; ?>