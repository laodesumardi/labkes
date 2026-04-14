<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            // ==================== ADMIN ====================
            [
                'nip' => '198001012010011001',
                'nama_lengkap' => 'Dr. Hasan Basri, S.KM',
                'email' => 'hasan.basri@labkes.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'no_telepon' => '081234567890',
                'alamat' => 'Jl. Merdeka No. 10, Jakarta Pusat',
                'tanggal_lahir' => '1980-01-01',
                'jenis_kelamin' => 'Laki-laki',
                'is_active' => true,
            ],
            [
                'nip' => '198512152010022002',
                'nama_lengkap' => 'Dra. Nurul Hikmah, M.Kes',
                'email' => 'nurul.hikmah@labkes.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'no_telepon' => '081234567895',
                'alamat' => 'Jl. Cempaka No. 5, Jakarta Selatan',
                'tanggal_lahir' => '1985-12-15',
                'jenis_kelamin' => 'Perempuan',
                'is_active' => true,
            ],

            // ==================== DOKTER ====================
            [
                'nip' => '198502152015031002',
                'nama_lengkap' => 'Dr. Rahmat Hidayat, Sp.PD',
                'email' => 'rahmat.hidayat@labkes.com',
                'password' => Hash::make('password123'),
                'role' => 'dokter',
                'no_telepon' => '081234567891',
                'alamat' => 'Jl. Melati No. 15, Jakarta Barat',
                'tanggal_lahir' => '1985-02-15',
                'jenis_kelamin' => 'Laki-laki',
                'is_active' => true,
            ],
            [
                'nip' => '198803202016042003',
                'nama_lengkap' => 'Dr. Sri Mulyani, Sp.A',
                'email' => 'sri.mulyani@labkes.com',
                'password' => Hash::make('password123'),
                'role' => 'dokter',
                'no_telepon' => '081234567896',
                'alamat' => 'Jl. Kenanga No. 8, Jakarta Timur',
                'tanggal_lahir' => '1988-03-20',
                'jenis_kelamin' => 'Perempuan',
                'is_active' => true,
            ],
            [
                'nip' => '199011102017052004',
                'nama_lengkap' => 'Dr. Agus Salim, Sp.B',
                'email' => 'agus.salim@labkes.com',
                'password' => Hash::make('password123'),
                'role' => 'dokter',
                'no_telepon' => '081234567897',
                'alamat' => 'Jl. Mawar No. 3, Jakarta Utara',
                'tanggal_lahir' => '1990-11-10',
                'jenis_kelamin' => 'Laki-laki',
                'is_active' => true,
            ],

            // ==================== PETUGAS LAB ====================
            [
                'nip' => '199003102018042003',
                'nama_lengkap' => 'Fitri Handayani, A.Md',
                'email' => 'fitri.handayani@labkes.com',
                'password' => Hash::make('password123'),
                'role' => 'petugas_lab',
                'no_telepon' => '081234567892',
                'alamat' => 'Jl. Dahlia No. 7, Jakarta Selatan',
                'tanggal_lahir' => '1990-03-10',
                'jenis_kelamin' => 'Perempuan',
                'is_active' => true,
            ],
            [
                'nip' => '199205202019052006',
                'nama_lengkap' => 'Rudi Hermawan, S.ST',
                'email' => 'rudi.hermawan@labkes.com',
                'password' => Hash::make('password123'),
                'role' => 'petugas_lab',
                'no_telepon' => '081234567898',
                'alamat' => 'Jl. Anggrek No. 12, Jakarta Barat',
                'tanggal_lahir' => '1992-05-20',
                'jenis_kelamin' => 'Laki-laki',
                'is_active' => true,
            ],
            [
                'nip' => '199408152020062007',
                'nama_lengkap' => 'Dewi Sartika, A.Md',
                'email' => 'dewi.sartika@labkes.com',
                'password' => Hash::make('password123'),
                'role' => 'petugas_lab',
                'no_telepon' => '081234567899',
                'alamat' => 'Jl. Kamboja No. 20, Jakarta Timur',
                'tanggal_lahir' => '1994-08-15',
                'jenis_kelamin' => 'Perempuan',
                'is_active' => true,
            ],

            // ==================== PASIEN ====================
            [
                'nip' => '199512202020052004',
                'nama_lengkap' => 'Budi Santoso',
                'email' => 'budi.santoso@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'pasien',
                'no_telepon' => '081234567893',
                'alamat' => 'Jl. Mawar Indah No. 45, Depok',
                'tanggal_lahir' => '1995-12-20',
                'jenis_kelamin' => 'Laki-laki',
                'is_active' => true,
            ],
            [
                'nip' => '199803152021062005',
                'nama_lengkap' => 'Siti Aminah',
                'email' => 'siti.aminah@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'pasien',
                'no_telepon' => '081234567894',
                'alamat' => 'Jl. Kenanga Permai No. 10, Bekasi',
                'tanggal_lahir' => '1998-03-15',
                'jenis_kelamin' => 'Perempuan',
                'is_active' => true,
            ],
            [
                'nip' => '199006252022072006',
                'nama_lengkap' => 'Ahmad Wijaya',
                'email' => 'ahmad.wijaya@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'pasien',
                'no_telepon' => '081234567900',
                'alamat' => 'Jl. Raya Bogor No. 88, Bogor',
                'tanggal_lahir' => '1990-06-25',
                'jenis_kelamin' => 'Laki-laki',
                'is_active' => true,
            ],
            [
                'nip' => '198805202018032002',
                'nama_lengkap' => 'Dewi Kartika',
                'email' => 'dewi.kartika@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'pasien',
                'no_telepon' => '081234567901',
                'alamat' => 'Jl. Cilandak No. 30, Jakarta Selatan',
                'tanggal_lahir' => '1988-05-20',
                'jenis_kelamin' => 'Perempuan',
                'is_active' => true,
            ],
            [
                'nip' => '200005202025082007',
                'nama_lengkap' => 'Muhammad Rizki',
                'email' => 'rizki.muhammad@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'pasien',
                'no_telepon' => '081234567902',
                'alamat' => 'Jl. Pendidikan No. 5, Tangerang',
                'tanggal_lahir' => '2000-05-20',
                'jenis_kelamin' => 'Laki-laki',
                'is_active' => true,
            ],
            [
                'nip' => '199709152023092008',
                'nama_lengkap' => 'Lestari Indah',
                'email' => 'lestari.indah@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'pasien',
                'no_telepon' => '081234567903',
                'alamat' => 'Jl. Sudirman No. 25, Jakarta Pusat',
                'tanggal_lahir' => '1997-09-15',
                'jenis_kelamin' => 'Perempuan',
                'is_active' => true,
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
