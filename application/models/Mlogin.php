<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mlogin extends CI_Model
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

    function show_posisikerja($id_user)
    {
        $this->db->select('*');
        $this->db->from('posisi_kerja pk');
        $this->db->join('role r', 'r.id_role=pk.id_role');
        $this->db->join('user_kry uk', 'uk.id_user=pk.id_user');
        $this->db->join('identitas_kry idk', 'idk.id_kry=pk.id_kry');
        $this->db->where('uk.id_user', $id_user);
        $this->db->where('pk.status_posisi', '1');
        return $this->db->get();
    }

    function show_user($no_rekammedis)
    {
        $this->db->select('*');
        $this->db->from('user_pasien up');
        $this->db->join('pasien p', 'p.id_pasien=up.id_pasien');
        $this->db->where('up.is_active', 1);
        $this->db->where('p.no_rekammedis', $no_rekammedis);
        return $this->db->get();
    }
}
