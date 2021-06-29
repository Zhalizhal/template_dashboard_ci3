<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {

    public function index()
    {
        
        $data['title'] = 'Menu Management';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('menu', 'Menu', 'required',[
            'required' => 'Menu Kosong!'
        ]);

        if($this->form_validation->run() == false){

            $this->load->view('templates/dash_header', $data);
            $this->load->view('templates/dash_sidebar', $data);
            $this->load->view('templates/dash_topbar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('templates/dash_footer');
        }else{
            $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Menu berhasil ditambahkan!</div>');
            redirect('menu');
        }
        
    }
    
    //fitur edit masih error
    public function editmenu(){

    $data = array(
        'id' => $this->input->post('id'),
        'menu' => $this->input->post('menu')
    );

    $this->db->set($data);
    $this->db->where('id', $data['id']);
    $this->db->update('user_menu');
    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
    Menu berhasil diedit!</div>');
    redirect('menu');
    
    // var_dump($menu);
    // die;

    }

    public function hapusmenu($id){
        $this->db->delete('user_menu', ['id' => $id]);
         $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Menu berhasil dihapus!</div>');
        redirect('menu');
    }

    public function submenu(){

        $data['title'] = 'Sub Menu Management';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->model('Menu_model', 'menu');
        $data['subMenu'] = $this->menu->getSubMenu();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('title', 'Title', 'required',[
            'required' => 'Title Kosong!'
        ]);
        $this->form_validation->set_rules('menu_id', 'Menu_id', 'required',[
            'required' => 'Menu ID Kosong!'
        ]);
        $this->form_validation->set_rules('url', 'Url', 'required',[
            'required' => 'Url Kosong!'
        ]);
        $this->form_validation->set_rules('icon', 'Icon', 'required',[
            'required' => 'Icon Kosong!'
        ]);
        $this->form_validation->set_rules('is_active', 'Is_active', 'required',[
            'required' => 'Status Kosong!'
        ]);

        if($this->form_validation->run() == false){

            $this->load->view('templates/dash_header', $data);
            $this->load->view('templates/dash_sidebar', $data);
            $this->load->view('templates/dash_topbar', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('templates/dash_footer');
        }else{
            $data = array(
                'menu_id' => $this->input->post('menu_id'),
                'title' => $this->input->post('title'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active')
            );
            $this->db->insert('user_sub_menu', $data);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Sub Menu berhasil ditambahkan!</div>');
            redirect('menu/submenu');
        }
        

    }
    public function editSubmenu(){

            $data = array(
                'id' => $this->input->post('id'),
                'menu_id' => $this->input->post('menu_id'),
                'title' => $this->input->post('title'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active')
            );

            $this->db->set($data);
            $this->db->where('id', $data['id']);
            $this->db->update('user_sub_menu');
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Sub Menu berhasil diedit!</div>');
            redirect('menu/submenu');
        

    }
    
    public function hapusSubmenu($id){
       $this->db->delete('user_sub_menu', ['id' => $id]);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
           Sub Menu berhasil dihapus!</div>');
       redirect('menu/submenu');
   }

    public function cobamenu(){
        
        $data['title'] = 'Coba Menu';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['user'] = $this->db->get_where('user_sub_menu', ['title' => $this->session->userdata('title')])->row_array();
        
        
            $this->load->view('templates/dash_header', $data);
            $this->load->view('templates/dash_sidebar', $data);
            $this->load->view('templates/dash_topbar', $data);
            $this->load->view('menu/cobamenu', $data);
            $this->load->view('templates/dash_footer');
    }

    
}