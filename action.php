<?php
/*
  *    xtralogin plugin for adding input field to the login dialog
  *    @authorL  Myron Turner <turnermm02@shaw.ca>
**/
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
        *      Insert extra input filed into login form
        *      loginxtrainput hidden input will identify the extra login field in the $_REQUEST array
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
     *    Check for  loginxtrainput
     *    If loginxtrainput is present in the $_REQUEST array
     *       check if the extra input field as been filled out
     *       -- if not prevent the login
      *     -- if it is present, handle the $xtra_input data
      *        you can, for instance, save it to a file in the meta directory:
      *           $file = metaFN('xtralogin:data','ser')     
      *      for a serializled file in the meta/extralogin directory with a '.ser'  extension
    */
   function handle_act_preprocess(&$event, $param) {        
         global $INPUT;   
 
           if (!$INPUT->server->has('REMOTE_USER')) return;
            $user =  $INPUT->server->str('REMOTE_USER');
          /* the following code is ready to use */  
        /*    
            $file = metaFN('xtralogin:data','ser') ;
            if(file_exists($file)) {
                $user_data = unserialize(file_get_contents($file));
                if(isset($user_data))   {
                 if(isset($user_data[$user])  && isset($user_data[$user]));
                    $saved_data =  $user_data[$user] ;
               }
               else $saved_data = "";
            }
            else $user_data = array();
         */
         
         if(!$INPUT->str('loginxtrainput','')) return;
         if(!$INPUT->str('loginxtra','') && !$saved_data) {
             msg('your warning here') ;
             $event->result = false; // login fail
             $event->preventDefault();
             $event->stopPropagation();              
             return;
         }
         $xtra_input = $INPUT->str('loginxtra');
       
        /* do your own thing here,
             e.g compare $xtra_input with current $user_data  and make decison based on comparison     
       */      
       /*  
        Finally Save new data
       $user_data[$user] = $INPUT->str('loginxtra'];
            io_saveFile($file, serialize($user_data);
       */  

     
    }

 }
     
  

