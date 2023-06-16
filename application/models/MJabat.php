<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MJabat extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    function show_data($tbl)
    {
        $this->db->select('*');
        $this->db->from($tbl);
        return $this->db->get();
    }

    function show_databyid($tbl, $tbl_id, $id)
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

    function show_kriteriajabatan($id_jabatan='') 
    {
        $this->db->select('*');
        $this->db->from('kriteria_jab kj');
        $this->db->join('kriteria k', 'k.id_kriteria=kj.id_kriteria');
        $this->db->join('jabatan j', 'j.id_jabatan=kj.id_jabatan');
        if ($id_jabatan) {
           $this->db->where('kj.id_jabatan', $id_jabatan);
        }
        return $this->db->get();
    }

    function show_kriteriakry($id_kry='') 
    {
        $this->db->select('*');
        $this->db->from('kriteria_kry kk');
        $this->db->join('kriteria k', 'k.id_kriteria=kk.id_kriteria');
        $this->db->join('karyawan kr', 'kr.id_kry=kk.id_kry');
        if ($id_kry) {
           $this->db->where('kk.id_kry', $id_kry);
        }
        return $this->db->get();
    }

    function show_kriteriakrygroupkry() 
    {
        $this->db->select('*');
        $this->db->from('kriteria_kry kk');
        $this->db->join('kriteria k', 'k.id_kriteria=kk.id_kriteria');
        $this->db->join('karyawan kr', 'kr.id_kry=kk.id_kry');
        $this->db->group_by('kk.id_kry');
        return $this->db->get();
    }

    function show_logrekomendasi($id_log='', $id_jabatan='')
    {
        $this->db->select('*');
        $this->db->from('log_rekomendasi lr');
        $this->db->join('jabatan j', 'j.id_jabatan=lr.id_jabatan');
        $this->db->join('karyawan k', 'k.id_kry=lr.kry_max_sim');
        if ($id_log) {
           $this->db->where('id_log', $id_log);
        }
        if ($id_jabatan) {
           $this->db->where('lr.id_jabatan', $id_jabatan);
        }
        return $this->db->get();
    }

    function show_kandidat($id_log)
    {
        $this->db->select('*');
        $this->db->from('kandidat k');
        $this->db->join('log_rekomendasi l', 'l.id_log=k.id_log');
        $this->db->join('karyawan kr', 'kr.id_kry=k.id_kry');
        $this->db->join('kriteria_kry kk', 'kr.id_kry=kk.id_kry');
        $this->db->where('k.id_log', $id_log);
        $this->db->group_by('kk.id_kry');
        return $this->db->get();
    }

    function show_kandidatmax($id_log, $sim)
    {
        $this->db->select('*');
        $this->db->from('kandidat k');
        $this->db->where('k.id_log', $id_log);
        $this->db->where('k.sim', $sim);
        return $this->db->get();
    }

}
