<?php

    namespace Database\Seeders;

    use App\Models\Carousel;
    use App\Models\CatPost;
    use App\Models\Doctor;
    use App\Models\MenuItem;
    use App\Models\Page;
    use App\Models\Post;
    use App\Models\Service;
    use App\Models\Setting;
    use App\Models\User;
    use App\Models\Video;
    use Illuminate\Database\Seeder;

    class FirstSeed extends Seeder {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run(): void {
            User::create([
                'name' => 'admin',
                'email' => 'ngocnhan@gmail.com',
                'password' => bcrypt('dakhoangocnhan'),
            ]);

            Setting::create([
                'name' => 'PHÒNG KHÁM ĐA KHOA NGỌC NHÂN',
                'hotline' => '0270 3777 999',
                'email' => 'ngocnhan@gmail.com',
                'address' => '168 đường 30/4, thị trấn Trà Ôn, huyện Trà Ôn, Vinh Long, Vietnam',
                'logo' => 'uploads//01JMST6FDJEXSVPEVMPCK8ERQ0.webp',
                'slogan' => 'Nhanh chóng - Chất lượng - Hiệu quả cao',
                'zalo' => '1900 1234',
                'facebook' => 'https://www.facebook.com/ngocnhan',
                'messenger' => 'https://www.messenger.com/ngocnhan',
                'google_map' => 'https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7685.271145987463!2d105.925913!3d9.965595!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a065d487618e95%3A0x320323dfe31785d7!2zU-G7nyBZIFThur8gVsSpbmggTG9uZyBQaMOybmcgS2jDoW0gxJBhIEtob2EgTmfhu41jIE5ow6Ju!5e1!3m2!1svi!2sus!4v1740323823891!5m2!1svi!2sus',
                'mst' => '1501128933',
                'hr_status' => 'on',
                'hr_content' => 'Thời gian làm việc: 7h30 - 17h30',
            ]);

            CatPost::create([
                'name' => 'Tin tức sự kiện',
                'content' => 'Tin tức mới nhất gần đây',
            ]);
            CatPost::create([
                'name' => 'An sinh xã hội',
                'content' => 'Tin tức về những vấn đề an sinh xã hội',
            ]);

            Post::create([
                'name' => 'Giới thiệu',
                'content' => 'Giới thiệu',
                'image' => 'uploads//01JMSJ3NWM9EWFD9Q0RNTMDG6F.png',
                'user_id' => 1,
                'cat_post_id' => 1,
            ]);

            Post::create([
                'name' => 'Phòng khám',
                'content' => '<h1><a href="https://www.google.com/maps/search/Ph%C3%B2ng+Kh%C3%A1m+%C4%90a+Khoa+Ng%E1%BB%8Dc+Nh%C3%A2n+V%C4%A9nh+Long">Phòng Khám Đa Khoa Ngọc Nhân</a></h1><p>Phòng Khám Đa Khoa Ngọc Nhân là một cơ sở y tế tư nhân uy tín tại huyện Trà Ôn, tỉnh Vĩnh Long, chuyên cung cấp các dịch vụ khám, tư vấn, chẩn đoán và điều trị cho nhiều bệnh lý đa dạng.</p><p><strong>Địa chỉ và thông tin liên hệ:</strong></p><ul><li><strong>Địa chỉ:</strong> 168 đường 30/4, khu 6, thị trấn Trà Ôn, huyện Trà Ôn, tỉnh Vĩnh Long</li><li><strong>Số điện thoại:</strong> 0270 3777 999</li><li><strong>Website: pkngocnhan.vn</strong></li></ul><p><strong>Giờ làm việc:</strong></p><ul><li>Thứ Hai đến Thứ Bảy: 07:30 - 17:00</li><li>Chủ Nhật: Đóng cửa</li></ul><p><strong>Dịch vụ cung cấp:</strong></p><ul><li>Khám và điều trị các bệnh lý về tiêu hóa, gan, mật, tim mạch, nội tiết, hô hấp, thận - tiết niệu, nội thần kinh, cơ xương khớp.</li><li>Thực hiện các xét nghiệm cận lâm sàng như siêu âm tổng quát, đo loãng xương, đo điện tim, đo điện não, chụp X-quang và xét nghiệm Elisa.</li></ul><p><strong>Đội ngũ y bác sĩ:</strong> Phòng khám sở hữu đội ngũ y bác sĩ chuyên môn cao, tận tâm và luôn tôn trọng, tư vấn tận tình cho người bệnh.</p><p>Với trang thiết bị hiện đại và dịch vụ chất lượng, Phòng Khám Đa Khoa Ngọc Nhân đã trở thành địa chỉ tin cậy cho người dân trong khu vực và các vùng lân cận khi có nhu cầu chăm sóc sức khỏe.</p><p><br></p>',
                'image' => 'uploads//01JMSJ3NWM9EWFD9Q0RNTMDG6F.png',
                'user_id' => 1,
                'cat_post_id' => 1,
            ]);

            Post::create([
                'name' => 'Bác sĩ chuyên khoa',
                'content' => '<h1><a href="https://www.google.com/maps/search/Ph%C3%B2ng+Kh%C3%A1m+%C4%90a+Khoa+Ng%E1%BB%8Dc+Nh%C3%A2n">Phòng Khám Đa Khoa Ngọc Nhân</a></h1><p>Phòng Khám Đa Khoa Ngọc Nhân tự hào sở hữu đội ngũ bác sĩ chuyên khoa có chuyên môn cao và tận tâm, đảm bảo chất lượng dịch vụ y tế cho cộng đồng. Dưới đây là một số bác sĩ tiêu biểu tại phòng khám:</p><ul><li><strong>TS.BS Dũng</strong>: Giám đốc chuyên môn, chuyên khoa Tim mạch.</li><li><strong>PGS.TS Trần</strong>: Trưởng khoa Nội, chuyên gia Nội khoa.</li><li><strong>BS.CKI Vinh</strong>: Trưởng khoa Ngoại, chuyên về phẫu thuật tổng quát.</li><li><strong>BS.CKI Hoàng</strong>: Trưởng khoa Cấp cứu, chuyên về cấp cứu và hồi sức.</li></ul><p>Với đội ngũ bác sĩ giàu kinh nghiệm và trang thiết bị hiện đại, Phòng Khám Đa Khoa Ngọc Nhân cam kết mang đến dịch vụ chăm sóc sức khỏe chất lượng cao, đáp ứng mọi nhu cầu khám chữa bệnh của người dân.</p><p><br></p>',
                'image' => 'uploads//01JMSJ3NWM9EWFD9Q0RNTMDG6F.png',
                'user_id' => 1,
                'cat_post_id' => 1,
            ]);

            Post::create([
                'name' => 'Dịch vụ',
                'content' => 'dịch vụ',
                'image' => 'uploads//01JMSJ3NWM9EWFD9Q0RNTMDG6F.png',
                'user_id' => 1,
                'cat_post_id' => 1,
            ]);

            Post::create([
                'name' => 'Khám chuyên khoa',
                'content' => '<p>Phòng Khám Đa Khoa Ngọc Nhân cung cấp đa dạng các dịch vụ khám chuyên khoa nhằm đáp ứng nhu cầu chăm sóc sức khỏe của cộng đồng. Các dịch vụ bao gồm:</p><ul><li><strong>Khám sức khỏe tổng quát</strong>: Đánh giá tình trạng sức khỏe chung, phát hiện sớm các vấn đề tiềm ẩn để có biện pháp phòng ngừa và điều trị kịp thời.</li><li><strong>Khám chuyên khoa</strong>: Bao gồm các chuyên khoa như Tim mạch, Hô hấp, Tiêu hóa – Gan mật, Cơ xương khớp, Da liễu, Mắt, Răng Hàm Mặt, Tai Mũi Họng và Phụ khoa.</li><li><strong>Cận lâm sàng</strong>: Thực hiện các xét nghiệm và chẩn đoán hình ảnh như siêu âm, X-quang, điện tim, điện não để hỗ trợ chẩn đoán chính xác.</li><li><strong>Xét nghiệm</strong>: Cung cấp các dịch vụ xét nghiệm máu, nước tiểu và các xét nghiệm chuyên sâu khác.</li><li><strong>Tiêm chủng</strong>: Cung cấp các loại vắc-xin phòng ngừa bệnh cho trẻ em và người lớn.</li><li><strong>Nha khoa</strong>: Chăm sóc và điều trị các vấn đề về răng miệng.</li></ul><p>Với đội ngũ bác sĩ giàu kinh nghiệm và trang thiết bị hiện đại, Phòng Khám Đa Khoa Ngọc Nhân cam kết mang đến dịch vụ chăm sóc sức khỏe chất lượng cao, đáp ứng mọi nhu cầu khám chữa bệnh của người dân.</p>',
                'image' => 'uploads//01JMSJ3NWM9EWFD9Q0RNTMDG6F.png',
                'user_id' => 1,
                'cat_post_id' => 1,
            ]);

            Post::create([
                'name' => 'Khám sức khỏe',
                'content' => 'Khám sức khỏe',
                'image' => 'uploads//01JMSJ3NWM9EWFD9Q0RNTMDG6F.png',
                'user_id' => 1,
                'cat_post_id' => 1,
            ]);

            Post::create([
                'name' => 'Tiêm chủng',
                'content' => 'Tiêm chủng',
                'image' => 'uploads//01JMSJ3NWM9EWFD9Q0RNTMDG6F.png',
                'user_id' => 1,
                'cat_post_id' => 1,
            ]);

            Post::create([
                'name' => 'Tuyển dụng',
                'content' => 'Tuyển dụng',
                'image' => 'uploads//01JMSJ3NWM9EWFD9Q0RNTMDG6F.png',
                'user_id' => 1,
                'cat_post_id' => 1,
            ]);

            Post::create([
                'name' => 'Tin tức sự kiện',
                'content' => 'Tin tức sự kiện',
                'image' => 'uploads//01JMSJ3NWM9EWFD9Q0RNTMDG6F.png',
                'user_id' => 1,
                'cat_post_id' => 1,
            ]);

            Post::create([
                'name' => 'An Ninh Xã Hội',
                'content' => 'An Ninh Xã Hội',
                'image' => 'uploads//01JMSJ3NWM9EWFD9Q0RNTMDG6F.png',
                'user_id' => 1,
                'cat_post_id' => 1,
            ]);

            Post::create([
                'name' => 'Chi phí khám bệnh',
                'content' => 'Chi phí khám bệnh',
                'image' => 'uploads//01JMSJ3NWM9EWFD9Q0RNTMDG6F.png',
                'user_id' => 1,
                'cat_post_id' => 1,
            ]);


            Page::create([
                'name' => 'Giới thiệu phòng khám',
                'content' => '<h1>Phòng Khám Đa Khoa Ngọc Nhân - Trà Ôn, Vĩnh Long</h1><h2>Giới Thiệu</h2><p>Phòng khám Đa khoa Ngọc Nhân là cơ sở y tế uy tín tại thị trấn Trà Ôn, với đội ngũ y bác sĩ giàu kinh nghiệm và trang thiết bị hiện đại. Chúng tôi cam kết mang đến dịch vụ chăm sóc sức khỏe chất lượng cao cho người dân địa phương và vùng lân cận.</p><h2>Dịch Vụ Chính</h2><p><strong>Khám Chữa Bệnh</strong></p><ul><li>Khám chuyên khoa đa dạng</li><li>Khám sức khỏe tổng quát</li><li>Cấp cứu và điều trị</li></ul><p><strong>Cận Lâm Sàng</strong></p><ul><li>Xét nghiệm</li><li>Chẩn đoán hình ảnh</li><li>Thăm dò chức năng</li></ul><p><strong>Dịch Vụ Khác</strong></p><ul><li>Tiêm chủng an toàn</li><li>Điều trị nha khoa</li><li>Tư vấn sức khỏe</li></ul><h2>Ưu Điểm Nổi Bật</h2><ul><li>Đội ngũ y bác sĩ chuyên môn cao</li><li>Trang thiết bị y tế hiện đại</li><li>Dịch vụ chuyên nghiệp, tận tâm</li><li>Hoạt động liên tục cả tuần</li><li>Môi trường khám chữa bệnh sạch sẽ</li></ul><h2>Thông Tin Liên Hệ</h2><p><strong>Phòng Khám Đa Khoa Ngọc Nhân</strong></p><ul><li>Địa chỉ: 168 đường 30/4, thị trấn Trà Ôn, huyện Trà Ôn, Vĩnh Long</li><li>Hotline: 0270 3777 999</li><li>Thời gian làm việc: Luôn mở cửa</li><li>Trạng thái: Đang hoạt động</li></ul><p><em>Phòng khám Đa khoa Ngọc Nhân - Chăm sóc sức khỏe toàn diện, uy tín và chuyên nghiệp</em></p><p><br></p>',
                'image' => 'uploads//01JMV0Y6RQ4M3PYY2825M28Q40.png',
            ]);

            Page::create([
               'name' => 'Giới thiệu bác sĩ chuyên khoa',
                'content' => '<h1>Cơ Hội Nghề Nghiệp Tại Phòng Khám Đa Khoa Ngọc Nhân</h1><h2>Vị Trí Tuyển Dụng:</h2><p><strong>1. Bác Sĩ Nội Tổng Quát</strong></p><ul><li>Số lượng: 03 người</li><li>Yêu cầu: Có chứng chỉ hành nghề</li><li>Kinh nghiệm: Ưu tiên có kinh nghiệm lâm sàng</li></ul><p><strong>2. Bác Sĩ Chẩn Đoán Hình Ảnh</strong></p><ul><li>Số lượng: 01 người</li><li>Yêu cầu: Có chứng chỉ hành nghề</li><li>Chuyên môn: Thành thạo đọc và phân tích kết quả chẩn đoán hình ảnh</li></ul><p><strong>3. Dược Sĩ</strong></p><ul><li>Số lượng: 01 người</li><li>Trình độ: Trung cấp hoặc Cao đẳng</li><li>Ưu tiên: Có chứng chỉ hành nghề</li></ul><p><strong>4. Điều Dưỡng</strong></p><ul><li>Số lượng: 02 người</li><li>Trình độ: Trung cấp hoặc Cao đẳng</li><li>Ưu tiên: Có chứng chỉ hành nghề</li></ul><h2>Thông Tin Liên Hệ</h2><p>Ứng viên quan tâm vui lòng liên hệ:</p><ul><li>Điện thoại: 02703 777 999 (Trong giờ hành chính)</li><li>Địa chỉ: Số 168, Đường 30/4, Khu 5, TT Trà Ôn, H. Trà Ôn, T. Vĩnh Long</li></ul><p><em>Phòng khám Đa khoa Ngọc Nhân - Môi trường làm việc chuyên nghiệp, phát triển bền vững</em></p><p><br></p>',
                'image' => 'uploads//01JMV13QZGNRX2WXSJNGS45KNE.jpg',
            ]);

            Page::create([
                'name' => 'Khám chuyên khoa',
                'content' => '<h1>Khám Chuyên Khoa</h1><p>Phòng khám Đa khoa Ngọc Nhân cung cấp các dịch vụ khám chuyên khoa đa dạng với đội ngũ bác sĩ giàu kinh nghiệm. Các chuyên khoa chính bao gồm:</p><ul><li>Nội tổng quát</li><li>Tim mạch</li><li>Tai mũi họng</li><li>Sản phụ khoa</li><li>Nhi khoa</li><li>Nha khoa</li></ul><p>Bác sĩ sẽ thăm khám, chẩn đoán và đề xuất phương pháp điều trị phù hợp. Hỗ trợ các xét nghiệm và chẩn đoán hình ảnh khi cần thiết.</p><p>Liên hệ: 02703 777 999 để đặt lịch khám chuyên khoa.</p><p><br></p>',
                'image' => 'uploads//01JMV1861ZRHZHMY5B1VRKMJXE.png',
            ]);

            Page::create([
                'name' => 'Khám Sức Khỏe',
                'content' => '<h1>Khám Sức Khỏe</h1><p>Dịch vụ khám sức khỏe tổng quát tại Ngọc Nhân bao gồm:</p><ul><li>Khám tổng quát các cơ quan</li><li>Xét nghiệm máu, nước tiểu</li><li>Chụp X-quang ngực</li><li>Siêu âm ổ bụng</li><li>Điện tim</li></ul><p>Kết quả khám được bác sĩ tư vấn chi tiết, giúp phát hiện sớm các vấn đề sức khỏe. Có gói khám theo yêu cầu và khám theo độ tuổi.</p><p>Đặt lịch khám: 02703 777 999.</p><p><br></p>',
                'image' => 'uploads//01JMV1BB1C9G4WBB1F3DWT6VKD.jpg',
            ]);

            Page::create([
                'name' => 'Tiêm Ngừa',
                'content' => '<h1>Tiêm Ngừa</h1><p>Phòng khám cung cấp dịch vụ tiêm chủng an toàn với:</p><ul><li>Đầy đủ các loại vaccine thiết yếu</li><li>Bảo quản vaccine theo tiêu chuẩn</li><li>Quy trình tiêm chủng đúng kỹ thuật</li><li>Theo dõi sau tiêm 30 phút</li><li>Tư vấn chi tiết trước và sau tiêm</li></ul><p>Đội ngũ y bác sĩ giàu kinh nghiệm, đảm bảo an toàn tuyệt đối trong tiêm chủng.</p><p>Địa chỉ: 168 đường 30/4, thị trấn Trà Ôn, Vĩnh Long Liên hệ: 02703 777 999</p><p><br></p>',
                'image' => 'uploads//01JMV1CQ1JY147XFAKVNEBRPNE.jpg',
            ]);

            Page::create([
                'name' => 'Chi Phí Khám Bệnh',
                'content' => '<h1>Chi Phí Khám Bệnh Tại Phòng Khám Đa Khoa Ngọc Nhân</h1><p>Phòng khám Đa khoa Ngọc Nhân công khai minh bạch các mức giá khám bệnh theo quy định, đảm bảo quyền lợi cho người bệnh.</p><h2>Giá Khám Bệnh Cơ Bản</h2><ul><li>Khám thông thường: từ 30.100đ - 45.900đ (tùy cấp độ bệnh viện)</li><li>Khám chuyên khoa: từ 33.200đ - 42.100đ</li><li>Khám cấp giấy chứng thương, giám định y khoa: 160.000đ - 184.200đ (chưa bao gồm xét nghiệm, X-quang)</li></ul><h2>Khám Sức Khỏe Định Kỳ</h2><ol><li><strong>Khám sức khỏe tổng quát cho người lao động, lái xe</strong><ul><li>Giá: 160.000đ - 184.200đ</li><li>Không bao gồm xét nghiệm và X-quang</li></ul></li><li><strong>Khám sức khỏe xuất khẩu lao động</strong><ul><li>Giá: 450.000đ - 515.400đ</li><li>Không bao gồm xét nghiệm và X-quang</li></ul></li></ol><h2>Dịch Vụ Chuyên Sâu</h2><p><strong>Hội chẩn chuyên gia</strong></p><ul><li>Áp dụng cho ca bệnh khó</li><li>Chi phí: 200.000đ - 230.200đ/ca</li><li>Chỉ áp dụng với trường hợp mời chuyên gia đơn vị khác</li></ul><h2>Lưu Ý:</h2><ul><li>Giá trên chưa bao gồm các chi phí xét nghiệm và chẩn đoán hình ảnh</li><li>Có thể thanh toán bằng tiền mặt hoặc chuyển khoản</li><li>Áp dụng bảo hiểm y tế theo quy định</li><li>Giá có thể thay đổi theo thời điểm</li></ul><p><strong>Liên hệ tư vấn chi tiết:</strong></p><ul><li>Hotline: 02703 777 999</li><li>Địa chỉ: 168 đường 30/4, thị trấn Trà Ôn, Vĩnh Long</li></ul><p><br></p>',
                'image' => 'uploads//01JMV1M2P35JN4CFCSJCXFKKSF.png',
            ]);

            Service::create([
                'name' => 'Khám sức khỏe tổng quát',
                'description' => '<h1>Dịch vụ Khám Sức Khỏe Tổng Quát Tại Phòng Khám Đa Khoa Ngọc Nhân - Trà Ôn, Vĩnh Long</h1><p>Phòng khám Đa khoa Ngọc Nhân tự hào mang đến dịch vụ khám sức khỏe tổng quát chất lượng cao, toàn diện cho người dân Trà Ôn và các vùng lân cận thuộc tỉnh Vĩnh Long. Với đội ngũ bác sĩ giàu kinh nghiệm cùng trang thiết bị hiện đại, chúng tôi cam kết mang đến trải nghiệm khám chữa bệnh tốt nhất cho mọi bệnh nhân.</p><h2>Quy Trình Khám Sức Khỏe Tổng Quát Chuyên Nghiệp</h2><p>Khi đến khám tại Phòng khám Đa khoa Ngọc Nhân, bạn sẽ được trải qua quy trình khám tổng quát bài bản, bao gồm:</p><p><strong>Bước 1: Kiểm Tra Các Chỉ Số Cơ Bản</strong></p><ul><li>Đo chiều cao, cân nặng, huyết áp</li><li>Kiểm tra nhịp tim, nhịp thở</li><li>Đánh giá chỉ số BMI</li></ul><p><strong>Bước 2: Khám Lâm Sàng Chuyên Sâu</strong></p><ul><li>Khám tổng quát các cơ quan</li><li>Khám chuyên khoa: Tim mạch, hô hấp, tiêu hóa</li><li>Đánh giá tình trạng xương khớp</li></ul><p><strong>Bước 3: Thực Hiện Các Xét Nghiệm</strong></p><ul><li>Xét nghiệm máu tổng quát</li><li>Chức năng gan, thận</li><li>Đường huyết, mỡ máu</li><li>Nước tiểu</li></ul><p><strong>Bước 4: Chẩn Đoán Hình Ảnh</strong></p><ul><li>Chụp X-quang ngực</li><li>Siêu âm ổ bụng tổng quát</li><li>Điện tim (ECG)</li></ul><h2>Ưu Điểm Vượt Trội</h2><ol><li><strong>Đội Ngũ Y Bác Sĩ Chuyên Nghiệp</strong> Phòng khám quy tụ đội ngũ bác sĩ có trình độ chuyên môn cao, nhiều năm kinh nghiệm trong lĩnh vực khám chữa bệnh.</li><li><strong>Trang Thiết Bị Hiện Đại</strong> Đầu tư hệ thống máy móc, thiết bị y tế tiên tiến, đảm bảo kết quả chẩn đoán chính xác.</li><li><strong>Chi Phí Hợp Lý</strong> Mức phí khám tổng quát được niêm yết công khai, minh bạch, phù hợp với điều kiện kinh tế của người dân địa phương.</li><li><strong>Thời Gian Linh Hoạt</strong> Phòng khám hoạt động cả ngày trong tuần, tạo điều kiện thuận lợi cho người dân sắp xếp thời gian khám.</li></ol><h2>Đối Tượng Nên Thực Hiện Khám Sức Khỏe Tổng Quát</h2><ul><li>Người trên 40 tuổi</li><li>Người có tiền sử bệnh gia đình</li><li>Người làm việc trong môi trường độc hại</li><li>Người có các dấu hiệu bất thường về sức khỏe</li><li>Người cần khám sức khỏe định kỳ theo yêu cầu công việc</li></ul><h2>Thông Tin Liên Hệ và Đặt Lịch Khám</h2><p><strong>Phòng Khám Đa Khoa Ngọc Nhân</strong></p><ul><li>Địa chỉ: [Địa chỉ cụ thể tại Trà Ôn, Vĩnh Long]</li><li>Hotline: [Số điện thoại]</li><li>Thời gian làm việc: 7:00 - 20:00 (Từ Thứ 2 đến Chủ Nhật)</li><li>Website: [Website phòng khám]</li></ul><h2>Kết Luận</h2><p>Với sự đầu tư về cơ sở vật chất, trang thiết bị và đội ngũ y bác sĩ chuyên nghiệp, Phòng khám Đa khoa Ngọc Nhân cam kết mang đến dịch vụ khám sức khỏe tổng quát chất lượng cao, góp phần chăm sóc và bảo vệ sức khỏe cho người dân Trà Ôn, Vĩnh Long.</p><p>Hãy chủ động bảo vệ sức khỏe của bản thân và gia đình bằng việc thực hiện khám sức khỏe tổng quát định kỳ tại Phòng khám Đa khoa Ngọc Nhân. Liên hệ ngay với chúng tôi để được tư vấn và đặt lịch khám!</p><p><em>Từ khóa: khám sức khỏe tổng quát, phòng khám đa khoa Ngọc Nhân, khám tổng quát Trà Ôn, khám sức khỏe Vĩnh Long, dịch vụ khám tổng quát</em></p><p><br></p>',
                'image' => 'uploads//01JMTX786H5HBVE1GM2P2FDXFP.webp'
            ]);

            Service::create([
                'name' => 'Khám chuyên khoa',
                'description' => '<h1>Dịch Vụ Khám Chuyên Khoa Tại Phòng Khám Đa Khoa Ngọc Nhân - Trà Ôn, Vĩnh Long</h1><p>Phòng khám Đa khoa Ngọc Nhân cung cấp các dịch vụ khám chuyên khoa chất lượng cao, với đội ngũ bác sĩ chuyên môn sâu trong từng lĩnh vực. Chúng tôi cam kết mang đến giải pháp điều trị hiệu quả, phù hợp với từng bệnh nhân.</p><h2>Các Chuyên Khoa Nổi Bật</h2><p><strong>1. Chuyên Khoa Tim Mạch</strong></p><ul><li>Khám và điều trị các bệnh về tim</li><li>Tầm soát bệnh mạch vành</li><li>Đo điện tim, siêu âm tim</li><li>Tư vấn phòng ngừa bệnh tim mạch</li></ul><p><strong>2. Chuyên Khoa Tiêu Hóa</strong></p><ul><li>Khám và điều trị các bệnh về dạ dày</li><li>Nội soi tiêu hóa</li><li>Điều trị viêm gan các loại</li><li>Tư vấn chế độ ăn uống khoa học</li></ul><p><strong>3. Chuyên Khoa Tai Mũi Họng</strong></p><ul><li>Điều trị viêm xoang, viêm họng</li><li>Phẫu thuật nạo VA, cắt amidan</li><li>Điều trị các bệnh về tai</li><li>Chăm sóc và phục hồi thính lực</li></ul><p><strong>4. Chuyên Khoa Sản Phụ Khoa</strong></p><ul><li>Khám thai định kỳ</li><li>Siêu âm thai 4D</li><li>Điều trị các bệnh phụ khoa</li><li>Tư vấn sức khỏe sinh sản</li></ul><p><strong>5. Chuyên Khoa Nhi</strong></p><ul><li>Khám và điều trị bệnh trẻ em</li><li>Tiêm chủng vaccine</li><li>Tư vấn dinh dưỡng cho trẻ</li><li>Theo dõi sự phát triển của trẻ</li></ul><h2>Quy Trình Khám Chuyên Khoa</h2><p><strong>1. Tiếp Nhận và Phân Loại</strong></p><ul><li>Đăng ký thông tin bệnh nhân</li><li>Tư vấn chọn chuyên khoa phù hợp</li><li>Hướng dẫn quy trình khám</li></ul><p><strong>2. Thăm Khám Chuyên Sâu</strong></p><ul><li>Bác sĩ chuyên khoa thăm khám</li><li>Khai thác tiền sử bệnh</li><li>Đánh giá tình trạng hiện tại</li></ul><p><strong>3. Chỉ Định Cận Lâm Sàng</strong></p><ul><li>Xét nghiệm chuyên sâu</li><li>Chẩn đoán hình ảnh</li><li>Các test đặc hiệu theo chuyên khoa</li></ul><p><strong>4. Chẩn Đoán và Điều Trị</strong></p><ul><li>Kết luận bệnh lý</li><li>Đề xuất phương án điều trị</li><li>Kê đơn thuốc phù hợp</li></ul><h2>Ưu Điểm Dịch Vụ</h2><p><strong>1. Đội Ngũ Y Bác Sĩ Chuyên Môn Cao</strong></p><ul><li>Bác sĩ có nhiều năm kinh nghiệm</li><li>Thường xuyên cập nhật kiến thức mới</li><li>Tận tâm với người bệnh</li></ul><p><strong>2. Trang Thiết Bị Hiện Đại</strong></p><ul><li>Máy móc chẩn đoán tiên tiến</li><li>Phòng khám vô trùng</li><li>Thiết bị theo dõi bệnh nhân</li></ul><p><strong>3. Môi Trường Khám Chữa Bệnh</strong></p><ul><li>Phòng khám rộng rãi, thoáng mát</li><li>Khu vực chờ tiện nghi</li><li>Thái độ phục vụ chuyên nghiệp</li></ul><h2>Chính Sách Hỗ Trợ Bệnh Nhân</h2><ul><li>Tư vấn miễn phí qua điện thoại</li><li>Hỗ trợ thủ tục bảo hiểm y tế</li><li>Theo dõi sau điều trị</li><li>Chế độ bảo mật thông tin</li></ul><h2>Thông Tin Đặt Lịch Khám</h2><p><strong>Phòng Khám Đa Khoa Ngọc Nhân</strong></p><ul><li>Địa chỉ: [Địa chỉ cụ thể tại Trà Ôn, Vĩnh Long]</li><li>Hotline tư vấn: [Số điện thoại]</li><li>Giờ làm việc: 7:00 - 20:00 (Tất cả các ngày trong tuần)</li><li>Website: [Website phòng khám]</li></ul><p><br></p>',
                'image' => 'uploads//01JMTX9DAW2GFCR7585N7GV24S.webp'
            ]);

            Service::create([
                'name' => 'Cận lâm sàng',
                'description' => '<h1>Dịch Vụ Cận Lâm Sàng Tại Phòng Khám Đa Khoa Ngọc Nhân - Trà Ôn, Vĩnh Long</h1><p>Phòng khám Đa khoa Ngọc Nhân đầu tư hệ thống cận lâm sàng hiện đại, cung cấp các dịch vụ xét nghiệm và chẩn đoán hình ảnh chất lượng cao. Với đội ngũ kỹ thuật viên chuyên nghiệp, chúng tôi cam kết mang đến kết quả chính xác, nhanh chóng cho người bệnh.</p><h2>Các Dịch Vụ Cận Lâm Sàng</h2><p><strong>1. Xét Nghiệm Máu</strong></p><ul><li>Tổng phân tích tế bào máu</li><li>Sinh hóa máu</li><li>Đông máu cơ bản</li><li>Xét nghiệm chức năng gan, thận</li><li>Xét nghiệm hormon</li><li>Xét nghiệm miễn dịch</li></ul><p><strong>2. Xét Nghiệm Nước Tiểu</strong></p><ul><li>Tổng phân tích nước tiểu</li><li>Định lượng protein</li><li>Tìm hồng cầu, bạch cầu</li><li>Xét nghiệm đường niệu</li></ul><p><strong>3. Chẩn Đoán Hình Ảnh</strong></p><ul><li>Chụp X-quang kỹ thuật số</li><li>Siêu âm tổng quát</li><li>Siêu âm tim</li><li>Siêu âm màu 4D</li><li>Điện tim</li></ul><p><strong>4. Nội Soi</strong></p><ul><li>Nội soi dạ dày</li><li>Nội soi đại tràng</li><li>Nội soi tai mũi họng</li></ul><h2>Ưu Điểm Nổi Bật</h2><p><strong>1. Trang Thiết Bị Hiện Đại</strong></p><ul><li>Máy xét nghiệm tự động</li><li>Hệ thống chụp X-quang kỹ thuật số</li><li>Máy siêu âm đời mới</li><li>Thiết bị nội soi tiên tiến</li></ul><p><strong>2. Đội Ngũ Chuyên Môn</strong></p><ul><li>Kỹ thuật viên được đào tạo bài bản</li><li>Bác sĩ giàu kinh nghiệm đọc kết quả</li><li>Nhân viên phòng xét nghiệm chuyên nghiệp</li></ul><p><strong>3. Quy Trình Thực Hiện</strong></p><ul><li>Tuân thủ nghiêm ngặt quy trình vô trùng</li><li>Kiểm soát chất lượng thường xuyên</li><li>Bảo quản mẫu đúng tiêu chuẩn</li></ul><h2>Quy Trình Thực Hiện</h2><p><strong>1. Tiếp Nhận Yêu Cầu</strong></p><ul><li>Kiểm tra chỉ định của bác sĩ</li><li>Hướng dẫn chuẩn bị cho xét nghiệm</li><li>Tư vấn chi phí và thời gian</li></ul><p><strong>2. Lấy Mẫu/Thực Hiện</strong></p><ul><li>Tuân thủ quy trình kỹ thuật</li><li>Đảm bảo an toàn cho người bệnh</li><li>Ghi nhận thông tin chính xác</li></ul><p><strong>3. Xử Lý Và Phân Tích</strong></p><ul><li>Phân tích mẫu theo tiêu chuẩn</li><li>Kiểm tra chất lượng kết quả</li><li>Lưu trữ dữ liệu an toàn</li></ul><p><strong>4. Trả Kết Quả</strong></p><ul><li>Bác sĩ đọc và nhận định</li><li>In kết quả chi tiết</li><li>Giải thích cho người bệnh</li></ul><h2>Thời Gian Trả Kết Quả</h2><ul><li>Xét nghiệm thông thường: 2-4 giờ</li><li>Xét nghiệm chuyên sâu: 24-48 giờ</li><li>Chẩn đoán hình ảnh: 15-30 phút</li><li>Trường hợp khẩn cấp: ưu tiên xử lý nhanh</li></ul><h2>Chính Sách Giá</h2><ul><li>Niêm yết công khai, minh bạch</li><li>Theo đúng quy định của ngành y tế</li><li>Áp dụng bảo hiểm y tế</li><li>Có chính sách ưu đãi cho gói khám</li></ul><h2>Thông Tin Liên Hệ</h2><p><strong>Phòng Khám Đa Khoa Ngọc Nhân</strong></p><ul><li>Địa chỉ: [Địa chỉ cụ thể tại Trà Ôn, Vĩnh Long]</li><li>Hotline: [Số điện thoại]</li><li>Giờ làm việc: 7:00 - 20:00 (Tất cả các ngày trong tuần)</li><li>Website: [Website phòng khám]</li></ul><h2>Lời Khuyên Cho Người Bệnh</h2><ul><li>Tuân thủ hướng dẫn chuẩn bị trước xét nghiệm</li><li>Thông báo tiền sử dị ứng (nếu có)</li><li>Mang theo giấy tờ tùy thân và thẻ BHYT</li><li>Đến đúng giờ hẹn để được phục vụ tốt nhất</li></ul><p><br></p>',
                'image' => 'uploads//01JMTXAR411Y5815M5X14HW73Y.webp'
            ]);

            Service::create([
                'name' => 'Xét nghiệm',
                'description' => '<h1>Dịch Vụ Xét Nghiệm Tại Phòng Khám Đa Khoa Ngọc Nhân - Trà Ôn, Vĩnh Long</h1><p>Phòng khám Đa khoa Ngọc Nhân cung cấp dịch vụ xét nghiệm toàn diện với hệ thống máy móc hiện đại, đội ngũ kỹ thuật viên chuyên nghiệp, đảm bảo kết quả chính xác và nhanh chóng cho người bệnh.</p><h2>Các Loại Xét Nghiệm Chính</h2><p><strong>1. Xét Nghiệm Máu</strong></p><ul><li>Công thức máu toàn phần</li><li>Nhóm máu và yếu tố Rh</li><li>Đường huyết</li><li>Mỡ máu (Cholesterol, Triglyceride)</li><li>Men gan (AST, ALT, GGT)</li><li>Chức năng thận (Ure, Creatinine)</li><li>Axit uric</li><li>Điện giải đồ</li><li>CRP (phát hiện viêm)</li><li>HbA1C (đái tháo đường)</li></ul><p><strong>2. Xét Nghiệm Nước Tiểu</strong></p><ul><li>Tổng phân tích nước tiểu</li><li>Protein niệu</li><li>Đường niệu</li><li>Tìm hồng cầu, bạch cầu</li><li>Tỷ trọng nước tiểu</li><li>Vi khuẩn niệu</li></ul><p><strong>3. Xét Nghiệm Vi Sinh</strong></p><ul><li>Cấy máu</li><li>Cấy đờm</li><li>Cấy nước tiểu</li><li>Cấy phân</li><li>Kháng sinh đồ</li></ul><p><strong>4. Xét Nghiệm Miễn Dịch</strong></p><ul><li>HIV</li><li>Viêm gan B, C</li><li>Giang mai</li><li>Thyroid (T3, T4, TSH)</li><li>Dấu ấn ung thư</li></ul><h2>Quy Trình Xét Nghiệm</h2><p><strong>1. Đăng Ký và Tư Vấn</strong></p><ul><li>Tiếp nhận chỉ định xét nghiệm</li><li>Tư vấn chuẩn bị trước xét nghiệm</li><li>Hướng dẫn thủ tục hành chính</li></ul><p><strong>2. Chuẩn Bị Người Bệnh</strong></p><ul><li>Kiểm tra thông tin cá nhân</li><li>Hướng dẫn nhịn ăn (nếu cần)</li><li>Giải thích quy trình lấy mẫu</li></ul><p><strong>3. Lấy Mẫu Xét Nghiệm</strong></p><ul><li>Thực hiện theo quy trình vô trùng</li><li>Lấy đủ lượng mẫu cần thiết</li><li>Bảo quản mẫu đúng tiêu chuẩn</li></ul><p><strong>4. Phân Tích Mẫu</strong></p><ul><li>Xử lý mẫu theo quy trình</li><li>Kiểm tra chất lượng</li><li>Ghi nhận kết quả</li></ul><p><strong>5. Trả Kết Quả</strong></p><ul><li>Bác sĩ kiểm tra và ký kết quả</li><li>In phiếu kết quả chi tiết</li><li>Giải thích kết quả cho người bệnh</li></ul><h2>Ưu Điểm Dịch Vụ</h2><p><strong>1. Trang Thiết Bị</strong></p><ul><li>Máy xét nghiệm tự động hiện đại</li><li>Hệ thống lưu trữ mẫu chuyên nghiệp</li><li>Phòng xét nghiệm đạt chuẩn</li></ul><p><strong>2. Đội Ngũ Nhân Viên</strong></p><ul><li>Kỹ thuật viên có chuyên môn cao</li><li>Bác sĩ giàu kinh nghiệm</li><li>Nhân viên phục vụ tận tình</li></ul><p><strong>3. Quy Trình Thực Hiện</strong></p><ul><li>Tuân thủ quy trình vô trùng</li><li>Kiểm soát chất lượng nghiêm ngặt</li><li>Bảo mật thông tin người bệnh</li></ul><h2>Thời Gian Trả Kết Quả</h2><ul><li>Xét nghiệm thông thường: 2-4 giờ</li><li>Xét nghiệm vi sinh: 24-72 giờ</li><li>Xét nghiệm đặc biệt: theo thông báo</li><li>Có dịch vụ trả kết quả khẩn cấp</li></ul><h2>Chính Sách Giá và Thanh Toán</h2><ul><li>Giá cả niêm yết công khai</li><li>Áp dụng bảo hiểm y tế</li><li>Thanh toán linh hoạt</li><li>Có gói ưu đãi cho khám định kỳ</li></ul><h2>Thông Tin Liên Hệ</h2><p><strong>Phòng Khám Đa Khoa Ngọc Nhân</strong></p><ul><li>Địa chỉ: [Địa chỉ cụ thể tại Trà Ôn, Vĩnh Long]</li><li>Hotline: [Số điện thoại]</li><li>Giờ làm việc: 7:00 - 20:00 (Tất cả các ngày trong tuần)</li><li>Website: [Website phòng khám]</li></ul><h2>Lưu Ý Khi Đi Xét Nghiệm</h2><ul><li>Mang theo giấy tờ tùy thân</li><li>Nhịn ăn trước khi xét nghiệm máu</li><li>Thông báo về thuốc đang sử dụng</li><li>Đến đúng giờ hẹn</li></ul><p><br></p>',
                'image' => 'uploads//01JMTXCEEP8B4DZDQZD0N9665T.webp'
            ]);

            Service::create([
                'name' => 'Tiêm Chủng',
                'description' => '<h1>Dịch Vụ Tiêm Chủng An Toàn Tại Phòng Khám Đa Khoa Ngọc Nhân - Trà Ôn, Vĩnh Long</h1><p>Phòng khám Đa khoa Ngọc Nhân cung cấp dịch vụ tiêm chủng chất lượng cao, đảm bảo an toàn tuyệt đối với đầy đủ các loại vaccine thiết yếu cho mọi lứa tuổi. Chúng tôi tuân thủ nghiêm ngặt quy trình tiêm chủng theo hướng dẫn của Bộ Y tế.</p><h2>Các Loại Vaccine</h2><p><strong>1. Vaccine Cho Trẻ Em</strong></p><ul><li>Vaccine 6 trong 1</li><li>Vaccine phòng viêm não Nhật Bản</li><li>Vaccine phòng rotavirus</li><li>Vaccine phòng thủy đậu</li><li>Vaccine phòng cúm</li><li>Vaccine phòng viêm phổi</li><li>Vaccine phòng sởi - quai bị - rubella</li></ul><p><strong>2. Vaccine Cho Người Lớn</strong></p><ul><li>Vaccine phòng viêm gan A, B</li><li>Vaccine phòng cúm mùa</li><li>Vaccine phòng uốn ván</li><li>Vaccine phòng HPV</li><li>Vaccine phòng phế cầu</li><li>Vaccine phòng dại</li></ul><h2>Quy Trình Tiêm Chủng An Toàn</h2><p><strong>1. Tư Vấn Trước Tiêm</strong></p><ul><li>Khám sàng lọc</li><li>Kiểm tra chống chỉ định</li><li>Tư vấn lịch tiêm phù hợp</li><li>Giải đáp thắc mắc cho phụ huynh/người tiêm</li></ul><p><strong>2. Chuẩn Bị Tiêm</strong></p><ul><li>Kiểm tra vaccine</li><li>Đảm bảo dây chuyền lạnh</li><li>Chuẩn bị dụng cụ vô trùng</li><li>Rửa tay sát khuẩn</li></ul><p><strong>3. Thực Hiện Tiêm</strong></p><ul><li>Kiểm tra lại thông tin</li><li>Sát khuẩn vị trí tiêm</li><li>Tiêm đúng kỹ thuật</li><li>Theo dõi ngay lập tức</li></ul><p><strong>4. Theo Dõi Sau Tiêm</strong></p><ul><li>Theo dõi 30 phút tại phòng khám</li><li>Hướng dẫn theo dõi tại nhà</li><li>Xử trí kịp thời nếu có phản ứng</li><li>Lập lịch tiêm mũi tiếp theo</li></ul><h2>Ưu Điểm Dịch Vụ</h2><p><strong>1. Đảm Bảo Chất Lượng</strong></p><ul><li>Vaccine chính hãng</li><li>Nguồn gốc rõ ràng</li><li>Bảo quản đúng quy định</li><li>Hệ thống dây chuyền lạnh chuẩn</li></ul><p><strong>2. Đội Ngũ Y Tế</strong></p><ul><li>Bác sĩ chuyên khoa nhi</li><li>Điều dưỡng giàu kinh nghiệm</li><li>Thường xuyên cập nhật kiến thức</li><li>Tận tâm, chu đáo</li></ul><p><strong>3. Cơ Sở Vật Chất</strong></p><ul><li>Phòng tiêm riêng biệt</li><li>Trang thiết bị hiện đại</li><li>Phòng theo dõi thoáng mát</li><li>Khu vực chờ tiện nghi</li></ul><h2>Dịch Vụ Đặc Biệt</h2><ul><li>Nhắc lịch tiêm tự động</li><li>Tư vấn 24/7 qua điện thoại</li><li>Hỗ trợ cấp cứu tại chỗ</li><li>Cấp sổ theo dõi tiêm chủng</li></ul><h2>Thông Tin Thực Hiện</h2><p><strong>1. Thời Gian</strong></p><ul><li>Thứ 2 - Chủ nhật: 7:00 - 20:00</li><li>Tiêm chủng theo lịch hẹn</li><li>Có dịch vụ tiêm ngoài giờ</li></ul><p><strong>2. Chi Phí</strong></p><ul><li>Niêm yết công khai</li><li>Tư vấn miễn phí</li><li>Có gói tiêm combo ưu đãi</li><li>Thanh toán linh hoạt</li></ul><h2>Lưu Ý Quan Trọng</h2><ul><li>Mang theo sổ tiêm chủng</li><li>Thông báo tiền sử dị ứng</li><li>Đến đúng giờ hẹn</li><li>Ăn uống đầy đủ trước tiêm</li></ul><h2>Thông Tin Liên Hệ</h2><p><strong>Phòng Khám Đa Khoa Ngọc Nhân</strong></p><ul><li>Địa chỉ: [Địa chỉ cụ thể tại Trà Ôn, Vĩnh Long]</li><li>Hotline: [Số điện thoại]</li><li>Website: [Website phòng khám]</li><li>Email: [Email phòng khám]</li></ul><h2>Tại Sao Chọn Tiêm Chủng Tại Ngọc Nhân?</h2><ol><li>An toàn tuyệt đối</li><li>Đội ngũ chuyên nghiệp</li><li>Vaccine chất lượng cao</li><li>Giá cả hợp lý</li><li>Chăm sóc tận tâm</li></ol><p><br></p>',
                'image' => 'uploads//01JMTXFMHSHQHDZXE2EQZAQSPH.webp'
            ]);

            Service::create([
                'name' => 'Nha khoa',
                'description' => '<h1>Dịch Vụ Nha Khoa Tại Phòng Khám Đa Khoa Ngọc Nhân - Trà Ôn, Vĩnh Long</h1><p>Phòng khám Đa khoa Ngọc Nhân cung cấp các dịch vụ nha khoa chất lượng cao với đội ngũ bác sĩ chuyên môn giỏi và trang thiết bị hiện đại. Chúng tôi cam kết mang đến nụ cười khỏe đẹp cho mọi bệnh nhân.</p><h2>Các Dịch Vụ Nha Khoa Chính</h2><p><strong>1. Khám Và Điều Trị Răng</strong></p><ul><li>Khám tổng quát răng miệng</li><li>Chụp X-quang răng</li><li>Điều trị sâu răng</li><li>Lấy tủy răng</li><li>Trám răng thẩm mỹ</li><li>Điều trị viêm nướu</li><li>Cạo vôi răng</li></ul><p><strong>2. Phục Hình Răng</strong></p><ul><li>Bọc răng sứ</li><li>Cầu răng sứ</li><li>Mão răng sứ</li><li>Trồng răng implant</li><li>Hàm giả tháo lắp</li><li>Veneer sứ</li></ul><p><strong>3. Chỉnh Nha</strong></p><ul><li>Niềng răng thẩm mỹ</li><li>Niềng răng mắc cài kim loại</li><li>Niềng răng mắc cài sứ</li><li>Niềng răng trong suốt</li></ul><p><strong>4. Thẩm Mỹ Nha Khoa</strong></p><ul><li>Tẩy trắng răng</li><li>Đính đá răng</li><li>Dán sứ Veneer</li><li>Phục hình răng thẩm mỹ</li></ul><h2>Ưu Điểm Dịch Vụ</h2><p><strong>1. Đội Ngũ Y Bác Sĩ</strong></p><ul><li>Bác sĩ chuyên khoa răng hàm mặt</li><li>Nhiều năm kinh nghiệm</li><li>Thường xuyên cập nhật kỹ thuật mới</li><li>Tận tâm với bệnh nhân</li></ul><p><strong>2. Trang Thiết Bị</strong></p><ul><li>Ghế nha khoa hiện đại</li><li>Máy chụp X-quang kỹ thuật số</li><li>Thiết bị khử trùng tiên tiến</li><li>Vật liệu nha khoa chất lượng cao</li></ul><p><strong>3. Quy Trình Điều Trị</strong></p><ul><li>Thăm khám tỉ mỉ</li><li>Lên kế hoạch điều trị chi tiết</li><li>Tư vấn rõ ràng, minh bạch</li><li>Theo dõi sau điều trị</li></ul><h2>Quy Trình Khám Và Điều Trị</h2><p><strong>1. Tiếp Nhận</strong></p><ul><li>Đăng ký thông tin</li><li>Tư vấn sơ bộ</li><li>Sắp xếp lịch khám</li></ul><p><strong>2. Thăm Khám</strong></p><ul><li>Khám tổng quát răng miệng</li><li>Chụp X-quang (nếu cần)</li><li>Chẩn đoán tình trạng</li></ul><p><strong>3. Lập Kế Hoạch</strong></p><ul><li>Đề xuất phương án điều trị</li><li>Tư vấn chi phí</li><li>Lên lịch điều trị</li></ul><p><strong>4. Điều Trị</strong></p><ul><li>Thực hiện theo kế hoạch</li><li>Giải thích từng bước</li><li>Đảm bảo an toàn, vô trùng</li></ul><p><strong>5. Theo Dõi</strong></p><ul><li>Hướng dẫn chăm sóc tại nhà</li><li>Tái khám định kỳ</li><li>Xử lý các vấn đề phát sinh</li></ul><h2>Chính Sách Giá</h2><ul><li>Báo giá chi tiết, minh bạch</li><li>Thanh toán linh hoạt</li><li>Có gói điều trị trọn gói</li><li>Bảo hành dài hạn</li></ul><h2>Tiêu Chuẩn Vô Trùng</h2><ul><li>Dụng cụ được tiệt trùng nghiêm ngặt</li><li>Thay găng tay, khẩu trang mới mỗi ca</li><li>Phòng khám được khử trùng thường xuyên</li><li>Tuân thủ quy trình kiểm soát nhiễm khuẩn</li></ul><h2>Thông Tin Liên Hệ</h2><p><strong>Phòng Khám Đa Khoa Ngọc Nhân</strong></p><ul><li>Địa chỉ: [Địa chỉ cụ thể tại Trà Ôn, Vĩnh Long]</li><li>Hotline: [Số điện thoại]</li><li>Giờ làm việc: 7:00 - 20:00 (Tất cả các ngày trong tuần)</li><li>Website: [Website phòng khám]</li></ul><p><br></p>',
                'image' => 'uploads//01JMTXH654FB5DKHNAHN8RC1SR.webp'
            ]);

            Doctor::create([
                'name' => 'TS.BS Dũng',
                'description' => '<p>Giám đốc chuyên môn: Chuyên khoa Tim mạch</p>',
                'image' => 'uploads//01JMTGKZT0TSCFTEQ9DSJ33G48.jpg'
            ]);

            Doctor::create([
                'name' => 'PGS.TS Trần',
                'description' => '<p>Trưởng khoa Nội: Chuyên gia Nội khoa</p>',
                'image' => 'uploads//01JMTGP62PAWETBK8J34VR9SB0.jpg'
            ]);

            Doctor::create([
                'name' => 'BS.CKI Vinh',
                'description' => '<p>Trưởng khoa Ngoại: Phẫu thuật tổng quát</p>',
                'image' => 'uploads//01JMTGRV1DWMM142WR3AK8H1JC.jpg'
            ]);

            Doctor::create([
                'name' => 'BS.CKI Hoàng',
                'description' => '<p>Trưởng khoa Cấp cứu: Cấp cứu - Hồi sức</p>',
                'image' => 'uploads//01JMTGXQ5ZQB1SGHZP80Y5BEWF.jpg'
            ]);

            Carousel::create([
                'image' => 'uploads//01JMSKCWGSPB7WSMB32891SS2K.jpg'
            ]);

            Carousel::create([
                'image' => 'uploads//01JMSKDCDKQM9MFEBBRR6XP7GR.png'
            ]);

            Carousel::create([
                'image' => 'uploads//01JMSKDXXY080DXFRPSEBAKA06.jpg'
            ]);

            // Tạo dữ liệu mẫu cho menu items
            MenuItem::create([
                'label' => 'Trang chủ',
                'type' => 'link',
                'link' => 'http://127.0.0.1:8000/',
                'order' => 1,
            ]);

            MenuItem::create([
                'label' => 'Giới thiệu',
                'type' => 'link', 
                'link' => 'http://127.0.0.1:8000/',
                'order' => 2,
            ]);

            MenuItem::create([
                'parent_id' => 2,
                'label' => 'Phòng khám',
                'type' => 'post',
                'post_id' => 2,
                'order' => 4,
            ]);

            MenuItem::create([
                'parent_id' => 2,
                'label' => 'Bác sĩ chuyên khoa',
                'type' => 'post',
                'post_id' => 3,
                'order' => 3, 
            ]);

            MenuItem::create([
                'label' => 'Dịch vụ',
                'type' => 'link',
                'link' => 'http://127.0.0.1:8000/',
                'order' => 5,
            ]);

            MenuItem::create([
                'parent_id' => 5,
                'label' => 'Khám chuyên khoa',
                'type' => 'post',
                'post_id' => 5,
                'order' => 6,
            ]);

            MenuItem::create([
                'parent_id' => 5,
                'label' => 'Tiêm chủng',
                'type' => 'post',
                'post_id' => 7,
                'order' => 7,
            ]);

            MenuItem::create([
                'parent_id' => 5,
                'label' => 'Khám sức khỏe',
                'type' => 'post',
                'post_id' => 6,
                'order' => 8,
            ]);

            MenuItem::create([
                'label' => 'Tuyển dụng',
                'type' => 'post',
                'post_id' => 8,
                'order' => 9,
            ]);

            MenuItem::create([
                'label' => 'Tin tức sự kiện',
                'type' => 'cat',
                'cat_id' => 1,
                'order' => 10,
            ]);

            MenuItem::create([
                'label' => 'An sinh xã hội',
                'type' => 'cat',
                'cat_id' => 2,
                'order' => 11,
            ]);

            MenuItem::create([
                'label' => 'Chi phí khám bệnh',
                'type' => 'post',
                'post_id' => 11,
                'order' => 12,
            ]);

            Video::insert([
                [
                    'title' => 'Phòng Tiêm ngừa chất lượng cao',
                    'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                    'display_order' => 1,
                    'is_hot' => true,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'title' => 'Quy trình khám bệnh',
                    'youtube_url' => 'https://www.youtube.com/watch?v=oHg5SJYRHA0',
                    'display_order' => 2,
                    'is_hot' => false,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'title' => 'Phòng khám Ngọc Nhân',
                    'youtube_url' => 'https://www.youtube.com/watch?v=tgbNymZ7vqY',
                    'display_order' => 3,
                    'is_hot' => false,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'title' => 'Khám tổng quát cho người lớn tuổi',
                    'youtube_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                    'display_order' => 4,
                    'is_hot' => false,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);

        }
    }



