<title>Trang chủ | DomDom - Chuỗi cửa hàng thức ăn nhanh</title>

<style>
  .container form {
    min-height: 100% !important;
  }
</style>

<div class="search absolute top-52 left-16">
  <form action="#ci" method="post" class="form-search">
    <section class="content-home">
      <h1 class="text-center my-4 leading-relaxed text-5xl">THÈM MÓN GÌ, <br> <span id="text">NGẠI CHI MÀ KHÔNG
          NÓI?</span></h1>
      <div class="content w-full flex justify-center text-xl">
        <div class=" flex items-center w-full h-14 rounded-lg shadow-red-200 shadow-md bg-white pr-4 pl-2">
          <div class="grid place-items-center h-full w-12 text-gray-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
          </div>

          <input class="peer h-full w-full outline-none text-base text-gray-700 px-2" type="search" id="search"
            name="search" value="<?php echo $_POST["search"]; ?>" placeholder="Gà rán, 15000, Mì,..." />
        </div>
    </section>
  </form>
</div>

<?php
$input = "";
if (isset($_POST["search"])) {
  $input = $_POST["search"];

  if ($input != "") {
    echo "<section class='w-3/4 mx-auto mt-16 mb-12'>
            <h2 class='border-b border-gray-500 text-2xl font-bold px-2 py-4'>KẾT QUẢ DÀNH CHO: " . $input . "</h2>";
    $ctrl = new cDishes;

    if ($ctrl->cSearchDish($input) != 0) {
      $result = $ctrl->cSearchDish($input);
      $n = $result->num_rows;

      if ($n > 0) {

        echo "<div class='grid grid-cols-4 gap-x-14 gap-y-10 my-4'>";
        $img_dish = "";

        while ($row = $result->fetch_assoc()) {
          $img_dish = "images/dish/" . $row["image"];
          if (!file_exists($img_dish))
            $img_dish = "images/nodish.png";

          $price = str_replace(".00", "", number_format($row["price"], "2", ".", ","));
          echo "<div class='w-full bg-white shadow rounded-lg hover:scale-105 transition delay-150'>
                        <a href='index.php?p=dish&i=" . $row["dishID"] . "'>
                    <div class='h-40 w-full bg-gray-200 flex flex-col justify-between p-4 bg-cover bg-center border-2 border-red-100 rounded-t-lg' style='background-image: url(" . $img_dish . ")'>
                    </div>
                    <div class='px-4 pt-2 pb-4 flex flex-col items-center'>
                      <p class='text-gray-400 font-light text-xs text-center'>" . $row["dishCategory"] . "</p>
                      <h1 class='text-orange-600 font-bold text-center h-10 mt-1'>" . $row["dishName"] . "</h1>
                      <p class='text-center text-red-600 mt-1'>" . str_replace(".00", "", number_format($row["price"], "2", ".", ",")) . " đ</p>
                      <button type='submit' class='py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-600 active:bg-blue-700 disabled:opacity-50 mt-4 w-full flex items-center justify-center'>
                        Thêm
                        <svg
                          xmlns='http://www.w3.org/2000/svg'
                          class='h-6 w-6 ml-2'
                          fill='none'
                          viewBox='0 0 24 24'
                          stroke='currentColor'
                          >
                          <path
                            stroke-linecap='round'
                            stroke-linejoin='round'
                            stroke-width='2'
                            d='M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z'
                          />
                        </svg>
                      </button>
                    </div>
                    </a>
                  </div>";
        }
        echo "</div>";
      }
    } else
      echo "Không có dữ liệu!";

    if ($n == 0 && $m == 0) {
      echo "<div class='grid grid-cols-1 w-full my-4'><h5 class='font-bold'>Xin lỗi! Chúng tôi không tìm thấy kết quả bạn cần!</h5></div>";
      $_POST["search"] = "";
    }

    echo "</section>";
  }
} else
  $_POST["search"] = "";
?>

<main class="container">
  <section class="products overflow-hidden">
    <div class="container mx-auto text-center pt-10 my-4">
      <h1 class="text-3xl font-bold mb-6">DANH MỤC SẢN PHẨM</h1>
      <hr class="border-t-2" style="width: 40%; margin: 0 auto 40px; border-color: var(--fourth-color);">
      <div class="grid grid-cols-6 gap-x-5 gap-y-2">
        <?php
        $ctrl = new cDishes;
        if ($ctrl->cGetAllCategory() != 0) {
          $result = $ctrl->cGetAllCategory();
          $count = 0;
          $border = "";
          $img_dish = "";

          while ($row = $result->fetch_assoc()) {
            $count++;
            if ($count % 2 == 0)
              $border = "#FFA726";
            else
              $border = "#EF5350";
            $img_dish = "images/dish/" . $row["image"];
            if (!file_exists($img_dish))
              $img_dish = "images/nodish.png";
            echo "
                    <div class='text-center product-category group'>
                        <a class='flex flex-col items-center' href='index.php?p=dish&c=" . $row["dishCategory"] . "&#ci'>
                            <div class='relative'>
                            <img alt='' class='rounded-full size-52' style='border-width: 12px; border-left: 0; border-color: " . $border . ";' src='" . $img_dish . "'/>
                            </div>
                            <div class='title-product py-2 px-4 rounded-lg w-96 group-hover:translate-y-0 delay-150 ease-linear'>
                            <h2 class='text-2xl text-center text-amber-600 font-bold uppercase'>" . $row["dishCategory"] . "</h2>
                            </div>
                        </a>
                    </div>";
          }
        } else
          "Không có dữ liệu!";
        ?>
      </div>
    </div>
  </section>
  <section class="my-16">
    <h2 class="text-center text-3xl font-bold mb-6">KHUYẾN MÃI ĐANG DIỄN RA</h2>
    <hr class="border-t-2" style="width: 40%; margin: 0 auto 40px; border-color: var(--fourth-color);">
    <div class="grid grid-cols-4 gap-5 gap-x-24 mt-32 w-full">
      <?php
      $ctrl = new cPromotions;
      if ($ctrl->cGetAllPromotionGoingOn() != 0) {
        $result = $ctrl->cGetAllPromotionGoingOn();

        $count = 0;
        $bg = "";
        $color = "";
        $img_pomotion = "";

        while ($row = $result->fetch_assoc()) {
          $count++;
          $img_pomotion = "images/promotion/" . $row["image"];
          if (!file_exists($img_pomotion))
            $img_pomotion = "images/nodish.png";

          if ($count % 2 == 0) {
            $bg = "#EF5350";
            $color = "rgb(255, 255, 255)";
          } else {
            $bg = "rgba(255, 255, 255, 0.8)";
            $color = "#EF5350";
          }

          $id = $row["promotionID"] - 1;

          echo "
              <div class='rounded-3xl mb-20 pb-6 h-fit hover:scale-110 delay-150 ease-linear transition-all' style='background-color: " . $bg . "; color: " . $color . ";'>
                  <a class='relative flex flex-col items-center' href='index.php?p=promotion#" . $id . "'>
                    <img alt='" . $row["promotionName"] . "' class='rounded-full size-40 absolute bottom-24 border-amber-400 border-2' src='" . $img_pomotion . "'/>
                    <h2 class='text-lg font-semibold mt-20 mb-2'>" . $row["promotionName"] . "</h2>
                    <p class='text-md text-center px-2 h-12'>" . $row["description"] . "</p>
                  </a>
              </div>";
        }
      } else
        echo "Không có dữ liệu!";
      ?>
    </div>
  </section>
</main>