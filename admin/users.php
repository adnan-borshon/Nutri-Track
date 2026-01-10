<?php include 'header.php'; ?>

<div class="space-y-6">
    <div class="page-header">
        <div>
            <h1 class="text-3xl font-bold">User Management</h1>
            <p class="text-muted-foreground">Manage platform users and their assignments</p>
        </div>
        <button class="btn btn-primary">
            ➕ Add User
        </button>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="table-filters">
                <input type="text" class="search-input" placeholder="Search users...">
                <select class="filter-select">
                    <option value="all">All Status</option>
                    <option value="active">Active</option>
                    <option value="pending">Pending</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>
        <div class="card-content">
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Status</th>
                            <th>Goal</th>
                            <th>Nutritionist</th>
                            <th>Join Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="table-row">
                            <td>
                                <div class="user-info-cell">
                                    <div class="user-avatar">JD</div>
                                    <div class="user-details">
                                        <h4 class="user-name">John Doe</h4>
                                        <p class="user-email">john@example.com</p>
                                    </div>
                                </div>
                            </td>
                            <td><span class="status-badge active">active</span></td>
                            <td>Weight Loss</td>
                            <td>Dr. Smith</td>
                            <td>2024-01-15</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-outline btn-sm">👁️ View</button>
                                </div>
                            </td>
                        </tr>
                
                        <tr class="table-row">
                            <td>
                                <div class="user-info-cell">
                                    <div class="user-avatar">JS</div>
                                    <div class="user-details">
                                        <h4 class="user-name">Jane Smith</h4>
                                        <p class="user-email">jane@example.com</p>
                                    </div>
                                </div>
                            </td>
                            <td><span class="status-badge active">active</span></td>
                            <td>Maintain</td>
                            <td>Dr. Chen</td>
                            <td>2024-02-20</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-outline btn-sm">👁️ View</button>
                                </div>
                            </td>
                        </tr>
                
                        <tr class="table-row">
                            <td>
                                <div class="user-info-cell">
                                    <div class="user-avatar">MJ</div>
                                    <div class="user-details">
                                        <h4 class="user-name">Mike Johnson</h4>
                                        <p class="user-email">mike@example.com</p>
                                    </div>
                                </div>
                            </td>
                            <td><span class="status-badge pending">pending</span></td>
                            <td>Build Muscle</td>
                            <td class="unassigned">Unassigned</td>
                            <td>2024-03-10</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-primary btn-sm">✅ Approve</button>
                                    <button class="btn btn-outline btn-sm">👨⚕️ Assign</button>
                                </div>
                            </td>
                        </tr>
                
                        <tr class="table-row">
                            <td>
                                <div class="user-info-cell">
                                    <div class="user-avatar">ED</div>
                                    <div class="user-details">
                                        <h4 class="user-name">Emily Davis</h4>
                                        <p class="user-email">emily@example.com</p>
                                    </div>
                                </div>
                            </td>
                            <td><span class="status-badge active">active</span></td>
                            <td>Weight Loss</td>
                            <td>Dr. Smith</td>
                            <td>2024-03-15</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-outline btn-sm">👁️ View</button>
                                </div>
                            </td>
                        </tr>
                
                        <tr class="table-row">
                            <td>
                                <div class="user-info-cell">
                                    <div class="user-avatar">CW</div>
                                    <div class="user-details">
                                        <h4 class="user-name">Chris Wilson</h4>
                                        <p class="user-email">chris@example.com</p>
                                    </div>
                                </div>
                            </td>
                            <td><span class="status-badge inactive">inactive</span></td>
                            <td>Gain Weight</td>
                            <td class="unassigned">Unassigned</td>
                            <td>2024-01-05</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-outline btn-sm">👁️ View</button>
                                    <button class="btn btn-outline btn-sm">👨⚕️ Assign</button>
                                </div>
                            </td>
                        </tr>
                
                        <tr class="table-row">
                            <td>
                                <div class="user-info-cell">
                                    <div class="user-avatar">SB</div>
                                    <div class="user-details">
                                        <h4 class="user-name">Sarah Brown</h4>
                                        <p class="user-email">sarah@example.com</p>
                                    </div>
                                </div>
                            </td>
                            <td><span class="status-badge pending">pending</span></td>
                            <td>Weight Loss</td>
                            <td class="unassigned">Unassigned</td>
                            <td>2024-03-20</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn btn-primary btn-sm">✅ Approve</button>
                                    <button class="btn btn-outline btn-sm">👨⚕️ Assign</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>