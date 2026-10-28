<?php

namespace Tests\Feature;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\MahasiswaStatusHistory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MahasiswaManagementTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $dosen;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->dosen = User::factory()->create([
            'role' => 'dosen',
        ]);
    }

    public function test_admin_can_access_dashboard_mahasiswa()
    {
        $response = $this->actingAs($this->admin)
            ->withSession(['active_role' => 'mahasiswa'])
            ->get(route('dashboard.mahasiswa'));

        $response->assertStatus(200);
        $response->assertSee('Data Mahasiswa');
    }

    public function test_admin_can_view_mahasiswa_index_and_filters()
    {
        $mhs = Mahasiswa::create([
            'nim' => '220101999',
            'nama' => 'Test Mahasiswa',
            'jenis_kelamin' => 'L',
            'fakultas' => 'Fakultas Teknik',
            'program_studi' => 'Teknik Informatika',
            'jenjang' => 'S1',
            'semester' => 5,
            'tahun_akademik' => '2026/2027',
            'status' => 'Aktif',
            'jenis_kelas' => 'Reguler',
            'status_beasiswa' => false,
        ]);

        $response = $this->actingAs($this->admin)
            ->withSession(['active_role' => 'mahasiswa'])
            ->get(route('mahasiswa.index', ['status' => 'Aktif', 'fakultas' => 'Fakultas Teknik']));

        $response->assertStatus(200);
        $response->assertSee('Test Mahasiswa');
        $response->assertSee('220101999');
    }

    public function test_admin_can_create_mahasiswa_and_status_history_is_recorded()
    {
        $payload = [
            'nim' => '220101888',
            'nama' => 'Bambang Sudiro',
            'jenis_kelamin' => 'L',
            'fakultas' => 'Fakultas Teknik',
            'program_studi' => 'Teknik Informatika',
            'jenjang' => 'S1',
            'semester' => 3,
            'tahun_akademik' => '2026/2027',
            'status' => 'Aktif',
            'jenis_kelas' => 'Reguler',
            'status_beasiswa' => '1',
            'alamat' => 'Jl. Kaliurang KM 9',
            'no_hp' => '08123456789',
        ];

        $response = $this->actingAs($this->admin)
            ->withSession(['active_role' => 'mahasiswa'])
            ->post(route('mahasiswa.store'), $payload);

        $response->assertRedirect(route('mahasiswa.index'));
        $this->assertDatabaseHas('mahasiswas', ['nim' => '220101888', 'nama' => 'Bambang Sudiro']);

        $mhs = Mahasiswa::where('nim', '220101888')->first();
        $this->assertNotNull($mhs);
        $this->assertDatabaseHas('mahasiswa_status_histories', [
            'mahasiswa_id' => $mhs->id,
            'semester' => 3,
            'tahun_akademik' => '2026/2027',
            'status' => 'Aktif',
        ]);
    }

    public function test_admin_can_update_mahasiswa_and_status_history_updates()
    {
        $mhs = Mahasiswa::create([
            'nim' => '220101777',
            'nama' => 'Citra Kirana',
            'jenis_kelamin' => 'P',
            'fakultas' => 'Fakultas Ekonomi & Bisnis',
            'program_studi' => 'Manajemen',
            'jenjang' => 'S1',
            'semester' => 5,
            'tahun_akademik' => '2026/2027',
            'status' => 'Aktif',
            'jenis_kelas' => 'Reguler',
            'status_beasiswa' => false,
        ]);

        $updatePayload = [
            'nim' => '220101777',
            'nama' => 'Citra Kirana Putri',
            'jenis_kelamin' => 'P',
            'fakultas' => 'Fakultas Ekonomi & Bisnis',
            'program_studi' => 'Manajemen',
            'jenjang' => 'S1',
            'semester' => 5,
            'tahun_akademik' => '2026/2027',
            'status' => 'Cuti',
            'jenis_kelas' => 'Reguler',
        ];

        $response = $this->actingAs($this->admin)
            ->withSession(['active_role' => 'mahasiswa'])
            ->put(route('mahasiswa.update', $mhs), $updatePayload);

        $response->assertRedirect(route('mahasiswa.index'));
        $this->assertDatabaseHas('mahasiswas', ['nim' => '220101777', 'status' => 'Cuti']);
        $this->assertDatabaseHas('mahasiswa_status_histories', [
            'mahasiswa_id' => $mhs->id,
            'status' => 'Cuti',
        ]);
    }

    public function test_admin_can_delete_mahasiswa()
    {
        $mhs = Mahasiswa::create([
            'nim' => '220101666',
            'nama' => 'Hapus Saya',
            'jenis_kelamin' => 'L',
            'fakultas' => 'Fakultas Hukum',
            'program_studi' => 'Ilmu Hukum',
            'jenjang' => 'S1',
            'semester' => 1,
            'tahun_akademik' => '2026/2027',
            'status' => 'Nonaktif',
            'jenis_kelas' => 'Reguler',
            'status_beasiswa' => false,
        ]);

        $response = $this->actingAs($this->admin)
            ->withSession(['active_role' => 'mahasiswa'])
            ->delete(route('mahasiswa.destroy', $mhs));

        $response->assertRedirect(route('mahasiswa.index'));
        $this->assertDatabaseMissing('mahasiswas', ['nim' => '220101666']);
    }

    public function test_laporan_mahasiswa_and_fakultas_view()
    {
        Mahasiswa::create([
            'nim' => '220101555',
            'nama' => 'Laporan Test Mhs',
            'jenis_kelamin' => 'P',
            'fakultas' => 'Fakultas Teknik',
            'program_studi' => 'Teknik Informatika',
            'jenjang' => 'S1',
            'semester' => 3,
            'tahun_akademik' => '2026/2027',
            'status' => 'Aktif',
            'jenis_kelas' => 'Reguler',
            'status_beasiswa' => false,
        ]);

        $response = $this->actingAs($this->admin)
            ->withSession(['active_role' => 'mahasiswa'])
            ->get(route('mahasiswa.laporan'));

        $response->assertStatus(200);
        $response->assertSee('Laporan Mahasiswa per Fakultas');
        $response->assertSee('Fakultas Teknik');

        // Test detail per fakultas
        $detailResponse = $this->actingAs($this->admin)
            ->withSession(['active_role' => 'mahasiswa'])
            ->get(route('mahasiswa.laporan.fakultas', 'Fakultas Teknik'));

        $detailResponse->assertStatus(200);
        $detailResponse->assertSee('Fakultas Teknik');
        $detailResponse->assertSee('Teknik Informatika');
    }

    public function test_export_csv_and_pdf_routes()
    {
        $csvResponse = $this->actingAs($this->admin)
            ->withSession(['active_role' => 'mahasiswa'])
            ->get(route('mahasiswa.export', ['format' => 'excel']));

        $csvResponse->assertStatus(200);
        $this->assertTrue(str_contains($csvResponse->headers->get('content-type'), 'text/csv'));

        $pdfResponse = $this->actingAs($this->admin)
            ->withSession(['active_role' => 'mahasiswa'])
            ->get(route('mahasiswa.export', ['format' => 'pdf']));

        $pdfResponse->assertStatus(200);
        $this->assertTrue(str_contains($pdfResponse->headers->get('content-type'), 'application/pdf'));

        $laporanCsvResponse = $this->actingAs($this->admin)
            ->withSession(['active_role' => 'mahasiswa'])
            ->get(route('mahasiswa.laporan.export', ['format' => 'excel']));

        $laporanCsvResponse->assertStatus(200);
        $this->assertTrue(str_contains($laporanCsvResponse->headers->get('content-type'), 'text/csv'));

        $laporanPdfResponse = $this->actingAs($this->admin)
            ->withSession(['active_role' => 'mahasiswa'])
            ->get(route('mahasiswa.laporan.export', ['format' => 'pdf']));

        $laporanPdfResponse->assertStatus(200);
        $this->assertTrue(str_contains($laporanPdfResponse->headers->get('content-type'), 'application/pdf'));
    }

    public function test_dosen_can_view_mahasiswa_and_reports_but_cannot_modify()
    {
        $mhs = Mahasiswa::create([
            'nim' => '220101444',
            'nama' => 'Dosen Access Check',
            'jenis_kelamin' => 'L',
            'fakultas' => 'Fakultas Teknik',
            'program_studi' => 'Teknik Informatika',
            'jenjang' => 'S1',
            'semester' => 3,
            'tahun_akademik' => '2026/2027',
            'status' => 'Aktif',
            'jenis_kelas' => 'Reguler',
            'status_beasiswa' => false,
        ]);

        // Dosen can access index
        $indexResponse = $this->actingAs($this->dosen)
            ->withSession(['active_role' => 'mahasiswa'])
            ->get(route('mahasiswa.index'));
        $indexResponse->assertStatus(200);

        // Dosen can access show
        $showResponse = $this->actingAs($this->dosen)
            ->withSession(['active_role' => 'mahasiswa'])
            ->get(route('mahasiswa.show', $mhs));
        $showResponse->assertStatus(200);

        // Dosen can access reports
        $reportResponse = $this->actingAs($this->dosen)
            ->withSession(['active_role' => 'mahasiswa'])
            ->get(route('mahasiswa.laporan'));
        $reportResponse->assertStatus(200);

        // Dosen CANNOT access create (forbidden 403)
        $createResponse = $this->actingAs($this->dosen)
            ->withSession(['active_role' => 'mahasiswa'])
            ->get(route('mahasiswa.create'));
        $createResponse->assertStatus(403);

        // Dosen CANNOT access edit (forbidden 403)
        $editResponse = $this->actingAs($this->dosen)
            ->withSession(['active_role' => 'mahasiswa'])
            ->get(route('mahasiswa.edit', $mhs));
        $editResponse->assertStatus(403);

        // Dosen CANNOT delete (forbidden 403)
        $deleteResponse = $this->actingAs($this->dosen)
            ->withSession(['active_role' => 'mahasiswa'])
            ->delete(route('mahasiswa.destroy', $mhs));
        $deleteResponse->assertStatus(403);
    }
}
