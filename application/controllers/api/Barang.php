<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Barang extends REST_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Barang_model', 'barang');
		$this->methods['index_get']['limit'] = 2;
	}

	public function index_get()
	{
		$kode = $this->get('kode');

		if ($kode === null) {
			$barang = $this->barang->getBarang();
		} else {
			$barang = $this->barang->getBarang($kode);
		}

		if ($barang) {
			$this->response([
				'status' => true,
				'data' => $barang
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => false,
				'data' => 'Kode tidak ditemukan!'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function index_delete()
	{
		$kode = $this->delete('kode');

		if ($kode === null) {
			$this->response([
				'status' => false,
				'message' => 'Kode tidak ditemukan!'
			], REST_Controller::HTTP_BAD_REQUEST);
		} else {
			if ($this->barang->deleteBarang($kode) > 0) {
				$this->response([
					'status' => true,
					'kode' => $kode,
					'message' => 'Data barang berhasil dihapus!'
				], REST_Controller::HTTP_NO_CONTENT);
			} else {
				$this->response([
					'status' => false,
					'message' => 'Data barang gagal dihapus! Kode tidak ditemukan!'
				], REST_Controller::HTTP_BAD_REQUEST);
			}
		}
	}

	public function index_post()
	{
		$data = [
			'kode' => $this->post('kode', true),
			'nama_barang' => $this->post('nama_barang', true),
			'jenis' => $this->post('jenis', true),
			'harga' => $this->post('harga', true),
			'stok' => $this->post('stok', true)
		];

		if ($this->barang->createBarang($data) > 0) {
			$this->response([
				'status' => true,
				'message' => 'Data barang berhasil ditambahkan!'
			], REST_Controller::HTTP_CREATED);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Data barang gagal ditambahkan!'
			], REST_Controller::HTTP_BAD_REQUEST);
		}
	}

	public function index_put()
	{
		$kode = $this->put('kode');

		$data = [
			'kode' => $this->put('kode', true),
			'nama_barang' => $this->put('nama_barang', true),
			'jenis' => $this->put('jenis', true),
			'harga' => $this->put('harga', true),
			'stok' => $this->put('stok', true)
		];

		if ($this->barang->updateBarang($data, $kode) > 0) {
			$this->response([
				'status' => true,
				'message' => 'Data barang berhasil diperbarui!'
			], REST_Controller::HTTP_NO_CONTENT);
		} else {
			$this->response([
				'status' => false,
				'message' => 'Data barang gagal diperbarui!'
			], REST_Controller::HTTP_BAD_REQUEST);
		}
	}
}
