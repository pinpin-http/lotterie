<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Draw;
use App\Models\Prize;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test l'affichage de la page d'accueil.
     */
    public function testIndexDisplaysHomepage()
    {
        // Visite la route nommée "home" (la page d'accueil)
        $response = $this->get(route('home'));

        // Vérifie que la page d'accueil est accessible
        $response->assertStatus(200);
        $response->assertViewIs('pages.frontoffice.home');
    }

    /**
     * Test l'affichage du classement avec un ID de tirage spécifique.
     */
    public function testViewRankingWithDrawId()
    {
        // Crée un tirage fermé pour le test
        $draw = Draw::factory()->create(['status' => 'closed']);

        // Crée quelques prix associés à ce tirage
        Prize::factory()->count(3)->create(['draw_id' => $draw->id]);

        // Accède à la route "ranking" avec un ID de tirage
        $response = $this->get(route('ranking', ['draw_id' => $draw->id]));

        // Vérifie que le status est OK, la vue correcte et la présence des données attendues
        $response->assertStatus(200);
        $response->assertViewIs('pages.frontoffice.ranking');
        $response->assertViewHas('draws', function ($draws) use ($draw) {
            return $draws->first()->id === $draw->id;
        });
    }

    /**
     * Test l'affichage du classement sans fournir d'ID de tirage.
     */
    public function testViewRankingWithoutDrawId()
    {
        // Crée plusieurs tirages fermés
        $draws = Draw::factory()->count(5)->create(['status' => 'closed']);

        // Accède à la route "ranking" sans ID de tirage
        $response = $this->get(route('ranking'));

        // Vérifie que le status est OK et que la vue est correcte
        $response->assertStatus(200);
        $response->assertViewIs('pages.frontoffice.ranking');
        $response->assertViewHas('draws', function ($viewDraws) use ($draws) {
            // Vérifie que les tirages dans la vue correspondent aux tirages créés
            return $viewDraws->count() === 5;
        });
    }
}
