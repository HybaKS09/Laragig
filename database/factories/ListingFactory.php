namespace Database\Factories;

use App\Models\Listing;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ListingFactory extends Factory
{
protected $model = Listing::class;

public function definition()
{
return [
// Supposons que `user_id` est un entier qui référence un utilisateur existant.
'user_id' => \App\Models\User::factory(),
'title' => $this->faker->sentence,
'description' => $this->faker->paragraph,
'logo' => $this->faker->imageUrl(640, 480, 'business', true),
'company' => $this->faker->company,
'location' => $this->faker->city,
'email' => $this->faker->companyEmail,
'website' => $this->faker->url,
// `tags` pourrait être une chaîne de caractères de mots-clés séparés par des virgules, par exemple.
'tags' => join(', ', $this->faker->words($nb = 3, $asText = false)),
// `created_at` et `updated_at` sont automatiquement gérés par Eloquent, donc pas besoin de les inclure ici.
];
}
}