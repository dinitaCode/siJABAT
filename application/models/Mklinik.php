<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mklinik extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    function show_data($tbl, $tbl_id, $id)
    {
        $this->db->select('*');
        $this->db->from($tbl);
        $this->db->where($tbl_id, $id);
        return $this->db->get();
    }

    function insert($tbl, $data)
    {
        $this->db->insert($tbl, $data);
    }

    function update($tbl, $tbl_id, $id, $dataEdit)
    {
        $this->db->where($tbl_id, $id);
        $this->db->update($tbl, $dataEdit);
    }

    function delete($tbl, $tbl_id, $id)
    {
        $this->db->delete($tbl, array($tbl_id => $id));
    }

    function show_option()
    {
        $this->db->select('*');
        $this->db->from('klinik_option');
        return $this->db->get();
    }

    function show_list_hari()
    {
        $this->db->select('*');
        $this->db->from('list_hari');
        return $this->db->get();
    }

    function show_list_goldarah()
    {
        $this->db->select('*');
        $this->db->from('list_goldarah');
        return $this->db->get();
    }

    function show_list_statusantrian()
    {
        $this->db->select('*');
        $this->db->from('list_statusantrian');
        return $this->db->get();
    }

    function show_pengumuman()
    {
        $this->db->select('*');
        $this->db->from('pengumuman');
        $this->db->order_by('tglup_pengumuman DESC');
        return $this->db->get();
    }

    function show_libur($today = '', $setelah = '')
    {
        $this->db->select('*');
        $this->db->from('libur l');
        $this->db->join('pengumuman p', 'l.id_pengumuman=p.id_pengumuman');
        if ($today) {
            $this->db->where('l.tgl_libur', date('Y-m-d'));
        }
        if ($setelah) {
            $this->db->where('l.tgl_libur >= date("Y-m-d")');
        }
        return $this->db->get();
    }

    function show_kry() //KARYAWAN
    {
        $this->db->select('*');
        $this->db->from('identitas_kry idk');
        $this->db->join('posisi_kerja pk', 'idk.id_kry=pk.id_kry');
        $this->db->join('role r', 'r.id_role=pk.id_role');
        $this->db->join('user_kry uk', 'uk.id_user=pk.id_user');
        $this->db->where('pk.status_posisi', '1'); //aktif
        $this->db->order_by('tglmasuk_kry DESC');
        return $this->db->get();
    }

    function show_profil($id_user) //KARYAWAN
    {
        $this->db->select('*');
        $this->db->from('identitas_kry idk');
        $this->db->join('posisi_kerja pk', 'idk.id_kry=pk.id_kry');
        $this->db->join('role r', 'r.id_role=pk.id_role');
        $this->db->join('user_kry uk', 'uk.id_user=pk.id_user');
        $this->db->where('uk.id_user', $id_user);
        $this->db->where('pk.status_posisi', '1');
        $this->db->order_by('tglmasuk_kry DESC');
        return $this->db->get();
    }

    function show_dokter()
    {
        $this->db->select('*');
        $this->db->from('posisi_kerja pk');
        $this->db->join('role r', 'r.id_role=pk.id_role');
        $this->db->join('user_kry uk', 'uk.id_user=pk.id_user');
        $this->db->join('identitas_kry idk', 'idk.id_kry=pk.id_kry');
        $this->db->where('r.id_role', '3');
        $this->db->where('pk.status_posisi', '1');
        return $this->db->get();
    }

    function show_sip_dokter($id_user = '')
    {
        $this->db->select('*');
        $this->db->from('sip_dokter s');
        $this->db->join('identitas_kry idk', 'idk.id_kry=s.id_kry');
        if ($id_user) {
            $this->db->join('posisi_kerja pk', 'idk.id_kry=pk.id_kry');
            $this->db->where('pk.id_user', $id_user);
        }
        return $this->db->get();
    }

    function show_jadwal($hari = '')
    {
        $this->db->select('*');
        $this->db->from('jadwal_dokter j');
        $this->db->join('identitas_kry idk', 'idk.id_kry=j.id_kry');
        if ($hari) {
            $this->db->where('hari', $hari);
        }
        $this->db->order_by('hari');
        return $this->db->get();
    }

    function show_jadwal_periksa($id_jadwal = "", $tgl_periksa = "", $hari = "")
    {
        $this->db->select('*');
        $this->db->from('periksa pr');
        $this->db->join('jadwal_dokter j', 'pr.id_jadwal=j.id_jadwal');
        $this->db->join('identitas_kry idk', 'idk.id_kry=j.id_kry');
        if ($hari) {
            $this->db->where('j.hari', $hari);
        }
        if ($id_jadwal) {
            $this->db->where('j.id_jadwal', $id_jadwal);
        }
        if ($tgl_periksa) {
            $this->db->where('pr.tgl_periksa', $tgl_periksa);
        }
        $this->db->order_by('pr.tgl_periksa DESC');
        return $this->db->get();
    }

    function show_jadwal_periksa_pasien($id_userpasien = "")
    {
        $this->db->select('*');
        $this->db->from('periksa pr');
        $this->db->join('jadwal_dokter j', 'pr.id_jadwal=j.id_jadwal');
        $this->db->join('identitas_kry idk', 'idk.id_kry=j.id_kry');
        $this->db->join('pasien p', 'p.id_pasien=pr.id_pasien');
        $this->db->join('user_pasien up', 'up.id_pasien=p.id_pasien');
        if ($id_userpasien) {
            $this->db->where('up.id_userpasien', $id_userpasien);
        }
        $this->db->order_by('pr.tgl_periksa DESC');
        $this->db->order_by('pr.no_antrian');
        return $this->db->get();
    }

    function show_idt_pasien($id_pasien = "")
    {
        $this->db->select('*');
        $this->db->from('pasien p');
        $this->db->join('user_pasien up', 'up.id_pasien=p.id_pasien');
        $this->db->where('up.is_active', 1);
        if ($id_pasien) {
            $this->db->where('p.id_pasien', $id_pasien);
        }
        $this->db->order_by('p.tgldaftar_pasien');
        return $this->db->get();
    }

    function show_profil_pasien($id_userpasien = "")
    {
        $this->db->select('*');
        $this->db->from('user_pasien up');
        $this->db->join('pasien p', 'up.id_pasien=p.id_pasien');
        if ($id_userpasien) {
            $this->db->where('up.id_userpasien', $id_userpasien);
        }
        return $this->db->get();
    }

    function show_jadwal_periksa_cari($tglawal = '', $tglakhir = '', $tgl_periksa = '', $no_rekammedis = '')
    {
        $this->db->select('*');
        $this->db->from('periksa pr');
        $this->db->join('jadwal_dokter j', 'pr.id_jadwal=j.id_jadwal');
        $this->db->join('identitas_kry idk', 'idk.id_kry=j.id_kry');
        $this->db->join('pasien p', 'p.id_pasien=pr.id_pasien');
        $this->db->join('user_pasien up', 'up.id_pasien=p.id_pasien');
        if ($tglawal && $tglakhir) :
            $this->db->where('pr.tgl_periksa >=', $tglawal);
            $this->db->where('pr.tgl_periksa <=', $tglakhir);
            $this->db->group_by('pr.tgl_periksa');
        elseif ($tgl_periksa) :
            $this->db->where('pr.tgl_periksa', $tgl_periksa);
        elseif ($no_rekammedis) :
            $this->db->where('p.no_rekammedis', $no_rekammedis);
        endif;
        $this->db->order_by('pr.tgl_periksa');
        return $this->db->get();
    }

    public function show_periksa_periode($tglawal = '', $tglakhir = '')
    {
        $this->db->select('*');
        $this->db->from('periksa pr');
        $this->db->where('pr.tgl_periksa >=', $tglawal);
        $this->db->where('pr.tgl_periksa <=', $tglakhir);
        $this->db->order_by('pr.tgl_periksa');
        return $this->db->get();
    }

    function show_jadwal_periksa_pasien_cari($id_userpasien, $tglawal = '', $tglakhir = '')
    {
        $this->db->select('*');
        $this->db->from('periksa pr');
        $this->db->join('jadwal_dokter j', 'pr.id_jadwal=j.id_jadwal');
        $this->db->join('identitas_kry idk', 'idk.id_kry=j.id_kry');
        $this->db->join('pasien p', 'p.id_pasien=pr.id_pasien');
        $this->db->join('user_pasien up', 'up.id_pasien=p.id_pasien');
        $this->db->where('up.id_userpasien', $id_userpasien);
        if ($tglawal && $tglakhir) :
            $this->db->where('pr.tgl_periksa >=', $tglawal);
            $this->db->where('pr.tgl_periksa <=', $tglakhir);
            $this->db->group_by('pr.tgl_periksa');
        endif;
        $this->db->order_by('pr.tgl_periksa DESC');
        $this->db->order_by('pr.no_antrian');
        return $this->db->get();
    }
}
