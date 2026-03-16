<?php
require_once '../includes/auth_check.php';
require_once '../config/database.php';

/**
 * Add a new room/table booking.
 */
function addBooking($userId, $roomId, $date, $time, $guests) {
    global $pdo;
    try {
        $stmt = $pdo->prepare("INSERT INTO bookings (user_id, room_id, booking_date, booking_time, guests) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$userId, $roomId ?: null, $date, $time, $guests]);
    } catch (\PDOException $e) {
        error_log("Add Booking Error: " . $e->getMessage());
        return false;
    }
}

/**
 * Delete a booking by ID.
 * Optionally restricted to the specific user if an admin check isn't applied before calling.
 */
function deleteBooking($bookingId, $userId = null) {
    global $pdo;
    try {
        if ($userId !== null) {
            // Delete only if it belongs to the requesting user
            $stmt = $pdo->prepare("DELETE FROM bookings WHERE id = ? AND user_id = ?");
            return $stmt->execute([$bookingId, $userId]);
        } else {
            // Admin delete (no user verification needed)
            $stmt = $pdo->prepare("DELETE FROM bookings WHERE id = ?");
            return $stmt->execute([$bookingId]);
        }
    } catch (\PDOException $e) {
        error_log("Delete Booking Error: " . $e->getMessage());
        return false;
    }
}

// Processing incoming POST requests for bookings
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $roomId = !empty($_POST['room_id']) ? $_POST['room_id'] : null;
        $date = $_POST['booking_date'];
        $time = $_POST['booking_time'];
        $guests = $_POST['guests'];

        if (addBooking($_SESSION['user_id'], $roomId, $date, $time, $guests)) {
            header("Location: ../pages/cart.php?success=booking_added");
        } else {
            header("Location: ../pages/bookings.php?error=booking_failed");
        }
        exit;
    }

    if ($action === 'delete') {
        $bookingId = $_POST['booking_id'];
        
        // Ensure user can only delete their own unless they are staff backing it out
        if ($_SESSION['role'] === 'staff') {
            $success = deleteBooking($bookingId);
            header("Location: ../admin/bookings.php?msg=" . ($success ? "deleted" : "error"));
        } else {
            $success = deleteBooking($bookingId, $_SESSION['user_id']);
            header("Location: ../pages/cart.php?msg=" . ($success ? "deleted" : "error"));
        }
        exit;
    }
}
?>
