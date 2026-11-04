<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Pengujian minimum sesuai lembar tugas:
 * memastikan hak akses ditegakkan di sisi server (middleware Spatie),
 * bukan hanya dengan menyembunyikan tombol di view.
 */
class BookAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
    }

    private function userWithRole(string $role): User
    {
        $user = User::factory()->create();
        $user->assignRole($role);

        return $user;
    }

    private function makeItem(): Item
    {
        $category = Category::create([
            'name' => 'Komputer',
            'description' => 'Perangkat komputer',
        ]);

        return Item::create([
            'category_id' => $category->id,
            'name' => 'Laptop',
            'code' => 'INV001',
            'quantity' => 5,
            'price' => 7500000,
        ]);
    }

    public function test_tamu_diarahkan_ke_halaman_login(): void
    {
        $this->get(route('items.index'))->assertRedirect(route('login'));
    }

    public function test_login_dengan_password_salah_gagal(): void
    {
        $user = $this->userWithRole('Admin');

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password-salah',
        ]);

        $this->assertGuest();
    }

    public function test_login_dengan_kredensial_valid_berhasil(): void
    {
        $user = $this->userWithRole('Admin');

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('dashboard', absolute: false));

        $this->assertAuthenticatedAs($user);
    }

    public function test_dashboard_dapat_diakses_setiap_role(): void
    {
        foreach (['Admin', 'Dosen', 'Mahasiswa'] as $role) {
            $this->actingAs($this->userWithRole($role))
                ->get(route('dashboard'))
                ->assertOk();
        }
    }

    public function test_semua_role_dapat_melihat_daftar_buku(): void
    {
        $item = $this->makeItem();

        foreach (['Admin', 'Dosen', 'Mahasiswa'] as $role) {
            $this->actingAs($this->userWithRole($role))
                ->get(route('items.index'))
                ->assertOk();

            $this->actingAs($this->userWithRole($role))
                ->get(route('items.show', $item))
                ->assertOk();
        }
    }

    public function test_dosen_dapat_menambah_dan_mengubah_buku(): void
    {
        $item = $this->makeItem();
        $dosen = $this->userWithRole('Dosen');

        $this->actingAs($dosen)
            ->get(route('items.create'))
            ->assertOk();

        $this->actingAs($dosen)
            ->post(route('items.store'), [
                'category_id' => $item->category_id,
                'name' => 'Monitor',
                'code' => 'INV002',
                'quantity' => 3,
                'price' => 1500000,
            ])
            ->assertRedirect(route('items.index'));

        $this->assertDatabaseHas('items', ['code' => 'INV002']);

        $this->actingAs($dosen)
            ->get(route('items.edit', $item))
            ->assertOk();

        $this->actingAs($dosen)
            ->put(route('items.update', $item), [
                'category_id' => $item->category_id,
                'name' => 'Laptop Pro',
                'code' => 'INV001',
                'quantity' => 7,
                'price' => 8000000,
            ])
            ->assertRedirect(route('items.index'));

        $this->assertDatabaseHas('items', ['code' => 'INV001', 'name' => 'Laptop Pro']);
    }

    public function test_mahasiswa_tidak_dapat_menambah_atau_mengubah_buku(): void
    {
        $item = $this->makeItem();
        $mahasiswa = $this->userWithRole('Mahasiswa');

        $this->actingAs($mahasiswa)->get(route('items.create'))->assertForbidden();
        $this->actingAs($mahasiswa)->get(route('items.edit', $item))->assertForbidden();

        $this->actingAs($mahasiswa)
            ->post(route('items.store'), [
                'category_id' => $item->category_id,
                'name' => 'Buku Baru',
                'code' => 'INV999',
                'quantity' => 1,
                'price' => 1000,
            ])
            ->assertForbidden();

        $this->actingAs($mahasiswa)
            ->put(route('items.update', $item), [
                'category_id' => $item->category_id,
                'name' => 'Diubah',
                'code' => 'INV001',
                'quantity' => 1,
                'price' => 1000,
            ])
            ->assertForbidden();

        $this->assertDatabaseMissing('items', ['code' => 'INV999']);
        $this->assertDatabaseHas('items', ['code' => 'INV001', 'name' => 'Laptop']);
    }

    public function test_admin_dapat_menghapus_buku_sedangkan_dosen_dan_mahasiswa_ditolak(): void
    {
        $item = $this->makeItem();

        $this->actingAs($this->userWithRole('Dosen'))
            ->delete(route('items.destroy', $item))
            ->assertForbidden();

        $this->actingAs($this->userWithRole('Mahasiswa'))
            ->delete(route('items.destroy', $item))
            ->assertForbidden();

        $this->assertDatabaseHas('items', ['id' => $item->id]);

        $this->actingAs($this->userWithRole('Admin'))
            ->delete(route('items.destroy', $item))
            ->assertRedirect(route('items.index'));

        $this->assertDatabaseMissing('items', ['id' => $item->id]);
    }

    public function test_hanya_admin_yang_dapat_mengelola_role_pengguna(): void
    {
        $this->actingAs($this->userWithRole('Admin'))
            ->get(route('users.index'))
            ->assertOk();

        $this->actingAs($this->userWithRole('Dosen'))
            ->get(route('users.index'))
            ->assertForbidden();

        $this->actingAs($this->userWithRole('Mahasiswa'))
            ->get(route('users.index'))
            ->assertForbidden();
    }

    public function test_admin_dapat_mengubah_role_pengguna(): void
    {
        $target = $this->userWithRole('Mahasiswa');

        $this->actingAs($this->userWithRole('Admin'))
            ->put(route('users.role.update', $target), ['role' => 'Dosen'])
            ->assertRedirect();

        $this->assertTrue($target->fresh()->hasRole('Dosen'));
    }

    public function test_pengguna_baru_mendapat_role_mahasiswa_saat_registrasi(): void
    {
        $this->post('/register', [
            'name' => 'Pengguna Baru',
            'email' => 'baru@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();

        $this->assertTrue(
            User::where('email', 'baru@example.com')->first()->hasRole('Mahasiswa')
        );
    }

    public function test_logout_mengakhiri_sesi(): void
    {
        $this->actingAs($this->userWithRole('Admin'))
            ->post('/logout');

        $this->assertGuest();

        // Halaman terlindungi tidak lagi bisa diakses setelah logout.
        $this->get(route('items.index'))->assertRedirect(route('login'));
    }
}
