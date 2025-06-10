<?php include 'app/views/shares/header.php'; ?>
<h1>Sửa sản phẩm</h1>
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
<form method="POST" action="/webbanhang/Product/update" enctype="multipart/form-data" onsubmit="return validateForm();">
    <input type="hidden" name="id" value="<?php echo $product->id; ?>">
    <div class="form-group">
        <label for="name">Tên sản phẩm:</label>
        <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>" required>
    </div>
    <div class="form-group">
        <label for="description">Mô tả:</label>
        <textarea id="description" name="description" class="form-control" required><?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8');
        ?></textarea>
    </div>
    <div class="form-group">
        <label for="price">Giá:</label>
        <input type="number" id="price" name="price" class="form-control" step="0.01" value="<?php echo htmlspecialchars($product->price, ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>
    <div class="form-group">
        <label for="category_id">Danh mục:</label>
        <select id="category_id" name="category_id" class="form-control" required>
            <?php foreach ($categories as $category): ?>
            <option value="<?php echo $category->id; ?>" <?php echo $category->id == $product->category_id ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8');?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="image">Hình ảnh:</label>
        <input type="file" id="image" name="image" class="form-control">
        <input type="hidden" name="existing_image" value="<?php echo $product->image;?>">
        <?php if ($product->image): ?>
            <img src="/webbanhang/<?php echo $product->image; ?>" alt="Product Image" style="max-width: 100px;">
        <?php endif; ?>
    </div>
    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
</form>
<a href="/webbanhang/Product" class="btn btn-secondary mt-2">Quay lại danh sách sản phẩm</a>
<?php include 'app/views/shares/footer.php'; ?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // const urlParams = new URLSearchParams(window.location.search);
        const productId = <?= $editId ?>;
        fetch(`/webbanhang/api/product/${productId}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('id').value = data.id;
            document.getElementById('name').value = data.name;
            document.getElementById('description').value = data.description;
            document.getElementById('price').value = data.price;
            document.getElementById('category_id').value = data.category_id;
        });
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
        document.getElementById('edit-product-form').addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);
            const jsonData = {};
            formData.forEach((value, key) => {
                jsonData[key] = value;
            });
            fetch(`/webbanhang/api/product/${jsonData.id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(jsonData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.message === 'Product updated successfully') {
                location.href = '/webbanhang/Product';
                } else {
                    alert('Cập nhật sản phẩm thất bại');
                }
            });
        });
    });
</script>