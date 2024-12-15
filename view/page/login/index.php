<html lang="en">
<?php
error_reporting(1);
session_start();

include("../../../model/connect.php");
$db = new Database;
$conn = $db->connect();

if (isset($_POST["btndn"])) {
    $email = $_POST["email"];
    $psw = md5($_POST["psw"]);
    if (empty($email) || empty($psw))
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Vui lòng nhập đầy đủ thông tin!',
                    icon: 'warning',
                    confirmButtonColor: 'red',
                    confirmButtonText: 'Đồng ý'
                });
            });
        </script>";
    else {
        $sql = "SELECT * FROM user WHERE email = '$email' AND password = '$psw' AND status = 1";
        $result = $conn->query($sql);

        $row = $result->fetch_assoc();

        if ($result->num_rows > 0) {
            $_SESSION["user"] = [$row["userID"], $row["storeID"], $row["roleID"]];
            $_SESSION["login"] = 1;

            switch ($row["roleID"]) {
                case 1:
                    echo "<script>window.location.href = '../admin/index.php'</script>";
                    break;
                case 2:
                    echo "<script>window.location.href = '../manager/index.php'</script>";
                    break;
                case 3:
                    echo "<script>window.location.href = '../orderstaff/index.php'</script>";
                    break;
                case 4:
                    echo "<script>window.location.href = '../kitchenstaff/index.php'</script>";
                    break;
            }
        } else {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Thông tin đăng nhập không hợp lệ. Vui lòng nhập lại!',
                        icon: 'warning',
                        confirmButtonColor: 'red',
                        confirmButtonText: 'Đồng ý'
                    });
                });
            </script>";
        }
    }
}
?>

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Quản trị hệ thống | Đăng nhập</title>
    <link rel="shortcut icon" href="../../../images/logo-nobg.png" type="image/x-icon" />

    <!-- Font Awesome CSS -->
    <link href="../../../view/css/all.css" rel="stylesheet" />

    <!-- Preconnect for Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Playwrite+DE+Grund:wght@100..400&display=swap" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../../view/css/bootstrap.min.css" />

    <!-- Style CSS -->
    <link rel="stylesheet" href="../../../view/css/style.css" />

    <!-- Tailwind CSS -->
    <script src="../../../view/js/tailwindcss.js"></script>

    <!-- jQuery -->
    <script src="../../../view/js/jquery.min.js"></script>

    <!-- Chart -->
    <script src="../../../view/js/chart.js"></script>

    <!-- Font Awesome JS -->
    <script src="../../../view/js/all.js"></script>

    <!-- Bootstrap JS (bundle includes Popper.js) -->
    <script src="../../../view/js/bootstrap.bundle.min.js"></script>

    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: "Playwrite DE Grund", cursive;
            background-image: url("../../../images/bglogin.png");
            overflow: hidden;
            background-size: 100%;
            background-position: center;
        }

        .swal2-modal {
            width: 50%;
            border-radius: 15px;
        }

        .swal2-icon {
            font-size: 0.8rem;
        }

        .swal2-title {
            font-size: 1.3rem;
        }

        .swal2-confirm {
            border-radius: 8px;
            padding: 6px 20px;
        }

        @media only screen and (max-width: 600px) {
            body {
                background-size: auto;
                background-position: right;
            }
        }

        .starfall {
            position: absolute;
            height: 100%;
            width: 100%;
            top: 0;
            left: 0;
            -webkit-transform-style: preserve-3d;
            transform-style: preserve-3d;
            -webkit-perspective: 1000px;
            perspective: 1000px;
            z-index: -1;
        }

        .starfall .falling-star {
            width: 8px;
            height: 8px;
            background: #00d1b2;
            position: absolute;
            border-radius: 50%;
            opacity: 0.5;
        }

        .falling-star:nth-child(1) {
            -webkit-transform: translateX(68vw) translateY(-8px);
            transform: translateX(68vw) translateY(-8px);
            -webkit-animation: anim1 4s infinite;
            animation: anim1 4s infinite;
            -webkit-animation-delay: 0.3s;
            animation-delay: 0.3s;
        }

        @-webkit-keyframes anim1 {
            10% {
                opacity: 0.5;
            }

            12% {
                opacity: 1;
                -webkit-box-shadow: 0 0 3px 0 #fff;
                box-shadow: 0 0 3px 0 #fff;
            }

            15% {
                opacity: 0.5;
            }

            50% {
                opacity: 0;
            }

            100% {
                -webkit-transform: translateX(88vw) translateY(100vh);
                transform: translateX(88vw) translateY(100vh);
                opacity: 0;
            }
        }

        @keyframes anim1 {
            10% {
                opacity: 0.5;
            }

            12% {
                opacity: 1;
                -webkit-box-shadow: 0 0 3px 0 #fff;
                box-shadow: 0 0 3px 0 #fff;
            }

            15% {
                opacity: 0.5;
            }

            50% {
                opacity: 0;
            }

            100% {
                -webkit-transform: translateX(88vw) translateY(100vh);
                transform: translateX(88vw) translateY(100vh);
                opacity: 0;
            }
        }

        .falling-star:nth-child(2) {
            -webkit-transform: translateX(57vw) translateY(-8px);
            transform: translateX(57vw) translateY(-8px);
            -webkit-animation: anim2 4s infinite;
            animation: anim2 4s infinite;
            -webkit-animation-delay: 0.6s;
            animation-delay: 0.6s;
        }

        @-webkit-keyframes anim2 {
            10% {
                opacity: 0.5;
            }

            12% {
                opacity: 1;
                -webkit-box-shadow: 0 0 3px 0 #fff;
                box-shadow: 0 0 3px 0 #fff;
            }

            15% {
                opacity: 0.5;
            }

            50% {
                opacity: 0;
            }

            100% {
                -webkit-transform: translateX(77vw) translateY(100vh);
                transform: translateX(77vw) translateY(100vh);
                opacity: 0;
            }
        }

        @keyframes anim2 {
            10% {
                opacity: 0.5;
            }

            12% {
                opacity: 1;
                -webkit-box-shadow: 0 0 3px 0 #fff;
                box-shadow: 0 0 3px 0 #fff;
            }

            15% {
                opacity: 0.5;
            }

            50% {
                opacity: 0;
            }

            100% {
                -webkit-transform: translateX(77vw) translateY(100vh);
                transform: translateX(77vw) translateY(100vh);
                opacity: 0;
            }
        }

        .falling-star:nth-child(3) {
            -webkit-transform: translateX(70vw) translateY(-8px);
            transform: translateX(70vw) translateY(-8px);
            -webkit-animation: anim3 4s infinite;
            animation: anim3 4s infinite;
            -webkit-animation-delay: 0.9s;
            animation-delay: 0.9s;
        }

        @-webkit-keyframes anim3 {
            10% {
                opacity: 0.5;
            }

            12% {
                opacity: 1;
                -webkit-box-shadow: 0 0 3px 0 #fff;
                box-shadow: 0 0 3px 0 #fff;
            }

            15% {
                opacity: 0.5;
            }

            50% {
                opacity: 0;
            }

            100% {
                -webkit-transform: translateX(90vw) translateY(100vh);
                transform: translateX(90vw) translateY(100vh);
                opacity: 0;
            }
        }

        @keyframes anim3 {
            10% {
                opacity: 0.5;
            }

            12% {
                opacity: 1;
                -webkit-box-shadow: 0 0 3px 0 #fff;
                box-shadow: 0 0 3px 0 #fff;
            }

            15% {
                opacity: 0.5;
            }

            50% {
                opacity: 0;
            }

            100% {
                -webkit-transform: translateX(90vw) translateY(100vh);
                transform: translateX(90vw) translateY(100vh);
                opacity: 0;
            }
        }

        .falling-star:nth-child(4) {
            -webkit-transform: translateX(54vw) translateY(-8px);
            transform: translateX(54vw) translateY(-8px);
            -webkit-animation: anim4 4s infinite;
            animation: anim4 4s infinite;
            -webkit-animation-delay: 1.2s;
            animation-delay: 1.2s;
        }

        @-webkit-keyframes anim4 {
            10% {
                opacity: 0.5;
            }

            12% {
                opacity: 1;
                -webkit-box-shadow: 0 0 3px 0 #fff;
                box-shadow: 0 0 3px 0 #fff;
            }

            15% {
                opacity: 0.5;
            }

            50% {
                opacity: 0;
            }

            100% {
                -webkit-transform: translateX(74vw) translateY(100vh);
                transform: translateX(74vw) translateY(100vh);
                opacity: 0;
            }
        }

        @keyframes anim4 {
            10% {
                opacity: 0.5;
            }

            12% {
                opacity: 1;
                -webkit-box-shadow: 0 0 3px 0 #fff;
                box-shadow: 0 0 3px 0 #fff;
            }

            15% {
                opacity: 0.5;
            }

            50% {
                opacity: 0;
            }

            100% {
                -webkit-transform: translateX(74vw) translateY(100vh);
                transform: translateX(74vw) translateY(100vh);
                opacity: 0;
            }
        }

        .falling-star:nth-child(5) {
            -webkit-transform: translateX(85vw) translateY(-8px);
            transform: translateX(85vw) translateY(-8px);
            -webkit-animation: anim5 4s infinite;
            animation: anim5 4s infinite;
            -webkit-animation-delay: 1.5s;
            animation-delay: 1.5s;
        }

        @-webkit-keyframes anim5 {
            10% {
                opacity: 0.5;
            }

            12% {
                opacity: 1;
                -webkit-box-shadow: 0 0 3px 0 #fff;
                box-shadow: 0 0 3px 0 #fff;
            }

            15% {
                opacity: 0.5;
            }

            50% {
                opacity: 0;
            }

            100% {
                -webkit-transform: translateX(105vw) translateY(100vh);
                transform: translateX(105vw) translateY(100vh);
                opacity: 0;
            }
        }

        @keyframes anim5 {
            10% {
                opacity: 0.5;
            }

            12% {
                opacity: 1;
                -webkit-box-shadow: 0 0 3px 0 #fff;
                box-shadow: 0 0 3px 0 #fff;
            }

            15% {
                opacity: 0.5;
            }

            50% {
                opacity: 0;
            }

            100% {
                -webkit-transform: translateX(105vw) translateY(100vh);
                transform: translateX(105vw) translateY(100vh);
                opacity: 0;
            }
        }

        .falling-star:nth-child(6) {
            -webkit-transform: translateX(59vw) translateY(-8px);
            transform: translateX(59vw) translateY(-8px);
            -webkit-animation: anim6 4s infinite;
            animation: anim6 4s infinite;
            -webkit-animation-delay: 1.8s;
            animation-delay: 1.8s;
        }

        @-webkit-keyframes anim6 {
            10% {
                opacity: 0.5;
            }

            12% {
                opacity: 1;
                -webkit-box-shadow: 0 0 3px 0 #fff;
                box-shadow: 0 0 3px 0 #fff;
            }

            15% {
                opacity: 0.5;
            }

            50% {
                opacity: 0;
            }

            100% {
                -webkit-transform: translateX(79vw) translateY(100vh);
                transform: translateX(79vw) translateY(100vh);
                opacity: 0;
            }
        }

        @keyframes anim6 {
            10% {
                opacity: 0.5;
            }

            12% {
                opacity: 1;
                -webkit-box-shadow: 0 0 3px 0 #fff;
                box-shadow: 0 0 3px 0 #fff;
            }

            15% {
                opacity: 0.5;
            }

            50% {
                opacity: 0;
            }

            100% {
                -webkit-transform: translateX(79vw) translateY(100vh);
                transform: translateX(79vw) translateY(100vh);
                opacity: 0;
            }
        }

        .falling-star:nth-child(7) {
            -webkit-transform: translateX(33vw) translateY(-8px);
            transform: translateX(33vw) translateY(-8px);
            -webkit-animation: anim7 4s infinite;
            animation: anim7 4s infinite;
            -webkit-animation-delay: 2.1s;
            animation-delay: 2.1s;
        }

        @-webkit-keyframes anim7 {
            10% {
                opacity: 0.5;
            }

            12% {
                opacity: 1;
                -webkit-box-shadow: 0 0 3px 0 #fff;
                box-shadow: 0 0 3px 0 #fff;
            }

            15% {
                opacity: 0.5;
            }

            50% {
                opacity: 0;
            }

            100% {
                -webkit-transform: translateX(53vw) translateY(100vh);
                transform: translateX(53vw) translateY(100vh);
                opacity: 0;
            }
        }

        @keyframes anim7 {
            10% {
                opacity: 0.5;
            }

            12% {
                opacity: 1;
                -webkit-box-shadow: 0 0 3px 0 #fff;
                box-shadow: 0 0 3px 0 #fff;
            }

            15% {
                opacity: 0.5;
            }

            50% {
                opacity: 0;
            }

            100% {
                -webkit-transform: translateX(53vw) translateY(100vh);
                transform: translateX(53vw) translateY(100vh);
                opacity: 0;
            }
        }

        .falling-star:nth-child(8) {
            -webkit-transform: translateX(82vw) translateY(-8px);
            transform: translateX(82vw) translateY(-8px);
            -webkit-animation: anim8 4s infinite;
            animation: anim8 4s infinite;
            -webkit-animation-delay: 2.4s;
            animation-delay: 2.4s;
        }

        @-webkit-keyframes anim8 {
            10% {
                opacity: 0.5;
            }

            12% {
                opacity: 1;
                -webkit-box-shadow: 0 0 3px 0 #fff;
                box-shadow: 0 0 3px 0 #fff;
            }

            15% {
                opacity: 0.5;
            }

            50% {
                opacity: 0;
            }

            100% {
                -webkit-transform: translateX(102vw) translateY(100vh);
                transform: translateX(102vw) translateY(100vh);
                opacity: 0;
            }
        }

        @keyframes anim8 {
            10% {
                opacity: 0.5;
            }

            12% {
                opacity: 1;
                -webkit-box-shadow: 0 0 3px 0 #fff;
                box-shadow: 0 0 3px 0 #fff;
            }

            15% {
                opacity: 0.5;
            }

            50% {
                opacity: 0;
            }

            100% {
                -webkit-transform: translateX(102vw) translateY(100vh);
                transform: translateX(102vw) translateY(100vh);
                opacity: 0;
            }
        }

        .falling-star:nth-child(9) {
            -webkit-transform: translateX(24vw) translateY(-8px);
            transform: translateX(24vw) translateY(-8px);
            -webkit-animation: anim9 4s infinite;
            animation: anim9 4s infinite;
            -webkit-animation-delay: 2.7s;
            animation-delay: 2.7s;
        }

        @-webkit-keyframes anim9 {
            10% {
                opacity: 0.5;
            }

            12% {
                opacity: 1;
                -webkit-box-shadow: 0 0 3px 0 #fff;
                box-shadow: 0 0 3px 0 #fff;
            }

            15% {
                opacity: 0.5;
            }

            50% {
                opacity: 0;
            }

            100% {
                -webkit-transform: translateX(44vw) translateY(100vh);
                transform: translateX(44vw) translateY(100vh);
                opacity: 0;
            }
        }

        @keyframes anim9 {
            10% {
                opacity: 0.5;
            }

            12% {
                opacity: 1;
                -webkit-box-shadow: 0 0 3px 0 #fff;
                box-shadow: 0 0 3px 0 #fff;
            }

            15% {
                opacity: 0.5;
            }

            50% {
                opacity: 0;
            }

            100% {
                -webkit-transform: translateX(44vw) translateY(100vh);
                transform: translateX(44vw) translateY(100vh);
                opacity: 0;
            }
        }

        .falling-star:nth-child(10) {
            -webkit-transform: translateX(54vw) translateY(-8px);
            transform: translateX(54vw) translateY(-8px);
            -webkit-animation: anim10 4s infinite;
            animation: anim10 4s infinite;
            -webkit-animation-delay: 3s;
            animation-delay: 3s;
        }

        @-webkit-keyframes anim10 {
            10% {
                opacity: 0.5;
            }

            12% {
                opacity: 1;
                -webkit-box-shadow: 0 0 3px 0 #fff;
                box-shadow: 0 0 3px 0 #fff;
            }

            15% {
                opacity: 0.5;
            }

            50% {
                opacity: 0;
            }

            100% {
                -webkit-transform: translateX(74vw) translateY(100vh);
                transform: translateX(74vw) translateY(100vh);
                opacity: 0;
            }
        }

        @keyframes anim10 {
            10% {
                opacity: 0.5;
            }

            12% {
                opacity: 1;
                -webkit-box-shadow: 0 0 3px 0 #fff;
                box-shadow: 0 0 3px 0 #fff;
            }

            15% {
                opacity: 0.5;
            }

            50% {
                opacity: 0;
            }

            100% {
                -webkit-transform: translateX(74vw) translateY(100vh);
                transform: translateX(74vw) translateY(100vh);
                opacity: 0;
            }
        }

        .falling-star:nth-child(11) {
            -webkit-transform: translateX(11vw) translateY(-8px);
            transform: translateX(11vw) translateY(-8px);
            -webkit-animation: anim11 4s infinite;
            animation: anim11 4s infinite;
            -webkit-animation-delay: 3.3s;
            animation-delay: 3.3s;
        }

        @-webkit-keyframes anim11 {
            10% {
                opacity: 0.5;
            }

            12% {
                opacity: 1;
                -webkit-box-shadow: 0 0 3px 0 #fff;
                box-shadow: 0 0 3px 0 #fff;
            }

            15% {
                opacity: 0.5;
            }

            50% {
                opacity: 0;
            }

            100% {
                -webkit-transform: translateX(31vw) translateY(100vh);
                transform: translateX(31vw) translateY(100vh);
                opacity: 0;
            }
        }

        @keyframes anim11 {
            10% {
                opacity: 0.5;
            }

            12% {
                opacity: 1;
                -webkit-box-shadow: 0 0 3px 0 #fff;
                box-shadow: 0 0 3px 0 #fff;
            }

            15% {
                opacity: 0.5;
            }

            50% {
                opacity: 0;
            }

            100% {
                -webkit-transform: translateX(31vw) translateY(100vh);
                transform: translateX(31vw) translateY(100vh);
                opacity: 0;
            }
        }

        .falling-star:nth-child(12) {
            -webkit-transform: translateX(14vw) translateY(-8px);
            transform: translateX(14vw) translateY(-8px);
            -webkit-animation: anim12 4s infinite;
            animation: anim12 4s infinite;
            -webkit-animation-delay: 3.6s;
            animation-delay: 3.6s;
        }

        @-webkit-keyframes anim12 {
            10% {
                opacity: 0.5;
            }

            12% {
                opacity: 1;
                -webkit-box-shadow: 0 0 3px 0 #fff;
                box-shadow: 0 0 3px 0 #fff;
            }

            15% {
                opacity: 0.5;
            }

            50% {
                opacity: 0;
            }

            100% {
                -webkit-transform: translateX(34vw) translateY(100vh);
                transform: translateX(34vw) translateY(100vh);
                opacity: 0;
            }
        }

        @keyframes anim12 {
            10% {
                opacity: 0.5;
            }

            12% {
                opacity: 1;
                -webkit-box-shadow: 0 0 3px 0 #fff;
                box-shadow: 0 0 3px 0 #fff;
            }

            15% {
                opacity: 0.5;
            }

            50% {
                opacity: 0;
            }

            100% {
                -webkit-transform: translateX(34vw) translateY(100vh);
                transform: translateX(34vw) translateY(100vh);
                opacity: 0;
            }
        }

        .falling-star:nth-child(13) {
            -webkit-transform: translateX(66vw) translateY(-8px);
            transform: translateX(66vw) translateY(-8px);
            -webkit-animation: anim13 4s infinite;
            animation: anim13 4s infinite;
            -webkit-animation-delay: 3.9s;
            animation-delay: 3.9s;
        }

        @-webkit-keyframes anim13 {
            10% {
                opacity: 0.5;
            }

            12% {
                opacity: 1;
                -webkit-box-shadow: 0 0 3px 0 #fff;
                box-shadow: 0 0 3px 0 #fff;
            }

            15% {
                opacity: 0.5;
            }

            50% {
                opacity: 0;
            }

            100% {
                -webkit-transform: translateX(86vw) translateY(100vh);
                transform: translateX(86vw) translateY(100vh);
                opacity: 0;
            }
        }

        @keyframes anim13 {
            10% {
                opacity: 0.5;
            }

            12% {
                opacity: 1;
                -webkit-box-shadow: 0 0 3px 0 #fff;
                box-shadow: 0 0 3px 0 #fff;
            }

            15% {
                opacity: 0.5;
            }

            50% {
                opacity: 0;
            }

            100% {
                -webkit-transform: translateX(86vw) translateY(100vh);
                transform: translateX(86vw) translateY(100vh);
                opacity: 0;
            }
        }

        .falling-star:nth-child(14) {
            -webkit-transform: translateX(64vw) translateY(-8px);
            transform: translateX(64vw) translateY(-8px);
            -webkit-animation: anim14 4s infinite;
            animation: anim14 4s infinite;
            -webkit-animation-delay: 4.2s;
            animation-delay: 4.2s;
        }

        @-webkit-keyframes anim14 {
            10% {
                opacity: 0.5;
            }

            12% {
                opacity: 1;
                -webkit-box-shadow: 0 0 3px 0 #fff;
                box-shadow: 0 0 3px 0 #fff;
            }

            15% {
                opacity: 0.5;
            }

            50% {
                opacity: 0;
            }

            100% {
                -webkit-transform: translateX(84vw) translateY(100vh);
                transform: translateX(84vw) translateY(100vh);
                opacity: 0;
            }
        }

        @keyframes anim14 {
            10% {
                opacity: 0.5;
            }

            12% {
                opacity: 1;
                -webkit-box-shadow: 0 0 3px 0 #fff;
                box-shadow: 0 0 3px 0 #fff;
            }

            15% {
                opacity: 0.5;
            }

            50% {
                opacity: 0;
            }

            100% {
                -webkit-transform: translateX(84vw) translateY(100vh);
                transform: translateX(84vw) translateY(100vh);
                opacity: 0;
            }
        }

        .falling-star:nth-child(15) {
            -webkit-transform: translateX(3vw) translateY(-8px);
            transform: translateX(3vw) translateY(-8px);
            -webkit-animation: anim15 4s infinite;
            animation: anim15 4s infinite;
            -webkit-animation-delay: 4.5s;
            animation-delay: 4.5s;
        }

        @-webkit-keyframes anim15 {
            10% {
                opacity: 0.5;
            }

            12% {
                opacity: 1;
                -webkit-box-shadow: 0 0 3px 0 #fff;
                box-shadow: 0 0 3px 0 #fff;
            }

            15% {
                opacity: 0.5;
            }

            50% {
                opacity: 0;
            }

            100% {
                -webkit-transform: translateX(23vw) translateY(100vh);
                transform: translateX(23vw) translateY(100vh);
                opacity: 0;
            }
        }

        @keyframes anim15 {
            10% {
                opacity: 0.5;
            }

            12% {
                opacity: 1;
                -webkit-box-shadow: 0 0 3px 0 #fff;
                box-shadow: 0 0 3px 0 #fff;
            }

            15% {
                opacity: 0.5;
            }

            50% {
                opacity: 0;
            }

            100% {
                -webkit-transform: translateX(23vw) translateY(100vh);
                transform: translateX(23vw) translateY(100vh);
                opacity: 0;
            }
        }

        .falling-star:nth-child(16) {
            -webkit-transform: translateX(78vw) translateY(-8px);
            transform: translateX(78vw) translateY(-8px);
            -webkit-animation: anim16 4s infinite;
            animation: anim16 4s infinite;
            -webkit-animation-delay: 4.8s;
            animation-delay: 4.8s;
        }

        @-webkit-keyframes anim16 {
            10% {
                opacity: 0.5;
            }

            12% {
                opacity: 1;
                -webkit-box-shadow: 0 0 3px 0 #fff;
                box-shadow: 0 0 3px 0 #fff;
            }

            15% {
                opacity: 0.5;
            }

            50% {
                opacity: 0;
            }

            100% {
                -webkit-transform: translateX(98vw) translateY(100vh);
                transform: translateX(98vw) translateY(100vh);
                opacity: 0;
            }
        }

        @keyframes anim16 {
            10% {
                opacity: 0.5;
            }

            12% {
                opacity: 1;
                -webkit-box-shadow: 0 0 3px 0 #fff;
                box-shadow: 0 0 3px 0 #fff;
            }

            15% {
                opacity: 0.5;
            }

            50% {
                opacity: 0;
            }

            100% {
                -webkit-transform: translateX(98vw) translateY(100vh);
                transform: translateX(98vw) translateY(100vh);
                opacity: 0;
            }
        }

        .falling-star:nth-child(17) {
            -webkit-transform: translateX(98vw) translateY(-8px);
            transform: translateX(98vw) translateY(-8px);
            -webkit-animation: anim17 4s infinite;
            animation: anim17 4s infinite;
            -webkit-animation-delay: 5.1s;
            animation-delay: 5.1s;
        }

        @-webkit-keyframes anim17 {
            10% {
                opacity: 0.5;
            }

            12% {
                opacity: 1;
                -webkit-box-shadow: 0 0 3px 0 #fff;
                box-shadow: 0 0 3px 0 #fff;
            }

            15% {
                opacity: 0.5;
            }

            50% {
                opacity: 0;
            }

            100% {
                -webkit-transform: translateX(118vw) translateY(100vh);
                transform: translateX(118vw) translateY(100vh);
                opacity: 0;
            }
        }

        @keyframes anim17 {
            10% {
                opacity: 0.5;
            }

            12% {
                opacity: 1;
                -webkit-box-shadow: 0 0 3px 0 #fff;
                box-shadow: 0 0 3px 0 #fff;
            }

            15% {
                opacity: 0.5;
            }

            50% {
                opacity: 0;
            }

            100% {
                -webkit-transform: translateX(118vw) translateY(100vh);
                transform: translateX(118vw) translateY(100vh);
                opacity: 0;
            }
        }

        .falling-star:nth-child(18) {
            -webkit-transform: translateX(34vw) translateY(-8px);
            transform: translateX(34vw) translateY(-8px);
            -webkit-animation: anim18 4s infinite;
            animation: anim18 4s infinite;
            -webkit-animation-delay: 5.4s;
            animation-delay: 5.4s;
        }

        @-webkit-keyframes anim18 {
            10% {
                opacity: 0.5;
            }

            12% {
                opacity: 1;
                -webkit-box-shadow: 0 0 3px 0 #fff;
                box-shadow: 0 0 3px 0 #fff;
            }

            15% {
                opacity: 0.5;
            }

            50% {
                opacity: 0;
            }

            100% {
                -webkit-transform: translateX(54vw) translateY(100vh);
                transform: translateX(54vw) translateY(100vh);
                opacity: 0;
            }
        }

        @keyframes anim18 {
            10% {
                opacity: 0.5;
            }

            12% {
                opacity: 1;
                -webkit-box-shadow: 0 0 3px 0 #fff;
                box-shadow: 0 0 3px 0 #fff;
            }

            15% {
                opacity: 0.5;
            }

            50% {
                opacity: 0;
            }

            100% {
                -webkit-transform: translateX(54vw) translateY(100vh);
                transform: translateX(54vw) translateY(100vh);
                opacity: 0;
            }
        }

        .falling-star:nth-child(19) {
            -webkit-transform: translateX(54vw) translateY(-8px);
            transform: translateX(54vw) translateY(-8px);
            -webkit-animation: anim19 4s infinite;
            animation: anim19 4s infinite;
            -webkit-animation-delay: 5.7s;
            animation-delay: 5.7s;
        }

        @-webkit-keyframes anim19 {
            10% {
                opacity: 0.5;
            }

            12% {
                opacity: 1;
                -webkit-box-shadow: 0 0 3px 0 #fff;
                box-shadow: 0 0 3px 0 #fff;
            }

            15% {
                opacity: 0.5;
            }

            50% {
                opacity: 0;
            }

            100% {
                -webkit-transform: translateX(74vw) translateY(100vh);
                transform: translateX(74vw) translateY(100vh);
                opacity: 0;
            }
        }

        @keyframes anim19 {
            10% {
                opacity: 0.5;
            }

            12% {
                opacity: 1;
                -webkit-box-shadow: 0 0 3px 0 #fff;
                box-shadow: 0 0 3px 0 #fff;
            }

            15% {
                opacity: 0.5;
            }

            50% {
                opacity: 0;
            }

            100% {
                -webkit-transform: translateX(74vw) translateY(100vh);
                transform: translateX(74vw) translateY(100vh);
                opacity: 0;
            }
        }

        .falling-star:nth-child(20) {
            -webkit-transform: translateX(71vw) translateY(-8px);
            transform: translateX(71vw) translateY(-8px);
            -webkit-animation: anim20 4s infinite;
            animation: anim20 4s infinite;
            -webkit-animation-delay: 6s;
            animation-delay: 6s;
        }

        @-webkit-keyframes anim20 {
            10% {
                opacity: 0.5;
            }

            12% {
                opacity: 1;
                -webkit-box-shadow: 0 0 3px 0 #fff;
                box-shadow: 0 0 3px 0 #fff;
            }

            15% {
                opacity: 0.5;
            }

            50% {
                opacity: 0;
            }

            100% {
                -webkit-transform: translateX(91vw) translateY(100vh);
                transform: translateX(91vw) translateY(100vh);
                opacity: 0;
            }
        }

        @keyframes anim20 {
            10% {
                opacity: 0.5;
            }

            12% {
                opacity: 1;
                -webkit-box-shadow: 0 0 3px 0 #fff;
                box-shadow: 0 0 3px 0 #fff;
            }

            15% {
                opacity: 0.5;
            }

            50% {
                opacity: 0;
            }

            100% {
                -webkit-transform: translateX(91vw) translateY(100vh);
                transform: translateX(91vw) translateY(100vh);
                opacity: 0;
            }
        }

        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            z-index: 200;
            -webkit-transform-style: preserve-3d;
            transform-style: preserve-3d;
            overflow: hidden;
        }

        @-webkit-keyframes move {
            0% {
                -webkit-transform: translateY(0);
                transform: translateY(0);
                opacity: 0;
            }

            10%,
            90% {
                opacity: 1;
            }

            100% {
                -webkit-transform: translateY(45vw);
                transform: translateY(45vw);
                opacity: 0;
            }
        }

        @keyframes move {
            0% {
                -webkit-transform: translateY(0);
                transform: translateY(0);
                opacity: 0;
            }

            10%,
            90% {
                opacity: 1;
            }

            100% {
                -webkit-transform: translateY(45vw);
                transform: translateY(45vw);
                opacity: 0;
            }
        }
    </style>
</head>

<body>
    <div class="starfall"></div>
    <div class="flex h-screen w-screen">
        <div class="w-1/3 h-5/6 bg-transperant flex border-amber-100 border-2 flex-col justify-center items-center p-10 mx-auto my-auto rounded-xl"
            style="box-shadow: 0 0 10px #f59e15;">
            <div class="mb-8 flex flex-col items-center justify-center">
                <img alt="Logo" class="mb-4 size-24 rounded-full border-amber-200 border-2"
                    src="../../../images/logo.png" />
                <h1 class="text-amber-500 text-2xl font-black mb-2">ĐĂNG NHẬP</h1>
                <p class="text-gray-400">Welcome back!</p>
            </div>
            <div class="w-full max-w-sm">
                <form action="" method="POST">
                    <div class="relative mt-2 mb-3 group">
                        <label for="email"
                            class="ml-3 mb-2 font-bold text-gray-600">Email</label>
                        <i class="absolute top-10 left-3 text-2xl text-gray-600 fa-solid fa-envelope"></i>
                        <input type="email" id="email"
                            class="w-full border border-gray-300 py-2 pl-12 pr-5 rounded-lg form-control"
                            name="email" />
                    </div>
                    <div class="relative mb-10 mt-2">
                        <label for="psw" class="ml-3 mb-2 font-bold text-gray-600">Mật
                            khẩu</label>
                        <i class="absolute top-10 left-3 text-2xl text-gray-600 fa-solid fa-lock"></i>
                        <input type="password" id="psw"
                            class="w-full border border-gray-300 py-2 pl-12 pr-5 rounded-lg form-control"
                            name="psw" />
                    </div>
                    <button type="submit" class="w-full text-white py-2 px-4 rounded-lg btn btn-danger hover:cursor-pointer"
                        name="btndn">Đăng
                        nhập</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        for (let i = 0; i < 20; i++) {
            let fallingStart = document.createElement("div");
            fallingStart.classList.add("falling-star");
            document.querySelector(".starfall").appendChild(fallingStart);
        }
    </script>
</body>

</html>