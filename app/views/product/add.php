<?php include 'app/views/shares/header.php'; ?>
    <h1>Thêm sản phẩm mới</h1>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form method="POST" action="/webbanhang/Product/save" enctype="multipart/form-data" onsubmit="return validateForm();">
        <div class="form-group">
            <label for="name">Tên sản phẩm:</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Mô tả:</label>
            <textarea id="description" name="description" class="form-control"required></textarea>
        </div>
        <div class="form-group">
            <label for="price">Giá:</label>
            <input type="number" id="price" name="price" class="form-control" step="0.01"required>
        </div>
        <div class="form-group">
            <label for="category_id">Danh mục:</label>
            <select id="category_id" name="category_id" class="form-control" required>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category->id; ?>"><?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="image">Hình ảnh:</label>
            <input type="file" id="image" name="image" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
    </form>
    <a href="/webbanhang/Product" class="btn btn-secondary mt-2">Quay lại danh sách sản phẩm</a>
<?php include 'app/views/shares/footer.php'; ?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        fetch('/webbanhang/api/category')
        .then(response => response.json())
        .then(data => {
            const categorySelect = document.getElementById('category_id');
            data.forEach(category => {
                const option = document.createElement('option');
                option.value = category.id;
                option.textContent = category.name;
                categorySelect.appendChild(option);
            });
        });
        document.getElementById('add-product-form').addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);
            const jsonData = {};
            formData.forEach((value, key) => {
                jsonData[key] = value;
            });
            fetch('/webbanhang/api/product', {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json'
                },
                body: JSON.stringify(jsonData)
            })
            .then(response => response.json())
            .then(text => {
                console.log('Raw response:', text); // Log the raw response text
                try {
                    const data = text;
                    if (data.message === 'Product created successfully') {
                    location.href = '/webbanhang/Product';
                    } else {
                    alert('Thêm sản phẩm thất bại');
                    }
                } catch (error) {
                    console.error('Error parsing JSON:', error);
                    alert('Lỗi: Không thể phân tích JSON từ phản hồi của máy chủ.');
                }
            });
        });
    });
</script>
