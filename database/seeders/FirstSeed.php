<?php

    namespace Database\Seeders;

    use App\Models\CatPost;
    use App\Models\Post;
    use App\Models\Setting;
    use App\Models\User;
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
                'name' => 'Bệnh Viện Đa Khoa Ngọc Nhân',
                'hotline' => '1900 1234',
                'email' => 'ngocnhan@gmail.com',
                'address' => 'Số 1, Đường 1, Phường 1, Quận 1, TP.HCM',
                'logo' => 'logo.png',
                'slogan' => 'Bệnh Viện Đa Khoa Ngọc Nhân Tốt Nhất',
                'image_schedule' => 'image_schedule.png',
                'zalo' => '1900 1234',
                'facebook' => 'https://www.facebook.com/ngocnhan',
                'messenger' => 'https://www.messenger.com/ngocnhan',
                'google_map' => 'https://www.google.com/maps/place/Bệnh+Viện+Đa+Khoa+Ngọc+Nhân/@10',
                'mst' => '123456789',
            ]);

            CatPost::create([
                'name' => 'Danh Mục 1',
                'content' => 'Nội dung danh mục 1',
            ]);

            Post::create([
                'name' => 'Bài Viết 1',
                'content' => 'Nội dung bài viết 1',
                'image' => 'image1.png',
                'user_id' => 1,
                'cat_post_id' => 1,
            ]);
        }
    }
