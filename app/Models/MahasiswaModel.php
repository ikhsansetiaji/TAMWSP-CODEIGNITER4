<?php

namespace App\Models;

use CodeIgniter\Model;

class MahasiswaModel extends Model
{
    protected $table            = 'mahasiswa';
    protected $primaryKey       = 'id_mahasiswa';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    
    protected $allowedFields    = [
        'nim',
        'nama_lengkap',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'program_studi',
        'fakultas',
        'alamat',
        'nomor_hp',
        'email',
        'angkatan',
        'status_mahasiswa',
        'foto'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'nim'            => 'required|min_length[5]|max_length[20]',
        'nama_lengkap'   => 'required|min_length[3]|max_length[100]',
        'jenis_kelamin'  => 'required|in_list[Laki-laki,Perempuan]',
        'tempat_lahir'   => 'permit_empty|max_length[50]',
        'tanggal_lahir'  => 'permit_empty|valid_date',
        'program_studi'  => 'permit_empty|max_length[50]',
        'fakultas'       => 'permit_empty|max_length[50]',
        'alamat'         => 'permit_empty',
        'nomor_hp'       => 'permit_empty|max_length[20]',
        'email'          => 'permit_empty|valid_email|max_length[50]',
        'angkatan'       => 'permit_empty|numeric|exact_length[4]',
        'status_mahasiswa' => 'permit_empty|in_list[Aktif,Cuti,Lulus,Nonaktif]',
    ];

    protected $validationMessages = [
        'nim' => [
            'required'   => 'NIM wajib diisi',
            'is_unique'  => 'NIM sudah terdaftar',
            'min_length' => 'NIM minimal 5 karakter',
        ],
        'nama_lengkap' => [
            'required'   => 'Nama lengkap wajib diisi',
            'min_length' => 'Nama minimal 3 karakter',
        ],
        'jenis_kelamin' => [
            'required' => 'Jenis kelamin wajib dipilih',
            'in_list'  => 'Jenis kelamin tidak valid',
        ],
        'email' => [
            'valid_email' => 'Format email tidak valid',
        ],
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Get all mahasiswa with optional filters
     */
    public function getAllMahasiswa($filters = [])
    {
        $builder = $this->builder();

        // Filter by status
        if (isset($filters['status']) && !empty($filters['status'])) {
            $builder->where('status_mahasiswa', $filters['status']);
        }

        // Filter by angkatan
        if (isset($filters['angkatan']) && !empty($filters['angkatan'])) {
            $builder->where('angkatan', $filters['angkatan']);
        }

        // Filter by program studi
        if (isset($filters['program_studi']) && !empty($filters['program_studi'])) {
            $builder->like('program_studi', $filters['program_studi']);
        }

        // Search by nama or nim
        if (isset($filters['search']) && !empty($filters['search'])) {
            $builder->groupStart()
                    ->like('nama_lengkap', $filters['search'])
                    ->orLike('nim', $filters['search'])
                    ->groupEnd();
        }

        return $builder->orderBy('created_at', 'DESC')->get()->getResultArray();
    }

    /**
     * Get mahasiswa by ID
     */
    public function getMahasiswaById($id)
    {
        return $this->where('id_mahasiswa', $id)->first();
    }

    /**
     * Check if NIM exists (excluding current ID for update)
     */
    public function isNimExists($nim, $excludeId = null)
    {
        $builder = $this->builder();
        $builder->where('nim', $nim);
        
        if ($excludeId !== null) {
            $builder->where('id_mahasiswa !=', $excludeId);
        }
        
        return $builder->countAllResults() > 0;
    }
}