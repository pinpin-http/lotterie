<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MiddlewareRoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_protected_route()
    {
        // Créer un utilisateur avec le rôle admin
        $admin = User::factory()->create(['role' => 'admin']);

        // Agir en tant qu'administrateur et accéder à la route protégée
        $response = $this->actingAs($admin)->get('/admin/dashboard');

        // Vérifier que la réponse est 200 (OK)
        $response->assertStatus(200);
    }

    public function test_non_admin_is_redirected_from_protected_route()
    {
        // Créer un utilisateur normal
        $user = User::factory()->create(['role' => 'user']);

        // Agir en tant qu'utilisateur et essayer d'accéder à la route protégée
        $response = $this->actingAs($user)->get('/admin/dashboard');

        // Vérifier que l'utilisateur est redirigé (statut 302)
        $response->assertStatus(302);
        $response->assertRedirect('/'); // Par défaut, on redirige vers la page d'accueil
    }
}
