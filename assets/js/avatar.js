// JavaScript để cải thiện trải nghiệm người dùng khi upload avatar
document.addEventListener('DOMContentLoaded', function () {
    var avatarUpload = document.getElementById('avatar-upload');
    var avatarPreview = document.getElementById('avatar-preview');
    var avatarContainer = document.querySelector('.avatar-container');
    var avatarEdit = document.querySelector('.avatar-edit');

    if (avatarUpload && avatarPreview) {
        // Hiệu ứng hover cho avatar
        if (avatarContainer) {
            avatarContainer.addEventListener('mouseenter', function() {
                this.classList.add('hover');
            });
            
            avatarContainer.addEventListener('mouseleave', function() {
                this.classList.remove('hover');
            });
        }

        // Hiệu ứng ripple khi click vào nút upload
        if (avatarEdit) {
            avatarEdit.addEventListener('click', function(e) {
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                
                const size = Math.max(rect.width, rect.height) * 2;
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.className = 'avatar-ripple';
                ripple.style.width = ripple.style.height = `${size}px`;
                ripple.style.left = `${x}px`;
                ripple.style.top = `${y}px`;
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        }

        // Xem trước ảnh khi chọn file
        avatarUpload.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                // Hiển thị loading spinner
                if (!document.querySelector('.avatar-loading')) {
                    const loading = document.createElement('div');
                    loading.className = 'avatar-loading';
                    loading.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
                    avatarContainer.appendChild(loading);
                }
                
                var reader = new FileReader();
                reader.onload = function (e) {
                    // Thêm hiệu ứng fade-in cho ảnh mới
                    avatarPreview.style.opacity = 0;
                    setTimeout(function() {
                        avatarPreview.src = e.target.result;
                        avatarPreview.style.opacity = 1;
                        
                        // Xóa loading spinner
                        const loading = document.querySelector('.avatar-loading');
                        if (loading) {
                            loading.remove();
                        }
                    }, 300);
                }
                reader.readAsDataURL(this.files[0]);
                
                // Hiển thị thông báo thành công
                const successMessage = document.createElement('div');
                successMessage.className = 'avatar-success-message';
                successMessage.innerHTML = '<i class="fa fa-check-circle"></i> Ảnh đã được chọn';
                
                // Xóa thông báo cũ nếu có
                const oldMessage = document.querySelector('.avatar-success-message');
                if (oldMessage) {
                    oldMessage.remove();
                }
                
                avatarContainer.appendChild(successMessage);
                
                // Tự động ẩn thông báo sau 3 giây
                setTimeout(function() {
                    successMessage.classList.add('fade-out');
                    setTimeout(function() {
                        successMessage.remove();
                    }, 500);
                }, 3000);
            }
        });
    }
});
