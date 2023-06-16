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

        public function Proses_kriteriaJB() 
        {
            $this->_cekIN();
            date_default_timezone_set("Asia/Jakarta");

            $data = array(
                'nilai_kriteriaJab' => $this->input->post('nilai_kriteriaJab'),
            );
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

                            $konv = (1 - (($kj->nilai_kriteriaJab - $kk->nilai_kriteriaKry) / $kj->nilai_kriteriaJab));
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
                'sim' => $sim, 
                'tglup_kandidat' => date('Y-m-d H:i:s')
            );
            $this->MJabat->insert('kandidat', $data);
            //print_r($data);
            $arraySIM[$i] = $sim;
            $i++;
        }
        $maxsim = max($arraySIM);
        // print_r($arraySIM);
        // echo "<br><br>maxsim ".$id_log.": ".$maxsim;
        // SIMPAN Nama dan Nilai Max Sim di tbl log
        $kandidatmax = $this->MJabat->show_kandidatmax($id_log, $maxsim)->row();
        //print_r($kandidatmax);
        $update = array(
            'nilai_max_sim' => $maxsim,
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
}
