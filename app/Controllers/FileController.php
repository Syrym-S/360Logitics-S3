<?php

namespace App\Controllers;

use App\Models\File;
use WP_REST_Request;
use WP_REST_Response;

class FileController
{
    public function getFile(WP_REST_Request $request)
    {
        $id = $request->get_param('id');

        $file = File::where('key', $id);

        if (!$file->exists()) {
            return new WP_REST_Response([
                'code' => 'file_not_found',
                'message' => 'File not found',
            ], 404);
        };

        $file = $file->first();

        if ($file->is_deleted) {
            return new WP_REST_Response([
                'code' => 'file_deleted',
                'message' => 'File has been deleted',
            ], 410);
        }

        $path = $file->path;

        header('Content-Type: ' . mime_content_type($path));
        header('Content-Disposition: attachment; filename="' . basename($path) . '"');
        header('Content-Length: ' . filesize($path));

        readfile($path);
        exit;
    }

    public function getFileInfo(WP_REST_Request $request)
    {
        $id = $request->get_param('id');

        $file = File::where('key', $id);

        if (!$file->exists()) {
            return new WP_REST_Response([
                'code' => 'file_not_found',
                'message' => 'File not found',
            ], 404);
        };

        $file = $file->first();

        if ($file->is_deleted) {
            return new WP_REST_Response([
                'code' => 'file_deleted',
                'message' => 'File has been deleted',
            ], 410);
        }

        return new WP_REST_Response([
            'key' => $file->key,
            'mime_type' => $file->mime_type,
            'source' => $file->source,
            'created_at' => $file->created_at,
            'remote_service' => $file->remoteService ? $file->remoteService->name : null,
        ]);
    }
}
