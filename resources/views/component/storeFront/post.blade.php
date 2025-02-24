
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">


<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <!-- Section Header -->
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-3xl font-bold text-medical-green mb-4">Bài viết mới nhất</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-medical-green-light to-medical-green mx-auto"></div>
        </div>

        <!-- Tabs Container -->
        <div class="max-w-6xl mx-auto">
            <!-- Tab Headers -->
            <div class="flex flex-wrap justify-center mb-8 gap-4" data-aos="fade-up">
                <button class="tab-btn active px-6 py-3 rounded-full bg-medical-green text-white font-medium transition-all duration-300" data-tab="tin-tuc">Tin tức y tế</button>
                <button class="tab-btn px-6 py-3 rounded-full bg-gray-200 text-gray-700 font-medium hover:bg-gray-300 transition-all duration-300" data-tab="chuyen-mon">Chuyên môn</button>
                <button class="tab-btn px-6 py-3 rounded-full bg-gray-200 text-gray-700 font-medium hover:bg-gray-300 transition-all duration-300" data-tab="tu-van">Tư vấn sức khỏe</button>
                <button class="tab-btn px-6 py-3 rounded-full bg-gray-200 text-gray-700 font-medium hover:bg-gray-300 transition-all duration-300" data-tab="nghien-cuu">Nghiên cứu</button>
            </div>

            <!-- Tab Contents -->
            <div class="tab-contents">
                <!-- Article Template (Repeated for each tab) -->
                <template id="article-template">
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden group" data-aos="fade-up">
                        <div class="relative overflow-hidden">
                            <img class="w-full h-48 object-cover transform group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        </div>
                        <div class="p-4">
                            <span class="text-xs text-medical-green font-medium date"></span>
                            <h3 class="text-lg font-semibold mt-2 mb-2 line-clamp-2 group-hover:text-medical-green transition-colors title"></h3>
                            <p class="text-gray-600 text-sm line-clamp-3 description"></p>
                        </div>
                    </div>
                </template>

                <!-- Tab Content Containers -->
                <div class="tab-content active" data-tab="tin-tuc">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6" id="tin-tuc-content"></div>
                </div>
                <div class="tab-content hidden" data-tab="chuyen-mon">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6" id="chuyen-mon-content"></div>
                </div>
                <div class="tab-content hidden" data-tab="tu-van">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6" id="tu-van-content"></div>
                </div>
                <div class="tab-content hidden" data-tab="nghien-cuu">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6" id="nghien-cuu-content"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    // Article Data
    const articles = {
        'tin-tuc': [
            {
                image: 'https://medlatec.vn/media/23252/file/kham-suc-khoe-doanh-nghiep-medlatec-68.jpg',
                date: '20/02/2024',
                title: 'Phòng khám triển khai chương trình khám sức khỏe định kỳ',
                description: 'Chương trình khám sức khỏe định kỳ giúp phát hiện sớm các bệnh lý và có biện pháp điều trị kịp thời...'
            },
            {
                image: 'https://medlatec.vn/med/images/service2.png',
                date: '19/02/2024',
                title: 'Ứng dụng công nghệ mới trong chẩn đoán hình ảnh',
                description: 'Phòng khám đầu tư hệ thống chẩn đoán hình ảnh hiện đại, nâng cao chất lượng khám chữa bệnh...'
            },
            {
                image: 'https://medlatec.vn/med/images/service3.png',
                date: '18/02/2024',
                title: 'Khai trương phòng khám vệ tinh mới',
                description: 'Mở rộng mạng lưới phòng khám vệ tinh nhằm phục vụ nhu cầu khám chữa bệnh của người dân...'
            },
            {
                image: 'https://medlatec.vn/media/23254/file/khach-hang-kham-suc-khoe-medlatec.jpg',
                date: '17/02/2024',
                title: 'Tổ chức hội thảo sức khỏe cộng đồng',
                description: 'Chương trình tư vấn sức khỏe miễn phí cho người dân với sự tham gia của các chuyên gia đầu ngành...'
            }
        ],
        'chuyen-mon': [
            {
                image: 'https://medlatec.vn/media/23252/file/kham-suc-khoe-doanh-nghiep-medlatec-68.jpg',
                date: '20/02/2024',
                title: 'Phương pháp điều trị bệnh tiểu đường mới',
                description: 'Cập nhật các phương pháp điều trị tiểu đường hiện đại, giúp kiểm soát đường huyết hiệu quả...'
            }
            // ... other articles with similar structure
        ],
        'tu-van': [
            {
                image: 'https://medlatec.vn/media/23252/file/kham-suc-khoe-doanh-nghiep-medlatec-68.jpg',
                date: '20/02/2024',
                title: 'Chế độ dinh dưỡng cho người cao tuổi',
                description: 'Hướng dẫn chi tiết về chế độ dinh dưỡng phù hợp cho người cao tuổi...'
            }
            // ... other articles with similar structure
        ],
        'nghien-cuu': [
            {
                image: 'https://medlatec.vn/media/23252/file/kham-suc-khoe-doanh-nghiep-medlatec-68.jpg',
                date: '20/02/2024',
                title: 'Nghiên cứu về điều trị ung thư',
                description: 'Kết quả nghiên cứu mới về phương pháp điều trị ung thư hiệu quả...'
            }
            // ... other articles with similar structure
        ]
    };

    // Initialize AOS
    AOS.init({
        duration: 800,
        easing: 'ease-out',
        once: true
    });

    // Render Articles Function
    function renderArticles(category) {
        const template = document.getElementById('article-template');
        const container = document.getElementById(`${category}-content`);
        container.innerHTML = '';

        articles[category].forEach((article, index) => {
            const clone = template.content.cloneNode(true);
            clone.querySelector('img').src = article.image;
            clone.querySelector('img').alt = article.title;
            clone.querySelector('.date').textContent = article.date;
            clone.querySelector('.title').textContent = article.title;
            clone.querySelector('.description').textContent = article.description;

            const wrapper = clone.querySelector('.group');
            wrapper.setAttribute('data-aos-delay', index * 100);

            container.appendChild(clone);
        });
    }

    // Tab Switching Logic
    document.addEventListener('DOMContentLoaded', function() {
        const tabBtns = document.querySelectorAll('.tab-btn');
        const tabContents = document.querySelectorAll('.tab-content');

        // Render initial tab
        renderArticles('tin-tuc');

        tabBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const tabName = btn.dataset.tab;

                // Update button states
                tabBtns.forEach(b => {
                    b.classList.remove('active', 'bg-medical-green', 'text-white');
                    b.classList.add('bg-gray-200', 'text-gray-700');
                });
                btn.classList.add('active', 'bg-medical-green', 'text-white');
                btn.classList.remove('bg-gray-200', 'text-gray-700');

                // Update tab content
                tabContents.forEach(content => {
                    content.classList.add('hidden');
                });
                document.querySelector(`.tab-content[data-tab="${tabName}"]`).classList.remove('hidden');

                // Render articles for the selected tab
                renderArticles(tabName);
                AOS.refresh();
            });
        });
    });
</script>

