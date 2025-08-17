<?php

namespace Tests\Feature;

use App\Models\Apiary;
use App\Models\Hive;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiaryTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_delete_their_only_apiary()
    {
        $user = User::factory()->create();
        $apiary = Apiary::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        $response = $this->delete(route('apiaries.destroy', $apiary));

        $response->assertRedirect(route('apiaries.show', $apiary));
        $response->assertSessionHas('error', 'No puedes eliminar tu único apiario. Siempre debe existir al menos uno.');
        $this->assertDatabaseHas('apiaries', ['id' => $apiary->id]);
    }

    public function test_user_can_delete_apiary_without_hives()
    {
        $user = User::factory()->create();
        $apiary1 = Apiary::factory()->create(['user_id' => $user->id]);
        $apiary2 = Apiary::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        $response = $this->delete(route('apiaries.destroy', $apiary1));

        $response->assertRedirect(route('apiaries.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('apiaries', ['id' => $apiary1->id]);
    }

    public function test_user_can_delete_apiary_and_its_hives()
    {
        $user = User::factory()->create();
        $apiary1 = Apiary::factory()->create(['user_id' => $user->id]);
        $apiary2 = Apiary::factory()->create(['user_id' => $user->id]);
        $hives = Hive::factory()->count(3)->create(['apiary_id' => $apiary1->id]);

        $this->actingAs($user);

        $response = $this->delete(route('apiaries.destroy', $apiary1), [
            'hives_action' => 'delete',
        ]);

        $response->assertRedirect(route('apiaries.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('apiaries', ['id' => $apiary1->id]);
        foreach ($hives as $hive) {
            $this->assertDatabaseMissing('hives', ['id' => $hive->id]);
        }
    }

    public function test_user_can_move_hives_when_deleting_apiary()
    {
        $user = User::factory()->create();
        $apiary1 = Apiary::factory()->create(['user_id' => $user->id]);
        $apiary2 = Apiary::factory()->create(['user_id' => $user->id]);
        $hives = Hive::factory()->count(3)->create(['apiary_id' => $apiary1->id]);

        $this->actingAs($user);

        $response = $this->delete(route('apiaries.destroy', $apiary1), [
            'hives_action' => 'move',
            'move_to_apiary_id' => $apiary2->id,
        ]);

        $response->assertRedirect(route('apiaries.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('apiaries', ['id' => $apiary1->id]);
        foreach ($hives as $hive) {
            $this->assertDatabaseHas('hives', ['id' => $hive->id, 'apiary_id' => $apiary2->id]);
        }
    }
}
