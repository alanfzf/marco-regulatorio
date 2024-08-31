<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\ArticleItem;
use App\Models\Law;
use App\Models\MaturityLevel;
use App\Models\User;
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
        $user = User::findOrFail(1);

        $law = Law::create([
            'law_name' => 'Sample Law',
            'law_description' => 'Description of the sample law.',
            'law_publish_date' => now(),
            'law_url_reference' => 'http://example.com/law',
        ]);

        $user->laws()->attach($law);

        // Create multiple Articles for this Law
        $articles = Article::factory()->count(15)->create([
            'law_id' => $law->id,
            'article_name' => Str::random(16),
        ]);

        // Create multiple ArticleItems for each Article
        foreach ($articles as $article) {
            $maturity = MaturityLevel::findOrFail(1);
            $informative = rand(0, 1) == 1;

            ArticleItem::factory()->count(5)->create([
                'article_id' => $article->id,
                'item_title' => Str::random(16),
                'item_description' => 'Description for the item.',
                'item_is_informative' => $informative,
                'maturity_id' => $maturity->id,
            ]);


        }
    }

}
