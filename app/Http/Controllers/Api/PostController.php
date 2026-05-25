<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Post;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with([
            'user',
            'comments.user',
            'likes',
        ]);

        if ($request->type == "report") {
            $query->where('flagged', false);

        }

        if ($request->type) {

            $query->where(
                'type',
                $request->type
            );
        }

        if ($request->category) {

            $query->where(
                'category',
                $request->category
            );
        }

        if ($request->status) {

            $query->where(
                'status',
                $request->status
            );
        }

        if ($request->location) {

            $query->where(
                'location',
                $request->location
            );
        }

        if ($request->search) {

            $query->where(
                'content',
                'like',
                '%' . $request->search . '%'
            );
        }

        return $query
            ->latest()
            ->get();
    }

    public function store(Request $request)
    {
        $imagePath = null;

        if ($request->hasFile('image')) {

            $imagePath = $request->file('image')
                ->store('posts', 'public');
        }

        $priority = "Medium";
            $content = strtolower($request->content);

            if (
                str_contains($content, 'kebakaran') ||
                str_contains($content, 'darurat')
            ) {

                $priority = "Urgent";
            }

            elseif (
                str_contains($content, 'pencurian') ||
                str_contains($content, 'gelap') ||
                str_contains($content, 'bahaya')
            ) {

                $priority = "High";
            }

            elseif (
                str_contains($content, 'rusak')
            ) {

                $priority = "Medium";
            }

            elseif (
                str_contains($content, 'kotor')
            ) {

                $priority = "Low";
            }

        $flagged = false;
        $badWords = [
            'bodoh',
            'bangsat',
            'tolol',
            'anjing',
            'goblok',
        ];

        foreach ($badWords as $word) {

            if (str_contains($content, $word)) {

                $flagged = true;

                break;
            }
        }
        
            $post = Post::create([
            'user_id' => $request->user_id,
            'category' => $request->category,
            'content' => $request->content,
            'type' => $request->type,
            'priority' => $request->priority,
            'status' => $request->status,
            'location' => $request->location,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'image' => $imagePath,
            'flagged' => $flagged,
        ]);

        return response()->json([
            'message' => 'Posting berhasil',
            'post' => $post
        ]);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        $post->delete();

        return response()->json([
            'message' => 'Posting berhasil dihapus'
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $post->update([
            'status' => $request->type == "report"
                ? "Pending"
                : null,
            'priority' => $request->priority,
            'verification' => $request->verification,
        ]);

        return response()->json([
            'message' => 'Laporan berhasil diperbarui',
            'data' => $post,
        ]);
    }

    public function show($id)
    {
        return Post::with([
            'user',
            'comments.user',
            'likes',
        ])->findOrFail($id);
    }

    public function analytics()
    {
        return response()->json([

            'total_reports' => Post::where(
                'type',
                'report'
            )->count(),

            'pending_reports' => Post::where(
                'status',
                'Pending'
            )->count(),

            'completed_reports' => Post::where(
                'status',
                'Selesai'
            )->count(),

            'urgent_reports' => Post::where(
                'priority',
                'Urgent'
            )->count(),

            'facility_reports' => Post::where(
                'category',
                'Fasilitas'
            )->count(),

            'security_reports' => Post::where(
                'category',
                'Keamanan'
            )->count(),

        ]);
    }
    }