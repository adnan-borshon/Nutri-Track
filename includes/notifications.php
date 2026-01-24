<?php
/**
 * Notification Helper Functions
 */

function createNotification($userId, $type, $title, $message) {
    try {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO notifications (user_id, type, title, message) VALUES (?, ?, ?, ?)");
        $stmt->execute([$userId, $type, $title, $message]);
        return true;
    } catch (PDOException $e) {
        error_log("Create notification error: " . $e->getMessage());
        return false;
    }
}

function getNotifications($userId, $limit = 10) {
    try {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC LIMIT ?");
        $stmt->execute([$userId, $limit]);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        error_log("Get notifications error: " . $e->getMessage());
        return [];
    }
}

function getUnreadNotificationCount($userId) {
    try {
        $db = getDB();
        $stmt = $db->prepare("SELECT COUNT(*) as count FROM notifications WHERE user_id = ? AND is_read = 0");
        $stmt->execute([$userId]);
        return $stmt->fetch()['count'];
    } catch (PDOException $e) {
        error_log("Get unread count error: " . $e->getMessage());
        return 0;
    }
}

function markNotificationAsRead($notificationId, $userId) {
    try {
        $db = getDB();
        $stmt = $db->prepare("UPDATE notifications SET is_read = 1 WHERE id = ? AND user_id = ?");
        $stmt->execute([$notificationId, $userId]);
        return true;
    } catch (PDOException $e) {
        error_log("Mark notification read error: " . $e->getMessage());
        return false;
    }
}

function markAllNotificationsAsRead($userId) {
    try {
        $db = getDB();
        $stmt = $db->prepare("UPDATE notifications SET is_read = 1 WHERE user_id = ?");
        $stmt->execute([$userId]);
        return true;
    } catch (PDOException $e) {
        error_log("Mark all notifications read error: " . $e->getMessage());
        return false;
    }
}
?>