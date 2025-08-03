<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\GeneratedContent;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContentHistoryController extends Controller
{
    /**
     * Display user's content history.
     */
    public function index(Request $request)
    {
        $query = auth()->user()
            ->generatedContents()
            ->with('contentType')
            ->latest();

        // Filter by status if provided
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Filter by content type if provided
        if ($request->content_type) {
            $query->where('content_type_id', $request->content_type);
        }

        // Search by title if provided
        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $contents = $query->paginate(15)->withQueryString();

        return Inertia::render('content-history', [
            'contents' => $contents,
            'filters' => $request->only(['status', 'content_type', 'search']),
        ]);
    }

    /**
     * Delete generated content.
     */
    public function destroy(GeneratedContent $content)
    {
        // Ensure user owns this content
        if ($content->user_id !== auth()->id()) {
            abort(403);
        }

        $content->delete();

        return back()->with('success', 'Konten berhasil dihapus.');
    }
}