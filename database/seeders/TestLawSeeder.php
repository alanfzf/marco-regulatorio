<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleItem;
use App\Models\Law;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TestLawSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a Law
        $law = Law::create([
            'law_name' => 'Sample Law',
            'law_description' => 'Description of the sample law.',
            'law_publish_date' => now(),
            'law_url_reference' => 'http://example.com/law',
        ]);

        // Create multiple Articles for this Law
        $articles = Article::factory()->count(15)->create([
            'law_id' => $law->id,
            'article_name' => Str::random(10),
        ]);

        // Create multiple ArticleItems for each Article
        foreach ($articles as $article) {
            ArticleItem::factory()->count(5)->create([
                'article_id' => $article->id,
                'item_title' => Str::random(10),
                'item_description' => 'Description for the item.',
                'item_is_informative' => rand(0, 1) == 1,
                'item_is_complete' => rand(0, 1) == 1,
            ]);
        }
    }

}
