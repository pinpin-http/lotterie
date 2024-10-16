<?php

namespace Tests\Feature;

use App\Models\Draw;
use App\Models\User;
use App\Models\Ticket;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Préparer un utilisateur administrateur pour les tests.
     */

     protected function setUp(): void
    {
        parent::setUp();

        // Crée un utilisateur avec le rôle admin
        $adminUser = User::factory()->create(['role' => 'admin']);
        $this->actingAs($adminUser); // Authentifie cet utilisateur en tant qu'admin
    }

    public function test_create_draw(){

        $response = $this->post(route('admin.store_draw'), [
            'numbers' => [1, 2, 3, 4, 5],
            'stars' => [1, 2],
        ]);

        $response->assertRedirect(route('admin.create_draw'));

        // Utiliser `where` pour vérifier que le tirage a bien été créé
        $this->assertDatabaseHas('draws', [
            'jackpot' => 3000000,
            'status' => 'open',
        ]);
    }

    public function test_launch_draw_with_insufficient_participants()
    {
        // Création d'un tirage sans suffisamment de participants
        $draw = Draw::factory()->create();

        // Exécution de la requête pour lancer le tirage
        $response = $this->post(route('admin.launch_draw', $draw->id));

        // Vérification de la redirection et de l'erreur en session
        $response->assertRedirect(route('admin.create_draw'));
        $errors = session('errors')->all();
        $this->assertContains('Le tirage doit avoir au moins 10 participants pour être lancé.', $errors);
        }


    public function test_generate_fake_participants()
    {
        // Création d'un tirage avec 90 participants fictifs
        $draw = Draw::factory()->create();
        $user = User::factory()->create(['id' => 1]); // Création d'un utilisateur fictif pour l'ID 1
        Ticket::factory()->count(90)->create(['draw_id' => $draw->id, 'user_id' => $user->id]);

        // Exécution de la requête pour générer des participants fictifs
        $response = $this->post(route('admin.generate_fake_participants'), ['draw_id' => $draw->id]);

        // Vérification du statut et de la structure de la réponse JSON
        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $this->assertEquals(100, $draw->tickets()->count());
    }





    public function test_distribute_prizes()
    {

        $draw = Draw::factory()->create(['status' => 'closed']);
        $user = User::factory()->create(); // Création d'un utilisateur pour les tickets
        Ticket::factory()->count(10)->create(['draw_id' => $draw->id, 'user_id' => $user->id]);

        $this->post(route('admin.distribute_prizes', $draw->id));

        $response = $this->post(route('admin.distribute_prizes', $draw->id));
        $response->assertRedirect(route('admin.create_draw'));
        $response->assertSessionHas('errors'); // Vérifie que des erreurs sont bien enregistrées dans la session
    }

}
