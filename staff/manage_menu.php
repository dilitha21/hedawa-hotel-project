<?php
require_once '../config/database.php';
require_once '../includes/staff_check.php';
require_once '../includes/header.php';

$menu_items = $pdo->query("SELECT * FROM food ORDER BY category ASC, name ASC")->fetchAll();
?>
<div class="staff-container" style="display: flex; min-height: calc(100vh - 80px - 200px); background: #f8fafc;">
    
    <!-- Sidebar -->
    <aside style="width: 250px; background: var(--white); box-shadow: var(--shadow-sm); padding: 2rem 0;">
        <h3 style="text-align: center; color: var(--primary-dark); margin-bottom: 2rem; border-bottom: 1px solid #edf2f7; padding-bottom: 1rem;">Staff Control</h3>
        <ul style="list-style: none;">
            <li><a href="dashboard.php" style="display: block; padding: 1rem 2rem; color: var(--text-main); font-weight: 500;"><i class="fa-solid fa-chart-pie"></i> Dashboard</a></li>
            <li><a href="view_orders.php" style="display: block; padding: 1rem 2rem; color: var(--text-main); font-weight: 500;"><i class="fa-solid fa-receipt"></i> View Orders</a></li>
            <li><a href="manage_menu.php" style="display: block; padding: 1rem 2rem; color: var(--primary); font-weight: 500; background: var(--bg-color); border-right: 4px solid var(--primary);"><i class="fa-solid fa-utensils"></i> Manage Menu</a></li>
            <li><a href="view_bookings.php" style="display: block; padding: 1rem 2rem; color: var(--text-main); font-weight: 500;"><i class="fa-solid fa-book-open"></i> View Bookings</a></li>
            <li><a href="register_staff.php" style="display: block; padding: 1rem 2rem; color: var(--text-main); font-weight: 500;"><i class="fa-solid fa-user-plus"></i> Register Staff</a></li>
        </ul>
    </aside>

    <!-- Content -->
    <div style="flex: 1; padding: 3rem; overflow-x: auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h2 style="margin: 0;"><i class="fa-solid fa-utensils" style="color:var(--primary);"></i> Manage Menu Structure</h2>
            <button class="btn" onclick="document.getElementById('addModal').style.display='flex'"><i class="fa-solid fa-plus"></i> Add New Food</button>
        </div>
        
        <?php if(isset($_GET['msg'])): ?>
            <div style="background: var(--bg-color); border-left: 4px solid var(--primary); padding: 1rem; margin-bottom: 2rem;">
                <p style="color: var(--primary-dark); font-weight: 500; margin:0;">
                    <?php 
                        if($_GET['msg'] === 'added') echo "New food item successfully added.";
                        elseif($_GET['msg'] === 'updated') echo "Food item successfully updated.";
                        elseif($_GET['msg'] === 'disabled') echo "Food item status disabled.";
                    ?>
                </p>
            </div>
        <?php endif; ?>
        <?php if(isset($_GET['err'])): ?>
            <div style="background: #fff5f5; border-left: 4px solid #e53e3e; padding: 1rem; margin-bottom: 2rem;">
                <p style="color: #c53030; font-weight: 500; margin:0;">
                    <?php 
                        if($_GET['err'] === 'invalid_data') echo "Invalid data provided. Please check price and name.";
                        elseif($_GET['err'] === 'db_error') echo "Database error occurred.";
                    ?>
                </p>
            </div>
        <?php endif; ?>

        <table style="width: 100%; border-collapse: collapse; background: var(--white); box-shadow: var(--shadow-sm); border-radius: var(--radius);">
            <tr style="background: var(--primary); color: var(--white); text-align: left;">
                <th style="padding: 1rem;">ID</th>
                <th style="padding: 1rem;">Name</th>
                <th style="padding: 1rem;">Category</th>
                <th style="padding: 1rem;">Price</th>
                <th style="padding: 1rem; text-align: center;">Status</th>
                <th style="padding: 1rem; text-align: center;">Actions</th>
            </tr>
            <?php foreach($menu_items as $item): ?>
            <tr style="border-bottom: 1px solid #edf2f7; opacity: <?= $item['is_available'] ? '1' : '0.6' ?>;">
                <td style="padding: 1rem; font-weight: 500;">#<?= $item['id'] ?></td>
                <td style="padding: 1rem;">
                    <strong><?= htmlspecialchars($item['name']) ?></strong><br>
                    <small style="color: var(--text-muted);"><?= htmlspecialchars($item['description']) ?></small>
                </td>
                <td style="padding: 1rem;"><?= htmlspecialchars($item['category']) ?></td>
                <td style="padding: 1rem; font-weight: 600;">Rs. <?= number_format($item['price'], 2) ?></td>
                <td style="padding: 1rem; text-align: center;">
                    <?php if($item['is_available']): ?>
                        <span style="background: var(--bg-color); color: var(--primary-dark); padding: 0.2rem 0.6rem; border-radius: 4px; font-size: 0.9rem;">Available</span>
                    <?php else: ?>
                        <span style="background: #edf2f7; color: var(--text-muted); padding: 0.2rem 0.6rem; border-radius: 4px; font-size: 0.9rem;">Disabled</span>
                    <?php endif; ?>
                </td>
                <td style="padding: 1rem; text-align: center;">
                    <div style="display: flex; gap: 0.5rem; justify-content: center;">
                        <button class="btn btn-outline" style="padding: 0.3rem 0.6rem; font-size: 0.85rem;" onclick="openEditModal(<?= htmlspecialchars(json_encode($item)) ?>)"><i class="fa-solid fa-pen"></i> Edit</button>
                        <form action="../actions/menu_process.php" method="POST" style="margin:0;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= $item['id'] ?>">
                            <button type="submit" class="btn btn-outline" style="padding: 0.3rem 0.6rem; color: #e53e3e; border-color: #e53e3e; font-size: 0.85rem;" onclick="return confirm('Disable <?= htmlspecialchars($item['name']) ?>?');" title="Disable"><i class="fa-solid fa-ban"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>

<!-- Add Modal -->
<div id="addModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 1000;">
    <div style="background: var(--white); padding: 2rem; border-radius: var(--radius); width: 100%; max-width: 500px; max-height: 90vh; overflow-y: auto;">
        <h3 style="margin-bottom: 1.5rem; color: var(--primary-dark);">Add New Food</h3>
        <form action="../actions/menu_process.php" method="POST" style="display: flex; flex-direction: column; gap: 1rem;">
            <input type="hidden" name="action" value="add">
            
            <div>
                <label style="display:block; margin-bottom: 0.3rem; font-weight: 500;">Food Name</label>
                <input type="text" name="name" required style="width: 100%; padding: 0.7rem; border: 1px solid #ddd; border-radius: 4px;">
            </div>
            
            <div>
                <label style="display:block; margin-bottom: 0.3rem; font-weight: 500;">Category</label>
                <select name="category" required style="width: 100%; padding: 0.7rem; border: 1px solid #ddd; border-radius: 4px; background: white;">
                    <option value="Starters">Starters</option>
                    <option value="Mains">Mains</option>
                    <option value="Desserts">Desserts</option>
                    <option value="Beverages">Beverages</option>
                </select>
            </div>
            
            <div>
                <label style="display:block; margin-bottom: 0.3rem; font-weight: 500;">Price (Rs.)</label>
                <input type="number" step="0.01" min="0" name="price" required style="width: 100%; padding: 0.7rem; border: 1px solid #ddd; border-radius: 4px;">
            </div>
            
            <div>
                <label style="display:block; margin-bottom: 0.3rem; font-weight: 500;">Description</label>
                <textarea name="description" rows="3" style="width: 100%; padding: 0.7rem; border: 1px solid #ddd; border-radius: 4px; resize: vertical;"></textarea>
            </div>
            
            <div style="display: flex; align-items: center; gap: 0.5rem; margin-top: 0.5rem;">
                <input type="checkbox" name="is_available" id="add_avail" value="1" checked>
                <label for="add_avail" style="font-weight: 500;">Item is immediately available</label>
            </div>
            
            <div style="display: flex; gap: 1rem; margin-top: 1rem;">
                <button type="submit" class="btn" style="flex:1;">Save Item</button>
                <button type="button" class="btn btn-outline" style="flex:1;" onclick="document.getElementById('addModal').style.display='none'">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 1000;">
    <div style="background: var(--white); padding: 2rem; border-radius: var(--radius); width: 100%; max-width: 500px; max-height: 90vh; overflow-y: auto;">
        <h3 style="margin-bottom: 1.5rem; color: var(--primary-dark);">Edit Food Item</h3>
        <form action="../actions/menu_process.php" method="POST" style="display: flex; flex-direction: column; gap: 1rem;">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" id="edit_id">
            
            <div>
                <label style="display:block; margin-bottom: 0.3rem; font-weight: 500;">Food Name</label>
                <input type="text" name="name" id="edit_name" required style="width: 100%; padding: 0.7rem; border: 1px solid #ddd; border-radius: 4px;">
            </div>
            
            <div>
                <label style="display:block; margin-bottom: 0.3rem; font-weight: 500;">Category</label>
                <select name="category" id="edit_category" required style="width: 100%; padding: 0.7rem; border: 1px solid #ddd; border-radius: 4px; background: white;">
                    <option value="Starters">Starters</option>
                    <option value="Mains">Mains</option>
                    <option value="Desserts">Desserts</option>
                    <option value="Beverages">Beverages</option>
                </select>
            </div>
            
            <div>
                <label style="display:block; margin-bottom: 0.3rem; font-weight: 500;">Price (Rs.)</label>
                <input type="number" step="0.01" min="0" name="price" id="edit_price" required style="width: 100%; padding: 0.7rem; border: 1px solid #ddd; border-radius: 4px;">
            </div>
            
            <div>
                <label style="display:block; margin-bottom: 0.3rem; font-weight: 500;">Description</label>
                <textarea name="description" id="edit_description" rows="3" style="width: 100%; padding: 0.7rem; border: 1px solid #ddd; border-radius: 4px; resize: vertical;"></textarea>
            </div>
            
            <div style="display: flex; align-items: center; gap: 0.5rem; margin-top: 0.5rem;">
                <input type="checkbox" name="is_available" id="edit_avail" value="1">
                <label for="edit_avail" style="font-weight: 500;">Item is available</label>
            </div>
            
            <div style="display: flex; gap: 1rem; margin-top: 1rem;">
                <button type="submit" class="btn" style="flex:1;">Update Item</button>
                <button type="button" class="btn btn-outline" style="flex:1;" onclick="document.getElementById('editModal').style.display='none'">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModal(item) {
    document.getElementById('edit_id').value = item.id;
    document.getElementById('edit_name').value = item.name;
    document.getElementById('edit_category').value = item.category;
    document.getElementById('edit_price').value = item.price;
    document.getElementById('edit_description').value = item.description;
    document.getElementById('edit_avail').checked = item.is_available == 1;
    document.getElementById('editModal').style.display = 'flex';
}
</script>

<?php require_once '../includes/footer.php'; ?>
