<?php
class cMessage
{
  public function successMessage($text)
  {
    echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
              let text = " . json_encode($text) . ";
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    didOpen: (toast) => {
                      toast.onmouseenter = Swal.stopTimer;
                      toast.onmouseleave = Swal.resumeTimer;
                    }
                  });
                  Toast.fire({
                    icon: 'success',
                    title: text + ' thành công'
                  });
                });
        </script>";
  }
  
  public function freeMessageLarge($text) {
    echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
              Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: '<h3 class=\"text-lg\">".$text."</h3>',
                showConfirmButton: false,
                timer: 1500
              });
            });
        </script>";
  }

  public function errorMessage($text)
  {
    echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
              let text = " . json_encode($text) . ";
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    didOpen: (toast) => {
                      toast.onmouseenter = Swal.stopTimer;
                      toast.onmouseleave = Swal.resumeTimer;
                    }
                  });
                  Toast.fire({
                    icon: 'error',
                    title: text + ' thất bại'
                  });
                });
        </script>";
  }
  
  public function emptyMessage()
  {
    echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    didOpen: (toast) => {
                      toast.onmouseenter = Swal.stopTimer;
                      toast.onmouseleave = Swal.resumeTimer;
                    }
                  });
                  Toast.fire({
                    icon: 'warning',
                    title: 'Vui lòng nhập đầy đủ thông tin!'
                  });
                });
        </script>";
  }
  
  public function falseMessage($text)
  {
    echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
              let text = " . json_encode($text) . ";
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    timer: 2000,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    didOpen: (toast) => {
                      toast.onmouseenter = Swal.stopTimer;
                      toast.onmouseleave = Swal.resumeTimer;
                    }
                  });
                  Toast.fire({
                    icon: 'warning',
                    title: text
                  });
                });
        </script>";
  }
}
