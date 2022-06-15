<?php
class Barang_model extends CI_Model
{
	public function getBarang($kode = null)
	{
		if ($kode === null) {
			return $this->db->get('barang')->result_array();
		} else {
			return $this->db->get_where('barang', ['kode' => $kode])->result_array();
		}
	}

	public function deleteBarang($kode)
	{
		$this->db->delete('barang', ['kode' => $kode]);
		return $this->db->affected_rows();
	}

	public function createBarang($data)
	{
		$this->db->insert('barang', $data);
		return $this->db->affected_rows();
	}

	public function updateBarang($data, $kode)
	{
		$this->db->update('barang', $data, ['kode' => $kode]);
		return $this->db->affected_rows();
	}
}
