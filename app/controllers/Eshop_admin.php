<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Eshop_admin extends   MY_Controller {
    function __construct(){
        parent::__construct(); 
        if (!$this->loggedIn) { 
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            $this->sma->md('login');
        }

        if (!$this->Owner) {
            $this->session->set_flashdata('warning', lang('access_denied'));
            redirect('welcome');
        } 
        $this->load->library('form_validation');
        $this->load->model('settings_model');     
        $this->load->model('pos_model');
        $this->load->model('eshop_model');     
    } 
    function pages() {
        $this->form_validation->set_rules('about_us', lang('About Us'), 'trim|required');
        $this->form_validation->set_rules('contact_us', lang('Contact Us'), 'trim|required');
        $this->form_validation->set_rules('terms', lang('Terms & conditions'), 'trim|required');
        $this->form_validation->set_rules('p_policy', lang('Privacy Policy'), 'trim|required');
        $this->form_validation->set_rules('faq', lang('FAQ'), 'trim|required');
        
        if ($this->form_validation->run() == true ) { 
            $data['about_us'] =    $this->input->post('about_us');
            $data['contact_us'] =   $this->input->post('contact_us');
            $data['terms'] =   $this->input->post('terms');
            $data['p_policy'] =   $this->input->post('p_policy');
            $data['faq'] = $this->input->post('faq');
            if($res = $this->eshop_model->updateEshopPages(1,$data)):
                $this->session->set_flashdata('message', lang('Data_updated_successfully'));
                redirect("eshop_admin/pages");
            else:
                $this->session->set_flashdata('error', lang('Data_not_updated_successfully'));
                redirect('eshop_admin/pages');
            endif;
        }
        else{
            $this->data['pages']   = $this->eshop_model->getEshopPages(1);
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('notifications')));
            $meta = array('page_title' => lang('notifications'), 'bc' => $bc);
            $this->page_construct('eshop/pages', $meta, $this->data);
        }
    }
    
    function settings() {
        
        $this->load->helper('html'); 
        
        $this->data['eshop_upload'] = $uploadPath = "assets/uploads/eshop_user/";
        
        if($this->input->post('action') === 'save_settings' ) { 
            
            $settings['facebook_link'] = !empty($this->input->post('facebook_link')) ? 'https://' . str_replace(['https://','http://'], '', $this->input->post('facebook_link')):'';
            $settings['google_link']   = !empty($this->input->post('google_link')) ?  'https://' . str_replace(['https://','http://'], '', $this->input->post('google_link')):'';
            $settings['twitter_link']  = !empty($this->input->post('twitter_link')) ?  'https://' . str_replace(['https://','http://'], '', $this->input->post('twitter_link')):'';
            $settings['shop_name']  = $this->input->post('shop_name');
            $settings['shop_phone']  = $this->input->post('shop_phone');
            $settings['shop_email']  = $this->input->post('shop_email');
            $settings['display_top_products']  = $this->input->post('display_top_products');
            $settings['display_hot_offers']  = $this->input->post('display_hot_offers');
            $default_banner  = $this->input->post('default_banner');
            
            $settings['homepage_image_text_1']  = $this->input->post('homepage_image_text_1');
            $settings['homepage_image_text_1_2']  = $this->input->post('homepage_image_text_1_2');
            $settings['homepage_image_text_2']  = $this->input->post('homepage_image_text_2');
            $settings['homepage_image_text_3']  = $this->input->post('homepage_image_text_3');
            $settings['show_homepage_images_text']  = $this->input->post('show_homepage_images_text');
            
            if(is_array($default_banner) && !empty($default_banner)){
               $settings['default_banner']  =  json_encode($default_banner);
            } else {
               $settings['default_banner']  = ''; 
            }
            
            //Copy Eshop Logo
            if(!empty($_FILES['eshop_logo']['tmp_name'])){
                list($filename,$ext) = explode('.',$_FILES['eshop_logo']['name']);
                $logoImage = md5(time().$filename) .'.'.$ext;
                if(copy($_FILES['eshop_logo']['tmp_name'], $uploadPath .$logoImage ))
                {
                    $settings['eshop_logo'] = $uploadPath . $logoImage;
                }
            } 
            
            //Copy Eshop hot_offers_banner
            if(!empty($_FILES['hot_offers_banner']['tmp_name'])){
                list($filename,$ext) = explode('.',$_FILES['hot_offers_banner']['name']);
                $logoImage = md5(time().$filename) .'.'.$ext;
                if(copy($_FILES['hot_offers_banner']['tmp_name'], $uploadPath .$logoImage ))
                {
                    $settings['hot_offers_banner'] = $uploadPath . $logoImage;
                }
            }            
            
            //Copy Banners
            if(!empty($_FILES['banner_image']['tmp_name'])){
                $i=0;
                foreach ($_FILES['banner_image']['name'] as $key=>$file) {
                    
                    if(empty($file)) continue;
                    $i++;
                    list($filename,$ext) = explode('.',$file);
                    //$bannerImage = "banner_static_".$key.'.'.$ext;
                    $bannerImage =  md5(time().$filename) .'.'.$ext;
                    
                    if(copy($_FILES['banner_image']['tmp_name'][$key], $uploadPath .$bannerImage ))
                    {
                        $settings['banner_image_'.$key] = $uploadPath . $bannerImage;
                    }
                }//end foreach
            }
            
            //Copy Homepahe Images
            if(!empty($_FILES['homepage_image']['tmp_name'])){
                 
                foreach ($_FILES['homepage_image']['name'] as $key=>$file) {
                    
                    if(empty($file)) continue;
                     
                    list($filename,$ext) = explode('.',$file);
                   // $homepageImage = "homepage_image_$key.$ext";
                    $homepageImage =  md5(time().$filename) .'.'.$ext;
                    if(copy($_FILES['homepage_image']['tmp_name'][$key], $uploadPath .$homepageImage ))
                    {
                        $settings['homepage_image_'.$key] = $uploadPath . $homepageImage;
                    }
                }//end foreach
            } 
            
            if(!empty($settings)){
               $rec = $this->eshop_model->updateEshopSettings(1 ,$settings);              
            }
            
            if($rec) {
                 unset($_POST);
                redirect('eshop_admin/settings');
            } else {
                $this->page_construct('eshop/settings', $meta, $this->data);
            }
        }
        else
        {
            $this->data['eshop_settings'] = $this->eshop_model->getEshopSettings(1);
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('settings')));
            $meta = array('page_title' => lang('settings'), 'bc' => $bc);
            $this->page_construct('eshop/settings', $meta, $this->data);
        }
    }
    
    
    public function shipping_methods() {
        
         if($this->input->post('action') === 'save_shipping' ) { 
              
             foreach ($_POST['price'] as $id => $price) {
                $price = (is_numeric($price)) ? $price : 0;
                $batchArr[] = array(
                    'id' => $id,
                    'price' => $price
                );
             }//end foreach.
             
             if(is_array($batchArr)) {
             $rec = $this->db->update_batch('eshop_shipping_methods',$batchArr, 'id'); 
           
                if($rec) {
                     unset($_POST);
                    redirect('eshop_admin/shipping_methods');
                } else {
                    $this->page_construct('eshop/shipping_methods', $meta, $this->data);
                }
             }
                
         } else {
        
            $this->data['shippings'] = $this->eshop_model->getShippingMethods();
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('Shippings')));
            $meta = array('page_title' => lang('Shippings'), 'bc' => $bc);
            $this->page_construct('eshop/shipping_methods', $meta, $this->data);
            
         }
    }
    
    public function deleteimage() {
        
       $fieldname = $this->uri->segment(3);
       
       if(!empty($fieldname)){
          $eshop_settings = $this->eshop_model->getEshopSettings(1);
          
            if(unlink( str_replace( base_url(), '', $eshop_settings->$fieldname))){
                $this->eshop_model->updateEshopSettings(1 , [$fieldname=>'']);
            }           
       }
       
       redirect('eshop_admin/settings');
        
    }
}
