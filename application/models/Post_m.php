<?php
	class Post_m extends CI_Model {
		public function __construct(){
			$this->load->database();
		}

		public function get_posts($slug = FALSE){
			if($slug === FALSE){
				$this->db->order_by('post.id', 'DESC');
				$this->db->join('categories', 'categories.id = post.category_id');
				$query = $this->db->get('post');
				return $query->result_array(); 
			}

			$query = $this->db->get_where('post', array('slug' => $slug));
			return $query->row_array();
		}


			public function create_post(){
				
				$slug = convert_accented_characters(url_title($this->input->post('title')));

				$data = array(
					'title' => $this->input->post('title'), 
					'slug' => $slug,
					'body' => $this->input->post('body'),
					'category_id' => $this->input->post('category_id'),
					'user_id' => $this->session->userdata('user_id')
				);

				return $this->db->insert('post',$data);
			}

			public function delete_post($id){
				$this->db->where('id', $id);
				$this->db->delete('post');
				return true;
			}

				public function update_post(){
				$slug = convert_accented_characters(url_title($this->input->post('title')));

				$data = array(
				'title' => $this->input->post('title'),
				'slug' => $slug,
				'body' => $this->input->post('body'),
				'category_id' => $this->input->post('category_id')
			);
			
			$this->db->where('id', $this->input->post('id'));
			return $this->db->update('post', $data);
		}

			public function get_categories(){
				$this->db->order_by('name');
				$query = $this->db->get('categories');
				return $query->result_array();
			}
		}
		