<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Kind;
use App\Models\Product;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $products = Product::query()
            ->active()
            ->select(['id', 'updated_at'])
            ->orderBy('id')
            ->get();

        $kinds = Kind::query()
            ->select(['id', 'updated_at'])
            ->get();

        $xml = $this->buildXml($products, $kinds);

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }

    private function buildXml($products, $kinds): string
    {
        $baseUrl = rtrim(config('app.url'), '/');
        $now = now()->toAtomString();

        $lines = ['<?xml version="1.0" encoding="UTF-8"?>'];
        $lines[] = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        // Static pages
        $staticPages = [
            ['loc' => $baseUrl . '/', 'priority' => '1.0'],
            ['loc' => $baseUrl . '/loc-san-pham', 'priority' => '0.9'],
            ['loc' => $baseUrl . '/tra-cuu-don-hang', 'priority' => '0.5'],
        ];

        foreach ($staticPages as $page) {
            $lines[] = '  <url>';
            $lines[] = "    <loc>{$page['loc']}</loc>";
            $lines[] = "    <changefreq>weekly</changefreq>";
            $lines[] = "    <priority>{$page['priority']}</priority>";
            $lines[] = '  </url>';
        }

        // Product pages
        foreach ($products as $product) {
            $loc = $baseUrl . '/chi-tiet-san-pham/' . $product->id;
            $lastmod = $product->updated_at->toAtomString();
            $lines[] = '  <url>';
            $lines[] = "    <loc>{$loc}</loc>";
            $lines[] = "    <lastmod>{$lastmod}</lastmod>";
            $lines[] = "    <changefreq>weekly</changefreq>";
            $lines[] = "    <priority>0.8</priority>";
            $lines[] = '  </url>';
        }

        $lines[] = '</urlset>';

        return implode("\n", $lines);
    }
}
