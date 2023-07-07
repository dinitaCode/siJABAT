<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rekomendasi extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('MJabat');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    private function _cekIN()
    {
        $isLogin = $this->session->userdata('logged_in');
        if ($isLogin != 1) {
            $this->session->set_flashdata('tetot', 'Maaf anda harus login terlebih dahulu.');
            redirect('/', 'refresh');
        }
    }

    public function index()
    {
        // welcome to siJABAT !!
        $this->_cekIN();
        date_default_timezone_set("Asia/Jakarta");

        $id_user        = $this->session->userdata('id_user');
        $data['user']   = $this->MJabat->show_databyid('user', 'id_user', $id_user)->row();

        $data['menu']       = 'Home';
        $data['content']    = "Vdashboard";

        $this->load->view('theme/index', $data);
    }
    
    public function Karyawan()
    {
        // welcome to siJABAT !!
        $this->_cekIN();
        date_default_timezone_set("Asia/Jakarta");

        $id_user        = $this->session->userdata('id_user');
        $data['user']   = $this->MJabat->show_databyid('user', 'id_user', $id_user)->row();

        $data['karyawan']   = $this->MJabat->show_data('karyawan')->result();

        $data['menu']       = 'Karyawan';
        $data['content']    = "Vkaryawan";

        $this->load->view('theme/index', $data);
    }

    public function DetailKry() 
    {
        $this->_cekIN();
        date_default_timezone_set("Asia/Jakarta");

        $id_user        = $this->session->userdata('id_user');
        $data['user']   = $this->MJabat->show_databyid('user', 'id_user', $id_user)->row();

        $id_kry = decrypt_url($this->uri->segment(3));
        $data['det']   = $this->MJabat->show_databyid('karyawan', 'id_kry', $id_kry)->row();
        $data['filter']   = $this->MJabat->show_databyid('filter_jab', 'id_kry', $id_kry)->result();
        $data['filnotinjab']    = $this->MJabat->show_jabnotinfilter($id_kry)->result();
        $data['kriteria']       = $this->MJabat->show_data('kriteria')->result();
        $data['kriteria_kry']   = $this->MJabat->show_kriteriakry($id_kry)->result();
        $data['jabatan']        = $this->MJabat->show_data('jabatan')->result();   

        $data['menu']       = 'Karyawan';
        $data['content']    = "Vdetailkaryawan";

        $this->load->view('theme/index', $data);
    }

    public function KriteriaKry()
    {
        $this->_cekIN();
        date_default_timezone_set("Asia/Jakarta");

        $idkry = decrypt_url($this->input->post('idkry'));
        $process = $this->input->post('process');

        if ($process == 'edit') {

            $data = array( 
                'id_kry' => $idkry, 
                'id_kriteria' => decrypt_url($this->input->post('idk')),
                'nilai_kriteriaKry' => $this->input->post('nilai_kriteriaKry'),
            );

            $id_kk = decrypt_url($this->input->post('idkk'));
            $this->MJabat->update('kriteria_kry', 'id_kriteriaKry', $id_kk, $data);

        } else if ($process == 'add') {
            $idkriteria = $this->input->post('id_kriteria');
            foreach($idkriteria AS $key => $val){
                $data = array(
                    'id_kry' => decrypt_url($this->input->post('idkry')),
                    'id_kriteria' => decrypt_url($_POST['id_kriteria'][$key]),
                    'nilai_kriteriaKry' => $_POST['nilai_kriteriaKry'][$key],
                );
                $this->MJabat->insert('kriteria_kry', $data);
            }
        } 
        
        $this->session->set_flashdata('notification', 'Kriteria Karyawan Berhasil Disimpan.');
        redirect('Rekomendasi/DetailKry/'. encrypt_url($idkry));
    }

    public function FilterKry() 
    {
        $this->_cekIN();
        date_default_timezone_set("Asia/Jakarta");

        $idkry = decrypt_url($this->input->post('idkry'));
        $data = array( 'id_jabatan' => $this->input->post('jbt'),
                        'status_filter' => '1',
                        'id_kry' => $idkry, );
        
         $this->MJabat->insert('filter_jab', $data);

        redirect('Rekomendasi/DetailKry/'. encrypt_url($idkry));
        $this->session->set_flashdata('notification', 'Filter Jabatan Berhasil Disimpan.');
    }

    public function CancelFilterKry()
    {
        $this->_cekIN();
        date_default_timezone_set("Asia/Jakarta");

        $id_filter = decrypt_url($this->input->post('idf'));
        $filterid = $this->MJabat->show_filterbyid('','',$id_filter)->row();
        $dataEdit = array('status_filter' => '0');
        $this->MJabat->delete('filter_jab', 'id_filter', $id_filter);

        $this->session->set_flashdata('notification', 'Filter Jabatan Berhasil Dihapus.');
        redirect('Rekomendasi/DetailKry/'. encrypt_url($filterid->id_kry));
    }

    public function Jabatan()
    {
        // welcome to siJABAT !!
        $this->_cekIN();
        date_default_timezone_set("Asia/Jakarta");

        $id_user        = $this->session->userdata('id_user');
        $data['user']   = $this->MJabat->show_databyid('user', 'id_user', $id_user)->row();

        $data['jabatan']        = $this->MJabat->show_data('jabatan')->result();
        $data['kriteria']       = $this->MJabat->show_data('kriteria')->result();
        $data['kriteria_jab']   = $this->MJabat->show_kriteriajabatan()->result();

        $data['menu']       = 'Jabatan';
        $data['content']    = "Vjabatan";

        $this->load->view('theme/index', $data);
    }

    public function DetailJab()
    {
        // welcome to siJABAT !!
        $this->_cekIN();
        date_default_timezone_set("Asia/Jakarta");

        $id_user        = $this->session->userdata('id_user');
        $data['user']   = $this->MJabat->show_databyid('user', 'id_user', $id_user)->row();

        $id_jabatan = decrypt_url($this->uri->segment(3));
        $data['jab']            = $this->MJabat->show_databyid('jabatan', 'id_jabatan', $id_jabatan)->row();
        $data['kriteria']       = $this->MJabat->show_data('kriteria')->result();
        $data['kriteria_jab']   = $this->MJabat->show_kriteriajabatan($id_jabatan)->result();
        $data['filter']         = $this->MJabat->show_filterbyid($id_jabatan)->result();
        $data['filnotinjab']    = $this->MJabat->show_jabnotinfilterjab($id_jabatan)->result();
        

        $data['menu']       = 'Jabatan';
        $data['content']    = "Vdetailjabatan";

        $this->load->view('theme/index', $data);
    }

    public function Proses_kriteriaJB() 
    {
        $this->_cekIN();
        date_default_timezone_set("Asia/Jakarta");

        $id_kriteriaJab = decrypt_url($this->input->post('id_kJ'));
        $data = array(
            'nilai_kriteriaJab' => $this->input->post('nilai_kriteriaJab'),
        );
        $this->MJabat->update('kriteria_jab', 'id_kriteriaJab', $id_kriteriaJab, $data);

        $this->session->set_flashdata('notification', 'Kriteria Jabatan Berhasil Disimpan.');
        redirect('Jabatan');
    }

    public function Kriteria()
    {
        // welcome to siJABAT !!
        $this->_cekIN();
        date_default_timezone_set("Asia/Jakarta");

        $id_user        = $this->session->userdata('id_user');
        $data['user']   = $this->MJabat->show_databyid('user', 'id_user', $id_user)->row();

        $data['kriteria']       = $this->MJabat->show_data('kriteria')->result();

        $data['menu']       = 'Kriteria';
        $data['content']    = "Vkriteria";

        $this->load->view('theme/index', $data);
    }

    function Pencarian() 
    {
        $this->_cekIN();
        date_default_timezone_set("Asia/Jakarta");
        $id_user        = $this->session->userdata('id_user');
        $data['user']   = $this->MJabat->show_databyid('user', 'id_user', $id_user)->row();

        $data['jabatan']        = $this->MJabat->show_data('jabatan')->result();
        $data['kriteria_kry']   = $this->MJabat->show_kriteriakrygroupkry()->result();

        $data['menu']       = 'Pencarian';
        $data['content']    = "Vcarirekomendasi";

        $this->load->view('theme/index', $data);
    }

    function GetKandidat()
    {
        $id_jabatan = $this->input->post('id_jabatan');
        $data = $this->MJabat->show_filterbyid($id_jabatan)->result_array();
        echo json_encode($data);
    }

    function Cari_rekomendasi() 
    { 
        $this->_cekIN();
        date_default_timezone_set("Asia/Jakarta");
        $id_user        = $this->session->userdata('id_user');
        $data['user']   = $this->MJabat->show_databyid('user', 'id_user', $id_user)->row();

        $id_jab = $this->input->post('id_jabatan');
        $id_log = uniqid();

        //INPUT Log Rekomendasi
        $datalog = array(
            'id_log' => $id_log,
            'id_jabatan' => $id_jab,
            'tgl_log' => date('Y-m-d H:i:s'),
        );
        $this->MJabat->insert('log_rekomendasi', $datalog);

        //PERHITUNGAN
        $kriteria_jab = $this->MJabat->show_kriteriajabatan($id_jab)->result();

        $karyawan = $this->input->post('karyawan');
        $konversi = array(); $perbandingan = array(); $i=0;
        foreach($karyawan AS $key => $val){ 
            $id_kry = $_POST['karyawan'][$key];
            $kriteria_kry = $this->MJabat->show_kriteriakry($id_kry)->result();
            $sim = 0; $x=0;
            foreach ($kriteria_jab as $kj) {
                foreach ($kriteria_kry as $kk) {
                    if ($kk->id_kriteria == $kj->id_kriteria) {
                        if ($kk->hitungan == "Text") {
                            //TEXT
                            if($kk->nilai_kriteriaKry == $kj->nilai_kriteriaJab){ 
                                $konversi[$x] = 1; 
                            }  else { 
                                $konversi[$x] = 0; 
                            }
                        } else {
                            //SCORE
                            $konv = (1 - ((abs($kj->nilai_kriteriaJab - $kk->nilai_kriteriaKry)) / $kj->nilai_kriteriaJab));                            
                            $konversi[$x] = number_format($konv,3);
                        }

                        $perb = $konversi[$x] * $kj->pembobotan;
                        $perbandingan[$x] = number_format($perb,3);
                        
                        $sim = $perb + $sim;
                        $x++;
                    }
                }
                $konversikry = json_encode($konversi);
                $perbandingankry = json_encode($perbandingan);
            }
            
            $data = array(
                'id_kry' => $id_kry,
                'id_log' => $id_log,
                'konversi' => $konversikry,
                'perbandingan' => $perbandingankry,
                'sim' => number_format($sim,3), 
                'tglup_kandidat' => date('Y-m-d H:i:s')
            );
            $this->MJabat->insert('kandidat', $data);
            //print_r($data);
            $arraySIM[$i] = $sim;
            $i++;
        }
        $maxsim = max($arraySIM);
        $formatsim = number_format($maxsim,3);
        // print_r($arraySIM);
        // echo "<br><br>maxsim ".$id_log.": ".$maxsim;
        // SIMPAN Nama dan Nilai Max Sim di tbl log
        $kandidatmax = $this->MJabat->show_kandidatmax($id_log, $formatsim)->row();
        // print_r($kandidatmax);
        // echo '<br>nilai_max_sim => '. $formatsim .'| kry_max_sim =>'. $kandidatmax->id_kry;

        $update = array(
            'nilai_max_sim' => $formatsim,
            'kry_max_sim' => $kandidatmax->id_kry,
        );
        $this->db->where('id_log', $id_log);
        $this->db->update('log_rekomendasi', $update);
        
        $this->session->set_flashdata('notification', 'Generate Rekomendasi Berhasil.');
        redirect('Rekomendasi/Hasil_rekomendasi/'. $id_log.'/'.$id_jab);        
    }

    function Hasil_rekomendasi() 
    {
        $this->_cekIN();
        date_default_timezone_set("Asia/Jakarta");

        $id_user        = $this->session->userdata('id_user');
        $data['user']   = $this->MJabat->show_databyid('user', 'id_user', $id_user)->row();

        $id_log = $this->uri->segment(3);
        $id_jab = $this->uri->segment(4);

        //echo $id_log." | jab : ".$id_jab;

        $data['jbt']            = $this->MJabat->show_databyid('jabatan', 'id_jabatan', $id_jab)->row();
        $data['kriteria_jab']   = $this->MJabat->show_kriteriajabatan($id_jab)->result();
        $data['kandidat']       = $this->MJabat->show_kandidat($id_log)->result();
        $data['log']            = $this->MJabat->show_logrekomendasi($id_log, $id_jab)->row();
        $data['karyawan']       = $this->MJabat->show_data('karyawan')->result();
        $data['kriteria']       = $this->MJabat->show_data('kriteria')->result();
        $data['kriteria_kry']   = $this->MJabat->show_kriteriakry()->result();

        $data['menu']       = 'Pencarian';
        $data['content']    = "Vhasilrekomendasi";

        $this->load->view('theme/index', $data);
    }

    public function History()
    {
        // welcome to siJABAT !!
        $this->_cekIN();
        date_default_timezone_set("Asia/Jakarta");

        $id_user        = $this->session->userdata('id_user');
        $data['user']   = $this->MJabat->show_databyid('user', 'id_user', $id_user)->row();

        $data['jabatan']    = $this->MJabat->show_data('jabatan')->result();
        $data['logrekom']   = $this->MJabat->show_logrekomendasi()->result();

        $data['menu']       = 'History';
        $data['content']    = "Vlogrekomendasi";

        $this->load->view('theme/index', $data);
    }

    public function Cetak_Rekomendasi() {
        $this->_cekIN();
        date_default_timezone_set("Asia/Jakarta");

        $id_log = decrypt_url($this->uri->segment(3));
        $id_jab = decrypt_url($this->uri->segment(4));

        $data['jbt']            = $this->MJabat->show_databyid('jabatan', 'id_jabatan', $id_jab)->row();
        $data['kriteria_jab']   = $this->MJabat->show_kriteriajabatan($id_jab)->result();
        $data['kandidat']       = $this->MJabat->show_kandidat($id_log)->result();
        $data['log']            = $this->MJabat->show_logrekomendasi($id_log, $id_jab)->row();
        $data['karyawan']       = $this->MJabat->show_data('karyawan')->result();
        $data['kriteria']       = $this->MJabat->show_data('kriteria')->result();
        $data['kriteria_kry']   = $this->MJabat->show_kriteriakry()->result();
        $data['content']    = "Vcetakhasilrekomendasi";

        $this->load->view("Vcetakhasilrekomendasi", $data);
    }
}
