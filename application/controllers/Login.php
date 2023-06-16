<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('Mlogin');
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('form_validation');
	}

	public function index()
	{
		date_default_timezone_set("Asia/Jakarta");

		$this->load->view('Vlogin');
	}

	public function Register()
	{
		$this->load->view('Vregister');
	}

	public function cek_login()
	{
		$this->load->view('Ceklogin');
	}

	public function Auth()
	{
		date_default_timezone_set("Asia/Jakarta");

		$username = htmlspecialchars($this->input->post('username', TRUE), ENT_QUOTES);
		$pwd = htmlspecialchars($this->input->post('password', TRUE), ENT_QUOTES);
		$password = md5($this->config->item('encryption_key').$pwd.$this->config->item('encryption_key'));

		//$user = $this->db->get_where('user_kry', ['username' => $username, 'is_active' => 1])->row_array();
		$user = $this->db->get_where('user', ['username' => $username])->row_array();
		if ($user) {
			if ($password == $user['password']) {

				$ubah['last_login'] = date("Y-m-d H:i:s");
				$this->db->where('id_user', $user['id_user']);
				$this->db->update('user', $ubah);

				$data = [
					'id_user' => $user['id_user'],
					'nama_lengkap' => $user['nama_lengkap'],
					'role' => $user['role'],
					'logged_in' => 1
				];
				$this->session->set_userdata($data);
				$this->session->set_flashdata('notification', 'Halo ' . $user['nama_lengkap'] . '.. Selamat Datang di Rekomendasi Jabatan - siJABAT.');
				redirect('Rekomendasi');
			} else {
				$this->session->set_flashdata('tetot', 'Maaf, Password salah.');
				redirect();
			}
		} else {
			$this->session->set_flashdata('tetot', 'Username Salah atau Belum Terdaftar. Segera, hubungi Tim Pengembang.');
			redirect();
		}
	}

	public function Logout()
	{
		$this->session->unset_userdata('id_user');
		$this->session->unset_userdata('nama_lengkap');
		$this->session->unset_userdata('role');
		$this->session->unset_userdata('logged_in');
		$this->session->sess_destroy();
		redirect('/', 'refresh');
	}

	function NotFound() {
		$data['content'] = '404';
		$this->load->view('themes/index', $data);
	}

	public function user()
	{
		$isLogin = $this->session->userdata('logged_in');
		//jika belum login, arahkan ke halaman login
		if ($isLogin == false) redirect("Login/cek_login");

		$data['admin'] = $this->Mlogin->show_user()->result();
		$data['content'] = 'Vtampiluser';
		$this->load->view('themes/master/index', $data);
	}

	public function Procces_reg()
	{
		$data['nama_lengkap'] = $this->input->post('nama_lengkap');
		$data['email'] = $this->input->post('email');
		$data['status_admin'] = '1';
		$data['password'] = md5($this->input->post('password'));
		$data['id_admin'] = uniqid();
		$this->Mlogin->insert_user($data);
		if ($data) {
			echo "<script type='text/javascript'>
    						alert('Penambahan User Admin Berhasil, silahkan login kembali ');
    						window.location='" . site_url() . "';
    					  </script>";
		}
	}

	public function TampilanEmailLupaPass()
	{
		$this->load->view('Vemaillupapass');
	}

	public function base64url_encode($data)
	{
		return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
	}

	public function base64url_decode($data)
	{
		return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
	}

	public function Forget_my_pass()
	{
		$email_user = $this->input->post('email_user');
		$clean = $this->security->xss_clean($email_user);
		$admin = $this->Mlogin->get_userdata($clean)->row();

		if ($admin) {
			$token = $this->Mlogin->insertToken($admin->id_user);

			$this->load->library('email');
			$config = array();
			$config['charset'] = 'utf-8';
			$config['useragent'] = 'Dalmas PJM';
			$config['protocol'] = "smtp";
			$config['mailtype'] = "html";
			$config['smtp_host'] = "mail.polimdo.web.id"; //pengaturan smtp
			$config['smtp_port'] = "587";
			$config['smtp_timeout'] = "5";
			$config['smtp_user'] = "no-reply@gusty.web.idd"; // isi dengan email kamu
			$config['smtp_pass'] = "No_2021*"; // isi dengan password kamu
			$config['crlf'] = "\r\n";
			$config['newline'] = "\r\n";
			$config['wordwrap'] = TRUE;
			//memanggil library email dan set konfigurasi untuk pengiriman email

			$this->email->initialize($config);
			//konfigurasi pengiriman
			$this->email->from($config['smtp_user']);
			$this->email->to($this->input->post('email_user'));
			$this->email->subject("Reset Password Audit Mutu Internal - Polimdo");

			$qstring = $this->base64url_encode($token);
			$data["user"] = $this->Mlogin->get_userdata($clean)->row();
			$data["url"] = site_url() . 'Login/reset_password/token/' . $qstring;
			//$data["link"] = '<a href="' . $url . '">' . $url . '</a>';

			$message = $this->load->view("Vemaillupapass", $data, true);
			$this->email->message($message);
			if ($this->email->send()) {
				$this->session->set_flashdata('tetot', "Silahkan cek email <b>" . $email_user . '</b> untuk melakukan reset password');
				redirect();
			} else {
				$this->session->set_flashdata('tetot', 'Berhasil melakukan registrasi, gagal mengirim verifikasi email. Mohon coba lagi.');
				redirect();
			}
		} else {
			$this->session->set_flashdata('tetot', 'Email yang anda isi tidak terdaftar, cek email anda dan isikan dengan benar.');
			redirect();
		}
	}

	public function reset_password()
	{
		$token 		= $this->base64url_decode($this->uri->segment(4));
		$cleanToken = $this->security->xss_clean($token);

		$user_info 	= $this->Mlogin->isTokenValid($cleanToken); //either false or array();          

		if (!$user_info) {
			$this->session->set_flashdata('tetot', 'Mohon maaf, token sudah tidak valid atau kadaluarsa.');
			redirect(site_url(), 'refresh');
		}

		$data = array(
			'email' => $user_info->email,
			'token' => $this->base64url_encode($token)
		);

		$this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
		$this->form_validation->set_rules('re_pass', 'Retype password', 'required|matches[password]');

		if ($this->form_validation->run() == FALSE) {
			$data_user['user']	= $this->Mlogin->show_user_id($user_info->id_user)->row();

			$this->load->view('Vgantipassword', $data_user);
		} else {

			$post 			= $this->input->post(NULL, TRUE);
			$cleanPost 		= $this->security->xss_clean($post);
			$hashed 		= md5($cleanPost['password']);
			$cleanPost['password']	= $hashed;
			$cleanPost['id_user'] 	= $user_info->id_user;
			unset($cleanPost['passconf']);
			if (!$this->Mlogin->update_password($cleanPost)) {
				$this->session->set_flashdata('tetot', 'Update password gagal.');
			} else {
				$this->session->set_flashdata('tetot', 'Password anda sudah diperbaharui. Silakan login.');
			}
			redirect(site_url('Login'), 'refresh');
		}
	}
}
