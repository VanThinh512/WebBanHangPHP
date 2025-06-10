<?php include 'app/views/shares/header.php'; ?>
<div class="category-form-container">
    <h1 class="page-title">Thêm danh mục mới</h1>
    <form id="category-add-form" autocomplete="off">
        <div class="form-group">
            <label for="name">Tên danh mục <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="description">Mô tả</label>
            <textarea class="form-control" id="description" name="description" rows="4"></textarea>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Lưu danh mục</button>
            <a href="/webbanhang/Category" class="btn btn-secondary ml-2">Quay lại</a>
        </div>
    </form>
    <div id="category-add-alert"></div>
</div>
<script>
document.getElementById('category-add-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const name = document.getElementById('name').value.trim();
    const description = document.getElementById('description').value.trim();
    const alertDiv = document.getElementById('category-add-alert');
    alertDiv.innerHTML = '';
    if (!name) {
        alertDiv.innerHTML = '<div class="alert alert-danger">Tên danh mục không được để trống.</div>';
        return;
    }
    fetch('/webbanhang/api/category', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({ name, description })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alertDiv.innerHTML = '<div class="alert alert-success">' + (data.message || 'Thêm danh mục thành công!') + '</div>';
            document.getElementById('category-add-form').reset();
        } else {
            alertDiv.innerHTML = '<div class="alert alert-danger">' + (data.message || 'Thêm danh mục thất bại!') + '</div>';
        }
    });
});
</script>
<?php include 'app/views/shares/footer.php'; ?>