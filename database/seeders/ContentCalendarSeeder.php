<?php

namespace Database\Seeders;

use App\Models\ContentCalendar;
use Illuminate\Database\Seeder;

class ContentCalendarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            [
                'event_date' => '2024-01-01',
                'event_name' => 'Tahun Baru',
                'event_type' => 'national_holiday',
                'description' => 'Merayakan pergantian tahun dengan semangat baru untuk bisnis',
                'content_ideas' => [
                    'Resolusi bisnis 2024',
                    'Terima kasih pelanggan tahun lalu',
                    'Target dan goals bisnis baru',
                    'Promo spesial tahun baru',
                    'Behind the scenes persiapan tahun baru'
                ],
                'hashtags' => ['tahunbaru2024', 'resolusi', 'semangatbaru', 'bisnisukm', 'indonesia']
            ],
            [
                'event_date' => '2024-02-08',
                'event_name' => 'Imlek/Chinese New Year',
                'event_type' => 'cultural',
                'description' => 'Perayaan tahun baru Tionghoa yang dirayakan komunitas Tionghoa Indonesia',
                'content_ideas' => [
                    'Ucapan selamat Imlek',
                    'Promo spesial Imlek',
                    'Tradisi Imlek dan bisnis',
                    'Makanan khas Imlek',
                    'Dekorasi merah dan emas'
                ],
                'hashtags' => ['imlek2024', 'chinesenewyear', 'gongxifacai', 'tradisi', 'keberuntungan']
            ],
            [
                'event_date' => '2024-02-14',
                'event_name' => 'Valentine Day',
                'event_type' => 'commercial',
                'description' => 'Hari kasih sayang yang menjadi momen spesial untuk promosi bisnis',
                'content_ideas' => [
                    'Promo spesial Valentine',
                    'Gift ideas untuk pasangan',
                    'Self love dan self care',
                    'Paket couple/romantis',
                    'Customer love stories'
                ],
                'hashtags' => ['valentine2024', 'cinta', 'hadiah', 'romantis', 'sayang']
            ],
            [
                'event_date' => '2024-03-08',
                'event_name' => 'Hari Perempuan Internasional',
                'event_type' => 'international',
                'description' => 'Merayakan pencapaian perempuan dan mendorong kesetaraan gender',
                'content_ideas' => [
                    'Apresiasi pelanggan perempuan',
                    'Produk khusus perempuan',
                    'Inspirasi wanita entrepreneur',
                    'Self empowerment content',
                    'Behind the scenes tim perempuan'
                ],
                'hashtags' => ['hariperempuan', 'womensday', 'empowerment', 'inspirasi', 'perempuanindonesia']
            ],
            [
                'event_date' => '2024-04-10',
                'event_name' => 'Idul Fitri',
                'event_type' => 'religious',
                'description' => 'Hari raya umat Islam setelah menjalankan ibadah puasa Ramadan',
                'content_ideas' => [
                    'Ucapan selamat Idul Fitri',
                    'Promo lebaran',
                    'Paket mudik/silaturahmi',
                    'Makanan khas lebaran',
                    'Tradisi lebaran Indonesia'
                ],
                'hashtags' => ['idulfitri', 'lebaran', 'mudik', 'silaturahmi', 'maafzahirbatin']
            ],
            [
                'event_date' => '2024-05-01',
                'event_name' => 'Hari Buruh',
                'event_type' => 'national_holiday',
                'description' => 'Memperingati perjuangan kaum buruh dan pekerja',
                'content_ideas' => [
                    'Apresiasi karyawan/tim',
                    'Work-life balance tips',
                    'Employee of the month',
                    'Behind the scenes tim kerja',
                    'Career opportunities'
                ],
                'hashtags' => ['hariburuh', 'pekerja', 'apresiasi', 'tim', 'karir']
            ],
            [
                'event_date' => '2024-05-12',
                'event_name' => 'Hari Ibu',
                'event_type' => 'national',
                'description' => 'Memperingati jasa dan pengorbanan para ibu',
                'content_ideas' => [
                    'Ucapan Hari Ibu',
                    'Promo spesial untuk ibu',
                    'Mom entrepreneur stories',
                    'Self care untuk ibu',
                    'Produk ramah ibu dan anak'
                ],
                'hashtags' => ['hariibu', 'ibu', 'kasihibu', 'mom', 'keluarga']
            ],
            [
                'event_date' => '2024-08-17',
                'event_name' => 'Hari Kemerdekaan RI',
                'event_type' => 'national_holiday',
                'description' => 'Memperingati kemerdekaan Indonesia ke-79',
                'content_ideas' => [
                    'Semangat kemerdekaan',
                    'Produk lokal Indonesia',
                    'Promo kemerdekaan',
                    'Cinta produk Indonesia',
                    'Sejarah perjuangan bangsa'
                ],
                'hashtags' => ['kemerdekaan', 'hutri79', 'indonesia', 'merdeka', 'produklokal']
            ],
            [
                'event_date' => '2024-10-01',
                'event_name' => 'Hari Batik Nasional',
                'event_type' => 'cultural',
                'description' => 'Memperingati penetapan batik sebagai warisan budaya dunia',
                'content_ideas' => [
                    'Keindahan batik Indonesia',
                    'Produk dengan motif batik',
                    'Sejarah batik nusantara',
                    'Modern batik fashion',
                    'Support pengrajin batik'
                ],
                'hashtags' => ['haribatik', 'batik', 'budayaindonesia', 'warisan', 'tradisi']
            ],
            [
                'event_date' => '2024-11-10',
                'event_name' => 'Hari Pahlawan',
                'event_type' => 'national_holiday',
                'description' => 'Memperingati jasa para pahlawan bangsa',
                'content_ideas' => [
                    'Mengenang jasa pahlawan',
                    'Semangat juang dalam bisnis',
                    'Heroes behind the brand',
                    'Nilai-nilai kepahlawanan',
                    'Inspirasi dari tokoh pahlawan'
                ],
                'hashtags' => ['haripahlawan', 'pahlawan', 'jasa', 'perjuangan', 'inspirasi']
            ],
            [
                'event_date' => '2024-11-11',
                'event_name' => 'Hari Belanja Online Nasional',
                'event_type' => 'commercial',
                'description' => 'Hari belanja online terbesar di Indonesia (11.11)',
                'content_ideas' => [
                    'Flash sale 11.11',
                    'Promo gila-gilaan',
                    'Bundle deals spesial',
                    'Cashback dan diskon',
                    'Shopping tips dan tricks'
                ],
                'hashtags' => ['harbelnas', '1111', 'sale', 'diskon', 'belanja']
            ],
            [
                'event_date' => '2024-12-25',
                'event_name' => 'Hari Natal',
                'event_type' => 'religious',
                'description' => 'Perayaan kelahiran Yesus Kristus',
                'content_ideas' => [
                    'Ucapan selamat Natal',
                    'Promo spesial Natal',
                    'Gift ideas Natal',
                    'Dekorasi Natal',
                    'Family time dan togetherness'
                ],
                'hashtags' => ['natal2024', 'christmas', 'hadiah', 'keluarga', 'perayaan']
            ]
        ];

        foreach ($events as $event) {
            ContentCalendar::create($event);
        }
    }
}