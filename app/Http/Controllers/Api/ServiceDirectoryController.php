<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;

class ServiceDirectoryController extends Controller
{
    // Mengambil semua Kategori beserta daftar jasanya
    public function getCategories()
    {
        // with('services') akan otomatis mengambil data jasa yang berelasi
        $categories = Category::with('services')->get();

        return response()->json([
            'message' => 'Berhasil mengambil daftar kategori',
            'data' => $categories
        ]);
    }

    // Mengambil semua Jasa (bisa berguna untuk fitur search bar di FE nanti)
    public function getServices()
    {
        $services = Service::with('category')->get();

        return response()->json([
            'message' => 'Berhasil mengambil daftar jasa',
            'data' => $services
        ]);
    }
}
