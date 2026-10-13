<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Schema;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $sitemap = Sitemap::create()
            ->add(
                Url::create(route('home'))
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                    ->setPriority(1.0)
            )
            ->add(
                Url::create(route('catalogue'))
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
                    ->setPriority(0.9)
            )
            ->add(
                Url::create(route('categories.index'))
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.8)
            )
            ->add(
                Url::create(route('services'))
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(0.7)
            )
            ->add(
                Url::create(route('about'))
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(0.6)
            )
            ->add(
                Url::create(route('contact'))
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(0.6)
            );

        if (Schema::hasTable('categories')) {
            Category::query()
                ->where('is_published', true)
                ->orderBy('slug')
                ->each(function (Category $category) use ($sitemap): void {
                    $sitemap->add(
                        Url::create(route('catalogue', ['category' => $category->slug]))
                            ->setLastModificationDate($category->updated_at ?? now())
                            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                            ->setPriority(0.7)
                    );
                });
        }

        if (Schema::hasTable('products')) {
            $sitemap->add(
                Product::query()
                    ->where('is_published', true)
                    ->orderBy('slug')
                    ->get()
            );
        }

        return $sitemap->toResponse(request());
    }

    public function robots(): Response
    {
        $lines = [
            'User-agent: *',
            'Disallow: /panier',
            'Disallow: /devis',
            '',
            'Sitemap: '.route('sitemap'),
        ];

        return response(implode("\n", $lines)."\n", 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
        ]);
    }
}
