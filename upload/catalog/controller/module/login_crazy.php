<?php
/**
 * @package    Login Crazy
 * @copyright    Copyright 2016 https://github.com/lakshitha212 - All rights reserved.
 * @license    GNU/GPL 2 or later
 */

//////////////////////////////////////////////////////////////////////
// Widget Display
//////////////////////////////////////////////////////////////////////
class ControllerModuleLoginCrazy extends Controller
{
    public function index()
    {
        $this->load->language('module/login_crazy');
        $data['text_loading'] = $this->language->get('text_loading');
        $data['text_signin_register'] = $this->language->get('text_signin_register');
        $data['text_new_customer'] = $this->language->get('text_new_customer');
        $data['text_returning'] = $this->language->get('text_returning');
        $data['text_returning_customer'] = $this->language->get('text_returning_customer');
        $data['text_details'] = $this->language->get('text_details');
        $data['text_forgotten'] = $this->language->get('text_forgotten');

        $data['entry_name'] = $this->language->get('entry_name');
        $data['entry_email'] = $this->language->get('entry_email');
        $data['entry_telephone'] = $this->language->get('entry_telephone');
        $data['entry_password'] = $this->language->get('entry_password');

        $data['button_login'] = $this->language->get('button_login');
        $data['forgotten'] = $this->url->link('account/forgotten', '', 'SSL');
        $data['button_register'] = $this->language->get('button_register');
        $data['register'] = $this->url->link('account/register&key=register', '', 'SSL');
        $this->document->addScript('catalog/view/javascript/login_crazy/login_crazy.js');
        return $this->load->view('module/login_crazy', $data);
    }

    public function login()
    {
        $json = array();
        $this->load->model('account/customer');

        if ($this->customer->isLogged()) {
            $json['islogged'] = true;
        } else if (isset($this->request->post)) {
            if (!$this->customer->login($this->request->post['email'], $this->request->post['password'])) {
                $json['error'] = $this->language->get('error_login');
            }
            $customer_info = $this->model_account_customer->getCustomerByEmail($this->request->post['email']);
            if ($customer_info && !$customer_info['approved']) {
                $json['error'] = $this->language->get('error_approved');
            }
        } else {
            $json['error'] = $this->language->get('error_warning');
        }

        if (!$json) {
            $json['success'] = true;
            unset($this->session->data['guest']);

            // Default Shipping Address
            $this->load->model('account/address');

            if ($this->config->get('config_tax_customer') == 'payment') {
                $this->session->data['payment_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
            }

            if ($this->config->get('config_tax_customer') == 'shipping') {
                $this->session->data['shipping_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
            }

            // Add to activity log
            $this->load->model('account/activity');

            $activity_data = array(
                'customer_id' => $this->customer->getId(),
                'name' => $this->customer->getFirstName() . ' ' . $this->customer->getLastName()
            );

            $this->model_account_activity->addActivity('login', $activity_data);
        }


        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }
}