<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Court;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PrestigePadelTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_displays_seeded_courts_and_catalog(): void
    {
        $this->seed(DatabaseSeeder::class);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('PadelHub');
        $response->assertSee('Main Padel,');
        $response->assertSee('Padel Court 1 - Panoramic Center');
        $response->assertSee('Padel Court 2 - Indoor Pro');
        $response->assertSee('Padel Court 3 - Outdoor Breezy');
        $response->assertSee('court-panoramic.svg');
        $response->assertSee('Masuk / Daftar');
        $response->assertDontSee('Kelola Booking');
    }

    public function test_customer_can_create_booking_and_view_success_page(): void
    {
        $this->seed(DatabaseSeeder::class);

        $court = Court::firstOrFail();

        $createResponse = $this->get(route('booking.create', ['court_id' => $court->id]));
        $createResponse->assertOk();
        $createResponse->assertSee($court->name);

        $storeResponse = $this->post(route('booking.store'), [
            'customer_name' => 'Budi Santoso',
            'customer_phone' => '081234567890',
            'booking_date' => now()->addDay()->toDateString(),
            'court_id' => $court->id,
            'start_time' => '18:00',
            'duration_hours' => 2,
        ]);

        $booking = Booking::firstOrFail();
        $storeResponse->assertRedirect(route('booking.success', $booking->id));

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'customer_name' => 'Budi Santoso',
            'total_price' => $court->price_per_hour * 2,
            'status' => 'Pending',
        ]);

        $this->assertDatabaseHas('booking_details', [
            'booking_id' => $booking->id,
            'court_id' => $court->id,
            'start_time' => '18:00',
            'duration_hours' => 2,
            'subtotal' => $court->price_per_hour * 2,
        ]);

        $successResponse = $this->get(route('booking.success', $booking->id));
        $successResponse->assertOk();
        $successResponse->assertSee('#PRV-' . $booking->id);
        $successResponse->assertSee('Budi Santoso');
        $successResponse->assertDontSee('Kelola Booking');
    }

    public function test_user_registration_assigns_user_role_and_prevents_role_escalation(): void
    {
        $this->get(route('register'))->assertOk();

        $response = $this->post('/register', [
            'name' => 'Member Baru',
            'email' => 'member@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'admin',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'email' => 'member@example.com',
            'role' => 'user',
        ]);
    }

    public function test_guest_and_non_admin_cannot_access_admin_routes(): void
    {
        $this->get(route('admin.bookings.index'))
            ->assertRedirect(route('login'));

        $this->get(route('admin.courts.index'))
            ->assertRedirect(route('login'));

        $regularUser = User::factory()->create(['role' => 'user']);

        $this->actingAs($regularUser)
            ->get(route('admin.bookings.index'))
            ->assertRedirect('/')
            ->assertSessionHas('error', 'Akses ditolak. Anda tidak memiliki izin administratif.');

        $this->actingAs($regularUser)
            ->get(route('admin.courts.index'))
            ->assertRedirect('/')
            ->assertSessionHas('error');
    }

    public function test_seeded_admin_can_login_manage_bookings_and_manage_courts(): void
    {
        $this->seed(DatabaseSeeder::class);
        Storage::fake('public');

        $loginResponse = $this->post('/login', [
            'email' => 'admin@gmail.com',
            'password' => 'password123',
        ]);

        $loginResponse->assertRedirect(route('admin.bookings.index'));
        $this->assertAuthenticated();

        // Create a booking to verify admin booking index, show, and status update
        $court = Court::firstOrFail();
        $this->post(route('booking.store'), [
            'customer_name' => 'Citra Dewi',
            'customer_phone' => '081987654321',
            'booking_date' => now()->addDays(2)->toDateString(),
            'court_id' => $court->id,
            'start_time' => '10:00',
            'duration_hours' => 1,
        ]);

        $booking = Booking::firstOrFail();

        $this->get(route('booking.success', $booking->id))
            ->assertOk()
            ->assertSee('Kelola Booking');

        $this->get(route('admin.bookings.index'))
            ->assertOk()
            ->assertSee('Citra Dewi')
            ->assertSee($court->name);

        $this->get(route('admin.bookings.show', $booking->id))
            ->assertOk()
            ->assertSee('#PRV-' . $booking->id)
            ->assertSee('Citra Dewi');

        $this->patch(route('admin.bookings.updateStatus', $booking->id), [
            'status' => 'Lunas',
        ])->assertRedirect();

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => 'Lunas',
        ]);

        // Admin Courts CRUD
        $this->get(route('admin.courts.index'))
            ->assertOk()
            ->assertSee('delete-court-dialog');

        $this->get(route('admin.courts.create'))->assertOk();

        $pngBytes = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=');
        $image = UploadedFile::fake()->createWithContent('court.png', $pngBytes);

        $storeCourtResponse = $this->post(route('admin.courts.store'), [
            'name' => 'Padel Court 4 - VIP Sky',
            'type' => 'Panoramic',
            'price_per_hour' => 450000,
            'description' => 'Lapangan VIP rooftop panoramic.',
            'image' => $image,
        ]);

        $storeCourtResponse->assertRedirect(route('admin.courts.index'));

        $createdCourt = Court::where('name', 'Padel Court 4 - VIP Sky')->firstOrFail();
        $this->assertNotNull($createdCourt->image);
        Storage::disk('public')->assertExists($createdCourt->image);

        $this->get(route('admin.courts.show', $createdCourt->id))
            ->assertOk()
            ->assertSee('Padel Court 4 - VIP Sky');

        $this->get(route('admin.courts.edit', $createdCourt->id))
            ->assertOk()
            ->assertSee('Padel Court 4 - VIP Sky');

        $newImage = UploadedFile::fake()->createWithContent('court-new.png', $pngBytes);
        $oldImagePath = $createdCourt->image;

        $this->put(route('admin.courts.update', $createdCourt->id), [
            'name' => 'Padel Court 4 - Royal Sky',
            'type' => 'Indoor',
            'price_per_hour' => 500000,
            'description' => 'Lapangan VIP indoor ber-AC.',
            'image' => $newImage,
        ])->assertRedirect(route('admin.courts.index'));

        $createdCourt->refresh();
        $this->assertSame('Padel Court 4 - Royal Sky', $createdCourt->name);
        Storage::disk('public')->assertMissing($oldImagePath);
        Storage::disk('public')->assertExists($createdCourt->image);

        $finalImagePath = $createdCourt->image;

        $this->delete(route('admin.courts.destroy', $createdCourt->id))
            ->assertRedirect(route('admin.courts.index'));

        $this->assertDatabaseMissing('courts', ['id' => $createdCourt->id]);
        Storage::disk('public')->assertMissing($finalImagePath);

        // Logout
        $this->post(route('logout'))->assertRedirect(route('home'));
        $this->assertGuest();
    }

    public function test_validation_errors_and_invalid_login_are_handled_gracefully(): void
    {
        $this->seed(DatabaseSeeder::class);

        // Invalid login
        $this->post('/login', [
            'email' => 'admin@gmail.com',
            'password' => 'wrong-password',
        ])->assertSessionHasErrors('email');
        $this->assertGuest();

        // Invalid booking (past date & invalid court)
        $this->post(route('booking.store'), [
            'customer_name' => '',
            'customer_phone' => '',
            'booking_date' => now()->subDay()->toDateString(),
            'court_id' => 9999,
            'start_time' => '',
            'duration_hours' => 10,
        ])->assertSessionHasErrors([
            'customer_name',
            'customer_phone',
            'booking_date',
            'court_id',
            'start_time',
            'duration_hours',
        ]);

        // Authenticated user visiting guest-only login/register redirects away
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user)->get(route('login'))->assertRedirect('/');
        $this->actingAs($user)->get(route('register'))->assertRedirect('/');
    }
}
