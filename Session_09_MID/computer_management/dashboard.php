<?php
// dashboard.php
require_once 'config/database.php';

// Handle search
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$sql = "SELECT * FROM computers";
if (!empty($search)) {
    $sql .= " WHERE computer_name LIKE :search";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['search' => "%$search%"]);
} else {
    $stmt = $pdo->query($sql);
}
$computers = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Computer Lab Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .status-badge { padding: 5px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 500; }
        .status-available { background: #d4edda; color: #155724; }
        .status-repair { background: #f8d7da; color: #721c24; }
        .table th { background-color: #2c3e50; color: white; }
        .btn-sm { margin: 2px; }
    </style>
</head>
<body>
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3 class="mb-0"><i class="fas fa-desktop"></i> University Computer Lab Management</h3>
            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="fas fa-plus"></i> Add New Computer
            </button>
        </div>
        <div class="card-body">
            <!-- Search Bar -->
            <form method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search by computer name..." value="<?= htmlspecialchars($search) ?>">
                    <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i> Search</button>
                    <?php if($search): ?>
                        <a href="dashboard.php" class="btn btn-outline-danger">Clear</a>
                    <?php endif; ?>
                </div>
            </form>

            <!-- Computers Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th><th>Computer Name</th><th>Model</th><th>OS</th>
                            <th>CPU</th><th>RAM (GB)</th><th>Status</th><th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($computers) > 0): ?>
                            <?php foreach($computers as $computer): ?>
                                <tr>
                                    <td><?= $computer['id'] ?></td>
                                    <td><?= htmlspecialchars($computer['computer_name']) ?></td>
                                    <td><?= htmlspecialchars($computer['model']) ?></td>
                                    <td><?= htmlspecialchars($computer['operating_system']) ?></td>
                                    <td><?= htmlspecialchars($computer['processor']) ?></td>
                                    <td><?= $computer['memory'] ?></td>
                                    <td>
                                        <span class="status-badge <?= $computer['available'] ? 'status-available' : 'status-repair' ?>">
                                            <?= $computer['available'] ? 'Available' : 'Under Repair' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning edit-btn" 
                                            data-id="<?= $computer['id'] ?>"
                                            data-name="<?= htmlspecialchars($computer['computer_name']) ?>"
                                            data-model="<?= htmlspecialchars($computer['model']) ?>"
                                            data-os="<?= htmlspecialchars($computer['operating_system']) ?>"
                                            data-processor="<?= htmlspecialchars($computer['processor']) ?>"
                                            data-memory="<?= $computer['memory'] ?>"
                                            data-available="<?= $computer['available'] ?>"
                                            data-bs-toggle="modal" data-bs-target="#editModal">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button class="btn btn-sm btn-danger delete-btn" data-id="<?= $computer['id'] ?>" data-name="<?= htmlspecialchars($computer['computer_name']) ?>" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="8" class="text-center">No computers found</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Computer Modal -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="actions/create.php" method="POST">
                <div class="modal-header bg-success text-white"><h5 class="modal-title">Add New Computer</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="mb-3"><label>Computer Name *</label><input type="text" name="computer_name" class="form-control" required></div>
                    <div class="mb-3"><label>Model *</label><input type="text" name="model" class="form-control" required></div>
                    <div class="mb-3"><label>Operating System</label><input type="text" name="operating_system" class="form-control"></div>
                    <div class="mb-3"><label>Processor</label><input type="text" name="processor" class="form-control"></div>
                    <div class="mb-3"><label>Memory (GB)</label><input type="number" name="memory" class="form-control"></div>
                    <div class="mb-3"><label>Status</label><select name="available" class="form-control"><option value="1">Available</option><option value="0">Under Repair</option></select></div>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-success">Save Computer</button></div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal (populated via JavaScript) -->
<div class="modal fade" id="editModal" tabindex="-1"><div class="modal-dialog"><div class="modal-content"><form action="actions/update.php" method="POST"><div class="modal-header bg-warning"><h5 class="modal-title">Edit Computer</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><input type="hidden" name="id" id="edit_id"><div class="mb-3"><label>Computer Name *</label><input type="text" name="computer_name" id="edit_name" class="form-control" required></div><div class="mb-3"><label>Model *</label><input type="text" name="model" id="edit_model" class="form-control" required></div><div class="mb-3"><label>Operating System</label><input type="text" name="operating_system" id="edit_os" class="form-control"></div><div class="mb-3"><label>Processor</label><input type="text" name="processor" id="edit_processor" class="form-control"></div><div class="mb-3"><label>Memory (GB)</label><input type="number" name="memory" id="edit_memory" class="form-control"></div><div class="mb-3"><label>Status</label><select name="available" id="edit_available" class="form-control"><option value="1">Available</option><option value="0">Under Repair</option></select></div></div><div class="modal-footer"><button type="submit" class="btn btn-warning">Update Computer</button></div></form></div></div></div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1"><div class="modal-dialog"><div class="modal-content"><form action="actions/delete.php" method="POST"><div class="modal-header bg-danger text-white"><h5 class="modal-title">Confirm Delete</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><input type="hidden" name="id" id="delete_id"><p>Are you sure you want to delete <strong id="delete_name"></strong>?</p></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-danger">Delete</button></div></form></div></div></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Populate edit modal
    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('edit_id').value = this.dataset.id;
            document.getElementById('edit_name').value = this.dataset.name;
            document.getElementById('edit_model').value = this.dataset.model;
            document.getElementById('edit_os').value = this.dataset.os;
            document.getElementById('edit_processor').value = this.dataset.processor;
            document.getElementById('edit_memory').value = this.dataset.memory;
            document.getElementById('edit_available').value = this.dataset.available;
        });
    });
    // Populate delete modal
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('delete_id').value = this.dataset.id;
            document.getElementById('delete_name').innerText = this.dataset.name;
        });
    });
</script>
</body>
</html>