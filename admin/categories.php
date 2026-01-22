<?php
require_once '../includes/session.php';
checkAuth('admin');
include 'header.php';
?>

<div class="section-header">
    <div class="container">
        <div>
            <h1 class="section-title">Food Categories</h1>
            <p class="section-description">Manage food categories and classifications</p>
        </div>
        <button class="btn btn-primary" onclick="showAddCategoryModal()">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-plus" style="vertical-align:middle;margin-right:4px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg> Add Category
        </button>
    </div>
</div>

<div class="grid grid-4">
    <div class="card">
        <div class="card-content">
            <div class="card-icon">
<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-apple" style="color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 14m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M12 11v-6a2 2 0 0 1 2 -2h2v1a2 2 0 0 1 -2 2h-2" /><path d="M10 10.5c-.667 -.667 -2.5 0 -2.5 2.5s1.833 3.167 2.5 2.5" /><path d="M16 10.5c.667 -.667 2.5 0 2.5 2.5s-1.833 3.167 -2.5 2.5" /></svg>
            </div>
            <h3 class="card-title">Fruits</h3>
            <p class="card-description">Fresh and dried fruits</p>
            <div class="faq-answer">142 items</div>
            <div class="admin-action-buttons">
                <button class="btn btn-outline">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit" style="vertical-align:middle;margin-right:4px;color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg> Edit
                </button>
                <button class="btn btn-secondary">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash" style="vertical-align:middle;margin-right:4px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg> Delete
                </button>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-content">
            <div class="card-icon">
<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-carrot" style="color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 21s9.834 -3.489 12.684 -6.34a4.487 4.487 0 0 0 0 -6.344a4.483 4.483 0 0 0 -6.342 0c-2.86 2.861 -6.347 12.689 -6.342 12.684z" /><path d="M9 13l-1.5 -1.5" /><path d="M16 14l-2 -2" /><path d="M22 8s-1.14 -2 -3 -2c-1.406 0 -3 2 -3 2s1.14 2 3 2s3 -2 3 -2z" /><path d="M16 2s-2 1.14 -2 3s2 3 2 3s2 -1.577 2 -3c0 -1.86 -2 -3 -2 -3z" /></svg>
            </div>
            <h3 class="card-title">Vegetables</h3>
            <p class="card-description">Fresh vegetables and greens</p>
            <div class="faq-answer">198 items</div>
            <div class="admin-action-buttons">
                <button class="btn btn-outline">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit" style="vertical-align:middle;margin-right:4px;color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg> Edit
                </button>
                <button class="btn btn-secondary">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash" style="vertical-align:middle;margin-right:4px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg> Delete
                </button>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-content">
            <div class="card-icon">
<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-bread" style="color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 4a3 3 0 0 1 2 5.235v8.765a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-8.764a3 3 0 0 1 1.824 -5.231l.176 -.005h12z" /><path d="M8 15l8 0" /></svg>
            </div>
            <h3 class="card-title">Grains</h3>
            <p class="card-description">Cereals, bread, and pasta</p>
            <div class="faq-answer">87 items</div>
            <div class="admin-action-buttons">
                <button class="btn btn-outline">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit" style="vertical-align:middle;margin-right:4px;color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg> Edit
                </button>
                <button class="btn btn-secondary">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash" style="vertical-align:middle;margin-right:4px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg> Delete
                </button>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-content">
            <div class="card-icon">
<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-meat" style="color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M13.62 8.382l1.966 -1.967a2 2 0 1 1 2.828 2.828l-1.966 1.967" /><path d="M10.5 11.5l-3.5 -3.5a2 2 0 1 1 2.828 -2.828l3.5 3.5" /><path d="M8 16l2 2" /><path d="M10.5 16.5l4.5 -4.5" /><path d="M12 18l2 2" /><path d="M16 12l-4.5 4.5" /><path d="M18 10l2 2" /><path d="M20 8l-8 8" /></svg>
            </div>
            <h3 class="card-title">Proteins</h3>
            <p class="card-description">Meat, fish, and legumes</p>
            <div class="faq-answer">156 items</div>
            <div class="admin-action-buttons">
                <button class="btn btn-outline">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit" style="vertical-align:middle;margin-right:4px;color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg> Edit
                </button>
                <button class="btn btn-secondary">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash" style="vertical-align:middle;margin-right:4px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg> Delete
                </button>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-content">
            <div class="card-icon">
<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-glass" style="color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 21l8 0" /><path d="M12 15l0 6" /><path d="M17 3l1 7c0 3.012 -2.686 5 -6 5s-6 -1.988 -6 -5l1 -7h10z" /><path d="M6 3l12 0" /></svg>
            </div>
            <h3 class="card-title">Dairy</h3>
            <p class="card-description">Milk, cheese, and yogurt</p>
            <div class="faq-answer">73 items</div>
            <div class="admin-action-buttons">
                <button class="btn btn-outline">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit" style="vertical-align:middle;margin-right:4px;color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg> Edit
                </button>
                <button class="btn btn-secondary">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash" style="vertical-align:middle;margin-right:4px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg> Delete
                </button>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-content">
            <div class="card-icon">
<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-nut" style="color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19 6.84a2.007 2.007 0 0 1 1 1.754v6.555c0 .728 -.394 1.4 -1.03 1.753l-6 3.844a2 2 0 0 1 -1.94 0l-6 -3.844a2.007 2.007 0 0 1 -1.03 -1.752v-6.557c0 -.728 .394 -1.399 1.03 -1.753l6 -3.582a2.049 2.049 0 0 1 1.94 0l6 3.582z" /><path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /></svg>
            </div>
            <h3 class="card-title">Nuts & Seeds</h3>
            <p class="card-description">Nuts, seeds, and oils</p>
            <div class="faq-answer">45 items</div>
            <div class="admin-action-buttons">
                <button class="btn btn-outline">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit" style="vertical-align:middle;margin-right:4px;color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg> Edit
                </button>
                <button class="btn btn-secondary">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash" style="vertical-align:middle;margin-right:4px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg> Delete
                </button>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-content">
            <div class="card-icon">
<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-cake" style="color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 20h18v-8a3 3 0 0 0 -3 -3h-12a3 3 0 0 0 -3 3v8z" /><path d="M3 14.803c.312 .135 .654 .204 1 .197a2.4 2.4 0 0 0 2 -1a2.4 2.4 0 0 1 4 0a2.4 2.4 0 0 0 4 0a2.4 2.4 0 0 1 4 0a2.4 2.4 0 0 0 2 1c.35 .007 .692 -.062 1 -.197" /><path d="M12 4l1.465 1.638a2 2 0 1 1 -3.015 .099l1.55 -1.737z" /></svg>
            </div>
            <h3 class="card-title">Desserts</h3>
            <p class="card-description">Sweets and treats</p>
            <div class="faq-answer">92 items</div>
            <div class="admin-action-buttons">
                <button class="btn btn-outline">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit" style="vertical-align:middle;margin-right:4px;color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg> Edit
                </button>
                <button class="btn btn-secondary">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash" style="vertical-align:middle;margin-right:4px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg> Delete
                </button>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-content">
            <div class="card-icon">
<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-cup" style="color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 11h14v-3h-14v3z" /><path d="M17.5 11l-1.5 10h-8l-1.5 -10" /><path d="M6 8v-1a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v1" /><path d="M15 5v-2" /></svg>
            </div>
            <h3 class="card-title">Beverages</h3>
            <p class="card-description">Drinks and smoothies</p>
            <div class="faq-answer">64 items</div>
            <div class="admin-action-buttons">
                <button class="btn btn-outline" onclick="editCategory(this)">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit" style="vertical-align:middle;margin-right:4px;color:#278b63;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg> Edit
                </button>
                <button class="btn btn-secondary" onclick="deleteCategory(this)">
<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash" style="vertical-align:middle;margin-right:4px;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg> Delete
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function showAddCategoryModal() {
    showNotification('Add Category feature coming soon!', 'info');
}

function editCategory(button) {
    const card = button.closest('.card');
    const title = card.querySelector('.card-title').textContent;
    showNotification(`Editing: ${title}`, 'info');
}

function deleteCategory(button) {
    const card = button.closest('.card');
    const title = card.querySelector('.card-title').textContent;
    if (confirm(`Are you sure you want to delete ${title}?`)) {
        showNotification(`${title} deleted successfully!`, 'success');
    }
}

function showNotifications() {
    showNotification('Notifications feature coming soon!', 'info');
}

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        border-radius: 0.375rem;
        color: white;
        font-weight: 500;
        z-index: 1000;
        max-width: 300px;
    `;
    
    const colors = {
        success: '#278b63',
        error: '#dc2626',
        info: '#3b82f6'
    };
    
    notification.style.backgroundColor = colors[type] || colors.info;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    setTimeout(() => notification.remove(), 3000);
}
</script>

<?php include 'footer.php'; ?>