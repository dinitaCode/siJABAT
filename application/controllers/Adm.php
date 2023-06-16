<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Adm extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Mklinik');
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

    public function Option_sys()
    {
        $option = $this->Mklinik->show_option()->result();
        foreach ($option as $opt) {
            $opt_sys[$opt->id_option] = $opt->option_value;
        }

        return $opt_sys;
    }

    public function index()
    {
        // welcome to ANTRIAN4.0 !!
        $this->_cekIN();
        date_default_timezone_set("Asia/Jakarta");
        $id_user        = $this->session->userdata('id_user');
        $data['user']   = $this->Mklinik->show_profil($id_user)->row();
        $data['menu']       = 'Home';
        $data['optsys']     = $this->Option_sys();
        $data['content']    = "admin/Vdash_adm";

        $data['list_antrian']   = $this->Mklinik->show_list_statusantrian()->result();
        $data['periksa']        = $this->Mklinik->show_jadwal_periksa_pasien()->result(); //jadwal yang sudah ada bookingan pasien
        $data['jwToday']        = $this->Mklinik->show_jadwal_periksa('', date('Y-m-d'), date('N'))->row();
        $data['jdw']            = $this->Mklinik->show_jadwal(date('N'))->row();
        $data['allpasien']      = $this->Mklinik->show_idt_pasien()->result();
        $data['libur']          = $this->Mklinik->show_libur(date('Y-m-d'))->row();

        $this->load->view('theme/index_admin', $data);
    }

    public function Profil()
    {
        $this->_cekIN();
        $id_user        = $this->session->userdata('id_user');
        $data['user']   = $this->Mklinik->show_profil($id_user)->row(); //KARYAWAN
        $data['menu']       = 'Profil';
        $data['optsys']     = $this->Option_sys();

        $data['idt']    = $this->Mklinik->show_profil($id_user)->row();
        $data['list_goldarah']      = $this->Mklinik->show_list_goldarah()->result();

        if ($this->session->userdata('id_role') == 3) {
            $data['sip'] = $this->Mklinik->show_sip_dokter($id_user)->row();
        } else {
            $data['sip'] = "";
        }

        $data['content']    = "admin/Vprofil_adm";

        $this->load->view('theme/index_admin', $data);
    }

    public function Proses_profil()
    {
        $this->_cekIN();
        date_default_timezone_set("Asia/Jakarta");
        $ac = $this->input->post('ac');

        $id_user = $this->session->userdata('id_user');
        $idt = $this->Mklinik->show_profil($id_user)->row();
        $data = array(
            'nama_kry' => $this->input->post('nama_kry'),
            'alamat_kry' => $this->input->post('alamat_kry'),
            'tempatlahir_kry' => $this->input->post('tempatlahir_kry'),
            'tgllahir_kry' => date('Y-m-d', strtotime($this->input->post('tgllahir_kry'))),
            'jnskelamin_kry' => $this->input->post('jnskelamin_kry'),
            'no_WA' => $this->input->post('no_WA'),
            'goldarah_kry' => $this->input->post('goldarah_kry'),
            'agama' => $this->input->post('agama'),
            'NIK' => $this->input->post('NIK'),
        );

        if ($ac == "add") {
            $id_role = $this->input->post('id_role');
            $id_kry = md5(microtime(true) . mt_Rand());
            $id_user = base_convert(microtime(false), 6, 36);
            $id_posisi = $id_role . "_" . base_convert(microtime(false), 6, 36);

            $data['id_kry'] = $id_kry;
            $this->Mklinik->insert('identitas_kry', $data);

            $datauser = array(
                'id_user' => $id_user,
                'username' => $this->input->post('no_WA'),
                'password' => $this->input->post('password'),
                'last_login' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
            );
            $this->Mklinik->insert('user_kry', $datauser);

            $dataposisi = array(
                'id_posisi' => $id_posisi,
                'id_kry' => $id_kry,
                'id_role' => $id_role,
                'id_user' => $id_user,
                'status_posisi' => 1
            );
            $this->Mklinik->insert('posisi_kerja', $dataposisi);

            //karyawan
            $this->session->set_flashdata('notification', 'Data Berhasil Disimpan. Terima kasih');
            redirect('Pengaturan');
        } else if ($ac == "edt") {
            $this->db->where('id_kry', $idt->id_kry);
            $this->db->update('identitas_kry', $data);

            $this->session->set_flashdata('notification', 'Data Berhasil Disimpan. Terima kasih');
            redirect('Profil');
        }
    }

    public function Process_profilepicture()
    {
        $this->_cekIN();

        $optsys = $this->Option_sys();
        $foto_default = $optsys[8];

        $config['upload_path'] = "./assets/img/foto_kry/"; //path folder file upload
        $config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
        $config['encrypt_name'] = TRUE; //Enkripsi nama yang terupload
        $this->load->library('image_lib');
        $this->load->library('upload', $config); //call library upload
        $this->upload->initialize($config);
        if (!empty($_FILES['foto_datauser']['name'])) {

            if ($this->upload->do_upload('foto_datauser')) {
                $gbr = $this->upload->data();
                //Compress Image
                $config['image_library']        = 'gd2';
                $config['source_image']         = './assets/img/foto_kry/' . $gbr['file_name'];
                $config['max_size']             = 50;
                $config['create_thumb']         = TRUE;
                $config['maintain_ratio']       = TRUE;
                $config['quality']              = '50%';
                $config['height']                = 300;
                $config['new_image']            = './assets/img/foto_kry/' . $gbr['file_name'];
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();

                $file_lama = $this->input->post('foto_datauser_lama');
                if ($file_lama != $foto_default) {
                    unlink("./assets/img/foto_kry/$file_lama");
                }

                $dataEdit['foto'] = $gbr['file_name'];
                $id_user = $this->session->userdata('id_user');
                $this->Mklinik->update('user_kry', 'id_user', $id_user, $dataEdit);

                $this->session->set_flashdata('notification', 'Foto user berhasil disimpan.');
            }
        } else {
            $er = $this->upload->display_errors();
            $this->session->set_flashdata('tetot', $er);
        }

        redirect('Profil');
    }

    public function Proses_sip_dokter()
    {
        $this->_cekIN();

        $optsys = $this->Option_sys();
        $foto_default = $optsys[8];

        $config['upload_path'] = "./dokumen/"; //path folder file upload
        $config['allowed_types'] = 'pdf'; //type yang dapat diakses bisa anda sesuaikan
        $config['encrypt_name'] = TRUE; //Enkripsi nama yang terupload
        $this->load->library('image_lib');
        $this->load->library('upload', $config); //call library upload
        $this->upload->initialize($config);
        if (!empty($_FILES['bukti_sip']['name'])) {

            if ($this->upload->do_upload('bukti_sip')) {
                $gbr = $this->upload->data();
                //Compress Image
                $config['image_library']        = 'gd2';
                $config['source_image']         = './dokumen/' . $gbr['file_name'];
                $config['max_size']             = 100;
                $config['create_thumb']         = TRUE;
                $config['maintain_ratio']       = TRUE;
                $config['new_image']            = './dokumen/' . $gbr['file_name'];
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();

                $file_lama = $this->input->post('bukti_sip_lama');
                if ($file_lama != $foto_default) {
                    unlink("./dokumen/$file_lama");
                }

                $dataEdit['bukti_sip'] = $gbr['file_name'];
                $dataEdit['no_sip'] = $this->input->post('no_sip');
                $id_sip = $this->input->post('id_sip');
                $this->Mklinik->update('sip_dokter', 'id_sip', $id_sip, $dataEdit);

                $this->session->set_flashdata('notification', 'Foto user berhasil disimpan.');
            }
        } else {
            $er = $this->upload->display_errors();
            $this->session->set_flashdata('tetot', $er);
        }

        redirect('Profil');
    }

    public function Pengaturan()
    {
        $this->_cekIN();
        $id_user        = $this->session->userdata('id_user');
        $data['user']   = $this->Mklinik->show_profil($id_user)->row();
        $data['menu']       = 'Pengaturan';
        $data['optsys']     = $this->Option_sys();

        $data['list_hari']      = $this->Mklinik->show_list_hari()->result();
        $data['list_goldarah']      = $this->Mklinik->show_list_goldarah()->result();
        $data['option'] = $this->Mklinik->show_option()->result();
        $data['kry']    = $this->Mklinik->show_kry()->result();
        $data['dokter'] = $this->Mklinik->show_dokter()->result();
        $data['jadwal'] = $this->Mklinik->show_jadwal()->result();
        $data['sip']    = $this->Mklinik->show_sip_dokter()->result();

        $data['content']    = "admin/Voption_adm";

        $this->load->view('theme/index_admin', $data);
    }

    public function Proses_option()
    {
        $this->_cekIN();
        $optsys = $this->Option_sys();

        $opttype = $this->input->post('option_type');

        if ($opttype == 1) :
            // tulisan
            $nama['option_value'] = $this->input->post('1');
            $this->Mklinik->update('klinik_option', 'id_option', 1, $nama);
            $alamat['option_value'] = $this->input->post('2');
            $this->Mklinik->update('klinik_option', 'id_option', 2, $alamat);
            $deskripsi['option_value'] = $this->input->post('4');
            $this->Mklinik->update('klinik_option', 'id_option', 4, $deskripsi);
            $wa['option_value'] = $this->input->post('5');
            $this->Mklinik->update('klinik_option', 'id_option', 5, $wa);
            $ig['option_value'] = $this->input->post('6');
            $this->Mklinik->update('klinik_option', 'id_option', 6, $ig);
            $jamtutup['option_value'] = $this->input->post('11');
            $this->Mklinik->update('klinik_option', 'id_option', 11, $jamtutup);

            $this->session->set_flashdata('notification', 'Pengaturan Utama berhasil disimpan.');
        elseif ($opttype == 0) :
            // logo dan kop
            $config['upload_path'] = "./assets/img/"; //path folder file upload
            $config['allowed_types'] = 'jpg|png|jpeg'; //type yang dapat diakses bisa anda sesuaikan
            $config['encrypt_name'] = TRUE; //Enkripsi nama yang terupload
            $this->load->library('image_lib');
            $this->load->library('upload', $config); //call library upload
            $this->upload->initialize($config);

            if (!empty($_FILES['logo']['name'])) {
                if ($this->upload->do_upload('logo')) {
                    $gbr = $this->upload->data();
                    $config['source_image']         = './assets/img/' . $gbr['file_name'];
                    $config['create_thumb']         = TRUE;
                    $config['maintain_ratio']       = TRUE;
                    $config['new_image']            = './assets/img/' . $gbr['file_name'];
                    $this->load->library('upload', $config);

                    $file_lama = $this->input->post('logo_lama');
                    if ($file_lama) {
                        unlink("./assets/img/$file_lama");
                    }

                    $logo['option_value'] = $gbr['file_name'];
                    $this->Mklinik->update('klinik_option', 'id_option', 3, $logo);

                    $this->session->set_flashdata('notification', 'Logo berhasil disimpan.');
                } else {
                    $er =  $this->upload->display_errors();
                    $this->session->set_flashdata('tetot', 'Logo GAGAL disimpan. ' . $er);
                }
            }
            if (!empty($_FILES['kop']['name'])) {
                if ($this->upload->do_upload('kop')) {
                    $gbr = $this->upload->data();
                    $config['source_image']         = './assets/img/' . $gbr['file_name'];
                    $config['create_thumb']         = TRUE;
                    $config['maintain_ratio']       = TRUE;
                    $config['new_image']            = './assets/img/' . $gbr['file_name'];
                    $this->load->library('upload', $config);

                    $file_lama = $this->input->post('kop_lama');
                    if ($file_lama) {
                        unlink("./assets/img/$file_lama");
                    }

                    $kop['option_value'] = $gbr['file_name'];
                    $this->Mklinik->update('klinik_option', 'id_option', 10, $kop);

                    $this->session->set_flashdata('notification', 'Kop Surat berhasil disimpan.');
                } else {
                    $er =  $this->upload->display_errors();
                    $this->session->set_flashdata('tetot', 'Kop Surat GAGAL disimpan. ' . $er);
                }
            }
        endif;
        redirect('Pengaturan');
    }

    public function Proses_jadwal()
    {
        $this->_cekIN();

        $id_jadwal =  $this->input->post('id_jadwal');
        $data = array(
            'id_kry' => $this->input->post('id_kry'),
            'kuota' => $this->input->post('kuota')
        );

        $this->db->where('id_jadwal', $id_jadwal);
        $this->db->update('jadwal_dokter', $data);

        $this->session->set_flashdata('notification', 'Data Berhasil Disimpan. Terima kasih');
        redirect('Pengaturan');
    }

    public function Proses_kry()
    {
        $this->_cekIN();
        date_default_timezone_set("Asia/Jakarta");
        $ac = $this->input->post('ac');

        $data = array(
            'nama_kry' => $this->input->post('nama_kry'),
            'alamat_kry' => $this->input->post('alamat_kry'),
            'tempatlahir_kry' => $this->input->post('tempatlahir_kry'),
            'tgllahir_kry' => date('Y-m-d', strtotime($this->input->post('tgllahir_kry'))),
            'jnskelamin_kry' => $this->input->post('jnskelamin_kry'),
            'no_WA' => $this->input->post('no_WA'),
            'goldarah_kry' => $this->input->post('goldarah_kry'),
            'agama' => $this->input->post('agama'),
            'NIK' => $this->input->post('NIK'),
        );

        if ($ac == "add") {
            $id_role = $this->input->post('id_role');
            $id_kry = md5(microtime(true) . mt_Rand());
            $id_user = base_convert(microtime(false), 6, 36);
            $id_posisi = $id_role . "_" . base_convert(microtime(false), 6, 36);

            $data['id_kry'] = $id_kry;
            $this->Mklinik->insert('identitas_kry', $data);

            $datauser = array(
                'id_user' => $id_user,
                'username' => $this->input->post('no_WA'),
                'password' => md5($this->config->item('encryption_key').$this->input->post('password').$this->config->item('encryption_key')),
                'last_login' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
            );
            $this->Mklinik->insert('user_kry', $datauser);

            $dataposisi = array(
                'id_posisi' => $id_posisi,
                'id_kry' => $id_kry,
                'id_role' => $id_role,
                'id_user' => $id_user,
                'status_posisi' => 1
            );
            $this->Mklinik->insert('posisi_kerja', $dataposisi);

            //karyawan
            $this->session->set_flashdata('notification', 'Data Berhasil Disimpan. Terima kasih');
            redirect('Pengaturan');
        } else if ($ac == "edt") {
            $id_kry = decrypt_url($this->input->post('idk'));
            $this->db->where('id_kry', $id_kry);
            $this->db->update('identitas_kry', $data);

            $this->session->set_flashdata('notification', 'Data Berhasil Disimpan. Terima kasih');
            redirect('Pengaturan');
        }
    }

    public function Nonaktif_userkry()
    {
        $this->_cekIN();
        date_default_timezone_set("Asia/Jakarta");

        $data['is_active'] = 0;
        $idus = $this->uri->segment(3);
        $id_user =  decrypt_url($idus);
        $this->db->where('id_user', $id_user);
        $this->db->update('user_kry', $data);

        $this->session->set_flashdata('notification', 'Karyawan berhasil di Nonaktifkan. Terima kasih');
        redirect('Pengaturan');
    }

    public function Aktif_userkry()
    {
        $this->_cekIN();
        date_default_timezone_set("Asia/Jakarta");

        $data['is_active'] = 1;
        $idus = $this->uri->segment(3);
        $id_user =  decrypt_url($idus);
        $this->db->where('id_user', $id_user);
        $this->db->update('user_kry', $data);

        $this->session->set_flashdata('notification', 'Karyawan berhasil di Aktifkan. Terima kasih');
        redirect('Pengaturan');
    }

    public function Pendaftaran()
    {
        //pendaftaran PASIEN melalui ADMIN 

        $this->_cekIN();
        $id_user        = $this->session->userdata('id_user');
        $data['user']   = $this->Mklinik->show_profil($id_user)->row();
        $data['menu']       = 'Pendaftaran';
        $data['optsys']     = $this->Option_sys();

        $data['pasien'] = $this->Mklinik->show_idt_pasien()->result();
        $data['dokter'] = $this->Mklinik->show_dokter()->result();
        $data['jadwal'] = $this->Mklinik->show_jadwal()->result();

        $data['content']    = "admin/Vdaftar_adm";

        $this->load->view('theme/index_admin', $data);
    }

    public function Det_pasien()
    {
        $this->_cekIN();
        $id_user        = $this->session->userdata('id_user'); //iduser karyawan
        $data['user']   = $this->Mklinik->show_profil($id_user)->row();
        $data['menu']       = 'Det_pasien';
        $data['optsys']     = $this->Option_sys();

        $idup = $this->uri->segment(3);
        $id_userpasien =  decrypt_url($idup);
        $data['p'] = $this->Mklinik->show_profil_pasien($id_userpasien)->row();

        $data['content']    = "admin/Vdetpasien_adm";

        $this->load->view('theme/index_admin', $data);
    }

    public function Proses_pasien_baru()
    {
        $this->_cekIN();
        date_default_timezone_set("Asia/Jakarta");

        $jk = $this->input->post('jnskelamin_pasien');
        $data = array(
            'no_rekammedis' => $this->input->post('no_rekammedis'),
            'nama_pasien' => $this->input->post('nama_pasien'),
            'tempatlahir_pasien' => $this->input->post('tempatlahir_pasien'),
            'tgllahir_pasien' => date('Y-m-d', strtotime($this->input->post('tgllahir_pasien'))),
            'jnskelamin_pasien' => $this->input->post('jnskelamin_pasien'),
            'alamat_pasien' => $this->input->post('alamat_pasien'),
            'noWA_pasien' => $this->input->post('noWA_pasien'),
        );

        $ac = $this->input->post('ac');

        if ($ac == 'add') {
            $id_pasien = base_convert(microtime(false), 6, 36);
            $id_userpasien = md5(microtime(true) . mt_Rand());
            $data['id_pasien'] = $id_pasien;
            $this->Mklinik->insert('pasien', $data);

            $foto_pasien = ($jk == "L") ? "p_male.png" : "p_female.png";
            $datauser = array(
                'id_userpasien' => $id_userpasien,
                'id_pasien' => $id_pasien,
                'password_pasien' => date('dmY', strtotime($this->input->post('tgllahir_pasien'))),
                'foto_pasien' => $foto_pasien,
                'last_login' => date('Y-m-d H:i:s'),
                'created_at' => date('Y-m-d H:i:s'),
            );
            $this->Mklinik->insert('user_pasien', $datauser);

            $this->session->set_flashdata('notification', 'Data Berhasil Disimpan. Terima kasih');
            redirect('Adm');
        } else if ($ac == "edt") {
            $idp = $this->uri->segment(3);
            $id_pasien =  decrypt_url($idp);
            $this->db->where('id_pasien', $id_pasien);
            $this->db->update('pasien', $data);

            $p = $this->Mklinik->show_idt_pasien($id_pasien)->row();

            $this->session->set_flashdata('notification', 'Data Berhasil Disimpan. Terima kasih');
            redirect('Adm/Det_pasien/' . encrypt_url($p->id_userpasien));
        }
    }

    public function Nonaktif_pasien()
    {
        $this->_cekIN();
        date_default_timezone_set("Asia/Jakarta");

        $data['is_active'] = 0;
        $idup = $this->uri->segment(3);
        $id_userpasien =  decrypt_url($idup);
        $this->db->where('id_userpasien', $id_userpasien);
        $this->db->update('user_pasien', $data);

        $this->session->set_flashdata('notification', 'Pasien berhasil di Nonaktifkan. Terima kasih');
        redirect('Pendaftaran');
    }

    public function Periksa()
    {
        $this->_cekIN();
        date_default_timezone_set("Asia/Jakarta");

        $id_user        = $this->session->userdata('id_user');
        $data['user']   = $this->Mklinik->show_profil($id_user)->row();
        $data['menu']       = 'Periksa';
        $data['optsys']     = $this->Option_sys();

        $data['list_hari']  = $this->Mklinik->show_list_hari()->result();
        $data['list_antrian'] = $this->Mklinik->show_list_statusantrian()->result();
        $data['libur'] = $this->Mklinik->show_libur('', date('Y-m-d'))->result();
        $data['dokter'] = $this->Mklinik->show_dokter()->result();
        $data['jadwal'] = $this->Mklinik->show_jadwal()->result();
        $data['periksa'] = $this->Mklinik->show_jadwal_periksa_pasien()->result();
        $data['allpasien'] = $this->Mklinik->show_idt_pasien()->result();

        $data['content']    = "admin/Vperiksa_adm";

        $this->load->view('theme/index_admin', $data);
    }

    public function Proses_periksa()
    {
        $this->_cekIN();
        date_default_timezone_set("Asia/Jakarta");

        $id_jadwal = decrypt_url($this->input->post('idj'));
        $id_pasien = decrypt_url($this->input->post('idp'));
        $tgl_periksa = date('Y-m-d', strtotime($this->input->post('tgl_periksa')));
        $jadwal = $this->Mklinik->show_jadwal_periksa($id_jadwal, $tgl_periksa);

        $jml_antrian = $jadwal->num_rows();
        $no_antrian = 1 + $jml_antrian;

        $data = array(
            'id_periksa' => $no_antrian . "_" . base_convert(microtime(false), 8, 36),
            'id_jadwal' => $id_jadwal,
            'id_pasien' => $id_pasien,
            'tgl_periksa' => $tgl_periksa,
            'no_antrian' => $no_antrian,
            'kuota' => $this->input->post('kuota'),
            'keluhan' => $this->input->post('keluhan'),
            'status_periksa' => 0,
            'tglup_periksa' => date('Y-m-d H:i:s')
        );
        $this->Mklinik->insert('periksa', $data);

        $this->session->set_flashdata('notification', 'Selamat, Pendaftaran Antrian Berhasil..');
        redirect('Periksa');
    }

    public function Antri()
    {
        $this->_cekIN();
        date_default_timezone_set("Asia/Jakarta");

        $id_periksa = decrypt_url($this->uri->segment(2));
        $status_periksa = decrypt_url($this->uri->segment(3));

        $dataPeriksa['status_periksa'] = $status_periksa;

        if ($status_periksa == 3) {
            //mulai periksa 
            $dataPeriksa['mulai_periksa'] = date("Y-m-d H:i:s");
        } else if ($status_periksa == 4) {
            //mulai periksa 
            $dataPeriksa['selesai_periksa'] = date("Y-m-d H:i:s");
        }

        // echo $id_periksa . " | stts : " . $status_periksa;
        // print_r($dataPeriksa);
        $this->db->where('id_periksa', $id_periksa);
        $this->db->update('periksa', $dataPeriksa);

        $this->session->set_flashdata('notification', 'Status Periksa Pasien berhasil di simpan. Terima kasih');
        redirect('Adm');
    }

    public function Rekapitulasi()
    {
        $this->_cekIN();
        $id_user        = $this->session->userdata('id_user');
        $data['user']   = $this->Mklinik->show_profil($id_user)->row();
        $data['menu']       = 'Rekapitulasi';
        $data['optsys']     = $this->Option_sys();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') :
            $cari =  $this->input->post('cari');
            $data['cari'] = $cari;
            if ($cari == 'periode') :
                $tgl_periode = $this->input->post('tgl_periode');
                $split = explode('-', $tgl_periode);
                $tglawal = date('Y-m-d', strtotime($split[0]));
                $tglakhir = date('Y-m-d', strtotime($split[1]));
                $data['tgl_periode'] = $tgl_periode;
                $data['periksa'] = $this->Mklinik->show_jadwal_periksa_cari($tglawal, $tglakhir)->result();
                $data['periksa_periode_all'] = $this->Mklinik->show_periksa_periode($tglawal, $tglakhir)->result();
            elseif ($cari == 'tglperiksa') :
                $tgl_periksa = $this->input->post('tgl_periksa');
                $data['tgl_periksa'] = $tgl_periksa;
                $data['periksa'] = $this->Mklinik->show_jadwal_periksa_cari('', '', $tgl_periksa)->result();
            elseif ($cari == 'norekammedis') :
                $no_rekammedis = $this->input->post('no_rekammedis');
                $data['no_rekammedis'] = $no_rekammedis;
                $data['periksa'] = $this->Mklinik->show_jadwal_periksa_cari('', '', '', $no_rekammedis)->result();
            endif;
        else :
            $data['cari'] = '';
        endif;

        $data['jadwal'] = $this->Mklinik->show_jadwal()->result();
        $data['list_antrian'] = $this->Mklinik->show_list_statusantrian()->result();
        $data['allperiksa'] = $this->Mklinik->show_jadwal_periksa_cari()->result();
        $data['allpasien'] = $this->Mklinik->show_idt_pasien()->result();

        $pasien = $this->Mklinik->show_jadwal_periksa_cari()->result();
        $selesai = 0;
        foreach ($pasien as $p) {
            if ($p->status_periksa == 4) {
                $selesai++;
            }
        }
        $data['selesai'] = $selesai;
        $data['content']    = "admin/Vrekap_adm";

        $this->load->view('theme/index_admin', $data);
    }

    public function Print_rekap()
    {
        $this->_cekIN();
        $id_user        = $this->session->userdata('id_user');
        $data['user']   = $this->Mklinik->show_profil($id_user)->row();
        $data['optsys']     = $this->Option_sys();

        $cari = $this->uri->segment(3);
        $data['cari'] = $cari;
        if ($cari == 'periode') :
            $tgl_periode = decrypt_url($this->uri->segment(4));
            $split = explode('-', $tgl_periode);
            $tglawal = date('Y-m-d', strtotime($split[0]));
            $tglakhir = date('Y-m-d', strtotime($split[1]));
            $data['tgl_periode'] = $tgl_periode;
            $data['periksa'] = $this->Mklinik->show_jadwal_periksa_cari($tglawal, $tglakhir)->result();
            $data['periksa_periode_all'] = $this->Mklinik->show_periksa_periode($tglawal, $tglakhir)->result();
        elseif ($cari == 'tglperiksa') :
            $tgl_periksa = decrypt_url($this->uri->segment(4));
            $data['tgl_periksa'] = $tgl_periksa;
            $data['periksa'] = $this->Mklinik->show_jadwal_periksa_cari('', '', $tgl_periksa)->result();
        elseif ($cari == 'norekammedis') :
            $no_rekammedis = decrypt_url($this->uri->segment(4));
            $data['no_rekammedis'] = $no_rekammedis;
            $data['periksa'] = $this->Mklinik->show_jadwal_periksa_cari('', '', '', $no_rekammedis)->result();
        endif;

        $data['jadwal'] = $this->Mklinik->show_jadwal()->result();
        $data['list_antrian'] = $this->Mklinik->show_list_statusantrian()->result();
        $data['allperiksa'] = $this->Mklinik->show_jadwal_periksa_pasien()->result();
        $data['allpasien'] = $this->Mklinik->show_idt_pasien()->result();

        $this->load->view('admin/Vcetakrekap_adm', $data);
    }

    public function Pengumuman()
    {
        $this->_cekIN();
        $id_user        = $this->session->userdata('id_user');
        $data['user']   = $this->Mklinik->show_profil($id_user)->row();
        $data['menu']       = 'Pengumuman';
        $data['optsys']     = $this->Option_sys();

        $data['pengumuman'] = $this->Mklinik->show_pengumuman()->result();
        $data['libur'] = $this->Mklinik->show_libur()->result();

        $data['content']    = "admin/Vpengumuman_adm";

        $this->load->view('theme/index_admin', $data);
    }

    public function Proses_pengumuman()
    {
        $this->_cekIN();
        date_default_timezone_set("Asia/Jakarta");

        $kategori = $this->input->post('kategori');
        $data['isi'] = $this->input->post('isi');
        $data['jenis_pengumuman'] = $kategori;

        $id_p = decrypt_url($this->uri->segment(3));

        if ($id_p) {
            //edit
            $this->db->where('id_pengumuman', $id_p);
            $this->db->update('pengumuman', $data);

            if ($kategori == 'libur') :
                $lbr['tgl_libur'] = date("Y-m-d", strtotime($this->input->post('tgl_libur')));
                $this->db->where('id_pengumuman', $id_p);
                $this->db->update('libur', $lbr);
            endif;
        } else {
            //add
            $id_pengumuman = base_convert(microtime(false), 6, 36);
            $data['id_pengumuman'] = $id_pengumuman;
            $data['tglup_pengumuman'] = date('Y-m-d H:i:s');
            $this->Mklinik->insert('pengumuman', $data);

            if ($kategori == 'libur') :
                $lbr['id_pengumuman'] = $id_pengumuman;
                $lbr['id_libur'] = base_convert(microtime(false), 6, 36);
                $lbr['tgl_libur'] = date("Y-m-d", strtotime($this->input->post('tgl_libur')));
                $this->Mklinik->insert('libur', $lbr);
            endif;
        }



        redirect('Pengumuman');
    }
}
