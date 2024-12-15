<?php
require_once "PHPMailer/src/Exception.php";
require_once "PHPMailer/src/PHPMailer.php";
require_once "PHPMailer/src/SMTP.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST["submit"])) {
    $email = $_POST["email"];

    $mail = new PHPMailer(true);
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
        $mail->Subject = mb_encode_mimeheader("Xác nhận đăng ký nhận khuyến mại mới nhất (no-reply)", "UTF-8", "B");
        $mail->Body = "Xin chào!<br><br>
            Đây là email xác nhận bạn đã đăng ký nhận khuyến mãi mới nhất từ chúng tôi.<br>
            Chúng tôi sẽ gửi mã khuyến mãi cho bạn vào địa chỉ email này ngay khi được cập nhật. Hãy kiểm tra email thường xuyên để không bỏ lỡ những ưu đãi hấp dẫn từ chúng tôi nhé!</a><br><br>
            Nếu bạn không yêu cầu điều này, vui lòng bỏ qua email này!<br><br>
            Trân trọng,<br>
            Đội ngũ hỗ trợ | DomDom";

        $mail->send();
        echo "<script>alert('Đăng ký thành công. Vui lòng kiểm tra email của bạn!');</script>";
    } catch (Exception $e) {
        echo "Lỗi khi gửi email: {$mail->ErrorInfo}";
    }
}

?>

<!-- On top button -->
<button class="fixed bottom-10 right-4 flex justify-center items-center text-black bg-gray-300 border-2 border-black rounded-full size-10 z-20 transition ease opacity-60 hover:opacity-900"
    onclick="scrollToTop()" id="onTopBtn">
    <i class="fas fa-level-up-alt size-6"></i>
    <!-- <i class="far fa-circle-up size-10"></i> -->
</button>

<!-- Footer -->
<footer class="pt-12 bottom-0 bg-amber-500 text-white">
    <div class="mx-auto w-full px-4 pb-8 pt-8 sm:px-6 lg:px-8">
        <div class="mx-auto">
            <h3 class="block text-center text-xl font-bold text-orange-700 sm:text-3xl">
                Đăng ký ngay để nhận được ưu đãi mới nhất từ chúng tôi
            </h3>

            <form class="mt-6" method="POST">
                <div class="relative w-1/2 mx-auto">
                    <label class="sr-only" for="email"> Email </label>

                    <input
                        class="w-full rounded-full outline-emerald-300 bg-gray-100 text-gray-500 p-4 pe-32 text-md font-medium"
                        name="email" type="email" id="email" placeholder="example@gmail.com" />

                    <button
                        class="absolute end-1 top-1/2 -translate-y-1/2 rounded-full btn btn-warning px-5 py-3 text-sm font-medium text-white transition"
                        name="submit"> Đăng ký
                    </button>
                </div>
            </form>
        </div>

        <div class="mt-16 grid grid-cols-1 gap-8 lg:grid-cols-2 lg:gap-32">
            <div class="mx-auto max-w-sm lg:max-w-none">
                <p class="text-gray-600 lg:text-left lg:text-lg">
                    Thiên lý ơi.
                    Em có thể ở lại đây không. <br>
                    Biết chăng ngoài trời mưa giông.
                    Nhiều cô đơn lắm em. <br>
                    Thiên lý ơi.
                    Anh chỉ mong người bình yên thôi. <br>
                    Nắm tay ghì chặt đôi môi.
                    Rồi ngồi giữa lưng đồi.
                </p>

                <div class="mt-6 flex gap-4">
                    <a class="text-gray-700 transition hover:text-gray-700/75" href="https://www.facebook.com"
                        target="_blank" rel="noreferrer">
                        <span class="sr-only"> Facebook </span>

                        <svg class="size-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>

                    <a class="text-gray-700 transition hover:text-gray-700/75" href="https://www.instagram.com"
                        target="_blank" rel="noreferrer">
                        <span class="sr-only"> Instagram </span>

                        <svg class="size-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>

                    <a class="text-gray-700 transition hover:text-gray-700/75" href="https://www.twitter.com"
                        target="_blank" rel="noreferrer">
                        <span class="sr-only"> Twitter </span>

                        <svg class="size-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path
                                d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                        </svg>
                    </a>

                    <a class="text-gray-700 transition hover:text-gray-700/75" href="https://www.github.com"
                        target="_blank" rel="noreferrer">
                        <span class="sr-only"> GitHub </span>

                        <svg class="size-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>

                    <a class="text-gray-700 transition hover:text-gray-700/75" href="https://www.tiktok.com"
                        target="_blank" rel="noreferrer">
                        <span class="sr-only"> Tiktok </span>

                        <svg class="size-6" fill="currentColor" width="800px" height="800px" viewBox="0 0 512 512"
                            id="icons" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M412.19,118.66a109.27,109.27,0,0,1-9.45-5.5,132.87,132.87,0,0,1-24.27-20.62c-18.1-20.71-24.86-41.72-27.35-56.43h.1C349.14,23.9,350,16,350.13,16H267.69V334.78c0,4.28,0,8.51-.18,12.69,0,.52-.05,1-.08,1.56,0,.23,0,.47-.05.71,0,.06,0,.12,0,.18a70,70,0,0,1-35.22,55.56,68.8,68.8,0,0,1-34.11,9c-38.41,0-69.54-31.32-69.54-70s31.13-70,69.54-70a68.9,68.9,0,0,1,21.41,3.39l.1-83.94a153.14,153.14,0,0,0-118,34.52,161.79,161.79,0,0,0-35.3,43.53c-3.48,6-16.61,30.11-18.2,69.24-1,22.21,5.67,45.22,8.85,54.73v.2c2,5.6,9.75,24.71,22.38,40.82A167.53,167.53,0,0,0,115,470.66v-.2l.2.2C155.11,497.78,199.36,496,199.36,496c7.66-.31,33.32,0,62.46-13.81,32.32-15.31,50.72-38.12,50.72-38.12a158.46,158.46,0,0,0,27.64-45.93c7.46-19.61,9.95-43.13,9.95-52.53V176.49c1,.6,14.32,9.41,14.32,9.41s19.19,12.3,49.13,20.31c21.48,5.7,50.42,6.9,50.42,6.9V131.27C453.86,132.37,433.27,129.17,412.19,118.66Z" />
                        </svg>
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-8 text-center lg:grid-cols-3 lg:text-left">
                <div>
                    <strong class="font-bold border-b border-gray-500/75 pb-1 text-gray-900 uppercase uppercase"> Chính
                        sách </strong>

                    <ul class="mt-6 space-y-1">
                        <li>
                            <a href="#" class="text-gray-700 transition hover:text-gray-700/75"> Thanh toán </a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-700 transition hover:text-gray-700/75"> Bảo mật </a>
                        </li>
                    </ul>
                </div>

                <div>
                    <strong class="font-bold border-b border-gray-500/75 pb-1 text-gray-900 uppercase"> Thông tin
                    </strong>

                    <ul class="mt-6 space-y-1">
                        <li>
                            <a class="text-gray-700 transition hover:text-gray-700/75" href="#">12 Nguyen Van Bao,
                                GV</a>
                        </li>
                        <li>
                            <a class="text-gray-700 transition hover:text-gray-700/75" href="#">(028) 2236 4456</a>
                        </li>
                        <li>
                            <a class="text-gray-700 transition hover:text-gray-700/75"
                                href="#">contact@fireflies.gmail.com</a>
                        </li>
                    </ul>
                </div>

                <div>
                    <strong class="font-bold border-b border-gray-500/75 pb-1 text-gray-900 uppercase"> Hỗ trợ </strong>

                    <ul class="mt-6 space-y-1">
                        <li>
                            <a class="text-gray-700 transition hover:text-gray-700/75" href="#"> FAQs </a>
                        </li>

                        <li>
                            <a class="text-gray-700 transition hover:text-gray-700/75" href="#"> Đặt hàng </a>
                        </li>

                        <li>
                            <a class="text-gray-700 transition hover:text-gray-700/75" href="#"> Chat </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="mt-8 border-t border-gray-100 pt-8">
            <p class="text-center text-xs/relaxed text-white/75 italic">
                © DOMDOM 2024. All rights reserved.
            </p>
        </div>
    </div>
</footer>
<script>
    window.addEventListener("scroll", function () {
        if (window.scrollY > 50) {
            document.querySelector("header").classList.add("scrolled");
        } else {
            document.querySelector("header").classList.remove("scrolled");
        }
    });

    function scrollToTop() {
        const scrollStep = -window.scrollY / 15;
        const scrollInterval = setInterval(function () {
            if (window.scrollY != 0) {
                window.scrollBy(0, scrollStep);
            } else {
                clearInterval(scrollInterval);
            }
        }, 15);
    }

    window.onscroll = function () {
        scrollFunction();
    };

    function scrollFunction() {
        if (
            document.body.scrollTop > 100 ||
            document.documentElement.scrollTop > 100
        ) {
            document.getElementById("onTopBtn").style.display = "block";
        } else {
            document.getElementById("onTopBtn").style.display = "none";
        }
    }

    const navlinks = document.querySelectorAll(".nav-link");
    let idActive = "home";

    navlinks.forEach(function (e) {
        e.style.color = "var(--secondary-color)";
    });

    navlinks.forEach(function (item) {
        item.addEventListener("click", () => {
            navlinks.forEach((i) => i.classList.remove("active"));
        });
    });

    if (window.location.search != "")
        idActive = window.location.search.slice(3);

    if (window.location.search.includes("dish"))
        idActive = "dish";

    if (window.location.search.includes("promotion"))
        idActive = "promotion";

    window.addEventListener("load", () => {
        navlinks.forEach(function (item) {
            if (item.id == idActive) item.classList.add("active");
            else item.classList.remove("active");
        });
    });

    function decrease(button) {
        let quantityElement = button.parentNode.querySelector("#quantityCart");
        let value = parseInt(quantityElement.textContent, 10);
        if (value > 1) {
            value--;
            quantityElement.textContent = value;
        }
    }

    function increase(button) {
        let quantityElement = button.parentNode.querySelector("#quantityCart");
        let value = parseInt(quantityElement.textContent, 10);
        value++;
        quantityElement.textContent = value;
    }

    document.addEventListener("readystatechange", () => {
        const progressBar = document.getElementById("progress-bar");

        if (document.readyState === "interactive") {
            progressBar.style.width = "50%";
        } else if (document.readyState === "complete") {
            progressBar.style.width = "100%";
            setTimeout(() => {
                progressBar.style.opacity = "0";
            }, 500);
        }
    });
</script>
</body>

</html>