<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ParameterLab;

class ParameterLabSeeder extends Seeder
{
    public function run()
    {
        $parameters = [
            // Kimia Darah
            ['kode_param' => 'GLU_PUASA', 'nama_param' => 'Gula Darah Puasa', 'satuan' => 'mg/dL', 'nilai_normal_min' => 70, 'nilai_normal_max' => 100, 'kategori' => 'kimia_darah'],
            ['kode_param' => 'GLU_2JPP', 'nama_param' => 'Gula Darah 2 Jam PP', 'satuan' => 'mg/dL', 'nilai_normal_min' => 70, 'nilai_normal_max' => 140, 'kategori' => 'kimia_darah'],
            ['kode_param' => 'GLU_SEWAKTU', 'nama_param' => 'Gula Darah Sewaktu', 'satuan' => 'mg/dL', 'nilai_normal_min' => 70, 'nilai_normal_max' => 200, 'kategori' => 'kimia_darah'],
            ['kode_param' => 'ASAM_URAT_L', 'nama_param' => 'Asam Urat (Laki-laki)', 'satuan' => 'mg/dL', 'nilai_normal_min' => 3.5, 'nilai_normal_max' => 7.2, 'kategori' => 'kimia_darah'],
            ['kode_param' => 'ASAM_URAT_P', 'nama_param' => 'Asam Urat (Perempuan)', 'satuan' => 'mg/dL', 'nilai_normal_min' => 2.6, 'nilai_normal_max' => 6.0, 'kategori' => 'kimia_darah'],
            ['kode_param' => 'KOL_TOTAL', 'nama_param' => 'Kolesterol Total', 'satuan' => 'mg/dL', 'nilai_normal_min' => 125, 'nilai_normal_max' => 200, 'kategori' => 'kimia_darah'],
            ['kode_param' => 'LDL', 'nama_param' => 'LDL', 'satuan' => 'mg/dL', 'nilai_normal_min' => 0, 'nilai_normal_max' => 100, 'kategori' => 'kimia_darah'],
            ['kode_param' => 'HDL', 'nama_param' => 'HDL', 'satuan' => 'mg/dL', 'nilai_normal_min' => 40, 'nilai_normal_max' => 60, 'kategori' => 'kimia_darah'],
            ['kode_param' => 'TRIGLISERIDA', 'nama_param' => 'Trigliserida', 'satuan' => 'mg/dL', 'nilai_normal_min' => 50, 'nilai_normal_max' => 150, 'kategori' => 'kimia_darah'],
            ['kode_param' => 'SGOT', 'nama_param' => 'SGOT/AST', 'satuan' => 'U/L', 'nilai_normal_min' => 5, 'nilai_normal_max' => 40, 'kategori' => 'kimia_darah'],
            ['kode_param' => 'SGPT', 'nama_param' => 'SGPT/ALT', 'satuan' => 'U/L', 'nilai_normal_min' => 5, 'nilai_normal_max' => 40, 'kategori' => 'kimia_darah'],
            ['kode_param' => 'UREUM', 'nama_param' => 'Ureum', 'satuan' => 'mg/dL', 'nilai_normal_min' => 10, 'nilai_normal_max' => 50, 'kategori' => 'kimia_darah'],
            ['kode_param' => 'CREATININ', 'nama_param' => 'Creatinin', 'satuan' => 'mg/dL', 'nilai_normal_min' => 0.5, 'nilai_normal_max' => 1.2, 'kategori' => 'kimia_darah'],

            // Urinalisis
            ['kode_param' => 'UR_WARNA', 'nama_param' => 'Warna Urine', 'satuan' => null, 'nilai_normal_min' => null, 'nilai_normal_max' => null, 'kategori' => 'urin'],
            ['kode_param' => 'UR_KEKERUHAN', 'nama_param' => 'Kekeruhan Urine', 'satuan' => null, 'nilai_normal_min' => null, 'nilai_normal_max' => null, 'kategori' => 'urin'],
            ['kode_param' => 'UR_ERITROSIT', 'nama_param' => 'Eritrosit Urine', 'satuan' => '/uL', 'nilai_normal_min' => 0, 'nilai_normal_max' => 5, 'kategori' => 'urin'],
            ['kode_param' => 'UR_LEUKOSIT', 'nama_param' => 'Leukosit Urine', 'satuan' => '/uL', 'nilai_normal_min' => 0, 'nilai_normal_max' => 10, 'kategori' => 'urin'],

            // Serologi
            ['kode_param' => 'HBSAG', 'nama_param' => 'HBsAg', 'satuan' => null, 'nilai_normal_min' => null, 'nilai_normal_max' => null, 'kategori' => 'serologi'],
            ['kode_param' => 'ANTI_HCV', 'nama_param' => 'Anti HCV', 'satuan' => null, 'nilai_normal_min' => null, 'nilai_normal_max' => null, 'kategori' => 'serologi'],
            ['kode_param' => 'GOLONGAN_DARAH', 'nama_param' => 'Golongan Darah', 'satuan' => null, 'nilai_normal_min' => null, 'nilai_normal_max' => null, 'kategori' => 'serologi'],
        ];

        foreach ($parameters as $param) {
            ParameterLab::create($param);
        }
    }
}
