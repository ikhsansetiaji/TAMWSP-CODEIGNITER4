<?php

namespace App\Controllers;

use App\Models\MahasiswaModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;

class Mahasiswa extends ResourceController
{
    use ResponseTrait;

    protected $modelName = 'App\Models\MahasiswaModel';
    protected $format    = 'json';

    /**
     * GET /mahasiswa
     * Mengambil semua data mahasiswa
     */
    public function index()
    {
        try {
            $model = new MahasiswaModel();
            
            // Get filters from query string
            $filters = [
                'status'        => $this->request->getGet('status'),
                'angkatan'      => $this->request->getGet('angkatan'),
                'program_studi' => $this->request->getGet('program_studi'),
                'search'        => $this->request->getGet('search'),
            ];

            $data = $model->getAllMahasiswa($filters);

            return $this->respond($data, 200);

        } catch (\Exception $e) {
            return $this->failServerError('Gagal mengambil data: ' . $e->getMessage());
        }
    }

    /**
     * GET /mahasiswa/{id}
     * Mengambil detail mahasiswa berdasarkan ID
     */
    public function show($id = null)
    {
        try {
            $model = new MahasiswaModel();
            $data = $model->getMahasiswaById($id);

            if (!$data) {
                return $this->failNotFound('Data mahasiswa tidak ditemukan');
            }

            return $this->respond($data, 200);

        } catch (\Exception $e) {
            return $this->failServerError('Gagal mengambil data: ' . $e->getMessage());
        }
    }

    /**
     * POST /mahasiswa
     * Menambahkan data mahasiswa baru
     */
    public function create()
    {
        try {
            $model = new MahasiswaModel();
            
            // Get data from request
            $data = [
                'nim'              => $this->request->getPost('nim'),
                'nama_lengkap'     => $this->request->getPost('nama_lengkap'),
                'jenis_kelamin'    => $this->request->getPost('jenis_kelamin'),
                'tempat_lahir'     => $this->request->getPost('tempat_lahir'),
                'tanggal_lahir'    => $this->request->getPost('tanggal_lahir'),
                'program_studi'    => $this->request->getPost('program_studi'),
                'fakultas'         => $this->request->getPost('fakultas'),
                'alamat'           => $this->request->getPost('alamat'),
                'nomor_hp'         => $this->request->getPost('nomor_hp'),
                'email'            => $this->request->getPost('email'),
                'angkatan'         => $this->request->getPost('angkatan'),
                'status_mahasiswa' => $this->request->getPost('status_mahasiswa') ?: 'Aktif',
            ];

            // Check if NIM already exists
            if ($model->isNimExists($data['nim'])) {
                return $this->fail([
                    'status'  => 400,
                    'message' => 'Validasi gagal',
                    'errors'  => ['nim' => 'NIM sudah terdaftar']
                ], 400);
            }

            // Handle file upload
            $foto = $this->request->getFile('foto');
            if ($foto && $foto->isValid() && !$foto->hasMoved()) {
                $newName = $foto->getRandomName();
                $foto->move(FCPATH . 'uploads/mahasiswa', $newName);
                $data['foto'] = 'mahasiswa/' . $newName;
            }

            // Validate and insert
            if (!$model->insert($data)) {
                return $this->fail([
                    'status'  => 400,
                    'message' => 'Validasi gagal',
                    'errors'  => $model->errors()
                ], 400);
            }

            $insertedId = $model->getInsertID();
            $insertedData = $model->find($insertedId);

            return $this->respondCreated([
                'status'  => 201,
                'message' => 'Data mahasiswa berhasil ditambahkan',
                'data'    => $insertedData
            ]);

        } catch (\Exception $e) {
            return $this->failServerError('Gagal menambah data: ' . $e->getMessage());
        }
    }

    /**
     * PUT /mahasiswa/{id}
     * Mengupdate data mahasiswa
     */
    public function update($id = null)
    {
        try {
            $model = new MahasiswaModel();
            
            // Check if mahasiswa exists
            $existingData = $model->find($id);
            if (!$existingData) {
                return $this->failNotFound('Data mahasiswa tidak ditemukan');
            }

            // Get data from POST (Android mengirim sebagai POST dengan method spoofing)
            $data = [
                'nim'              => $this->request->getPost('nim'),
                'nama_lengkap'     => $this->request->getPost('nama_lengkap'),
                'jenis_kelamin'    => $this->request->getPost('jenis_kelamin'),
                'tempat_lahir'     => $this->request->getPost('tempat_lahir'),
                'tanggal_lahir'    => $this->request->getPost('tanggal_lahir'),
                'program_studi'    => $this->request->getPost('program_studi'),
                'fakultas'         => $this->request->getPost('fakultas'),
                'alamat'           => $this->request->getPost('alamat'),
                'nomor_hp'         => $this->request->getPost('nomor_hp'),
                'email'            => $this->request->getPost('email'),
                'angkatan'         => $this->request->getPost('angkatan'),
                'status_mahasiswa' => $this->request->getPost('status_mahasiswa'),
            ];

            // Check if NIM is being changed and if new NIM already exists
            if (!empty($data['nim']) && $data['nim'] !== $existingData['nim']) {
                if ($model->isNimExists($data['nim'], $id)) {
                    return $this->fail([
                        'status'  => 400,
                        'message' => 'Validasi gagal',
                        'errors'  => ['nim' => 'NIM sudah terdaftar']
                    ], 400);
                }
            }

            // Remove null/empty values
            $data = array_filter($data, function($value) {
                return $value !== null && $value !== '';
            });

            // Handle file upload (jika ada foto baru)
            $foto = $this->request->getFile('foto');
            if ($foto && $foto->isValid() && !$foto->hasMoved()) {
                // Delete old photo if exists
                if (!empty($existingData['foto'])) {
                    $oldPhotoPath = FCPATH . 'uploads/' . $existingData['foto'];
                    if (file_exists($oldPhotoPath)) {
                        @unlink($oldPhotoPath);
                    }
                }

                // Upload new photo
                $newName = $foto->getRandomName();
                $foto->move(FCPATH . 'uploads/mahasiswa', $newName);
                $data['foto'] = 'mahasiswa/' . $newName;
            }
            
            // Update data
            if (!$model->update($id, $data)) {
                return $this->fail([
                    'status'  => 400,
                    'message' => 'Validasi gagal',
                    'errors'  => $model->errors()
                ], 400);
            }

            $updatedData = $model->find($id);

            return $this->respond([
                'status'  => 200,
                'message' => 'Data mahasiswa berhasil diupdate',
                'data'    => $updatedData
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Update error: ' . $e->getMessage());
            return $this->failServerError('Gagal mengupdate data: ' . $e->getMessage());
        }
    }
    
    /**
     * POST /mahasiswa/update/{id}
     * Alternative update endpoint using POST method
     */
    public function updatePost($id = null)
    {
        return $this->update($id);
    }

    /**
     * DELETE /mahasiswa/{id}
     * Menghapus data mahasiswa
     */
    public function delete($id = null)
    {
        try {
            $model = new MahasiswaModel();
            
            // Check if mahasiswa exists
            $data = $model->find($id);
            if (!$data) {
                return $this->failNotFound('Data mahasiswa tidak ditemukan');
            }

            // Delete photo file if exists
            if (!empty($data['foto'])) {
                $photoPath = FCPATH . 'uploads/' . $data['foto'];
                if (file_exists($photoPath)) {
                    unlink($photoPath);
                }
            }

            // Delete from database
            if (!$model->delete($id)) {
                return $this->failServerError('Gagal menghapus data');
            }

            return $this->respondDeleted([
                'status'  => 200,
                'message' => 'Data mahasiswa berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            return $this->failServerError('Gagal menghapus data: ' . $e->getMessage());
        }
    }

    /**
     * GET /mahasiswa/stats
     * Mendapatkan statistik mahasiswa
     */
    public function stats()
    {
        try {
            $model = new MahasiswaModel();
            $db = \Config\Database::connect();

            $stats = [
                'total'      => $model->countAll(),
                'aktif'      => $model->where('status_mahasiswa', 'Aktif')->countAllResults(false),
                'cuti'       => $model->where('status_mahasiswa', 'Cuti')->countAllResults(false),
                'lulus'      => $model->where('status_mahasiswa', 'Lulus')->countAllResults(false),
                'nonaktif'   => $model->where('status_mahasiswa', 'Nonaktif')->countAllResults(false),
                'laki_laki'  => $db->table('mahasiswa')->where('jenis_kelamin', 'Laki-laki')->countAllResults(),
                'perempuan'  => $db->table('mahasiswa')->where('jenis_kelamin', 'Perempuan')->countAllResults(),
            ];

            return $this->respond([
                'status'  => 200,
                'message' => 'Statistik berhasil diambil',
                'data'    => $stats
            ]);

        } catch (\Exception $e) {
            return $this->failServerError('Gagal mengambil statistik: ' . $e->getMessage());
        }
    }
}