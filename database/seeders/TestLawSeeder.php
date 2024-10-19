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
        // Encuentra al usuario con ID 1
        $user = User::findOrFail(1);

        // Crea una nueva ley
        $law = new Law();
        $law->law_name = 'Sample Law';
        $law->law_description = 'Description of the sample law.';
        $law->law_publish_date = now();
        $law->law_url_reference = 'http://example.com/law';
        $law->save();

        // Asocia la ley al usuario
        $user->laws()->attach($law);

        // Crea múltiples artículos para esta ley
        for ($i = 0; $i < 15; $i++) {
            $article = new Article();
            $article->law_id = $law->id;
            $article->article_name = Str::random(16);
            $article->save();

            // Encuentra el nivel de madurez con ID 1
            $maturity = MaturityLevel::findOrFail(1);

            // Crea múltiples elementos de artículo para cada artículo
            for ($j = 0; $j < 5; $j++) {
                $articleItem = new ArticleItem();
                $articleItem->article_id = $article->id;
                $articleItem->item_title = Str::random(16);
                $articleItem->item_description = 'Description for the item.';
                $articleItem->item_is_informative = rand(0, 1) == 1;
                $articleItem->maturity_id = $maturity->id;
                $articleItem->save();
            }
        }
    }
}
