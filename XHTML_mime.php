<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * XHTML Mime class for CodeIgniter
 *
 * Send XHTML as it's proper mime type (application/xhtml+xml) to browsers that
 * prefer it, and send "text/html" to all the others. I'm looking at you IE.
 *
 * Original work by Neil Crosby and Simon Jessey,
 * http://www.workingwith.me.uk/articles/scripting/mimetypes
 *
 * @package		CodeIgniter
 * @author		Mike Walker
 * @license		MIT
 * @link		http://incredimike.com/projects/xhtml_mime
 */

class XHTML_mime
{
   private $charset;
   private $default_mime;
   private $mime;
   private $CI;

   public function __construct()
   {
      $this->CI =& get_instance();
      
      //$this->charset = "iso-8859-1";
      $this->charset = $this->CI->config->item('charset'); // use default charset from config
      $this->default_mime = "text/html"; // default mime type

   }  
      
   public function discover_preferred_mime()
   {
      // set default mime type before running
      $mime = $this->default_mime;
   
      // special check for the W3C_Validator
      if ( stristr( $_SERVER["HTTP_USER_AGENT"], "W3C_Validator" ) )
         return "application/xhtml+xml";
   
      // check to see if the client accepts "application/xhtml+xml" content
      if ( stristr( $_SERVER["HTTP_ACCEPT"], "application/xhtml+xml" ) )
      {
         // obtain the Q value for "application/xhtml+xml", then also
         // retrieve the Q value for "text/html" if it exists (and it should)
         if ( preg_match("/application\/xhtml\+xml;q=0(\.[1-9]+)/i",
               $_SERVER["HTTP_ACCEPT"], $matches ) )
         {
            $xhtml_q = $matches[1];
            if ( preg_match("/text\/html;q=0(\.[1-9]+)/i", 
                  $_SERVER["HTTP_ACCEPT"], $matches ) )
            {
               $html_q = $matches[1];

               // if the Q value for XHTML is greater than or equal to that 
               // for HTML then use the "application/xhtml+xml" mimetype
               if ( $xhtml_q >= $html_q ) $mime = "application/xhtml+xml";
            }
         }
         else
         {
            // if there was no Q value, then just use the 
            // "application/xhtml+xml" mimetype
            $mime = "application/xhtml+xml";
         }
      }
      

      
      return $mime;
   }
   
   public function display()
   {
      $this->mime = $this->discover_preferred_mime();

      $this->CI->output->set_header("Content-Type: {$this->mime};charset={$this->charset}");
      $this->CI->output->set_header("Vary: Accept");
      
      $output = $this->CI->output->get_output();
      
      if ( $this->mime == "application/xhtml+xml" )
      {
         $prolog_type = "<?xml version='1.0' encoding='{$this->charset}' ?>\n<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.1//EN'\n\t'http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd'>\n<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en'>";
      }
      else
      {
         $output = $this->fix_html($output);
         $prolog_type = "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01//EN'\n\t'http://www.w3.org/TR/html4/strict.dtd'>\n<html lang='en'>";

      }
      
      // it seems a little wrong to be doing it this way
      // but CI doesn't have a prepend_output function.. yet.
      $this->CI->output->_display($prolog_type . $output);

   }
   
   
   private function fix_html($buffer)
   {
      return (str_replace(" />", ">", $buffer));
   }
   
}
// END XHTML_mime class

/* End of file XHTML_mime.php */
/* Location: ./system/application/hooks/XHTML_mime.php */