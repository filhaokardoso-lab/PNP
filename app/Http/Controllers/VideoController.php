<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class VideoController extends Controller
{
    // Show upload page for admins (reuses admin style for upload)
    public function create()
    {
        // Only administrators may access
        $user = Auth::user();
        if (!$user || !$user->hasRole('Administrador')) {
            return redirect()->route('dashboard.index')->with('error', 'Acesso negado');
        }

        // If migration not run yet, avoid querying non-existent table
        if (!Schema::hasTable('videos')) {
            $videos = collect();
        } else {
            $videos = Video::latest()->get();
        }
        return view('admin.videos-upload', compact('videos'));
    }

    // Store a new video (expects a YouTube URL and optional title/description)
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole('Administrador')) {
            return redirect()->route('dashboard.index')->with('error', 'Acesso negado');
        }
        // Ensure the videos table exists to avoid QueryException when migrations not run
        if (!Schema::hasTable('videos')) {
            return redirect()->back()->withInput()->with('error', 'Tabela "videos" não encontrada. Rode "php artisan migrate" para criar as tabelas necessárias.');
        }

        $request->validate([
            'url' => 'required|url',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        // Extract YouTube ID; accept common YouTube URL formats (youtu.be, v=, /embed/)
        $url = $request->input('url');
        $youtubeId = $this->extractYoutubeId($url);

        if (!$youtubeId) {
            return redirect()->back()->withInput()->withErrors(['url' => 'Apenas URLs do YouTube são aceitas (ex: https://youtu.be/ID ou https://www.youtube.com/watch?v=ID)']);
        }

        // Store normalized embed URL
        $embedUrl = "https://www.youtube.com/embed/{$youtubeId}";

        Video::create([
            'title' => $request->title,
            'url' => $embedUrl,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Vídeo adicionado com sucesso!');
    }

    /**
     * Try to extract a YouTube video ID from a URL.
     * Returns the 11-character ID or null.
     */
    private function extractYoutubeId(string $url): ?string
    {
        // Common patterns: v=VIDEOID, /embed/VIDEOID, youtu.be/VIDEOID
        if (preg_match('/(?:v=|\/embed\/|youtu\.be\/)([A-Za-z0-9_-]{11})/', $url, $m)) {
            return $m[1];
        }

        // Fallback: try parse query string (e.g., &v=)
        $parts = parse_url($url);
        if (!empty($parts['query'])) {
            parse_str($parts['query'], $qs);
            if (!empty($qs['v']) && preg_match('/^[A-Za-z0-9_-]{11}$/', $qs['v'])) {
                return $qs['v'];
            }
        }

        return null;
    }

    // Delete video (admin only)
    public function destroy($id)
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole('Administrador')) {
            return redirect()->route('dashboard.index')->with('error', 'Acesso negado');
        }

        $video = Video::findOrFail($id);
        $video->delete();

        return redirect()->back()->with('success', 'Vídeo excluído com sucesso!');
    }
}
