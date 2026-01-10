<?php include 'header.php'; ?>

<div class="section-header">
    <div class="container">
        <div>
            <h1 class="section-title">Food Database</h1>
            <p class="section-description">Manage food items and nutritional information</p>
        </div>
        <button class="btn btn-primary">
            ➕ Add Food Item
        </button>
    </div>
</div>

<div class="card">
    <div class="card-content">
        <div class="form-row">
            <input type="text" class="form-input" placeholder="Search foods...">
            <select class="form-input">
                <option value="all">All Categories</option>
                <option value="fruits">Fruits</option>
                <option value="vegetables">Vegetables</option>
                <option value="grains">Grains</option>
                <option value="proteins">Proteins</option>
                <option value="dairy">Dairy</option>
            </select>
        </div>
        
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Food Item</th>
                    <th>Category</th>
                    <th>Calories (per 100g)</th>
                    <th>Protein</th>
                    <th>Carbs</th>
                    <th>Fat</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="admin-user-info">
                            <div class="card-icon">🍎</div>
                            <div class="admin-user-details">
                                <h4>Apple</h4>
                                <p>Fresh red apple</p>
                            </div>
                        </div>
                    </td>
                    <td><span class="status-badge completed">Fruits</span></td>
                    <td>52</td>
                    <td>0.3g</td>
                    <td>14g</td>
                    <td>0.2g</td>
                    <td>
                        <div class="admin-action-buttons">
                            <button class="btn btn-outline">✏️ Edit</button>
                            <button class="btn btn-secondary">🗑️ Delete</button>
                        </div>
                    </td>
                </tr>
                
                <tr>
                    <td>
                        <div class="admin-user-info">
                            <div class="card-icon">🥕</div>
                            <div class="admin-user-details">
                                <h4>Carrot</h4>
                                <p>Fresh orange carrot</p>
                            </div>
                        </div>
                    </td>
                    <td><span class="status-badge completed">Vegetables</span></td>
                    <td>41</td>
                    <td>0.9g</td>
                    <td>10g</td>
                    <td>0.2g</td>
                    <td>
                        <div class="admin-action-buttons">
                            <button class="btn btn-outline">✏️ Edit</button>
                            <button class="btn btn-secondary">🗑️ Delete</button>
                        </div>
                    </td>
                </tr>
                
                <tr>
                    <td>
                        <div class="admin-user-info">
                            <div class="card-icon">🍗</div>
                            <div class="admin-user-details">
                                <h4>Chicken Breast</h4>
                                <p>Skinless, boneless</p>
                            </div>
                        </div>
                    </td>
                    <td><span class="status-badge completed">Proteins</span></td>
                    <td>165</td>
                    <td>31g</td>
                    <td>0g</td>
                    <td>3.6g</td>
                    <td>
                        <div class="admin-action-buttons">
                            <button class="btn btn-outline">✏️ Edit</button>
                            <button class="btn btn-secondary">🗑️ Delete</button>
                        </div>
                    </td>
                </tr>
                
                <tr>
                    <td>
                        <div class="admin-user-info">
                            <div class="card-icon">🍚</div>
                            <div class="admin-user-details">
                                <h4>Brown Rice</h4>
                                <p>Cooked brown rice</p>
                            </div>
                        </div>
                    </td>
                    <td><span class="status-badge completed">Grains</span></td>
                    <td>111</td>
                    <td>2.6g</td>
                    <td>23g</td>
                    <td>0.9g</td>
                    <td>
                        <div class="admin-action-buttons">
                            <button class="btn btn-outline">✏️ Edit</button>
                            <button class="btn btn-secondary">🗑️ Delete</button>
                        </div>
                    </td>
                </tr>
                
                <tr>
                    <td>
                        <div class="admin-user-info">
                            <div class="card-icon">🥛</div>
                            <div class="admin-user-details">
                                <h4>Milk</h4>
                                <p>Whole milk</p>
                            </div>
                        </div>
                    </td>
                    <td><span class="status-badge completed">Dairy</span></td>
                    <td>61</td>
                    <td>3.2g</td>
                    <td>4.8g</td>
                    <td>3.3g</td>
                    <td>
                        <div class="admin-action-buttons">
                            <button class="btn btn-outline">✏️ Edit</button>
                            <button class="btn btn-secondary">🗑️ Delete</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php include 'footer.php'; ?>