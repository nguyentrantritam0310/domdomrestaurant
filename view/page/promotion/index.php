<title>Khuyến mãi | DomDom - Chuỗi cửa hàng thức ăn nhanh</title>
<?php
require_once "PHPMailer/src/Exception.php";
require_once "PHPMailer/src/PHPMailer.php";
require_once "PHPMailer/src/SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$ctrl = new cMessage;

if (isset($_POST["promotionName"])) {
    $promotion = $_POST["promotionName"];
    $mail = new PHPMailer(true);
    $email = $_POST["emailInput"];
    try {
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = "nmsangtg26@gmail.com";
        $mail->Password = "slsd pceb dgnq xhlv";
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom("nmsangtg26@gmail.com", mb_encode_mimeheader("Chuỗi cửa hàng thức ăn nhanh Đom Đóm", "UTF-8", "B"));
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = mb_encode_mimeheader("Xác nhận ưu đãi (no-reply)", "UTF-8", "B");
        $mail->Body = "Xin chào!<br><br>
                Đây là email xác nhận bạn đã nhận được mã khuyến mãi <strong> $promotion</strong>.<br>
                Hãy đưa voucher này cho nhân viên khi thanh toán để sử dụng nhé! <br> <br>
                
                Trân trọng,<br>
                Đội ngũ hỗ trợ | DomDom";
        $mail->send();

        $ctrl->freeMessageLarge("Vui lòng kiểm tra email! Voucher đã được gửi đến email của bạn.");
    } catch (Exception $e) {
        $ctrl->freeMessageLarge("Đã có lỗi khi gửi mail (" . $mail->ErrorInfo . "). Vui lòng nhập lại!");
    }
    
    $db->close($conn);
}
?>
<style>
    .wheel {
        background: conic-gradient(#FF5733 0% 10%,
                #FFC300 10% 20%,
                #DAF7A6 20% 30%,
                #FF6F61 30% 40%,
                #4CAF50 40% 50%,
                #2196F3 50% 60%,
                #9C27B0 60% 70%,
                #FF9800 70% 80%,
                #E91E63 80% 90%,
                #F44336 90% 100%);
        transition: transform 4s cubic-bezier(0.33, 1, 0.68, 1);
    }

    .swal2-popup {
        width: 50% !important;
    }

    .swal2-html-container {
        color: red !important;
    }

    #arrow {
        position: absolute;
        top: 49%;
        left: 49%;
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-bottom: 15px solid white;
    }

    @import url("https://fonts.googleapis.com/css2?family=Noto+Sans+Symbols+2&display=swap");
    @import url("https://fonts.googleapis.com/css?family=Montserrat:400,700");
    @import url("https://fonts.cdnfonts.com/css/segoe-script");

    #background h1 {
        font-family: "Montserrat", sans-serif;
        font-size: max(25px, 7vw);
        ont-weight: bold;
    }

    hr {
        margin: 0.5em 0;
        height: clamp(2px, 0.5vw, 5px);
        background-image: url(https://images.unsplash.com/photo-1605707157753-c723b9d5af4a?&ixid=M3wzMjM4NDZ8MHwxfHJhbmRvbXx8fHx8fHx8fDE2OTUxNDQ3MzB8&ixlib=rb-4.0.3&w=800&q=80&dpr=2);
        background-position: center;
        background-size: 400px auto;
        background-repeat: repeat;
        border: 0.5px solid rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        animation: bg1 10s linear infinite alternate both;
        filter: saturate(2.2);
    }

    .emoji {
        margin: 0.3em 0;
        font-family: sans-serif;
        font-size: 1.78rem;
        -webkit-text-stroke: 0.5px rgba(0, 0, 0, 0.3);
        text-stroke: 0.5px rgba(0, 0, 0, 0.3);
        color: transparent;
        background-clip: text;
        background-image: url(https://images.unsplash.com/photo-1605707157753-c723b9d5af4a?&ixid=M3wzMjM4NDZ8MHwxfHJhbmRvbXx8fHx8fHx8fDE2OTUxNDQ3MzB8&ixlib=rb-4.0.3&w=800&q=80&dpr=2);
        background-position: center;
        background-size: 200px auto;
        background-repeat: repeat;
        transform: translateZ(0);
        animation: bg1 10s linear infinite alternate both;
        filter: saturate(3);
    }

    #copyright {
        font-size: 0.85rem;
    }

    #background {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        overflow: hidden;
        background-color: white;
        background-image: url(https://images.unsplash.com/photo-1615800098779-1be32e60cca3?crop=entropy&cs=srgb&fm=jpg&ixid=M3wzMjM4NDZ8MHwxfHJhbmRvbXx8fHx8fHx8fDE2OTUyNDAwMTN8&ixlib=rb-4.0.3&q=85);
        background-size: cover;
        background-repeat: no-repeat;
        user-select: none;
        pointer-events: none;
        z-index: -1;
    }

    #background>div {
        --size: 5vw;
        --symbol: "✽";
        --pos_x: 0vw;
        --duration_move: 7s;
        --delay_move: 0s;
        --duration_rotate: 1.5s;
        --delay_rotate: 0s;
        --duration_clip: 10s;
        --delay_clip: 0s;
        --hue: 0deg;

        position: absolute;
        top: 0;
        left: 0;
        font-size: clamp(15px, var(--size), 80px);
        font-family: "Noto Sans Symbols 2", sans-serif;
        transform-origin: center top;
        animation: move var(--duration_move) var(--delay_move) linear infinite normal both;
    }

    #background span {
        display: block;
        position: relative;
        transform-origin: center;
        transform: rotate(0deg);
        animation: rotate var(--duration_rotate) var(--delay_rotate) ease-in-out infinite alternate both;
    }

    #background span:after {
        content: var(--symbol);
        -webkit-text-stroke: 0.5px rgba(0, 0, 0, 0.2);
        text-stroke: 0.5px rgba(0, 0, 0, 0.2);
        line-height: 1.2;
        position: relative;
        display: block;
        color: transparent;
        background-clip: text;
        filter: brightness(1.2) hue-rotate(var(--hue));
        background-image: url(https://images.unsplash.com/photo-1580822115965-0b2532068eff?&ixid=M3wzMjM4NDZ8MHwxfHJhbmRvbXx8fHx8fHx8fDE2OTUxNDUzNzJ8&ixlib=rb-4.0.3&q=100&w=200&dpr=2);
        background-position: center;
        background-size: 200px auto;
        background-repeat: repeat;
        transform: translateZ(0);
        animation: bg1 var(--duration_clip) var(--delay_clip) linear infinite alternate both;
    }

    #background>div:nth-child(even) span:after {
        animation-name: bg2;
    }

    @keyframes bg1 {
        0% {
            background-position: 0% 0%;
        }

        100% {
            background-position: 100% 100%;
        }
    }

    @keyframes bg2 {
        0% {
            background-position: 100% 0%;
        }

        100% {
            background-position: 0% 100%;
        }
    }

    @keyframes rotate {
        0% {
            transform: rotate(115deg);
        }

        100% {
            transform: rotate(245deg);
        }
    }

    @keyframes move {
        0% {
            transform: translate3d(var(--pos_x), calc(0vh - var(--size)), 0);
        }

        100% {
            transform: translate3d(var(--pos_x), 100vh, 0);
        }
    }

    #background>div:nth-child(23n + 1) {
        --symbol: "🟄";
    }

    #background>div:nth-child(23n + 2) {
        --symbol: "❉";
    }

    #background>div:nth-child(23n + 3) {
        --symbol: "🟉";
    }

    #background>div:nth-child(23n + 4) {
        --symbol: "❈";
    }

    #background>div:nth-child(23n + 5) {
        --symbol: "✣";
    }

    #background>div:nth-child(23n + 6) {
        --symbol: "🞯";
    }

    #background>div:nth-child(23n + 7) {
        --symbol: "🟎";
    }

    #background>div:nth-child(23n + 8) {
        --symbol: "♦";
    }

    #background>div:nth-child(23n + 9) {
        --symbol: "✢";
    }

    #background>div:nth-child(23n + 10) {
        --symbol: "🞵";
    }

    #background>div:nth-child(23n + 11) {
        --symbol: "✤";
    }

    #background>div:nth-child(23n + 12) {
        --symbol: "✦";
    }

    #background>div:nth-child(23n + 13) {
        --symbol: "❇";
    }

    #background>div:nth-child(23n + 14) {
        --symbol: "🞻";
    }

    #background>div:nth-child(23n + 15) {
        --symbol: "✶";
    }

    #background>div:nth-child(23n + 16) {
        --symbol: "✳";
    }

    #background>div:nth-child(23n + 17) {
        --symbol: "❊";
    }

    #background>div:nth-child(23n + 18) {
        --symbol: "🟄";
    }

    #background>div:nth-child(23n + 19) {
        --symbol: "✻";
    }

    #background>div:nth-child(23n + 20) {
        --symbol: "❋";
    }

    #background>div:nth-child(23n + 21) {
        --symbol: "✷";
    }

    #background>div:nth-child(23n + 22) {
        --symbol: "✴";
    }

    #background>div:nth-child(21n + 1) {
        --pos_x: 5vw;
    }

    #background>div:nth-child(21n + 2) {
        --pos_x: 10vw;
    }

    #background>div:nth-child(21n + 3) {
        --pos_x: 15vw;
    }

    #background>div:nth-child(21n + 4) {
        --pos_x: 20vw;
    }

    #background>div:nth-child(21n + 5) {
        --pos_x: 25vw;
    }

    #background>div:nth-child(21n + 6) {
        --pos_x: 30vw;
    }

    #background>div:nth-child(21n + 7) {
        --pos_x: 35vw;
    }

    #background>div:nth-child(21n + 8) {
        --pos_x: 40vw;
    }

    #background>div:nth-child(21n + 9) {
        --pos_x: 45vw;
    }

    #background>div:nth-child(21n + 10) {
        --pos_x: 50vw;
    }

    #background>div:nth-child(21n + 11) {
        --pos_x: 55vw;
    }

    #background>div:nth-child(21n + 12) {
        --pos_x: 60vw;
    }

    #background>div:nth-child(21n + 13) {
        --pos_x: 65vw;
    }

    #background>div:nth-child(21n + 14) {
        --pos_x: 70vw;
    }

    #background>div:nth-child(21n + 15) {
        --pos_x: 75vw;
    }

    #background>div:nth-child(21n + 16) {
        --pos_x: 80vw;
    }

    #background>div:nth-child(21n + 17) {
        --pos_x: 85vw;
    }

    #background>div:nth-child(21n + 18) {
        --pos_x: 90vw;
    }

    #background>div:nth-child(21n + 19) {
        --pos_x: 95vw;
    }

    #background>div:nth-child(21n + 20) {
        --pos_x: 100vw;
    }

    #background>div:nth-child(12n + 1) {
        --hue: 30deg;
    }

    #background>div:nth-child(12n + 2) {
        --hue: 270deg;
    }

    #background>div:nth-child(12n + 3) {
        --hue: 90deg;
    }

    #background>div:nth-child(12n + 4) {
        --hue: 150deg;
    }

    #background>div:nth-child(12n + 5) {
        --hue: 330deg;
    }

    #background>div:nth-child(12n + 6) {
        --hue: 180deg;
    }

    #background>div:nth-child(12n + 7) {
        --hue: 60deg;
    }

    #background>div:nth-child(12n + 8) {
        --hue: 210deg;
    }

    #background>div:nth-child(12n + 9) {
        --hue: 120deg;
    }

    #background>div:nth-child(12n + 10) {
        --hue: 240deg;
    }

    #background>div:nth-child(12n + 11) {
        --hue: 300deg;
    }

    #background>div:nth-child(8n + 1) {
        --delay_move: -4s;
    }

    #background>div:nth-child(8n + 2) {
        --delay_move: -5s;
    }

    #background>div:nth-child(8n + 3) {
        --delay_move: -6s;
    }

    #background>div:nth-child(8n + 4) {
        --delay_move: -1s;
    }

    #background>div:nth-child(8n + 5) {
        --delay_move: -2s;
    }

    #background>div:nth-child(8n + 6) {
        --delay_move: -3s;
    }

    #background>div:nth-child(8n + 7) {
        --delay_move: -7s;
    }

    #background>div:nth-child(9n + 1) {
        --duration_move: 7.5s;
    }

    #background>div:nth-child(9n + 2) {
        --duration_move: 8s;
    }

    #background>div:nth-child(9n + 3) {
        --duration_move: 8.5s;
    }

    #background>div:nth-child(9n + 4) {
        --duration_move: 9s;
    }

    #background>div:nth-child(9n + 5) {
        --duration_move: 5.5s;
    }

    #background>div:nth-child(9n + 6) {
        --duration_move: 6s;
    }

    #background>div:nth-child(9n + 7) {
        --duration_move: 6.5s;
    }

    #background>div:nth-child(9n + 8) {
        --duration_move: 7.8s;
    }

    #background>div:nth-child(7n + 1) {
        --delay_rotate: 0.3s;
    }

    #background>div:nth-child(7n + 2) {
        --delay_rotate: 0.6s;
    }

    #background>div:nth-child(7n + 3) {
        --delay_rotate: 0.9s;
    }

    #background>div:nth-child(7n + 4) {
        --delay_rotate: -0.3s;
    }

    #background>div:nth-child(7n + 5) {
        --delay_rotate: -0.6s;
    }

    #background>div:nth-child(7n + 6) {
        --delay_rotate: -0.9s;
    }

    #background>div:nth-child(6n + 1) {
        --duration_rotate: 1s;
    }

    #background>div:nth-child(6n + 2) {
        --duration_rotate: 1.6s;
    }

    #background>div:nth-child(6n + 3) {
        --duration_rotate: 1.1s;
    }

    #background>div:nth-child(6n + 4) {
        --duration_rotate: 1.2s;
    }

    #background>div:nth-child(6n + 5) {
        --duration_rotate: 1.3s;
    }

    #background>div:nth-child(5n + 1) {
        --size: 3vw;
    }

    #background>div:nth-child(5n + 2) {
        --size: 4vw;
    }

    #background>div:nth-child(5n + 3) {
        --size: 6vw;
    }

    #background>div:nth-child(5n + 4) {
        --size: 7vw;
    }

    #title {
        font-size: 2rem;
        font-weight: 900;
        color: tomato;
        --x-offset: -0.0625em;
        --y-offset: 0.0625em;
        --stroke: 0.025em;
        --background-color: white;
        --stroke-color: lightblue;
        text-shadow:
            var(--x-offset) var(--y-offset) 0px var(--background-color),
            calc(var(--x-offset) - var(--stroke)) calc(var(--y-offset) + var(--stroke)) 0px var(--stroke-color);

    }

    @supports (text-shadow: 1px 1px 1px 1px black) {
        #title {
            text-shadow:

                var(--x-offset) var(--y-offset) 0px 0px var(--background-color),

                var(--x-offset) var(--y-offset) var(--stroke) 0px var(--stroke-color);

        }
    }
</style>

<div class="flex flex-col justify-center items-center absolute top-44 left-28">
    <h1 class="font-bold text-3xl mb-4">🎉 Chương Trình Khuyến Mãi 🎉</h1>
    <p class="italic text-lg">Quay để nhận ngay ưu đãi hấp dẫn!</p>
    <div id="wheel" class="wheel size-72 rounded-full mx-auto my-4 border-red-600 border-8 shadow shadow-red-500"></div>
    <img src="images/logo.png" alt="Logo" class="absolute size-10 rounded-full" style="top: 14.8rem; right: 14.3rem;"
        id="img">
    <span id="arrow"></span>
    <button id="spinButton" name="spinButton" class="btn btn-danger px-4 py-2 rounded-xl">Quay Ngay!</button>
</div>

<div class="w-full py-20">
    <div id="background">
        <div><span></span></div>
        <div><span></span></div>
        <div><span></span></div>
        <div><span></span></div>
        <div><span></span></div>
        <div><span></span></div>
        <div><span></span></div>
        <div><span></span></div>
        <div><span></span></div>
        <div><span></span></div>
        <div><span></span></div>
        <div><span></span></div>
        <div><span></span></div>
        <div><span></span></div>
        <div><span></span></div>
        <div><span></span></div>
        <div><span></span></div>
        <div><span></span></div>
        <div><span></span></div>
        <div><span></span></div>
        <div><span></span></div>
        <div><span></span></div>
        <div><span></span></div>
    </div>
    <h2 id="title"
        class="text-center text-3xl font-bold w-1/3 my-0 mx-auto pb-4 rounded-md border-b-4 border-gray-300 border-dotted">
        ƯU ĐÃI ĐANG DIỄN RA</h2>
    <div class="grid grid-cols-1 gap-y-10 w-2/3 mx-auto flex justify-center p-8 rounded-md">
        <?php
        $ctrl = new cPromotions;

        if ($ctrl->cGetAllPromotionGoingOn() != 0) {
            $result = $ctrl->cGetAllPromotionGoingOn();
            $n = 0;
            $order = 1;

            $img_pomotion = "";

            while ($row = $result->fetch_assoc()) {
                if (!file_exists("images/promotion/" . $row["image"]))
                    $img_promotion = "images/nodish.png";
                else
                    $img_promotion = "images/promotion/" . $row["image"];
                $n++;

                echo "<div id='" . $row["promotionID"] . "' class='flex justify-between items-center bg-white relative z-1 w-full rounded-2xl px-8 py-4 shadow transition-transform hover:-translate-y-3'>
                    <img src='" . $img_promotion . "' style='clip-path: polygon(50% 0%, 83% 12%, 100% 43%, 94% 78%, 68% 100%, 32% 100%, 6% 78%, 6% 44%, 17% 12%);' class='h-40 w-48 border-8 border-amber-300  order-" . ($n % 2 == 0 ? $order : $order + 1) . "'/>
                    <div class='text-center order-" . ($n % 2 == 0 ? $order + 1 : $order) . "'>
                        <h2 class='text-[#ff6347] mb-4 text-2xl font-bold'>" . $row["promotionName"] . "</h2>
                        <p class='text-xl my-2'>" . $row["description"] . "</p>
                        <p class='text-gray-500'>(Tối đa " . number_format($row["maxDiscountAmount"], 0, ".", ",") . "đ cho đơn từ 0đ)</p>
                        <p class='text-lg my-2'><strong>Thời gian áp dụng:</strong> Từ " . $row["startDate"] . " đến " . $row["endDate"] . "</p>
                        <p class='text-lg my-2'><strong>Điều kiện áp dụng:</strong> Tất cả hình thức mua hàng</p>
                        <button type='submit' class='btn bg-[#ff6347] text-white rounded-xl text-xl mt-3 transition-all hover:bg-[#e5533d] hover:scale-105'>Đặt món ngay!</button>
                    </div>
                </div>";
            }
        } else
            echo "Không có dữ liệu!";
        ?>
    </div>

    <?php
    $ctrl = new cPromotions;

    if ($ctrl->cGetAllPromotionComming()->num_rows > 0) {
        $result = $ctrl->cGetAllPromotionComming();
        $n = 0;
        $order = 1;

        $img_pomotion = "";
        echo "<h2 id='title' class='text-center text-3xl font-bold w-1/3 mb-0 mx-auto mt-14 pb-4 rounded-md border-b-4 border-gray-300 border-dotted'>ƯU ĐÃI SẮP DIỄN RA</h2>
                <div class='grid grid-cols-1 gap-y-10 w-2/3 mx-auto flex justify-center p-8 rounded-md'>";
        while ($row = $result->fetch_assoc()) {
            if (!file_exists("images/promotion/" . $row["image"]))
                $img_promotion = "images/nodish.png";
            else
                $img_promotion = "images/promotion/" . $row["image"];
            $n++;

            echo "<div id='" . $row["promotionID"] . "' class='flex justify-between items-center bg-white relative z-1 w-full rounded-2xl px-8 py-4 shadow transition-transform hover:-translate-y-3'>
                    <img src='" . $img_promotion . "' style='clip-path: polygon(50% 0%, 83% 12%, 100% 43%, 94% 78%, 68% 100%, 32% 100%, 6% 78%, 6% 44%, 17% 12%);' class='h-40 w-48 border-8 border-amber-300  order-" . ($n % 2 == 0 ? $order : $order + 1) . "'/>
                    <div class='text-center order-" . ($n % 2 == 0 ? $order + 1 : $order) . "'>
                        <h2 class='text-[#ff6347] mb-4 text-2xl font-bold'>" . $row["promotionName"] . "</h2>
                        <p class='text-xl my-2'>" . $row["description"] . "</p>
                        <p class='text-gray-500'>(Tối đa " . number_format($row["maxDiscountAmount"], 0, ".", ",") . "đ cho đơn từ 0đ)</p>
                        <p class='text-lg my-2'><strong>Thời gian áp dụng:</strong> Từ " . $row["startDate"] . " đến " . $row["endDate"] . "</p>
                        <p class='text-lg my-2'><strong>Điều kiện áp dụng:</strong> Tất cả hình thức mua hàng</p>
                        <button type='submit' class='btn bg-[#ff6347] text-white rounded-xl text-xl mt-3 transition-all hover:bg-[#e5533d] hover:scale-105'>Đặt món ngay!</button>
                    </div>
                </div>";
        }
    }
    ?>
</div>
</div>

<script>
    const promotions = [
        "Giảm 10% cho đơn hàng đầu tiên!",
        "Mua 1 tặng 1 cho món ăn bất kỳ!",
        "Giảm 20% cho 1 nước uống bất kỳ!",
        "Tặng nước ngọt khi mua burger!",
        "Giảm 15% cho đơn hàng trên 200k!",
        "Nhận miễn phí 1 phần khoai tây chiên!",
        "Giảm 30% khi mua combo mì ý + coca!",
        "Giảm 25% cho đơn hàng online!",
        "Tặng voucher 50k cho lần mua tiếp theo!",
        "Giảm 5% cho khách hàng thân thiết!"
    ];

    const spinButton = document.getElementById("spinButton");
    const wheel = document.getElementById("wheel");

    spinButton.addEventListener("click", () => {
        const randomDegree = Math.floor(Math.random() * 360 + 720);
        wheel.style.transition = "transform 4s ease-out";
        wheel.style.transform = `rotate(${randomDegree}deg)`;

        setTimeout(() => {
            wheel.style.transition = "none";
            wheel.style.transform = `rotate(${randomDegree % 360}deg)`;

            const degreePerPromotion = 360 / promotions.length;
            const currentDegree = randomDegree % 360;
            const promotionIndex = Math.floor((currentDegree + (degreePerPromotion / 2)) / degreePerPromotion) % promotions.length;

            Swal.fire({
                title: "Chúc mừng!",
                html: `
                <p>Vui lòng nhập email của bạn để nhận voucher: <br> ${promotions[promotionIndex]}</p>
                <form method='POST' id='formHidden'>
                    <input type='hidden' id='hidden' name='promotionName'>
                    <input type="email" id="emailInput" name='emailInput' class="swal2-input" placeholder="Email của bạn" required>
                </form>`,
                icon: "success",
                confirmButtonText: "Xác nhận",
                showCancelButton: true,
                cancelButtonText: "Hủy",
                preConfirm: () => {
                    const email = Swal.getPopup().querySelector("#emailInput").value;
                    if (!email || !/\S+@\S+\.\S+/.test(email)) {
                        Swal.showValidationMessage("Vui lòng nhập một địa chỉ email hợp lệ");
                    }
                }
            }).then((result) => {
                document.getElementById("hidden").value = promotions[promotionIndex];
                document.getElementById("formHidden").submit();
            });
        }, 4000);
    });
</script>