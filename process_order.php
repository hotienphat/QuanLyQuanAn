<?php
include 'includes/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $so_ban = $_POST['so_ban'];
    $so_luong_array = $_POST['so_luong'];  // Mảng so_luong[monan_id]

    $success = true;  // Biến kiểm tra thành công

    foreach ($so_luong_array as $monan_id => $so_luong) {
        if ($so_luong > 0) {
            // Lấy giá món từ bảng monan
            $stmt_gia = $conn->prepare("SELECT gia FROM monan WHERE id = ?");
            $stmt_gia->bind_param("i", $monan_id);
            $stmt_gia->execute();
            $result_gia = $stmt_gia->get_result();
            if ($row_gia = $result_gia->fetch_assoc()) {
                $gia = $row_gia['gia'];
                $tong_tien = $gia * $so_luong;

                // Lưu order vào DB
                $stmt = $conn->prepare("INSERT INTO orders (so_ban, monan_id, so_luong, tong_tien, trang_thai) VALUES (?, ?, ?, ?, 'pending')");
                $stmt->bind_param("iiid", $so_ban, $monan_id, $so_luong, $tong_tien);
                if (!$stmt->execute()) {
                    $success = false;
                    break;  // Dừng nếu lỗi
                }
            } else {
                $success = false;
                break;  // Món không tồn tại
            }
        }
    }

    // Redirect sau khi xử lý
    if ($success) {
        header('Location: index.html?ban=' . $so_ban . '&success=1');  // Quay về với thông báo thành công
    } else {
        header('Location: index.html?ban=' . $so_ban . '&error=1');  // Quay về với lỗi
    }
} else {
    // Nếu không phải POST, redirect về index
    header('Location: index.html');
}
?>
