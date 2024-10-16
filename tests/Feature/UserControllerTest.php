<?php

namespace Tests\Feature;

use App\Models\Draw;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Créer un utilisateur avec le rôle 'user' et authentifier
        $this->user = User::factory()->create(['role' => 'user']); // On attribue directement le rôle 'user'
        $this->actingAs($this->user); // Authentifier l'utilisateur
    }

    public function test_show_ticketing_page_displays_open_draws_and_user_tickets()
    {
        $draw = Draw::factory()->create(['status' => 'open']);
        Ticket::factory()->create([
            'user_id' => $this->user->id,
            'draw_id' => $draw->id,
        ]);

        $response = $this->get(route('user.ticketing'));

        $response->assertStatus(200);
        $response->assertViewHas('draws');
        $response->assertViewHas('userTickets');
        $response->assertSeeText((string) $draw->id);
    }

    public function test_user_can_buy_ticket_if_not_yet_purchased()
    {
        $draw = Draw::factory()->create(['status' => 'open']);
        $response = $this->post(route('user.buy_ticket', $draw->id));

        $response->assertRedirect(route('user.ticketing'));
        $response->assertSessionHas('success', 'Ticket acheté avec succès');
        $this->assertDatabaseHas('tickets', [
            'user_id' => $this->user->id,
            'draw_id' => $draw->id,
        ]);
    }

    public function test_user_cannot_buy_ticket_if_already_purchased()
    {
        // Création d'un tirage ouvert et d'un ticket déjà acheté par l'utilisateur pour ce tirage
        $draw = Draw::factory()->create(['status' => 'open']);
        Ticket::factory()->create([
            'user_id' => $this->user->id,
            'draw_id' => $draw->id,
        ]);

        // Tentative d'achat d'un autre ticket pour le même tirage
        $response = $this->post(route('user.buy_ticket', $draw->id));

        // Vérification de la redirection et de l'erreur en session
        $response->assertRedirect(route('user.ticketing'));
        $errors = session('errors')->all();
        $this->assertContains('Vous avez déjà acheté un ticket pour ce tirage.', $errors);
    }

    public function test_user_cannot_buy_ticket_if_draw_is_closed_or_full()
    {
        // Test pour un tirage fermé
        $closedDraw = Draw::factory()->create(['status' => 'closed']);
        $response = $this->post(route('user.buy_ticket', $closedDraw->id));

        // Vérification de la redirection et de l'erreur en session pour un tirage fermé
        $response->assertRedirect(route('user.ticketing'));
        $errors = session('errors')->all();
        $this->assertContains('Ce tirage est complet ou fermé.', $errors);

        // Test pour un tirage complet
        $fullDraw = Draw::factory()->create(['status' => 'open']);
        Ticket::factory(100)->create(['draw_id' => $fullDraw->id]);

        // Tentative d'achat de ticket pour un tirage complet
        $response = $this->post(route('user.buy_ticket', $fullDraw->id));

        // Vérification de la redirection et de l'erreur en session pour un tirage complet
        $response->assertRedirect(route('user.ticketing'));
        $errors = session('errors')->all();
        $this->assertContains('Ce tirage est complet ou fermé.', $errors);
    }

    public function test_show_participations_displays_user_tickets_and_ranking()
    {
        $draw = Draw::factory()->create(['status' => 'closed']);
        Ticket::factory()->create([
            'user_id' => $this->user->id,
            'draw_id' => $draw->id,
        ]);

        $response = $this->get(route('user.participations'));

        $response->assertStatus(200);
        $response->assertViewHas('tickets');
        $response->assertSeeText((string) $draw->id);
    }
}
