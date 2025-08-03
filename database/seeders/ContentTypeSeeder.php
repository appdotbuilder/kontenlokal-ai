<?php

namespace Database\Seeders;

use App\Models\ContentType;
use Illuminate\Database\Seeder;

class ContentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contentTypes = [
            [
                'name' => 'Naskah Video TikTok/Reels',
                'slug' => 'tiktok-reels-script',
                'description' => 'Generate engaging scripts for TikTok videos and Instagram Reels that capture attention and drive engagement.',
                'credit_cost' => 2,
                'prompt_template' => [
                    'system' => 'You are a creative content writer specializing in Indonesian social media content. Create engaging TikTok/Reels scripts that are trendy, relatable, and suitable for Indonesian UKM businesses.',
                    'user' => 'Create a TikTok/Reels script for: {description}. Style: {style}. Target audience: Indonesian consumers. Brand voice: {brand_voice}. Keep it under 30 seconds, use trending Indonesian phrases, and include a clear call-to-action.'
                ],
                'input_fields' => [
                    [
                        'name' => 'description',
                        'label' => 'Deskripsi Konten',
                        'type' => 'textarea',
                        'placeholder' => 'Jelaskan produk/layanan dan pesan yang ingin disampaikan...',
                        'required' => true
                    ],
                    [
                        'name' => 'style',
                        'label' => 'Gaya Konten',
                        'type' => 'select',
                        'options' => [
                            ['value' => 'casual', 'label' => 'Santai & Friendly'],
                            ['value' => 'professional', 'label' => 'Professional'],
                            ['value' => 'humorous', 'label' => 'Humor & Menghibur'],
                            ['value' => 'educational', 'label' => 'Edukatif'],
                            ['value' => 'trending', 'label' => 'Ikut Trend Terkini']
                        ],
                        'required' => true
                    ]
                ]
            ],
            [
                'name' => 'Email Marketing',
                'slug' => 'email-marketing',
                'description' => 'Create compelling email marketing campaigns that convert subscribers into customers.',
                'credit_cost' => 1,
                'prompt_template' => [
                    'system' => 'You are an expert email marketing copywriter for Indonesian businesses. Create compelling emails that drive action and build customer relationships.',
                    'user' => 'Create an email marketing campaign for: {description}. Email type: {email_type}. Target audience: {target_audience}. Brand voice: {brand_voice}. Include subject line, greeting, body, and clear CTA. Use Indonesian language and cultural context.'
                ],
                'input_fields' => [
                    [
                        'name' => 'description',
                        'label' => 'Tujuan Email',
                        'type' => 'textarea',
                        'placeholder' => 'Jelaskan tujuan email ini (promosi, newsletter, follow-up, dll)...',
                        'required' => true
                    ],
                    [
                        'name' => 'email_type',
                        'label' => 'Jenis Email',
                        'type' => 'select',
                        'options' => [
                            ['value' => 'promotion', 'label' => 'Email Promosi'],
                            ['value' => 'newsletter', 'label' => 'Newsletter'],
                            ['value' => 'welcome', 'label' => 'Email Selamat Datang'],
                            ['value' => 'follow_up', 'label' => 'Follow Up'],
                            ['value' => 'cart_abandonment', 'label' => 'Keranjang Ditinggal']
                        ],
                        'required' => true
                    ],
                    [
                        'name' => 'target_audience',
                        'label' => 'Target Audience',
                        'type' => 'text',
                        'placeholder' => 'Contoh: Ibu rumah tangga usia 25-40 tahun',
                        'required' => true
                    ]
                ]
            ],
            [
                'name' => 'Balasan Ulasan Pelanggan',
                'slug' => 'customer-review-response',
                'description' => 'Generate professional and personalized responses to customer reviews and feedback.',
                'credit_cost' => 1,
                'prompt_template' => [
                    'system' => 'You are a customer service expert for Indonesian businesses. Create professional, empathetic, and personalized responses to customer reviews that maintain brand reputation and show genuine care.',
                    'user' => 'Create a response to this customer review: "{review_text}". Review rating: {rating} stars. Response tone: {tone}. Brand voice: {brand_voice}. Address their concerns professionally and show appreciation for their feedback. Use polite Indonesian language.'
                ],
                'input_fields' => [
                    [
                        'name' => 'review_text',
                        'label' => 'Teks Ulasan Pelanggan',
                        'type' => 'textarea',
                        'placeholder' => 'Salin dan tempel ulasan pelanggan di sini...',
                        'required' => true
                    ],
                    [
                        'name' => 'rating',
                        'label' => 'Rating Ulasan',
                        'type' => 'select',
                        'options' => [
                            ['value' => '5', 'label' => '5 Bintang (Sangat Puas)'],
                            ['value' => '4', 'label' => '4 Bintang (Puas)'],
                            ['value' => '3', 'label' => '3 Bintang (Netral)'],
                            ['value' => '2', 'label' => '2 Bintang (Kurang Puas)'],
                            ['value' => '1', 'label' => '1 Bintang (Tidak Puas)']
                        ],
                        'required' => true
                    ],
                    [
                        'name' => 'tone',
                        'label' => 'Tone Balasan',
                        'type' => 'select',
                        'options' => [
                            ['value' => 'grateful', 'label' => 'Bersyukur & Menghargai'],
                            ['value' => 'apologetic', 'label' => 'Minta Maaf & Empati'],
                            ['value' => 'professional', 'label' => 'Professional & Formal'],
                            ['value' => 'friendly', 'label' => 'Ramah & Personal']
                        ],
                        'required' => true
                    ]
                ]
            ],
            [
                'name' => 'Caption Instagram',
                'slug' => 'instagram-caption',
                'description' => 'Create engaging Instagram captions with relevant hashtags for your business posts.',
                'credit_cost' => 1,
                'prompt_template' => [
                    'system' => 'You are a social media content creator specializing in Indonesian Instagram content. Create engaging captions that drive engagement and include relevant hashtags.',
                    'user' => 'Create an Instagram caption for: {description}. Post type: {post_type}. Brand voice: {brand_voice}. Include relevant Indonesian hashtags. Make it engaging and encourage interaction from Indonesian followers.'
                ],
                'input_fields' => [
                    [
                        'name' => 'description',
                        'label' => 'Deskripsi Post',
                        'type' => 'textarea',
                        'placeholder' => 'Jelaskan konten foto/video yang akan dipost...',
                        'required' => true
                    ],
                    [
                        'name' => 'post_type',
                        'label' => 'Jenis Post',
                        'type' => 'select',
                        'options' => [
                            ['value' => 'product', 'label' => 'Produk/Layanan'],
                            ['value' => 'behind_scenes', 'label' => 'Behind the Scenes'],
                            ['value' => 'testimonial', 'label' => 'Testimoni Pelanggan'],
                            ['value' => 'educational', 'label' => 'Konten Edukatif'],
                            ['value' => 'lifestyle', 'label' => 'Lifestyle/Inspirational']
                        ],
                        'required' => true
                    ]
                ]
            ]
        ];

        foreach ($contentTypes as $type) {
            ContentType::create($type);
        }
    }
}