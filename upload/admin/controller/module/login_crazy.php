<?php
/**
 * @package    Login Crazy
 * @copyright    Copyright 2016 https://github.com/lakshitha212 - All rights reserved.
 * @license    GNU/GPL 2 or later
 */

// ////////////////////////////////////////////////////////////////////
// Admin Panel
// ////////////////////////////////////////////////////////////////////
class ControllerModuleLoginCrazy extends Controller
{
    public function index()
    {
        $this->load->model('setting/setting');
        $this->language->load('module/login_crazy');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('extension/module');
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('login_crazy', $this->request->post);
            $this->session->data['success'] = $this->language->get('text_success');
            $this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], true));
        }
        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'])
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'])
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('module/laybuy_layout', 'token=' . $this->session->data['token'])
        );

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');

        $data['entry_status'] = $this->language->get('entry_status');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }
        if (!isset($this->request->get['module_id'])) {
            $data['action'] = $this->url->link('module/login_crazy', 'token=' . $this->session->data['token'], true);
        } else {
            $data['action'] = $this->url->link('module/login_crazy', 'token=' . $this->session->data['token'] . '&module_id=' . $this->request->get['module_id'], true);
        }

        $data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], true);
        if (isset($this->request->post['login_crazy_status'])) {
            $data['login_crazy_status'] = $this->request->post['login_crazy_status'];
        } else {
            $data['login_crazy_status'] = $this->config->get('login_crazy_status');
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        $this->response->setOutput($this->load->view('module/login_crazy', $data));

    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'module/login_crazy')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }
}