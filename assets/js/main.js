// Đảm bảo tất cả mã JavaScript chỉ chạy một lần khi trang đã tải xong
document.addEventListener('DOMContentLoaded', function () {
   console.log('DOM loaded - initializing filter functionality');

   // Xử lý tất cả các dropdown
   var dropdowns = document.querySelectorAll('.dropdown-check-list');
   console.log('Found dropdowns:', dropdowns.length);

   dropdowns.forEach(function (dropdown, index) {
      var anchor = dropdown.querySelector('.anchor');
      var items = dropdown.querySelector('.items');

      console.log('Dropdown #' + index + ' - anchor:', !!anchor, 'items:', !!items);

      if (anchor && items) {
         anchor.addEventListener('click', function (e) {
            console.log('Anchor clicked for dropdown #' + index);
            e.stopPropagation(); // Ngăn sự kiện lan ra ngoài

            // Đóng tất cả các dropdown khác
            dropdowns.forEach(function (otherDropdown) {
               if (otherDropdown !== dropdown && otherDropdown.classList.contains('active')) {
                  otherDropdown.classList.remove('active');
               }
            });

            // Toggle dropdown hiện tại
            dropdown.classList.toggle('active');
            console.log('Dropdown #' + index + ' active state:', dropdown.classList.contains('active'));
         });
      }
   });

   // Đóng tất cả dropdown khi click ra ngoài
   document.addEventListener('click', function (e) {
      dropdowns.forEach(function (dropdown) {
         if (!dropdown.contains(e.target) && dropdown.classList.contains('active')) {
            dropdown.classList.remove('active');
         }
      });
   });

   // Xử lý checkbox trong dropdown
   var checkboxes = document.querySelectorAll('.dropdown-check-list input[type="checkbox"]');
   var filterTags = document.querySelector('.filter-tags');
   var filterCount = document.querySelector('.filter-count span');
   var categoryCount = document.querySelector('.category-count');

   console.log('Found checkboxes:', checkboxes.length);
   console.log('Filter tags element:', !!filterTags);
   console.log('Filter count element:', !!filterCount);
   console.log('Category count element:', !!categoryCount);

   // Cập nhật filter tags
   function updateFilterTags() {
      if (!filterTags) return;

      filterTags.innerHTML = '';
      var count = 0;

      checkboxes.forEach(function (checkbox) {
         if (checkbox.checked) {
            count++;
            var label = checkbox.nextElementSibling.textContent;
            var tag = document.createElement('div');
            tag.className = 'filter-tag';
            tag.innerHTML = label + '<span class="remove" data-id="' + checkbox.id + '"><i class="fa fa-times"></i></span>';
            filterTags.appendChild(tag);

            // Xử lý sự kiện xóa tag
            tag.querySelector('.remove').addEventListener('click', function () {
               var id = this.getAttribute('data-id');
               document.getElementById(id).checked = false;
               updateFilterTags();
               updateCategoryCount();
            });
         }
      });

      if (filterCount) {
         filterCount.textContent = count;
      }

      console.log('Updated filter tags, count:', count);
   }

   // Cập nhật số lượng thể loại đã chọn
   function updateCategoryCount() {
      if (!categoryCount) return;

      var count = 0;
      checkboxes.forEach(function (checkbox) {
         if (checkbox.checked && checkbox.name === 'category[]') {
            count++;
         }
      });

      categoryCount.textContent = count;
      console.log('Updated category count:', count);
   }

   // Thêm sự kiện cho checkboxes
   checkboxes.forEach(function (checkbox, index) {
      checkbox.addEventListener('change', function () {
         console.log('Checkbox #' + index + ' changed, checked:', this.checked);
         updateFilterTags();
         updateCategoryCount();
      });
   });

   // Xử lý nút Clear All
   var clearAllBtn = document.getElementById('clearAllBtn');
   console.log('Clear all button:', !!clearAllBtn);

   if (clearAllBtn) {
      clearAllBtn.addEventListener('click', function (e) {
         console.log('Clear all button clicked');
         e.stopPropagation(); // Ngăn sự kiện lan ra ngoài

         checkboxes.forEach(function (checkbox) {
            checkbox.checked = false;
         });

         updateFilterTags();
         updateCategoryCount();
      });
   }

   // Xử lý nút Reset
   var resetBtn = document.querySelector('.btn-reset');
   console.log('Reset button:', !!resetBtn);

   if (resetBtn) {
      resetBtn.addEventListener('click', function () {
         console.log('Reset button clicked');
         // Reset checkboxes
         checkboxes.forEach(function (checkbox) {
            checkbox.checked = false;
         });

         // Reset text inputs
         document.querySelectorAll('.input-text').forEach(function (input) {
            input.value = '';
         });

         updateFilterTags();
         updateCategoryCount();
      });
   }

   // Thêm hiệu ứng ripple cho buttons và dropdowns
   function addRippleEffect(elements) {
      elements.forEach(function (element, index) {
         element.addEventListener('click', function (e) {
            console.log('Adding ripple effect to element #' + index);
            var ripple = document.createElement('span');
            ripple.className = 'ripple';
            this.appendChild(ripple);

            var rect = this.getBoundingClientRect();
            var size = Math.max(rect.width, rect.height);

            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = (e.clientX - rect.left - size / 2) + 'px';
            ripple.style.top = (e.clientY - rect.top - size / 2) + 'px';

            ripple.classList.add('active');

            setTimeout(function () {
               ripple.remove();
            }, 600);
         });
      });
   }

   // Thêm hiệu ứng ripple cho buttons
   var rippleButtons = document.querySelectorAll('.btn-search, .btn-reset');
   var rippleAnchors = document.querySelectorAll('.dropdown-check-list .anchor');

   console.log('Ripple buttons:', rippleButtons.length);
   console.log('Ripple anchors:', rippleAnchors.length);

   addRippleEffect(rippleButtons);
   addRippleEffect(rippleAnchors);

   // Khởi tạo ban đầu
   updateFilterTags();
   updateCategoryCount();

   console.log('Filter functionality initialized');
});

// JavaScript để điều khiển hiển thị form
document.addEventListener('DOMContentLoaded', function () {
   // Lấy các phần tử modal
   var loginModal = document.getElementById('loginModal');
   var registerModal = document.getElementById('registerModal');

   // Lấy các nút mở modal
   var loginBtn = document.getElementById('loginBtn');
   var registerBtn = document.getElementById('registerBtn');

   // Lấy các phần tử đóng modal
   var closeLogin = document.getElementById('closeLogin');
   var closeRegister = document.getElementById('closeRegister');

   // Lấy các nút chuyển đổi giữa đăng nhập và đăng ký
   var switchToRegister = document.getElementById('switchToRegister');
   var switchToLogin = document.getElementById('switchToLogin');

   // Khi người dùng nhấp vào nút đăng nhập
   if (loginBtn) {
      loginBtn.onclick = function (e) {
         e.preventDefault();
         loginModal.style.display = 'block';
      }
   }

   // Khi người dùng nhấp vào nút đăng ký
   if (registerBtn) {
      registerBtn.onclick = function (e) {
         e.preventDefault();
         registerModal.style.display = 'block';
      }
   }

   // Khi người dùng nhấp vào nút đóng
   if (closeLogin) {
      closeLogin.onclick = function () {
         loginModal.style.display = 'none';
      }
   }

   if (closeRegister) {
      closeRegister.onclick = function () {
         registerModal.style.display = 'none';
      }
   }

   // Khi người dùng nhấp vào nút chuyển đổi
   if (switchToRegister) {
      switchToRegister.onclick = function (e) {
         e.preventDefault();
         loginModal.style.display = 'none';
         registerModal.style.display = 'block';
      }
   }

   if (switchToLogin) {
      switchToLogin.onclick = function (e) {
         e.preventDefault();
         registerModal.style.display = 'none';
         loginModal.style.display = 'block';
      }
   }

   // Khi người dùng nhấp vào bất kỳ đâu bên ngoài modal
   window.onclick = function (event) {
      if (loginModal && event.target == loginModal) {
         loginModal.style.display = 'none';
      }
      if (registerModal && event.target == registerModal) {
         registerModal.style.display = 'none';
      }
   }

   // Kiểm tra mật khẩu khớp nhau
   var password = document.getElementById('password');
   var confirmPassword = document.getElementById('confirmPassword');
   var passwordMatchMessage = document.getElementById('passwordMatchMessage');
   var registerForm = document.querySelector('#registerModal form');

   // Hàm kiểm tra mật khẩu
   function checkPasswordMatch() {
      if (!confirmPassword || !password || !passwordMatchMessage) return;

      if (confirmPassword.value === '') {
         passwordMatchMessage.style.display = 'none';
         return;
      }

      if (password.value === confirmPassword.value) {
         passwordMatchMessage.textContent = 'Mật khẩu khớp!';
         passwordMatchMessage.style.color = 'green';
         passwordMatchMessage.style.display = 'block';
         confirmPassword.setCustomValidity('');
      } else {
         passwordMatchMessage.textContent = 'Mật khẩu không khớp!';
         passwordMatchMessage.style.color = 'red';
         passwordMatchMessage.style.display = 'block';
         confirmPassword.setCustomValidity('Mật khẩu không khớp');
      }
   }

   // Gắn sự kiện kiểm tra khi nhập
   if (password) password.addEventListener('input', checkPasswordMatch);
   if (confirmPassword) confirmPassword.addEventListener('input', checkPasswordMatch);

   // Kiểm tra khi submit form đăng ký
   if (registerForm) {
      registerForm.addEventListener('submit', function (e) {
         e.preventDefault();

         // Kiểm tra mật khẩu khớp nhau
         if (password.value !== confirmPassword.value) {
            checkPasswordMatch();
            return;
         }

         // Kiểm tra các trường bắt buộc
         var fullname = document.getElementById('username');
         var email = document.getElementById('email');
         var termsCheckbox = document.getElementById('terms');

         if (!fullname || !fullname.value.trim()) {
            alert('Vui lòng nhập họ tên');
            return;
         }

         if (!email || !email.value.trim()) {
            alert('Vui lòng nhập email');
            return;
         }

         if (!password || !password.value.trim()) {
            alert('Vui lòng nhập mật khẩu');
            return;
         }

         if (termsCheckbox && !termsCheckbox.checked) {
            alert('Vui lòng đồng ý với điều khoản sử dụng');
            return;
         }

         // Hiển thị loading
         var submitBtn = registerForm.querySelector('button[type="submit"]');
         var originalBtnText = submitBtn.innerHTML;
         submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Đang xử lý...';
         submitBtn.disabled = true;

         // Giả lập đăng ký thành công sau 1.5 giây
         setTimeout(function () {
            // Đóng modal đăng ký
            registerModal.style.display = 'none';

            // Lưu thông tin người dùng vào session (giả lập)
            // Trong thực tế, đây sẽ là phản hồi từ máy chủ
            var username = fullname.value;

            // Hiển thị thông báo đăng ký thành công
            alert('Đăng ký thành công! Chào mừng ' + username);

            // Tải lại trang với thông tin người dùng mới
            window.location.href = 'index.php?register_success=true&username=' + encodeURIComponent(username);
         }, 1500);
      });
   }

   // Chức năng bật tắt hiển thị mật khẩu
   document.querySelectorAll('.toggle-password').forEach(function (toggle) {
      toggle.addEventListener('click', function () {
         const passwordField = this.previousElementSibling;
         const type = passwordField.getAttribute('type');

         if (type === 'password') {
            passwordField.setAttribute('type', 'text');
            this.classList.remove('fa-eye-slash');
            this.classList.add('fa-eye');
         } else {
            passwordField.setAttribute('type', 'password');
            this.classList.remove('fa-eye');
            this.classList.add('fa-eye-slash');
         }
      });
   });

   // Xử lý form đăng nhập
   var loginForm = document.querySelector('#loginModal form');
   if (loginForm) {
      loginForm.addEventListener('submit', function (e) {
         e.preventDefault();

         // Kiểm tra các trường bắt buộc
         var email = document.getElementById('loginEmail');
         var password = document.getElementById('loginPassword');

         if (!email || !email.value.trim()) {
            alert('Vui lòng nhập email hoặc tên đăng nhập');
            return;
         }

         if (!password || !password.value.trim()) {
            alert('Vui lòng nhập mật khẩu');
            return;
         }

         // Hiển thị loading
         var submitBtn = loginForm.querySelector('button[type="submit"]');
         var originalBtnText = submitBtn.innerHTML;
         submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Đang xử lý...';
         submitBtn.disabled = true;

         // Giả lập đăng nhập thành công sau 1.5 giây
         setTimeout(function () {
            // Đóng modal đăng nhập
            loginModal.style.display = 'none';

            // Lưu thông tin người dùng vào session (giả lập)
            // Trong thực tế, đây sẽ là phản hồi từ máy chủ
            var username = email.value;

            // Hiển thị thông báo đăng nhập thành công
            alert('Đăng nhập thành công! Chào mừng trở lại, ' + username);

            // Tải lại trang với thông tin người dùng mới
            window.location.href = 'index.php?login_success=true&username=' + encodeURIComponent(username);
         }, 1500);
      });
   }

   // Xử lý dropdown người dùng
   const userDropdownToggle = document.querySelector('.user-dropdown-toggle');
   const userDropdown = document.getElementById('userDropdown');

   if (userDropdownToggle && userDropdown) {
      const dropdownMenu = userDropdown.querySelector('.user-dropdown-menu');
      console.log('Dropdown elements found:', userDropdownToggle, dropdownMenu);

      // Toggle dropdown when clicking the button
      userDropdownToggle.addEventListener('click', function (e) {
         e.preventDefault();
         e.stopPropagation();

         console.log('Dropdown toggle clicked');

         // Toggle show class for dropdown visibility
         dropdownMenu.classList.toggle('show');
         userDropdown.classList.toggle('active');

         // Set direct CSS properties to ensure visibility
         if (dropdownMenu.classList.contains('show')) {
            dropdownMenu.style.display = 'block';
            dropdownMenu.style.visibility = 'visible';
            dropdownMenu.style.opacity = '1';
            dropdownMenu.style.transform = 'translateY(0)';
            dropdownMenu.style.pointerEvents = 'auto';
         } else {
            setTimeout(function () {
               dropdownMenu.style.display = 'none';
               dropdownMenu.style.visibility = 'hidden';
               dropdownMenu.style.opacity = '0';
               dropdownMenu.style.transform = 'translateY(-10px)';
               dropdownMenu.style.pointerEvents = 'none';
            }, 200);
         }
      });

      // Close dropdown when clicking outside
      document.addEventListener('click', function (e) {
         if (!userDropdown.contains(e.target) && dropdownMenu.classList.contains('show')) {
            dropdownMenu.classList.remove('show');
            userDropdown.classList.remove('active');

            setTimeout(function () {
               dropdownMenu.style.display = 'none';
               dropdownMenu.style.visibility = 'hidden';
               dropdownMenu.style.opacity = '0';
               dropdownMenu.style.transform = 'translateY(-10px)';
               dropdownMenu.style.pointerEvents = 'none';
            }, 200);
         }
      });

      // Handle logout button click
      const logoutBtn = document.getElementById('logoutBtn');
      if (logoutBtn) {
         logoutBtn.addEventListener('click', function (e) {
            e.preventDefault();

            // Show loading state
            this.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Đang đăng xuất...';

            // Redirect after a short delay
            setTimeout(function () {
               window.location.href = 'index.php?logout=true';
            }, 1000);
         });
      }
   } else {
      console.error('User dropdown elements not found');
   }
});
