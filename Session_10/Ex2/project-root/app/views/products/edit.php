<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($product) ? 'Edit Product' : 'Add New Product' ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; }
        h1 { color: #333; margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #555; }
        input, textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px; }
        textarea { height: 100px; resize: vertical; }
        .error { color: #dc3545; font-size: 14px; margin-top: 5px; display: block; }
        .btn-submit { background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; }
        .btn-submit:hover { background: #0056b3; }
        .btn-back { background: #6c757d; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin-right: 10px; }
        .btn-back:hover { background: #5a6268; }
        .form-actions { margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1><?= isset($product) ? 'Edit Product' : 'Add New Product' ?></h1>
        
        <form method="POST" action="<?= isset($product) ? "/products/update/{$product['id']}" : '/products/store' ?>">
            <div class="form-group">
                <label for="name">Product Name *</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($product['name'] ?? '') ?>" required>
                <?php if (isset($errors['name'])): ?>
                    <span class="error"><?= htmlspecialchars($errors['name']) ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="price">Price ($) *</label>
                <input type="number" id="price" name="price" step="0.01" value="<?= htmlspecialchars($product['price'] ?? '') ?>" required>
                <?php if (isset($errors['price'])): ?>
                    <span class="error"><?= htmlspecialchars($errors['price']) ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number" id="stock" name="stock" value="<?= htmlspecialchars($product['stock'] ?? 0) ?>">
                <?php if (isset($errors['stock'])): ?>
                    <span class="error"><?= htmlspecialchars($errors['stock']) ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description"><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
            </div>
            
            <?php if (isset($errors['database'])): ?>
                <div class="error" style="margin-bottom: 15px;"><?= htmlspecialchars($errors['database']) ?></div>
            <?php endif; ?>
            
            <div class="form-actions">
                <a href="/products" class="btn-back">Cancel</a>
                <button type="submit" class="btn-submit"><?= isset($product) ? 'Update Product' : 'Create Product' ?></button>
            </div>
        </form>
    </div>
</body>
</html>