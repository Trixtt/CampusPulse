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
        try {

            $imagePath = null;

            if ($request->hasFile('image')) {

                $imagePath = $request
                    ->file('image')
                    ->store('posts', 'public');
            }

            $post = Post::create([

                'user_id' => $request->user_id,

                'content' => $request->content,

                'category' => $request->category,

                'type' => $request->type,

                'image' => $imagePath,

                'location' => $request->location,

                'status' => $request->status,

                'priority' => $request->priority,

            ]);

            return response()->json($post);

        } catch (\Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
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