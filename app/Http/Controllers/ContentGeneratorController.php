<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContentRequest;
use App\Models\ContentType;
use App\Models\GeneratedContent;
use App\Services\AIEngineService;
use Illuminate\Http\Request;


class ContentGeneratorController extends Controller
{
    /**
     * Display the content generator page.
     */
    public function index()
    {
        $contentTypes = ContentType::active()->get();
        $recentContents = auth()->user()
            ->generatedContents()
            ->with('contentType')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($content): array {
                /** @var GeneratedContent $content */
                return [
                    'id' => $content->id,
                    'title' => $content->title,
                    'status' => $content->status,
                    'created_at' => $content->created_at->toISOString(),
                    'content_type' => [
                        'name' => $content->contentType->name,
                    ],
                ];
            });

        return view('content.generator', [
            'contentTypes' => $contentTypes,
            'recentContents' => $recentContents,
            'userCredits' => auth()->user()->credits,
        ]);
    }

    /**
     * Generate new content.
     */
    public function store(StoreContentRequest $request)
    {
        $user = auth()->user();
        $contentType = ContentType::findOrFail($request->content_type_id);

        // Check if user has enough credits
        if (!$user->hasCredits($contentType->credit_cost)) {
            return back()->withErrors([
                'credits' => 'Kredit tidak mencukupi untuk membuat konten ini.'
            ]);
        }

        // Create generated content record
        $generatedContent = GeneratedContent::create([
            'user_id' => $user->id,
            'content_type_id' => $contentType->id,
            'title' => $request->title,
            'input_data' => $request->input_data,
            'credits_used' => $contentType->credit_cost,
            'status' => 'pending',
        ]);

        // Deduct credits
        $user->deductCredits($contentType->credit_cost);

        // Process content generation
        app(\App\Services\ContentGenerationService::class)->processGeneration($generatedContent);

        return redirect()->route('content.show', $generatedContent)
            ->with('success', 'Konten berhasil dibuat!');
    }

    /**
     * Show specific generated content.
     */
    public function show(GeneratedContent $content)
    {
        // Ensure user owns this content
        if ($content->user_id !== auth()->id()) {
            abort(403);
        }

        $content->load('contentType');

        return view('content.show', [
            'content' => $content,
        ]);
    }


}