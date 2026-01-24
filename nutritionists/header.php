<?php
require_once '../includes/session.php';
require_once '../includes/notifications.php';
checkAuth('nutritionist');
$user = getCurrentUser();
$notifications = getNotifications($user['id'], 5);
$notificationCount = getUnreadNotificationCount($user['id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriTrack - Nutritionist Dashboard</title>
    <link rel="stylesheet" href="http://localhost/Health%20DIet/style.css">
    <script src="nutritionist.js" defer></script>
    <script>
        function showProfilePopup() {
            document.getElementById('profilePopup').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
        
        function closeProfilePopup() {
            document.getElementById('profilePopup').style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        
        // Initialize popup functionality when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            const popup = document.getElementById('profilePopup');
            if (popup) {
                popup.addEventListener('click', function(e) {
                    if (e.target === popup) {
                        closeProfilePopup();
                    }
                });
            }
            
            // Close popup with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeProfilePopup();
                }
            });
        });
    </script>
</head>
<body>
    <div class="user-layout">
        <aside class="sidebar">
            <div class="sidebar-header">
                <a href="dashboard.php" class="logo">
                    <div style="display:flex; justify-self: center;">
                        <img style="width:30px;height:30px" src="../assets/images/nutritrak_logo-removebg-preview.png" alt="NutriTrack Logo">
                    </div>
                    <span class="logo-text"><span style="color:#278b63;">Nutri</span>Track</span>
                </a>
            </div>
            
            <nav class="sidebar-nav">
                <a href="dashboard.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px;height:16px;stroke-width:1.5;color:#278b63;vertical-align:middle;margin-right:8px;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
</svg> Dashboard
                </a>
                <a href="users.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'users.php' ? 'active' : ''; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px;height:16px;stroke-width:1.5;color:#278b63;vertical-align:middle;margin-right:8px;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
</svg> My Users
                </a>
                <a href="diet-plans.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'diet-plans.php' ? 'active' : ''; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px;height:16px;stroke-width:1.5;color:#278b63;vertical-align:middle;margin-right:8px;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
</svg> Diet Plans
                </a>
                <a href="suggestions.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'suggestions.php' ? 'active' : ''; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px;height:16px;stroke-width:1.5;color:#278b63;vertical-align:middle;margin-right:8px;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189m3.75 7.478a12.06 12.06 0 0 1-4.5 0m3.75 2.383a14.406 14.406 0 0 1-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 1 0-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
</svg> Recipes
                </a>
                <a href="guides.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'guides.php' ? 'active' : ''; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px;height:16px;stroke-width:1.5;color:#278b63;vertical-align:middle;margin-right:8px;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
</svg> Guides
                </a>
                <a href="progress.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'progress.php' ? 'active' : ''; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px;height:16px;stroke-width:1.5;color:#278b63;vertical-align:middle;margin-right:8px;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
</svg> Progress Log
                </a>
                <a href="chat.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'chat.php' ? 'active' : ''; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px;height:16px;stroke-width:1.5;color:#278b63;vertical-align:middle;margin-right:8px;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
</svg> Chat
                </a>
                <a href="appointments.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'appointments.php' ? 'active' : ''; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px;height:16px;stroke-width:1.5;color:#278b63;vertical-align:middle;margin-right:8px;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5a2.25 2.25 0 0 0 2.25-2.25m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5a2.25 2.25 0 0 1 21 9v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
</svg> Appointments
                </a>
                <a href="settings.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'active' : ''; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px;height:16px;stroke-width:1.5;color:#278b63;vertical-align:middle;margin-right:8px;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
</svg> Profile
                </a>
            </nav>
            
            <div class="sidebar-footer">
                <div class="user-info" onclick="showProfilePopup()" style="cursor: pointer;">
                    <?php echo getUserAvatar($user, '2rem'); ?>
                    <div>
                        <div class="team-name"><?php echo $user['name']; ?></div>
                        <div class="team-role">Nutritionist</div>
                    </div>
                </div>
                <a href="../landing page/auth.php?logout=1" class="btn btn-outline">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px;height:16px;stroke-width:1.5;color:#278b63;vertical-align:middle;margin-right:8px;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
</svg> Log out
                </a>
            </div>
        </aside>
        
        <div class="main-content">
            <header class="top-bar">
                <div></div>
                <div class="header-actions">
                    <div class="user-info">
                        <button class="btn btn-outline" onclick="toggleNotifications()" id="notificationBtn">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:16px;height:16px;stroke-width:1.5;color:#278b63;">
  <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
</svg>
                        </button>
                        <?php if ($notificationCount > 0): ?>
                        <div class="notification-dot" style="position: absolute; top: 0; right: 0; width: 8px; height: 8px; background: #dc2626; border-radius: 50%;"></div>
                        <?php endif; ?>
                        <div id="notificationDropdown" style="display: none; position: absolute; top: 100%; right: 0; width: 320px; background: white; border-radius: 0.5rem; box-shadow: 0 10px 25px rgba(0,0,0,0.15); z-index: 1000; margin-top: 0.5rem;">
                            <div style="padding: 1rem; border-bottom: 1px solid #e5e7eb;">
                                <h4 style="margin: 0; font-size: 0.875rem; font-weight: 600;">Notifications</h4>
                            </div>
                            <div style="max-height: 300px; overflow-y: auto;">
                                <?php if (empty($notifications)): ?>
                                <div style="padding: 2rem; text-align: center; color: #6b7280;">
                                    <p style="margin: 0;">No new notifications</p>
                                </div>
                                <?php else: ?>
                                <?php foreach ($notifications as $notif): ?>
                                <div style="display: block; padding: 0.75rem 1rem; border-bottom: 1px solid #f3f4f6;">
                                    <div style="display: flex; align-items: flex-start; gap: 0.75rem;">
                                        <div style="width: 2rem; height: 2rem; background: #dcfce7; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#278b63" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                        </div>
                                        <div style="flex: 1; min-width: 0;">
                                            <p style="margin: 0; font-size: 0.813rem; font-weight: 500; color: #111827;"><?php echo htmlspecialchars($notif['title']); ?></p>
                                            <p style="margin: 0.25rem 0 0; font-size: 0.75rem; color: #6b7280;"><?php echo htmlspecialchars($notif['message']); ?></p>
                                            <p style="margin: 0.25rem 0 0; font-size: 0.625rem; color: #9ca3af;" data-timestamp="<?php echo strtotime($notif['created_at']); ?>"><?php 
                                                $time = strtotime($notif['created_at']);
                                                $now = time();
                                                $diff = $now - $time;
                                                
                                                if ($diff < 60) {
                                                    echo 'Just now';
                                                } elseif ($diff < 3600) {
                                                    echo floor($diff / 60) . ' minutes ago';
                                                } elseif ($diff < 86400) {
                                                    echo floor($diff / 3600) . ' hours ago';
                                                } elseif ($diff < 604800) {
                                                    echo floor($diff / 86400) . ' days ago';
                                                } else {
                                                    echo date('M j, Y', $time);
                                                }
                                            ?></p>
                                        </div>
                                        <?php if (!$notif['is_read']): ?>
                                        <div style="width: 8px; height: 8px; background: #dc2626; border-radius: 50%; flex-shrink: 0;"></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="user-info" onclick="showProfilePopup()" style="cursor: pointer;">
                        <?php echo getUserAvatar($user, '2rem'); ?>
                        <span class="team-role"><?php echo $user['name']; ?></span>
                    </div>
                </div>
            </header>
            
            <main class="content-area">

<!-- Profile Popup Modal -->
<div id="profilePopup" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 0.75rem; padding: 2rem; max-width: 400px; width: 90%; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h3 style="font-size: 1.25rem; font-weight: 600; margin: 0; color: #111827;">Profile Information</h3>
            <button onclick="closeProfilePopup()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #6b7280; padding: 0.25rem; border-radius: 0.375rem; width: 2rem; height: 2rem; display: flex; align-items: center; justify-content: center;" onmouseover="this.style.backgroundColor='#f3f4f6'" onmouseout="this.style.backgroundColor='transparent'">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
        
        <div style="text-align: center; margin-bottom: 1.5rem;">
            <?php if (!empty($user['profile_image']) && file_exists(__DIR__ . '/../' . $user['profile_image'])): ?>
                <img src="../<?php echo htmlspecialchars($user['profile_image']); ?>" alt="Profile" style="width: 4rem; height: 4rem; border-radius: 50%; object-fit: cover; margin: 0 auto 1rem; box-shadow: 0 4px 8px rgba(39, 139, 99, 0.3);">
            <?php else: ?>
                <div style="width: 4rem; height: 4rem; background: linear-gradient(135deg, #278b63, #16a34a); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.5rem; margin: 0 auto 1rem; box-shadow: 0 4px 8px rgba(39, 139, 99, 0.3);"><?php echo getUserInitials($user['name']); ?></div>
            <?php endif; ?>
            <h4 style="font-size: 1.125rem; font-weight: 600; margin: 0 0 0.25rem 0; color: #111827;"><?php echo $user['name']; ?></h4>
            <p style="color: #278b63; font-size: 0.875rem; font-weight: 500; margin: 0;">Nutritionist</p>
        </div>
        
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            <div style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; background: #f9fafb; border-radius: 0.5rem;">
                <div style="width: 2rem; height: 2rem; background: #dcfce7; color: #278b63; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.875rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </div>
                <div>
                    <p style="font-size: 0.75rem; color: #6b7280; margin: 0;">Full Name</p>
                    <p style="font-size: 0.875rem; font-weight: 500; margin: 0; color: #111827;"><?php echo $user['name']; ?></p>
                </div>
            </div>
            
            <div style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; background: #f9fafb; border-radius: 0.5rem;">
                <div style="width: 2rem; height: 2rem; background: #dcfce7; color: #278b63; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.875rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                </div>
                <div>
                    <p style="font-size: 0.75rem; color: #6b7280; margin: 0;">Email Address</p>
                    <p style="font-size: 0.875rem; font-weight: 500; margin: 0; color: #111827;"><?php echo $user['email']; ?></p>
                </div>
            </div>
            
            <div style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; background: #f9fafb; border-radius: 0.5rem;">
                <div style="width: 2rem; height: 2rem; background: #dcfce7; color: #278b63; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.875rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                    </svg>
                </div>
                <div>
                    <p style="font-size: 0.75rem; color: #6b7280; margin: 0;">Phone Number</p>
                    <p style="font-size: 0.875rem; font-weight: 500; margin: 0; color: #111827;"><?php echo !empty($user['phone']) ? $user['phone'] : 'Not provided'; ?></p>
                </div>
            </div>
        </div>
        
        <div style="margin-top: 1.5rem; display: flex; gap: 0.75rem;">
            <button onclick="window.location.href='settings.php'" style="flex: 1; padding: 0.75rem 1rem; background: #278b63; color: white; border: none; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 500; cursor: pointer;" onmouseover="this.style.backgroundColor='#1f7a54'" onmouseout="this.style.backgroundColor='#278b63'">Edit Profile</button>
            <button onclick="closeProfilePopup()" style="flex: 1; padding: 0.75rem 1rem; background: white; color: #374151; border: 1px solid #d1d5db; border-radius: 0.5rem; font-size: 0.875rem; font-weight: 500; cursor: pointer;" onmouseover="this.style.backgroundColor='#f9fafb'" onmouseout="this.style.backgroundColor='white'">Close</button>
        </div>
    </div>
</div>

<script>
function updateNotificationTimes() {
    const timeElements = document.querySelectorAll('[data-timestamp]');
    const now = Math.floor(Date.now() / 1000); // Current Unix timestamp
    
    timeElements.forEach(element => {
        const createdTimestamp = parseInt(element.getAttribute('data-timestamp'));
        const diffSeconds = now - createdTimestamp; // Difference in seconds
        
        let timeText;
        if (diffSeconds < 60) {
            timeText = 'Just now';
        } else if (diffSeconds < 3600) {
            const minutes = Math.floor(diffSeconds / 60);
            timeText = minutes + (minutes === 1 ? ' minute ago' : ' minutes ago');
        } else if (diffSeconds < 86400) {
            const hours = Math.floor(diffSeconds / 3600);
            timeText = hours + (hours === 1 ? ' hour ago' : ' hours ago');
        } else if (diffSeconds < 604800) {
            const days = Math.floor(diffSeconds / 86400);
            timeText = days + (days === 1 ? ' day ago' : ' days ago');
        } else {
            const date = new Date(createdTimestamp * 1000);
            timeText = date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
        }
        
        element.textContent = timeText;
    });
}

// Update times every minute
setInterval(updateNotificationTimes, 60000);

function toggleNotifications() {
    const dropdown = document.getElementById('notificationDropdown');
    dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
    // Update times when dropdown opens
    if (dropdown.style.display === 'block') {
        updateNotificationTimes();
    }
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(e) {
    const dropdown = document.getElementById('notificationDropdown');
    const btn = document.getElementById('notificationBtn');
    if (dropdown && !dropdown.contains(e.target) && !btn.contains(e.target)) {
        dropdown.style.display = 'none';
    }
});
</script>