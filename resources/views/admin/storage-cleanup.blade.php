<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dọn dẹp file không sử dụng</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f7f9fc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .file-card {
            height: 100%;
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        .file-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .file-card .card-img-top {
            height: 200px;
            object-fit: cover;
            background-color: #f0f0f0;
        }
        .file-card.selected {
            border: 3px solid #0d6efd;
        }
        .file-card.unused {
            border: 3px solid #dc3545 !important;
        }
        .file-checkbox {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 10;
            transform: scale(1.5);
        }
        .file-extension {
            position: absolute;
            bottom: 0;
            right: 0;
            background-color: rgba(0,0,0,0.7);
            color: #fff;
            padding: 2px 8px;
            font-size: 12px;
            border-top-left-radius: 5px;
        }
        .pdf-card .card-img-top {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
        }
        .pdf-icon {
            font-size: 80px;
            color: #dc3545;
        }
        .stats-card {
            border-radius: 10px;
            border: none;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 20px 0;
            margin-bottom: 30px;
        }
        .btn-select-all {
            margin-right: 10px;
        }
        #confirmationModal .modal-header {
            background-color: #dc3545;
            color: white;
        }
        .file-path {
            font-size: 12px;
            color: #6c757d;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .file-size {
            font-weight: bold;
            color: #198754;
        }
        .resource-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 10;
        }
        .filter-buttons {
            margin-bottom: 20px;
        }
        .btn-filter {
            margin-right: 5px;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <h1 class="text-center">Dọn dẹp file không sử dụng</h1>
        </div>
    </div>

    <div class="container mb-5">
        <!-- Thống kê -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="stats-card card text-center p-3 h-100 bg-primary text-white">
                    <div class="card-body">
                        <h5 class="card-title">Tổng số file</h5>
                        <h2>{{ $totalFiles }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="stats-card card text-center p-3 h-100 bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">File đang sử dụng</h5>
                        <h2>{{ $usedCount }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="stats-card card text-center p-3 h-100 bg-danger text-white">
                    <div class="card-body">
                        <h5 class="card-title">File không sử dụng</h5>
                        <h2>{{ $unusedCount }}</h2>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Bộ lọc -->
        <div class="filter-buttons mb-4 text-center">
            <button type="button" class="btn btn-outline-primary btn-filter" onclick="filterFiles('all')">Tất cả</button>
            <button type="button" class="btn btn-outline-success btn-filter" onclick="filterFiles('used')">File đang sử dụng</button>
            <button type="button" class="btn btn-outline-danger btn-filter" onclick="filterFiles('unused')">File không sử dụng</button>
            <button type="button" class="btn btn-outline-info btn-filter" onclick="filterFiles('image')">Hình ảnh</button>
            <button type="button" class="btn btn-outline-warning btn-filter" onclick="filterFiles('pdf')">PDF</button>
        </div>

        @if(count($fileInfos) > 0)
            <form id="deleteForm" action="{{ route('cleanup.storage') }}" method="POST">
                @csrf
                <div class="d-flex justify-content-end mb-3">
                    <button type="button" class="btn btn-outline-primary btn-select-all" onclick="toggleSelectAll()">
                        <i class="fas fa-check-square me-2"></i> Chọn tất cả
                    </button>
                    <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                        <i class="fas fa-trash-alt me-2"></i> Xóa file đã chọn
                    </button>
                </div>

                <div class="row">
                    @foreach($fileInfos as $file)
                        <div class="col-md-3 mb-4 file-item {{ !$file['isUsed'] ? 'unused-file' : 'used-file' }} {{ $file['isImage'] ? 'image-file' : '' }} {{ $file['isPdf'] ? 'pdf-file' : '' }}">
                            <div class="file-card card h-100 position-relative {{ !$file['isUsed'] ? 'unused' : '' }}">
                                <input type="checkbox" name="files[]" value="{{ $file['path'] }}" class="file-checkbox" onchange="toggleCardSelection(this)">
                                
                                @if($file['isUsed'] && $file['resource'])
                                    <span class="badge bg-success resource-badge">{{ $file['resource'] }}</span>
                                @else
                                    <span class="badge bg-danger resource-badge">Không sử dụng</span>
                                @endif
                                
                                <div class="position-relative">
                                    @if($file['isImage'])
                                        <img src="{{ $file['url'] }}" alt="File preview" class="card-img-top">
                                    @elseif($file['isPdf'])
                                        <div class="card-img-top pdf-card">
                                            <i class="far fa-file-pdf pdf-icon"></i>
                                        </div>
                                    @else
                                        <div class="card-img-top d-flex align-items-center justify-content-center">
                                            <i class="far fa-file fa-5x text-secondary"></i>
                                        </div>
                                    @endif
                                    <div class="file-extension">{{ strtoupper($file['extension']) }}</div>
                                </div>
                                <div class="card-body">
                                    <p class="file-path mb-2">{{ $file['path'] }}</p>
                                    <div class="d-flex justify-content-between">
                                        <span class="file-size">{{ $file['size'] }}</span>
                                        <small class="text-muted">{{ $file['created'] }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </form>
        @else
            <div class="alert alert-success" role="alert">
                <i class="fas fa-check-circle me-2"></i> Không có file nào cần dọn dẹp! Tất cả file đang được sử dụng.
            </div>
        @endif
    </div>

    <!-- Modal xác nhận xóa -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Xác nhận xóa file</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc chắn muốn xóa <span id="fileCount">0</span> file đã chọn?</p>
                    <p class="text-danger"><i class="fas fa-exclamation-triangle me-2"></i> Hành động này không thể hoàn tác!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                    <button type="button" class="btn btn-danger" onclick="submitForm()">Xác nhận xóa</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Biến lưu trạng thái chọn tất cả
        let allSelected = false;
        
        // Modal xác nhận
        const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
        
        // Hàm chọn/bỏ chọn tất cả
        function toggleSelectAll() {
            allSelected = !allSelected;
            const checkboxes = document.querySelectorAll('.file-checkbox');
            
            checkboxes.forEach(checkbox => {
                checkbox.checked = allSelected;
                toggleCardSelection(checkbox);
            });
            
            // Thay đổi nội dung nút
            const button = document.querySelector('.btn-select-all');
            if (allSelected) {
                button.innerHTML = '<i class="fas fa-square me-2"></i> Bỏ chọn tất cả';
                button.classList.remove('btn-outline-primary');
                button.classList.add('btn-primary');
            } else {
                button.innerHTML = '<i class="fas fa-check-square me-2"></i> Chọn tất cả';
                button.classList.remove('btn-primary');
                button.classList.add('btn-outline-primary');
            }
        }
        
        // Hàm thay đổi giao diện khi chọn/bỏ chọn checkbox
        function toggleCardSelection(checkbox) {
            const card = checkbox.closest('.file-card');
            if (checkbox.checked) {
                card.classList.add('selected');
            } else {
                card.classList.remove('selected');
            }
        }
        
        // Hàm hiển thị modal xác nhận xóa
        function confirmDelete() {
            const selectedFiles = document.querySelectorAll('input[name="files[]"]:checked');
            
            if (selectedFiles.length === 0) {
                alert('Vui lòng chọn ít nhất một file để xóa.');
                return;
            }
            
            // Cập nhật số lượng file sẽ xóa trong modal
            document.getElementById('fileCount').textContent = selectedFiles.length;
            
            // Hiển thị modal xác nhận
            confirmationModal.show();
        }
        
        // Hàm submit form khi xác nhận xóa
        function submitForm() {
            document.getElementById('deleteForm').submit();
        }
        
        // Hàm lọc file theo trạng thái
        function filterFiles(filter) {
            // Cập nhật trạng thái active của các nút lọc
            document.querySelectorAll('.btn-filter').forEach(btn => {
                btn.classList.remove('btn-primary', 'btn-success', 'btn-danger', 'btn-info', 'btn-warning');
                btn.classList.add('btn-outline-primary', 'btn-outline-success', 'btn-outline-danger', 'btn-outline-info', 'btn-outline-warning');
            });
            
            // Hiển thị tất cả các file item
            document.querySelectorAll('.file-item').forEach(item => {
                item.style.display = 'none';
            });
            
            // Áp dụng bộ lọc
            switch(filter) {
                case 'all':
                    document.querySelectorAll('.file-item').forEach(item => {
                        item.style.display = 'block';
                    });
                    document.querySelector('.btn-filter:nth-child(1)').classList.replace('btn-outline-primary', 'btn-primary');
                    break;
                case 'used':
                    document.querySelectorAll('.used-file').forEach(item => {
                        item.style.display = 'block';
                    });
                    document.querySelector('.btn-filter:nth-child(2)').classList.replace('btn-outline-success', 'btn-success');
                    break;
                case 'unused':
                    document.querySelectorAll('.unused-file').forEach(item => {
                        item.style.display = 'block';
                    });
                    document.querySelector('.btn-filter:nth-child(3)').classList.replace('btn-outline-danger', 'btn-danger');
                    break;
                case 'image':
                    document.querySelectorAll('.image-file').forEach(item => {
                        item.style.display = 'block';
                    });
                    document.querySelector('.btn-filter:nth-child(4)').classList.replace('btn-outline-info', 'btn-info');
                    break;
                case 'pdf':
                    document.querySelectorAll('.pdf-file').forEach(item => {
                        item.style.display = 'block';
                    });
                    document.querySelector('.btn-filter:nth-child(5)').classList.replace('btn-outline-warning', 'btn-warning');
                    break;
            }
        }
        
        // Mặc định khi tải trang, hiển thị tất cả file
        document.addEventListener('DOMContentLoaded', function() {
            filterFiles('all');
        });
    </script>
</body>
</html>