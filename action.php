<?php

if(!defined('DOKU_INC')) die();

if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');

require_once(DOKU_PLUGIN.'action.php');

class action_plugin_xtralogin extends DokuWiki_Action_Plugin {
    private $captcha_installed =  true;
    function register(&$controller){
        $controller->register_hook('HTML_LOGINFORM_OUTPUT', 'BEFORE',$this,'handle_login_form',array());
        $controller->register_hook('ACTION_ACT_PREPROCESS', 'BEFORE',  $this, 'handle_act_preprocess');   
    }
    
      /**
        *      Insert captcha into login form 
        *      chk=captcha_check parameter to identify our login with captcha
      */
    function handle_login_form(&$event, $param) {   
       //	$pos = $event->data->findElementByAttribute('type', 'submit');           
         $pos = 0;
         $_form= '<fieldset><label><span><b>Info</b></span> ';
         $_form.= '<input type="textbox" name="loginxtra"/></label>';
         $_form.= '<input type="hidden" name="loginxtrainput" value="loginxtrainput" />';
         $_form.= '</fieldset>';  
         $event->data->insertElement($pos, $_form);
    }     
    
    /**
     *   Redirect with additional parameters if captcha fails
     *         do=logout : to force logout
     *         capt=r : to identify on reload that the captcha has failed
     *  Output captcha plugin's 'testfailed' message if capatcha failed test                
    */
   function handle_act_preprocess(&$event, $param) {        
         global $INPUT;   
 
         if(!$INPUT->str('loginxtrainput','')) return;
         if(!$INPUT->str('loginxtra','')) {
             $event->result = false; // login fail
             $event->preventDefault();
             $event->stopPropagation();              
             return;
         }
        /* do your own thing here */        

     
    }

 }
     
  

