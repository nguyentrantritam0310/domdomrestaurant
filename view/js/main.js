$(document).ready(function () {
  // TRÍ TÂM
  // đổi đơn vị tính
  let rowId = 0;
  $("#ma-" + rowId).val($(`#cateIngredient-${rowId}`).find("option:selected").data("id"));
  $(`#unit-${rowId}`).val($(`#cateIngredient-${rowId}`).val());
  $(document).on("change", `#cateIngredient-${rowId}`, function () {
    var rowId = $(this).attr("data-row-id");
    var ingredientId = $(this).find("option:selected").data("id");
    var selectedValue = $(`#cateIngredient-${rowId}`).val();
    $("#ma-" + rowId).val(ingredientId);
    $(`#unit-${rowId}`).val(selectedValue);
  });

  // thêm hàng cho tablebutton
  $("#addRowBtn").click(function () {
    rowId++;
    var options = $("#ingredientOptions").html();
    var table = $("#tableIngredient");

    var newRow = `
    <tr>
    <td></td>
                                        <td></td>
                                        <td></td>
    <td><span id="error-quantity-${rowId}" class="text-red-500 error-message"></span></td></tr>
             <tr>
                <td> 
                <input name="ingredientIds[]" type="text" id="ma-${rowId}" class="clsNLThem w-20 form-control bg-gray-100" readonly></td>
                    
                    <td>
                <select class="clsIngreName" name="ingredient[]" id="cateIngredient-${rowId}" data-row-id="${rowId}" class="w-full form-control"
                    >
                    ${options}
                </select>
                </td>
                    <td> 
                <input type="text" id="unit-${rowId}" class="clsDVT w-full form-control bg-gray-100" readonly></td>
                    <td>
                <input type="number" class="w-full form-control quantityIngre" id="quantityIngre-${rowId}" name="quantity[]"></td>
                <td>
                    <a href="javascript:void(0);" class="deleteRowBtn"><i class="fa-solid fa-circle-minus text-danger text-xl text-center w-full"></i></a>
                </td>
                </tr>`;

    table.append(newRow);
    $("#ma-" + rowId).val($(`#cateIngredient-${rowId}`).find("option:selected").data("id"));
    $(`#unit-${rowId}`).val($(`#cateIngredient-${rowId}`).val());
    $(`#cateIngredient-${rowId}`).change(function () {
      var rowId = $(this).attr("data-row-id");
      var ingredientId = $(this).find("option:selected").data("id");
      var selectedValue = $(`#cateIngredient-${rowId}`).val();
      $("#ma-" + rowId).val(ingredientId);
      $(`#unit-${rowId}`).val(selectedValue);
    });

    updateQuantityInputs();

  });

  // đổi đơn vị tính
  let u_rowId = $("#u_countIngreDish").val();
  for (var i=0; i< u_rowId;i++) {
    $("#u-ma-" + i).val($(`#u-cateIngredient-${i}`).find("option:selected").data("id"));
    $(`#u-unit-${i}`).val($(`#u-cateIngredient-${i}`).val());
    $(document).on("change", `#u-cateIngredient-${i}`, function () {
      var u_rowId = $(this).attr("data-row-id");
      var ingredientId = $(this).find("option:selected").data("id");
      var selectedValue = $(`#u-cateIngredient-${u_rowId}`).val();
      $("#u-ma-" + u_rowId).val(ingredientId);
      $(`#u-unit-${u_rowId}`).val(selectedValue);
      console.log(selectedValue);
      console.log(ingredientId);
    });
  }
  $("#u-ma-" + u_rowId).val($(`#u-cateIngredient-${u_rowId}`).find("option:selected").data("id"));
  $(`#u-unit-${u_rowId}`).val($(`#u-cateIngredient-${u_rowId}`).val());
  $(document).on("change", `#u-cateIngredient-${u_rowId}`, function () {
    var u_rowId = $(this).attr("data-row-id");
    var ingredientId = $(this).find("option:selected").data("id");
    var selectedValue = $(`#u-cateIngredient-${u_rowId}`).val();
    $("#u-ma-" + u_rowId).val(ingredientId);
    $(`#u-unit-${u_rowId}`).val(selectedValue);
    console.log(selectedValue);
    console.log(ingredientId);
  });

  // thêm hàng cho tablebutton
  $("#u-addRowBtn").click(function () {
    u_rowId++;
    var options = $("#u-ingredientOptions").html();
    var table = $("#u-tableIngredient");

    var newRow = `
    <tr>
    <td></td>
                                        <td></td>
                                        <td></td>
    <td><span id="uerror-quantity-${u_rowId}" class="text-red-500 error-message"></span></td></tr>
            <tr>
                <td> 
                <input name="u-ingredientIds[]" type="text" id="u-ma-${u_rowId}" class="w-20 form-control bg-gray-100" readonly></td>
                    
                    <td>
                <select name="u-ingredient[]" id="u-cateIngredient-${u_rowId}" data-row-id="${u_rowId}" class="w-full form-control"
                    >
                    ${options}
                </select>
                </td>
                    <td> 
                <input type="text" id="u-unit-${u_rowId}" class="w-full form-control bg-gray-100" readonly></td>
                    <td>
                <input type="number" id="uquantityIngre-${u_rowId}" class="w-full form-control" name="u-quantity[]"></td>
                <td>
                    <a href="javascript:void(0);" class="deleteRowBtn"><i class="fa-solid fa-circle-minus text-danger text-xl text-center w-full"></i></a>
                </td>
            </tr>`;
    table.append(newRow);

    $("#u-ma-" + u_rowId).val($(`#u-cateIngredient-${u_rowId}`).find("option:selected").data("id"));
    $(`#u-unit-${u_rowId}`).val($(`#u-cateIngredient-${u_rowId}`).val());
    $(`#u-cateIngredient-${u_rowId}`).change(function () {
      var u_rowId = $(this).attr("data-row-id");
      var ingredientId = $(this).find('option:selected').data('id');
      var selectedValue = $(this).val();
      $('#u-ma-' + u_rowId).val(ingredientId);
      $(`#u-unit-${u_rowId}`).val(selectedValue);
    });

    updateuQuantityInputs();
  });

  // xóa hàng cho tablebutton
  $(document).on("click", ".deleteRowBtn", function () {
    $(this).closest("tr").prev("tr").remove();
    $(this).closest("tr").remove();
  });

  // Cập nhật tổng tiền
  function updateTotal() {
    let total = 0;
    const quantities = $(".quantity-input");
    quantities.each(function () {
      const price = parseFloat($(this).data("unit-price"));
      const qty = parseInt($(this).val()) || 0;
      total += price * qty;
    });
    updatedTotal = parseFloat(total);
    $("#tongTienCheck").val(total.toLocaleString("vi-VN") + "đ");
    $("#tongTienCheck").attr("value", total);
  }
  $(".quantity-input").on("change", function () {
    updateTotal();
    console.log($("#tongTienCheck").val());
  });

  // Ngăn nhập số nhỏ hơn 1 khi gõ từ bàn phím
  $(".quantity-input").on("keypress", function (e) {
    const char = String.fromCharCode(e.which);
    if (!/^[1-9]$/.test(char)) {
      e.preventDefault();
    }
  });
  // lưu thông tin theo dõi đơn hàng
  let currentTotal = parseFloat($("#currentTotal").val());
  let updatedTotal;
  if (updatedTotal === undefined) {
    updatedTotal = currentTotal;
  }

  $(".quantity-input").on("input", function () {
    if ($(this).val() < 1) {
      $(this).val(1);
    }
  });

  $("#btnLuuThongTin").on("click", function () {
    if (updatedTotal > currentTotal) {
      $(".thanhtoanthem").html(
        `Bạn cần thanh toán thêm ${(updatedTotal - currentTotal).toLocaleString(
          "vi-VN"
        )}đ`
      );
      if ($("#statusOrder0").val() == 0) {
        $("#followDetailModal").modal("hide");
        $("#checkoutModal1").modal("show");
        $("#btnThanhToan1").on("click", function () {
          $("#infoOrder").submit();
        });
      } else if ($("#statusOrder1").val() == 1) {
        $("#infoOrder").submit();
        $("#followDetailModal").modal("show");
      }
    } else if (updatedTotal < currentTotal) {
      if ($("#statusOrder0").val() == 0) {
        setTimeout(function () {
          $("#infoOrder").submit();
        }, 3000);
        alert(
          `Chúng tôi sẽ hoàn trả số tiền dư ${Math.abs(
            updatedTotal - currentTotal
          ).toLocaleString("vi-VN")}đ vào tài khoản của bạn trong vòng 24 giờ.`
        );
      } else if ($("#statusOrder1").val() == 1) {
        $("#infoOrder").submit();
        $("#followDetailModal").modal("show");
      }
    } else {
      $("#infoOrder").submit();
    }
  });

  // REGEX
  // regex UC chuyen nguyen lieu tu cua hang thua sang cua hang thieu
  function ktStore() {
    let storeThua = $("#txtStoreThua").val()
    let storeThieu = $("#txtStoreThieu").val()
    if (storeThua === "") {
      $("#errStore").html("Cửa hàng không được rỗng")
      return false
    } else if (storeThieu === "") {
      $("#errStore").html("Cửa hàng không được rỗng")
      return false
    } else if (storeThieu === storeThua) {
      $("#errStore").html("Cửa hàng thiếu phải khác cửa hàng thừa")
      return false
    } else {
      $("#errStore").html("*")
      return true
    }
  }

  function ktQuantityInStock() {
    let quantityInStock = $("#txtQuantityInStock").val()
    let quantityThua = $("#txtStoreThua").find(":selected").data("quantity")
    if (quantityInStock === "") {
      $("#errQuantityInStock").html("Số lượng không được rỗng")
      return false
    } else if (Number(quantityInStock) > quantityThua) {
      $("#errQuantityInStock").html("Số lượng chuyển không được lớn hơn số lượng tồn cửa hàng thừa")
      return false
    } else if (Number(quantityInStock) < 1) {
      $("#errQuantityInStock").html("Số lượng chuyển không được nhỏ hơn 1")
      return false
    } else {
      $("#errQuantityInStock").html("*")
      return true
    }
  }

  $("#txtStoreThua").blur(function () {
    ktStore()
  })

  $("#txtStoreThieu").blur(function () {
    ktStore()
  })

  $("#txtQuantityInStock").blur(function () {
    ktQuantityInStock()
  })

  $("#form-SLT").on("submit", function (event) {
    let isValid = false;
    if (ktStore() && ktQuantityInStock()) {
      isValid = true;
    }
    if (!isValid) {
      event.preventDefault();
      alert("Thông tin không hợp lệ")
    }
  });

  // regex UC Thêm món ăn
  function ktDishName() {
    let dishName = $("#iDishName").val()
    if (dishName.length === 0) {
      $("#ierrDishName").html("Tên món ăn không được rỗng")
      return false
    } else {
      $("#ierrDishName").html("*")
      return true
    }
  }

  function ktDishPrice() {
    let dishPrice = $("#iDishPrice").val()
    if (dishPrice === "") {
      $("#ierrDishPrice").html("Giá bán không được rỗng")
      return false
    } else if (Number(dishPrice) < 0) {
      $("#ierrDishPrice").html("Giá bán không được nhỏ hơn 0")
      return false
    } else {
      $("#ierrDishPrice").html("*")
      return true
    }
  }

  function ktQuantity(index) {
    let quantity = $("#quantityIngre-" + index).val();
    let errorElement = $("#error-quantity-" + index);
    if (quantity === "") {
      errorElement.html("Số lượng không được rỗng");
      return false;
    } else if (Number(quantity) < 0) {
      errorElement.html("Số lượng phải lớn hơn 0");
      return false;
    } else {
      errorElement.html("");
      return true;
    }
  }

  function ktDishDescription() {
    let dishName = $("#iDishDescription").val()
    if (dishName.length === 0) {
      $("#ierrDishDescription").html("Mô tả không được rỗng")
      return false
    } else {
      $("#ierrDishDescription").html("*")
      return true
    }
  }

  function ktDishProcess() {
    let dishName = $("#iDishProcess").val()
    if (dishName.length === 0) {
      $("#ierrDishProcess").html("Quy trình chế biến không được rỗng")
      return false
    } else {
      $("#ierrDishProcess").html("*")
      return true
    }
  }

  $("#iDishName").blur(function () {
    ktDishName()
  })

  $("#iDishDescription").blur(function () {
    ktDishDescription()
  })

  $("#iDishProcess").blur(function () {
    ktDishProcess()
  })

  $("#iDishPrice").blur(function () {
    ktDishPrice()
  })

  function updateQuantityInputs() {
    for (let i = 0; i <= rowId; i++) {
      $("#quantityIngre-" + i).blur(function () {
        ktQuantity(i);
      });
    }
  }
  updateQuantityInputs();

  $("#form-themmonan").on("submit", function (event) {
    let isValid = false;
    if (ktDishName() && ktDishDescription() && ktDishProcess() && ktDishPrice()) {
      for (let u = 0; u <= rowId; u++) {
        if (ktQuantity(u))
          isValid = true;
        else {
          isValid = false;
          break;

        }
      }
    }
    if (!isValid) {
      event.preventDefault();
      alert("Thông tin không hợp lệ")
    }
  });

  // regex UC Sửa món ăn
  function ktuDishName() {
    let dishName = $("#uDishName").val()
    if (dishName.length === 0) {
      $("#uerrDishName").html("Tên món ăn không được rỗng")
      return false
    } else {
      $("#uerrDishName").html("*")
      return true
    }
  }

  function ktuDishPrice() {
    let dishPrice = $("#uDishPrice").val()
    if (dishPrice === "") {
      $("#uerrDishPrice").html("Giá bán không được rỗng")
      return false
    } else if (Number(dishPrice) < 0) {
      $("#uerrDishPrice").html("Giá bán không được nhỏ hơn 0")
      return false
    } else {
      $("#uerrDishPrice").html("*")
      return true
    }
  }

  function ktuQuantity(index) {
    let quantity = $("#uquantityIngre-" + index).val();
    let errorElement = $("#uerror-quantity-" + index);
    if (quantity === "") {
      errorElement.html("Số lượng không được rỗng");
      return false;
    } else if (Number(quantity) < 0) {
      errorElement.html("Số lượng phải lớn hơn 0");
      return false;
    } else {
      errorElement.html("");
      return true;
    }
  }

  function ktuDishDescription() {
    let dishName = $("#uDishDescription").val()
    if (dishName.length === 0) {
      $("#uerrDishDescription").html("Mô tả không được rỗng")
      return false
    } else {
      $("#uerrDishDescription").html("*")
      return true
    }
  }

  function ktuDishProcess() {
    let dishName = $("#uDishProcess").val()
    if (dishName.length === 0) {
      $("#uerrDishProcess").html("Quy trình chế biến không được rỗng")
      return false
    } else {
      $("#uerrDishProcess").html("*")
      return true
    }
  }

  $("#uDishName").blur(function () {
    ktuDishName()
  })

  $("#uDishDescription").blur(function () {
    ktuDishDescription()
  })

  $("#uDishProcess").blur(function () {
    ktuDishProcess()
  })

  $("#uDishPrice").blur(function () {
    ktuDishPrice()
  })

  function updateuQuantityInputs() {
    for (let i = 0; i <= u_rowId; i++) {
      $("#uquantityIngre-" + i).blur(function () {
        ktuQuantity(i);
      });
    }
  }
  updateuQuantityInputs();

  $("#form-suamonan").on("submit", function (event) {
    let isuValid = false;
    if (ktuDishName() && ktuDishDescription() && ktuDishProcess() && ktuDishPrice()) {
      for (let u = 0; u <= u_rowId; u++) {
        if (ktuQuantity(u))
          isuValid = true;
        else {
          isuValid = false;
          break;

        }
      }
    }
    if (!isuValid) {
      event.preventDefault();
      alert("Thông tin không hợp lệ")
    }
  });

  // regex UC Thêm nguyên liệu
  function ktIngredientName() {
    let ingredientName = $("#iIngredientName").val()
    if (ingredientName.length === 0) {
      $("#errIngredientName").html("Tên nguyên liệu không được rỗng")
      return false
    } else {
      $("#errIngredientName").html("*")
      return true
    }
  }

  function ktIngredientPrice() {
    let ingredientPrice = $("#iIngredientPrice").val()
    if (ingredientPrice === "") {
      $("#errIngredientPrice").html("Giá mua không được rỗng")
      return false
    } else if (Number(ingredientPrice) < 0) {
      $("#errIngredientPrice").html("Giá mua không được nhỏ hơn 0")
      return false
    } else {
      $("#errIngredientPrice").html("*")
      return true
    }
  }

  $("#iIngredientName").blur(function () {
    ktIngredientName()
  })

  $("#iIngredientPrice").blur(function () {
    ktIngredientPrice()
  })

  $("#form-themnguyenlieu").on("submit", function (event) {
    let isValid = false;
    if (ktIngredientName() && ktIngredientPrice()) {
      isValid = true;
    }
    if (!isValid) {
      event.preventDefault();
      alert("Thông tin không hợp lệ")
    }
  });

  // regex UC Sửa nguyên liệu
  function ktuIngredientName() {
    let ingredientName = $("#uIngredientName").val()
    if (ingredientName.length === 0) {
      $("#uerrIngredientName").html("Tên nguyên liệu không được rỗng")
      return false
    } else {
      $("#uerrIngredientName").html("*")
      return true
    }
  }

  function ktuIngredientPrice() {
    let ingredientPrice = $("#uIngredientPrice").val()
    if (ingredientPrice === "") {
      $("#uerrIngredientPrice").html("Giá mua không được rỗng")
      return false
    } else if (Number(ingredientPrice) < 0) {
      $("#uerrIngredientPrice").html("Giá mua không được nhỏ hơn 0")
      return false
    } else {
      $("#uerrIngredientPrice").html("*")
      return true
    }
  }

  $("#uIngredientName").blur(function () {
    ktuIngredientName()
  })

  $("#uIngredientPrice").blur(function () {
    console.log(1)
    ktuIngredientPrice()
  })

  $("#form-suanguyenlieu").on("submit", function (event) {
    let isValid = false;
    if (ktuIngredientName() && ktuIngredientPrice()) {
      isValid = true;
    }
    if (!isValid) {
      event.preventDefault();
      alert("Thông tin không hợp lệ")
    }
  });

  // REGEX TINH TOAN NGUYEN LIEU

  $("#tinhtoannlform").on("submit", function (event) {
    let isValid = false;
    const soLuongMon = $(".tinhtoannlinput");
    soLuongMon.each(function () {
      if ($(this).val() != 0) {
        if ($(this).val() > 0) {
          isValid = true;
          return false;
        } else {
          alert("Số lượng món không được âm")
        }
      }
    });
    if (!isValid) {
      event.preventDefault();
      alert("Nhập ít nhất 1 món ăn")

    }
  });

  // REGEX Kết quả ước lượng
  function ktQuantityNeed(index) {
    let quantity = $("#tinhtoannlinputt-" + index).val();
    if (quantity === "") {
      alert("Số lượng không được rỗng");
      return false;
    } else if (Number(quantity) <= 0) {
      alert("Số lượng phải lớn hơn 0");
      return false;
    } else {
      return true;
    }
  }

  for (let i = 0; i <= $(".tinhtoannlinputcls").length; i++) {
    $("#tinhtoannlinputt-" + i).blur(function () {
      console.log(i)
      ktQuantityNeed(i);
    });
  }

    // Nhập nguyên liệu khô
    $(".btnNhapNLKho").on("click", function () {
      $isValid = true;
      for (let i = 0; i <= $(".tinhtoannlinputcls").length; i++) {
        if (!ktQuantityNeed(i)) {
          $isValid = false;
          break;
        }
      }
      if ($isValid) {
        var row = $(this).closest("tr");
        row.find('input[type="number"]:first').attr("name", "Ingre[]");
        row.find('input[type="number"]:last').attr("name", "TotalQuantity[]");
        row.find('input[type="number"]:last').prop("readonly", true);
        $(this).css("background-color", "green");
        $(this).html("✔");
        $(this).removeClass("btn-danger").addClass("btn-success");
      }
    });

});
