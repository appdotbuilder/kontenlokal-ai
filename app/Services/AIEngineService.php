<?php

namespace App\Services;

use App\Models\GeneratedContent;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIEngineService
{
    /**
     * Generate content using OpenAI API.
     */
    public function generateContent(GeneratedContent $generatedContent): array
    {
        try {
            $user = $generatedContent->user;
            $contentType = $generatedContent->contentType;
            
            $startTime = microtime(true);

            // Build the prompt
            $prompt = $this->buildPrompt(
                $contentType->prompt_template,
                $generatedContent->input_data,
                $user->brand_voice
            );

            // Make API call to OpenAI
            $response = $this->callOpenAI($prompt);
            
            $endTime = microtime(true);
            $processingTime = round($endTime - $startTime, 2);

            if ($response['success']) {
                return [
                    'success' => true,
                    'content' => $response['content'],
                    'model' => $response['model'],
                    'processing_time' => $processingTime,
                ];
            }

            return [
                'success' => false,
                'error' => $response['error'],
                'processing_time' => $processingTime,
            ];

        } catch (\Exception $e) {
            Log::error('AI content generation failed', [
                'content_id' => $generatedContent->id,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => 'Terjadi kesalahan saat menghasilkan konten. Silakan coba lagi.',
            ];
        }
    }

    /**
     * Build prompt from template and user input.
     *
     * @param array<string, string> $template
     * @param array<string, string> $inputData
     * @param string|null $brandVoice
     * @return array<int, array<string, string>>
     */
    public function buildPrompt(array $template, array $inputData, ?string $brandVoice): array
    {
        $systemPrompt = $template['system'];
        $userPrompt = $template['user'];

        // Replace placeholders with actual data
        foreach ($inputData as $key => $value) {
            $userPrompt = str_replace('{' . $key . '}', $value, $userPrompt);
        }

        // Replace brand voice
        $brandVoiceText = $brandVoice ?: 'Ramah, profesional, dan mudah dipahami';
        $userPrompt = str_replace('{brand_voice}', $brandVoiceText, $userPrompt);

        return [
            [
                'role' => 'system',
                'content' => $systemPrompt
            ],
            [
                'role' => 'user',
                'content' => $userPrompt
            ]
        ];
    }

    /**
     * Call OpenAI API.
     *
     * @param array<int, array<string, string>> $messages
     * @return array<string, mixed>
     */
    protected function callOpenAI(array $messages): array
    {
        // For demo purposes, we'll simulate API response
        // In production, replace this with actual OpenAI API call
        
        if (config('app.env') === 'testing' || !config('services.openai.api_key')) {
            return $this->simulateOpenAIResponse($messages);
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.openai.api_key'),
                'Content-Type' => 'application/json',
            ])->timeout(60)->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => $messages,
                'max_tokens' => 1000,
                'temperature' => 0.7,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                return [
                    'success' => true,
                    'content' => $data['choices'][0]['message']['content'],
                    'model' => $data['model'],
                ];
            }

            return [
                'success' => false,
                'error' => 'API call failed: ' . $response->body(),
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'API error: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Simulate OpenAI response for demo/testing.
     *
     * @param array<int, array<string, string>> $messages
     * @return array<string, mixed>
     */
    protected function simulateOpenAIResponse(array $messages): array
    {
        $userMessage = $messages[1]['content'] ?? '';
        
        // Generate simulated content based on the request
        $simulatedContent = $this->generateSimulatedContent($userMessage);

        // Simulate processing delay
        sleep(random_int(2, 5));

        return [
            'success' => true,
            'content' => $simulatedContent,
            'model' => 'gpt-3.5-turbo-demo',
        ];
    }

    /**
     * Generate simulated content for demo purposes.
     */
    protected function generateSimulatedContent(string $prompt): string
    {
        // Basic content templates based on common patterns
        $templates = [
            'tiktok' => "🎬 **Script TikTok/Reels yang Menarik!**\n\n**Opening (0-3 detik):**\n\"Eh, kamu tau gak sih...\" [Hook yang bikin penasaran]\n\n**Content (4-20 detik):**\n✨ Cerita singkat tentang produk/layanan\n✨ Manfaat utama yang bikin viewers tertarik\n✨ Social proof atau testimoni singkat\n\n**Closing (21-30 detik):**\n\"Yuk, langsung DM aja untuk info lebih lanjut!\"\n\n**Call to Action:**\n- Follow untuk tips lainnya\n- Comment pengalaman kamu\n- Share ke teman yang butuh!\n\n#ContentCreator #UKMIndonesia #ViralTikTok",
            
            'email' => "**Subject:** 🎉 Penawaran Spesial Hanya Untuk Anda!\n\n**Halo [Nama],**\n\nTerima kasih sudah menjadi bagian dari keluarga besar kami! 💝\n\nKami punya kabar gembira nih... Ada penawaran spesial yang gak boleh kamu lewatkan:\n\n✅ Diskon hingga 50% untuk produk pilihan\n✅ Free ongkir ke seluruh Indonesia\n✅ Bonus eksklusif untuk pembelian hari ini\n\n**Buruan, promo terbatas!**\n\nKlik tombol di bawah ini untuk belanja sekarang:\n[BELANJA SEKARANG]\n\nAda pertanyaan? Langsung balas email ini ya!\n\nSalam hangat,\nTim [Nama Brand]",
            
            'review' => "Halo [Nama Pelanggan],\n\nTerima kasih banyak atas ulasan dan waktu yang Anda berikan untuk berbagi pengalaman! 🙏\n\nKami sangat menghargai feedback Anda dan senang mengetahui bahwa produk/layanan kami bisa memenuhi ekspektasi.\n\nKepuasan pelanggan adalah prioritas utama kami, dan ulasan seperti ini motivasi besar untuk terus memberikan yang terbaik.\n\nJika ada yang bisa kami bantu di masa mendatang, jangan ragu untuk menghubungi kami ya!\n\nSekali lagi, terima kasih dan semoga hari Anda menyenangkan! 😊\n\nSalam,\n[Nama Brand]",
            
            'instagram' => "✨ Caption Instagram yang Engaging ✨\n\n[Emoji yang relevan] Hook yang menarik perhatian di awal!\n\nCerita singkat atau fakta menarik tentang produk/momen ini... \n\nManfaat atau value yang didapat followers:\n🔸 Poin 1\n🔸 Poin 2  \n🔸 Poin 3\n\n💬 Pertanyaan untuk engagement: \"Kalian setuju gak nih?\"\n\n---\n\n#hashtag #relevant #indonesia #ukm #bisnisonline #contentstrategy #socialmedia #marketing"
        ];

        // Determine content type and return appropriate template
        $prompt = strtolower($prompt);
        
        if (str_contains($prompt, 'tiktok') || str_contains($prompt, 'reels')) {
            return $templates['tiktok'];
        } elseif (str_contains($prompt, 'email')) {
            return $templates['email'];
        } elseif (str_contains($prompt, 'review') || str_contains($prompt, 'ulasan')) {
            return $templates['review'];
        } elseif (str_contains($prompt, 'instagram') || str_contains($prompt, 'caption')) {
            return $templates['instagram'];
        }

        // Default general content
        return "**Konten Marketing yang Menarik** 🚀\n\nBerdasarkan input Anda, berikut adalah konten yang telah disesuaikan dengan brand voice dan target audience:\n\n" . 
               "✨ Pembukaan yang menarik perhatian\n" .
               "📝 Pesan utama yang jelas dan mudah dipahami  \n" .
               "🎯 Call-to-action yang mengajak interaksi\n" .
               "💡 Touch point emosional dengan audience\n\n" .
               "Konten ini sudah disesuaikan dengan karakteristik pasar Indonesia dan tren terkini untuk memaksimalkan engagement! 🇮🇩";
    }
}