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
   var passwordLengthMessage = document.getElementById('passwordLengthMessage');
   var registerSubmitBtn = document.getElementById('register');

   // Lấy các phần tử của form đăng ký
   var registerForm = document.getElementById('registerForm');
   var registerErrorArea = document.getElementById('registerErrorArea');
   var registerErrorMessage = document.getElementById('registerErrorMessage');

   // Hàm kiểm tra độ dài mật khẩu
   function checkPasswordLength() {
      if (!password || !passwordLengthMessage) return;

      if (password.value.length < 8) {
         passwordLengthMessage.textContent = 'Mật khẩu phải có ít nhất 8 ký tự!';
         passwordLengthMessage.className = 'password-check error';
         if (registerSubmitBtn) registerSubmitBtn.disabled = true;
         return false;
      } else {
         passwordLengthMessage.textContent = 'Mật khẩu hợp lệ!';
         passwordLengthMessage.className = 'password-check valid';
         if (registerSubmitBtn) registerSubmitBtn.disabled = validateForm() ? false : true;
         return true;
      }
   }

   // Hàm kiểm tra mật khẩu khớp nhau
   function checkPasswordMatch() {
      if (!confirmPassword || !password || !passwordMatchMessage) return;

      if (confirmPassword.value === '') {
         passwordMatchMessage.style.display = 'none';
         return;
      }

      if (password.value === confirmPassword.value) {
         passwordMatchMessage.textContent = 'Mật khẩu khớp!';
         passwordMatchMessage.className = 'password-check valid';
         passwordMatchMessage.style.display = 'block';
         confirmPassword.setCustomValidity('');
         if (registerSubmitBtn) registerSubmitBtn.disabled = validateForm() ? false : true;
      } else {
         passwordMatchMessage.textContent = 'Mật khẩu không khớp!';
         passwordMatchMessage.className = 'password-check error';
         passwordMatchMessage.style.display = 'block';
         confirmPassword.setCustomValidity('Mật khẩu không khớp');
         if (registerSubmitBtn) registerSubmitBtn.disabled = true;
      }
   }

   // Hàm kiểm tra toàn bộ form
   function validateForm() {
      var isPasswordValid = password && password.value.length >= 8;
      var isPasswordMatch = password && confirmPassword && password.value === confirmPassword.value;
      return isPasswordValid && isPasswordMatch;
   }

   // Gắn sự kiện kiểm tra khi nhập
   if (password) {
      password.addEventListener('input', function () {
         checkPasswordLength();
         if (confirmPassword && confirmPassword.value) {
            checkPasswordMatch();
         }
      });
   }

   if (confirmPassword) {
      confirmPassword.addEventListener('input', checkPasswordMatch);
   }

   // Function to show register error messages
   function showRegisterError(message) {
      if (registerErrorMessage && registerErrorArea) {
         registerErrorMessage.textContent = message;
         registerErrorArea.style.display = 'block';

         // Scroll to the error message
         registerErrorArea.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
      }
   }

   // Xử lý form đăng ký
   if (registerForm) {
      registerForm.addEventListener('submit', function (e) {
         e.preventDefault(); // Prevent normal form submission

         // Kiểm tra các trường bắt buộc
         var username = document.getElementById('username');
         var email = document.getElementById('email');
         var password = document.getElementById('password');
         var confirmPassword = document.getElementById('confirmPassword');

         // Hide any previous error messages
         registerErrorArea.style.display = 'none';

         if (!username || !username.value.trim()) {
            showRegisterError('Vui lòng nhập tên đăng nhập');
            username.focus();
            return false;
         }

         if (!email || !email.value.trim()) {
            showRegisterError('Vui lòng nhập email');
            email.focus();
            return false;
         }

         if (!password || !password.value.trim()) {
            showRegisterError('Vui lòng nhập mật khẩu');
            password.focus();
            return false;
         }

         if (!confirmPassword || !confirmPassword.value.trim()) {
            showRegisterError('Vui lòng xác nhận mật khẩu');
            confirmPassword.focus();
            return false;
         }

         if (password.value !== confirmPassword.value) {
            showRegisterError('Mật khẩu không khớp');
            confirmPassword.focus();
            return false;
         }

         // Hiển thị loading
         var submitBtn = registerForm.querySelector('input[type="submit"]');
         var originalBtnValue = submitBtn.value;
         submitBtn.value = 'Đang xử lý...';
         submitBtn.disabled = true;

         // Submit form using AJAX
         var formData = new FormData(registerForm);

         // Create XMLHttpRequest object
         var xhr = new XMLHttpRequest();
         xhr.open('POST', registerForm.action, true);
         xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

         xhr.onload = function () {
            if (xhr.status === 200) {
               try {
                  var response = JSON.parse(xhr.responseText);

                  if (response.success) {
                     // Registration successful - reload page to update menu
                     window.location.href = '/Admin/index.php';
                  } else {
                     // Registration failed - show error message
                     showRegisterError(response.error || 'Lỗi đăng ký không xác định');
                     submitBtn.value = originalBtnValue;
                     submitBtn.disabled = false;
                  }
               } catch (e) {
                  // JSON parse error
                  showRegisterError('Lỗi xử lý phản hồi từ máy chủ');
                  submitBtn.value = originalBtnValue;
                  submitBtn.disabled = false;
               }
            } else {
               // HTTP error
               showRegisterError('Lỗi kết nối đến máy chủ');
               submitBtn.value = originalBtnValue;
               submitBtn.disabled = false;
            }
         };

         xhr.onerror = function () {
            // Network error
            showRegisterError('Lỗi kết nối mạng');
            submitBtn.value = originalBtnValue;
            submitBtn.disabled = false;
         };

         // Send the form data
         xhr.send(formData);
         return false;
      });
   }

   // Kiểm tra độ dài mật khẩu khi trang được tải
   if (password) {
      setTimeout(checkPasswordLength, 300);
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
   var loginForm = document.getElementById('loginForm');
   var loginErrorArea = document.getElementById('loginErrorArea');
   var loginErrorMessage = document.getElementById('loginErrorMessage');

   if (loginForm) {
      loginForm.addEventListener('submit', function (e) {
         e.preventDefault(); // Prevent normal form submission

         // Kiểm tra các trường bắt buộc
         var email = document.getElementById('loginEmail');
         var password = document.getElementById('loginPassword');

         // Hide any previous error messages
         loginErrorArea.style.display = 'none';

         if (!email || !email.value.trim()) {
            showLoginError('Vui lòng nhập email hoặc tên đăng nhập');
            email.focus();
            return false;
         }

         if (!password || !password.value.trim()) {
            showLoginError('Vui lòng nhập mật khẩu');
            password.focus();
            return false;
         }

         // Hiển thị loading
         var submitBtn = loginForm.querySelector('input[type="submit"]');
         var originalBtnValue = submitBtn.value;
         submitBtn.value = 'Đang xử lý...';
         submitBtn.disabled = true;

         // Submit form using AJAX
         var formData = new FormData(loginForm);

         // Create XMLHttpRequest object
         var xhr = new XMLHttpRequest();
         xhr.open('POST', loginForm.action, true);
         xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

         xhr.onload = function () {
            if (xhr.status === 200) {
               try {
                  var response = JSON.parse(xhr.responseText);

                  if (response.success) {
                     // Login successful - redirect to home page
                     window.location.href = '/Admin/index.php';
                  } else {
                     // Login failed - show error message
                     showLoginError(response.error || 'Lỗi đăng nhập không xác định');
                     submitBtn.value = originalBtnValue;
                     submitBtn.disabled = false;
                  }
               } catch (e) {
                  // JSON parse error
                  showLoginError('Lỗi xử lý phản hồi từ máy chủ');
                  submitBtn.value = originalBtnValue;
                  submitBtn.disabled = false;
               }
            } else {
               // HTTP error
               showLoginError('Lỗi kết nối đến máy chủ');
               submitBtn.value = originalBtnValue;
               submitBtn.disabled = false;
            }
         };

         xhr.onerror = function () {
            // Network error
            showLoginError('Lỗi kết nối mạng');
            submitBtn.value = originalBtnValue;
            submitBtn.disabled = false;
         };

         // Send the form data
         xhr.send(formData);
         return false;
      });
   }

   // Function to show login error messages
   function showLoginError(message) {
      if (loginErrorMessage && loginErrorArea) {
         loginErrorMessage.textContent = message;
         loginErrorArea.style.display = 'block';

         // Scroll to the error message
         loginErrorArea.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
      }
   }

   // Check for login_error parameter in URL and show the login modal with error
   function checkForLoginError() {
      var urlParams = new URLSearchParams(window.location.search);
      if (urlParams.has('login_error') && loginModal) {
         loginModal.style.display = 'block';
         showLoginError(urlParams.get('error_message') || 'Tên đăng nhập hoặc mật khẩu không chính xác');
      }
   }

   // Run the check when page loads
   checkForLoginError();

   // Xử lý phân trang
   function initPagination() {
      console.log('Initializing pagination...');
      
      // Tìm input nhập số trang
      const pageInput = document.getElementById('pageInput');
      console.log('Page input found:', !!pageInput);
      
      if (pageInput) {
         // Xử lý chuyển trang khi nhấn Enter
         pageInput.addEventListener('keydown', function(event) {
            console.log('Key pressed on page input:', event.key);
            if (event.key === 'Enter') {
               event.preventDefault(); // Ngăn chặn hành vi mặc định của form
               goToPage();
            }
         });

         // Xử lý khi giá trị thay đổi
         pageInput.addEventListener('input', function() {
            const value = parseInt(this.value);
            const max = parseInt(this.getAttribute('max'));
            const min = parseInt(this.getAttribute('min'));

            if (value > max) this.value = max;
            if (value < min || isNaN(value)) this.value = min;
         });
      }

      // Thêm hiệu ứng ripple cho các nút phân trang
      const paginationButtons = document.querySelectorAll('.pagination-arrow, .pagination-numbers a');
      console.log('Pagination buttons found:', paginationButtons.length);
      
      paginationButtons.forEach(button => {
         button.addEventListener('click', function(e) {
            if (this.classList.contains('disabled') || this.classList.contains('active')) {
               e.preventDefault();
               return;
            }

            // Hiệu ứng ripple
            const ripple = document.createElement('span');
            ripple.className = 'ripple';
            this.appendChild(ripple);

            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            ripple.style.width = ripple.style.height = `${size}px`;
            ripple.style.left = `${e.clientX - rect.left - size / 2}px`;
            ripple.style.top = `${e.clientY - rect.top - size / 2}px`;

            setTimeout(() => {
               ripple.remove();
            }, 600);
         });
      });
   }

   // Hàm chuyển trang
   function goToPage() {
      console.log('goToPage function called');
      const pageInput = document.getElementById('pageInput');
      if (!pageInput) {
         console.error('Page input element not found');
         return;
      }

      const page = parseInt(pageInput.value);
      const maxPage = parseInt(pageInput.getAttribute('max') || '1');
      const minPage = parseInt(pageInput.getAttribute('min') || '1');
      
      console.log('Page values:', { page, maxPage, minPage });
      
      // Đảm bảo giá trị nằm trong khoảng hợp lệ
      const validPage = Math.max(minPage, Math.min(page || minPage, maxPage));
      console.log('Valid page:', validPage);
      
      // Cập nhật URL với tham số page mới
      try {
         const url = new URL(window.location.href);
         url.searchParams.set('page', validPage);
         console.log('Redirecting to:', url.toString());
         window.location.href = url.toString();
      } catch (error) {
         console.error('Error updating URL:', error);
         // Fallback nếu có lỗi
         window.location.href = window.location.pathname + '?page=' + validPage;
      }
   }

   // Khởi tạo phân trang khi DOM đã tải xong
   initPagination();

   // Xử lý dropdown người dùng
   const userDropdownToggle = document.querySelector('.user-dropdown-toggle');
   const userDropdown = document.getElementById('userDropdown');

   if (userDropdownToggle && userDropdown) {
      const dropdownMenu = userDropdown.querySelector('.user-dropdown-menu');
      console.log('Dropdown elements found:', userDropdownToggle, dropdownMenu);

      // Thêm hiệu ứng ripple khi click
      function createRippleEffect(event) {
         const button = event.currentTarget;
         const ripple = document.createElement('span');
         const rect = button.getBoundingClientRect();

         const size = Math.max(rect.width, rect.height);
         const x = event.clientX - rect.left - size / 2;
         const y = event.clientY - rect.top - size / 2;

         ripple.className = 'ripple';
         ripple.style.width = ripple.style.height = `${size}px`;
         ripple.style.left = `${x}px`;
         ripple.style.top = `${y}px`;

         button.appendChild(ripple);

         // Xóa ripple sau khi animation kết thúc
         setTimeout(() => {
            ripple.remove();
         }, 600);
      }

      // Toggle dropdown when clicking the button
      userDropdownToggle.addEventListener('click', function (e) {
         e.preventDefault();
         e.stopPropagation();

         console.log('Dropdown toggle clicked');

         // Tạo hiệu ứng ripple
         createRippleEffect(e);

         // Toggle show class for dropdown visibility
         dropdownMenu.classList.toggle('show');
         userDropdown.classList.toggle('active');

         // Set direct CSS properties to ensure visibility
         if (dropdownMenu.classList.contains('show')) {
            dropdownMenu.style.display = 'block';
            dropdownMenu.style.visibility = 'visible';
            dropdownMenu.style.opacity = '1';
            dropdownMenu.style.transform = 'translateY(0) scale(1)';
            dropdownMenu.style.pointerEvents = 'auto';
         } else {
            setTimeout(function () {
               dropdownMenu.style.display = 'none';
               dropdownMenu.style.visibility = 'hidden';
               dropdownMenu.style.opacity = '0';
               dropdownMenu.style.transform = 'translateY(-10px) scale(0.98)';
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
         // Thêm hiệu ứng ripple cho nút đăng xuất
         logoutBtn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            // Tạo hiệu ứng ripple
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();

            const size = Math.max(rect.width, rect.height) * 2;
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;

            ripple.className = 'ripple';
            ripple.style.width = ripple.style.height = `${size}px`;
            ripple.style.left = `${x}px`;
            ripple.style.top = `${y}px`;
            ripple.style.backgroundColor = 'rgba(244, 67, 54, 0.2)';

            this.appendChild(ripple);

            // Lưu nội dung ban đầu
            const originalContent = this.innerHTML;

            // Show loading state sau một khoảng thời gian ngắn
            setTimeout(() => {
               this.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Đang đăng xuất...';

               // Redirect after a short delay
               setTimeout(() => {
                  window.location.href = window.location.origin + '/Admin/logout.php';
               }, 800);
            }, 300);

            // Xóa ripple sau khi animation kết thúc
            setTimeout(() => {
               ripple.remove();
            }, 600);
         });
      }
   } else {
      console.error('User dropdown elements not found');
   }
});

// Image Preview Functionality
document.addEventListener('DOMContentLoaded', function() {
    const imageUpload = document.getElementById('imageUpload');
    
    if (imageUpload) {
        imageUpload.addEventListener('change', function() {
            previewImage(this);
        });
    }
});

function previewImage(input) {
    console.log('previewImage called', input);
    const previewContainer = input.closest('.form-group').querySelector('.image-preview-container');
    console.log('previewContainer:', previewContainer);
    
    if (!previewContainer) {
        console.error('Preview container not found');
        return;
    }
    
    const newImageContainer = previewContainer.querySelector('.new-image');
    console.log('newImageContainer:', newImageContainer);
    
    if (!newImageContainer) {
        console.error('New image container not found');
        return;
    }
    
    const preview = newImageContainer.querySelector('img');
    console.log('preview element:', preview);
    
    if (!preview) {
        console.error('Preview image element not found');
        return;
    }
    
    if (input.files && input.files[0]) {
        console.log('File selected:', input.files[0].name);
        const reader = new FileReader();
        
        reader.onload = function(e) {
            console.log('File loaded');
            preview.src = e.target.result;
            newImageContainer.style.display = 'block';
        }
        
        reader.onerror = function(e) {
            console.error('Error loading file:', e);
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        console.log('No file selected');
        preview.src = '#';
        newImageContainer.style.display = 'none';
    }
}


