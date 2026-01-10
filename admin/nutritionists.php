<?php include 'header.php'; ?>

<div class="section-header">
    <div class="container">
        <div>
            <h1 class="section-title">Nutritionist Management</h1>
            <p class="section-description">Manage nutritionists and their profiles</p>
        </div>
        <button class="btn btn-primary">
            ➕ Add Nutritionist
        </button>
    </div>
</div>

<div class="card">
    <div class="card-content">
        <input type="text" class="form-input" placeholder="Search nutritionists...">
        
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Nutritionist</th>
                    <th>Specialty</th>
                    <th>Status</th>
                    <th>Clients</th>
                    <th>Rating</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="admin-user-info">
                            <div class="team-avatar">SS</div>
                            <div class="admin-user-details">
                                <h4>Dr. Sarah Smith</h4>
                                <p>sarah@nutritrack.com</p>
                            </div>
                        </div>
                    </td>
                    <td><span class="status-badge completed">Weight Management</span></td>
                    <td><span class="status-badge confirmed">active</span></td>
                    <td>👥 24</td>
                    <td>4.9/5</td>
                    <td>
                        <button class="btn btn-outline">👁️ View</button>
                    </td>
                </tr>
                
                <tr>
                    <td>
                        <div class="admin-user-info">
                            <div class="team-avatar">MC</div>
                            <div class="admin-user-details">
                                <h4>Dr. Michael Chen</h4>
                                <p>michael@nutritrack.com</p>
                            </div>
                        </div>
                    </td>
                    <td><span class="status-badge completed">Sports Nutrition</span></td>
                    <td><span class="status-badge confirmed">active</span></td>
                    <td>👥 18</td>
                    <td>4.8/5</td>
                    <td>
                        <button class="btn btn-outline">👁️ View</button>
                    </td>
                </tr>
                
                <tr>
                    <td>
                        <div class="admin-user-info">
                            <div class="team-avatar">EW</div>
                            <div class="admin-user-details">
                                <h4>Dr. Emily Wilson</h4>
                                <p>emily@nutritrack.com</p>
                            </div>
                        </div>
                    </td>
                    <td><span class="status-badge completed">Clinical Nutrition</span></td>
                    <td><span class="status-badge confirmed">active</span></td>
                    <td>👥 31</td>
                    <td>4.95/5</td>
                    <td>
                        <button class="btn btn-outline">👁️ View</button>
                    </td>
                </tr>
                
                <tr>
                    <td>
                        <div class="admin-user-info">
                            <div class="team-avatar">JM</div>
                            <div class="admin-user-details">
                                <h4>Dr. James Martinez</h4>
                                <p>james@nutritrack.com</p>
                            </div>
                        </div>
                    </td>
                    <td><span class="status-badge completed">Pediatric Nutrition</span></td>
                    <td><span class="status-badge pending">pending</span></td>
                    <td>👥 0</td>
                    <td>-</td>
                    <td>
                        <button class="btn btn-outline">👁️ View</button>
                    </td>
                </tr>
                
                <tr>
                    <td>
                        <div class="admin-user-info">
                            <div class="team-avatar">LT</div>
                            <div class="admin-user-details">
                                <h4>Dr. Lisa Thompson</h4>
                                <p>lisa@nutritrack.com</p>
                            </div>
                        </div>
                    </td>
                    <td><span class="status-badge completed">Eating Disorders</span></td>
                    <td><span class="status-badge confirmed">active</span></td>
                    <td>👥 15</td>
                    <td>4.7/5</td>
                    <td>
                        <button class="btn btn-outline">👁️ View</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php include 'footer.php'; ?>